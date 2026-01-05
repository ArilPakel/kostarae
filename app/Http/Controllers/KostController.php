<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\KostView;


class KostController extends Controller
{
    /* =======================
     *  PEMILIK AREA
     * ======================= */
    public function index()
    {
        $kosts = Kost::where('pemilik_id', Auth::id())
            ->latest()
            ->get();

        return view('pemilik.kost.index', compact('kosts'));
    }

    public function create()
    {
        return view('pemilik.kost.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'alamat'     => 'required|string',
            'harga'      => 'required|numeric|min:0',
            'tipe'       => 'required|string',
            'fasilitas'  => 'nullable|array',
            'foto.*'     => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $filename = now()->timestamp . '-' . Str::random(8) . '.' . $file->extension();
                $file->storeAs('public/kost', $filename);
                $fotoPaths[] = "storage/kost/$filename";
            }
        }

        Kost::create([
            'pemilik_id' => Auth::id(),
            'nama'       => $validated['nama'],
            'alamat'     => $validated['alamat'],
            'harga'      => $validated['harga'],
            'tipe'       => $validated['tipe'],
            'fasilitas'  => $validated['fasilitas'] ?? [],
            'foto'       => $fotoPaths,
            'status'     => 'pending',
        ]);

        return redirect()
            ->route('pemilik.kost.index')
            ->with('success', 'Kost berhasil ditambahkan dan menunggu persetujuan admin.');
    }

    public function edit($id)
    {
        $kost = Kost::where('pemilik_id', Auth::id())->findOrFail($id);
        return view('pemilik.kost.edit', compact('kost'));
    }

    public function update(Request $request, $id)
    {
        $kost = Kost::where('pemilik_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'alamat'     => 'required|string',
            'harga'      => 'required|numeric|min:0',
            'tipe'       => 'required|string',
            'fasilitas'  => 'nullable|array',
            'foto.*'     => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = $kost->foto ?? [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $filename = now()->timestamp . '-' . Str::random(8) . '.' . $file->extension();
                $file->storeAs('public/kost', $filename);
                $foto[] = "storage/kost/$filename";
            }
        }

        $kost->update([
            'nama'      => $validated['nama'],
            'alamat'    => $validated['alamat'],
            'harga'     => $validated['harga'],
            'tipe'      => $validated['tipe'],
            'fasilitas' => $validated['fasilitas'] ?? [],
            'foto'      => $foto,
            'status'    => 'pending', // reset review
        ]);

        return redirect()
            ->route('pemilik.kost.index')
            ->with('success', 'Kost berhasil diperbarui dan menunggu persetujuan ulang.');
    }

    public function deletePhoto(Request $request, $id)
    {
        $kost = Kost::where('pemilik_id', Auth::id())->findOrFail($id);

        $foto = array_filter($kost->foto ?? [], fn($f) => $f !== $request->foto);

        $path = str_replace('storage/', 'public/', $request->foto);
        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $kost->update(['foto' => array_values($foto)]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $kost = Kost::where('pemilik_id', Auth::id())->findOrFail($id);

        foreach ($kost->foto ?? [] as $file) {
            $path = str_replace('storage/', 'public/', $file);
            Storage::delete($path);
        }

        $kost->delete();

        return back()->with('success', 'Kost berhasil dihapus.');
    }

    /* =======================
     *  PUBLIC AREA (PENCARIAN)
     * ======================= */
    public function publicList(Request $request)
    {
        $query = Kost::where('status', 'diterima');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('kelengkapan')) {
            $query->whereJsonContains('fasilitas', $request->kelengkapan);
        }

        $kosts = $query->latest()->paginate(12)->withQueryString();

        return view('kost.pencarian', compact('kosts'));
    }

    public function publicShow($id)
    {
        $kost = Kost::with(['reviews.user'])
            ->active()
            ->findOrFail($id);

        // Simpan view hanya untuk user biasa
        if (Auth::check() && Auth::user()->role === 'user') {
            KostView::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'kost_id' => $kost->id,
                ],
                [
                    'updated_at' => now(),
                ]
            );
        }

        return view('kost.detail', compact('kost'));
    }
}

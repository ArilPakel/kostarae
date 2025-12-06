<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KostController extends Controller
{
    // INDEX
    public function index()
    {
        $kosts = Kost::where('pemilik_id', Auth::id())->latest()->get();

        return view('pemilik.kost.index', compact('kosts'));
    }

    // CREATE
    public function create()
    {
        return view('pemilik.kost.create');
    }

    // STORE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'tipe' => 'required|string',
            'fasilitas' => 'nullable|array',
            'foto.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPaths = [];

        // Upload foto
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $filename = time().'-'.Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->storeAs('public/kost', $filename);
                $fotoPaths[] = "storage/kost/$filename";
            }
        }

        Kost::create([
            'pemilik_id' => Auth::id(),
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'harga' => $validated['harga'],
            'tipe' => $request->tipe,
            'fasilitas' => $request->fasilitas ?? [],
            'foto' => $fotoPaths,
            'status' => 'pending',
        ]);

        return redirect()->route('pemilik.kost.index')
            ->with('success', 'Kost berhasil ditambahkan!');
    }

    // EDIT
    public function edit($id)
    {
        $kost = Kost::where('pemilik_id', Auth::id())->findOrFail($id);

        return view('pemilik.kost.edit', compact('kost'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $kost = Kost::where('pemilik_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'tipe' => 'required|string',
            'fasilitas' => 'nullable|array',
            'foto.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $oldPhotos = $kost->foto ?? [];

        // Upload foto baru
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $filename = time().'-'.Str::random(8).'.'.$file->getClientOriginalExtension();
                $file->storeAs('public/kost', $filename);
                $oldPhotos[] = "storage/kost/$filename";
            }
        }

        $kost->update([
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'harga' => $validated['harga'],
            'tipe' => $request->tipe,
            'fasilitas' => $request->fasilitas ?? [],
            'foto' => $oldPhotos,
        ]);

        return redirect()->route('pemilik.kost.index')
            ->with('success', 'Kost berhasil diperbarui!');
    }

    // DELETE PHOTO
    public function deletePhoto(Request $request, $id)
    {
        $kost = Kost::where('pemilik_id', Auth::id())->findOrFail($id);

        $fotoArray = $kost->foto ?? [];
        $filename = $request->foto;

        $storagePath = str_replace('storage/', 'public/', $filename);

        if (Storage::exists($storagePath)) {
            Storage::delete($storagePath);
        }

        // Hapus dari array
        $fotoArray = array_values(array_filter($fotoArray, fn ($f) => $f !== $filename));

        $kost->update(['foto' => $fotoArray]);

        return response()->json(['success' => true]);
    }

    // DELETE KOST
    public function destroy($id)
    {
        $kost = Kost::where('pemilik_id', Auth::id())->findOrFail($id);

        foreach ($kost->foto ?? [] as $file) {
            $path = str_replace('storage/', 'public/', $file);
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        }

        $kost->delete();

        return redirect()->back()->with('success', 'Kost berhasil dihapus.');
    }

    public function publicShow($id)
    {
        $kost = Kost::findOrFail($id);

        
        $kost->foto = is_array($kost->foto) ? $kost->foto : json_decode($kost->foto, true);
        $kost->fasilitas = is_array($kost->fasilitas) ? $kost->fasilitas : json_decode($kost->fasilitas, true);

        return view('kost.detail', compact('kost')); 
    }
}

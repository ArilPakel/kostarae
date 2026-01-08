<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; 

class KostController extends Controller
{
    // ==========================================
    // 0. RESET SEMUA REKOMENDASI (TOMBOL DI DASHBOARD)
    // ==========================================
    public function resetRecommendation()
    {
        // Set SEMUA kost menjadi tidak direkomendasikan
        // Ini otomatis mengaktifkan logic "Fallback Rating Tertinggi" di PageController & Dashboard
        \App\Models\Kost::query()->update(['is_recommended' => false]);

        return back()->with('success', 'Mode Rekomendasi berhasil direset ke OTOMATIS (Berdasarkan Rating).');
    }

    // 1. INDEX
    public function index(Request $request)
    {
        $query = Kost::with(['pemilik'])->latest();

        // Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kost', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%") // Fallback kolom lama
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kosts = $query->paginate(10);
        
        // Statistik
        $totalKost     = Kost::count();
        $totalPending  = Kost::where('status', 'pending')->count();
        $totalApproved = Kost::whereIn('status', ['diterima', 'active', 'aktif'])->count(); 
        $totalRejected = Kost::where('status', 'ditolak')->count();

        return view('admin.kost.index', compact('kosts', 'totalKost', 'totalPending', 'totalApproved', 'totalRejected'));
    }

    // 2. SHOW
    public function show($id)
    {
        $kost = Kost::with(['pemilik', 'reviews'])->findOrFail($id);
        return view('admin.kost.show', compact('kost'));
    }

    // 3. APPROVE
    public function approve($id)
    {
        Kost::findOrFail($id)->update([
            'status' => 'diterima', 
            'alasan_penolakan' => null
        ]);
        
        return back()->with('success', 'Kost berhasil diterima dan ditayangkan.');
    }

    // 4. REJECT
    public function reject(Request $request, $id)
    {
        $request->validate(['alasan' => 'required|string|min:5']);
        
        Kost::findOrFail($id)->update([
            'status' => 'ditolak', 
            'alasan_penolakan' => $request->alasan
        ]);
        
        return back()->with('success', 'Kost ditolak.');
    }

    // 5. RESET
    public function resetStatus(Request $request, $id)
    {
        Kost::findOrFail($id)->update([
            'status' => 'pending', 
            'alasan_penolakan' => $request->alasan ?? null
        ]);
        return back()->with('success', 'Status reset ke Pending.');
    }

    // 6. CREATE
    public function create()
    {
        $users = User::where('role', 'pemilik')->orWhere('role', 'owner')->get();
        return view('admin.kost.create', compact('users'));
    }

    // 7. STORE
    public function store(Request $request)
    {
        $request->validate([
            'pemilik_id' => 'required|exists:users,id',
        ]);

        if ($request->filled('owner_phone_update')) {
            $request->validate(['owner_phone_update' => 'numeric|digits_between:10,15']);
            User::where('id', $request->pemilik_id)->update(['phone' => $request->owner_phone_update]);
        }

        $pemilik = User::findOrFail($request->pemilik_id);
        if (empty($pemilik->phone)) {
            return back()->withInput()->with('error', 'Pemilik ini belum memiliki nomor WhatsApp. Harap isi nomor WA terlebih dahulu.');
        }

        $cleanHarga = $request->harga ? str_replace(['.', ','], '', $request->harga) : 0;

        $request->validate([
            'nama'       => 'required|string|max:255',
            'alamat'     => 'required|string',
            'harga'      => 'required',
            'tipe'       => 'required|string',
            'foto'       => 'required|array|min:1|max:5',
            'foto.*'     => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoPaths = [];
        if($request->hasFile('foto')) {
            foreach($request->file('foto') as $file) {
                $path = $file->store('kosts', 'public'); 
                $fotoPaths[] = $path; 
            }
        }

        Kost::create([
            'pemilik_id' => $request->pemilik_id,
            'nama_kost'  => $request->nama, 
            'nama'       => $request->nama,
            'alamat'     => $request->alamat,
            'harga'      => $cleanHarga,
            'tipe_kost'  => $request->tipe,
            'tipe'       => $request->tipe,
            'fasilitas'  => json_encode($request->fasilitas ?? []),
            'foto'       => json_encode($fotoPaths),
            'status'     => 'pending',
            'deskripsi'  => $request->deskripsi,
            'kota'       => $request->kota,
            'kecamatan'  => $request->kecamatan,
            'kelurahan'  => $request->kelurahan,
        ]);

        return redirect()->route('admin.kost.index')->with('success', 'Kost berhasil ditambahkan.');
    }

    // 8. EDIT
    public function edit($id)
    {
        $kost = Kost::findOrFail($id);
        $users = User::whereIn('role', ['pemilik', 'owner'])->get();
        
        $alamatParts = explode(',', $kost->alamat);
        $lokasiData = [
            'detail' => isset($alamatParts[0]) ? trim($alamatParts[0]) : $kost->alamat,
            'kel'    => isset($alamatParts[1]) ? trim($alamatParts[1]) : ($kost->kelurahan ?? ''),
            'kec'    => isset($alamatParts[2]) ? trim($alamatParts[2]) : ($kost->kecamatan ?? ''),
            'kota'   => isset($alamatParts[3]) ? trim($alamatParts[3]) : ($kost->kota ?? ''),
        ];

        return view('admin.kost.edit', compact('kost', 'users', 'lokasiData'));
    }

    // 9. UPDATE
    public function update(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);

        if($request->has('pemilik_id')) {
            if ($request->filled('owner_phone_update')) {
                $pemilik = User::find($request->pemilik_id);
                if($pemilik) $pemilik->update(['phone' => $request->owner_phone_update]);
            }
        }

        $cleanHarga = str_replace(['.', ','], '', $request->harga);
        $request->merge(['harga' => $cleanHarga]);

        $request->validate([
            'nama'   => 'required|string|max:255',
            'harga'  => 'required|numeric',
            'foto.*' => 'image|max:2048',
        ]);

        $currentFotos = is_string($kost->foto) ? json_decode($kost->foto, true) : ($kost->foto ?? []);
        
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('kosts', 'public');
                $currentFotos[] = $path; 
            }
        }

        $fasilitas = $request->fasilitas ?? [];
        if ($request->filled('fasilitas_tambahan')) {
            $tambahan = array_map('trim', explode(',', $request->fasilitas_tambahan));
            $fasilitas = array_merge($fasilitas, $tambahan);
        }

        $kelurahanFinal = $request->filled('kelurahan_manual') ? $request->kelurahan_manual : $request->kelurahan;
        
        if($request->filled(['alamat', 'kecamatan', 'kota'])) {
             $alamatDetail = $request->alamat; 
             $alamatFull = "{$alamatDetail}, {$kelurahanFinal}, {$request->kecamatan}, {$request->kota}";
        } else {
            $alamatFull = $kost->alamat;
        }

        $kost->update([
            'pemilik_id' => $request->pemilik_id ?? $kost->pemilik_id,
            'nama_kost'  => $request->nama,
            'alamat'     => $alamatFull,
            'harga'      => $cleanHarga,
            'tipe_kost'  => $request->tipe,
            'fasilitas'  => json_encode($fasilitas),
            'foto'       => json_encode($currentFotos),
            'deskripsi'  => ucfirst($request->deskripsi),
            'kota'       => $request->kota ?? $kost->kota,
            'kecamatan'  => $request->kecamatan ?? $kost->kecamatan,
            'kelurahan'  => $kelurahanFinal ?? $kost->kelurahan,
        ]);

        return redirect()->route('admin.kost.index')->with('success', 'Data kost diperbarui.');
    }

    // 10. DESTROY
    public function destroy($id)
    {
        $kost = Kost::findOrFail($id);
        
        $fotos = is_string($kost->foto) ? json_decode($kost->foto, true) : $kost->foto;

        if ($fotos && is_array($fotos)) {
            foreach ($fotos as $item) {
                $path = is_array($item) ? ($item['path'] ?? null) : $item;
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
        $kost->delete();
        return back()->with('success', 'Data dihapus.');
    }

    // ==========================================
    // METHOD: REKOMENDASI (BINTANG/MANUAL ADMIN)
    // ==========================================
    public function promote($id)
    {
        $kost = Kost::findOrFail($id);
        
        // Toggle status Rekomendasi (True <-> False)
        $kost->is_recommended = !$kost->is_recommended;
        $kost->save();

        $msg = $kost->is_recommended ? 'ditambahkan ke' : 'dihapus dari';
        return back()->with('success', "Kost berhasil {$msg} rekomendasi halaman depan!");
    }

    // ==========================================
    // METHOD: UPDATE STATUS VIA AJAX
    // ==========================================
    public function updateStatus(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);
        
        $request->validate(['status' => 'required|in:pending,diterima,ditolak']);
        $kost->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status berhasil diubah']);
    }

    // ==========================================
    // METHOD: UPDATE ADS (IKLAN BERBAYAR/MEGAPHONE)
    // ==========================================
    // Pastikan ini HANYA ADA SATU dalam class ini
    public function updateAds(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);
        
        // Validasi Input dari Modal AJAX
        $request->validate([
            'is_promoted' => 'required|boolean',
            'promoted_start_date' => 'nullable|required_if:is_promoted,true|date',
            'promoted_end_date'   => 'nullable|required_if:is_promoted,true|date|after_or_equal:promoted_start_date',
        ]);

        // Update Data
        $kost->update([
            'is_promoted' => $request->is_promoted,
            'promoted_start_date' => $request->is_promoted ? $request->promoted_start_date : null,
            'promoted_end_date'   => $request->is_promoted ? $request->promoted_end_date : null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status iklan berhasil diperbarui!'
        ]);
    }
}
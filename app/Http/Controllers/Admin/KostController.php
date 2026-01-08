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
    // 0. RESET SEMUA REKOMENDASI
    // ==========================================
    public function resetRecommendation()
    {
        \App\Models\Kost::query()->update(['is_recommended' => false]);
        return back()->with('success', 'Mode Rekomendasi berhasil direset ke OTOMATIS.');
    }

    // 1. INDEX
    public function index(Request $request)
    {
        $query = Kost::with(['pemilik'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // [FIX] Hapus nama_kost agar tidak error pencarian
                $q->where('nama', 'like', "%{$search}%") 
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kosts = $query->paginate(10);
        
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
        return back()->with('success', 'Kost berhasil diterima.');
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

    // ==========================================
    // 7. STORE (BAGIAN YANG DIPERBAIKI)
    // ==========================================
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
            return back()->withInput()->with('error', 'Pemilik belum memiliki nomor WhatsApp.');
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

        // [FIX] Gabungkan alamat lengkap agar data kota/kecamatan tersimpan di kolom 'alamat'
        // Karena kolom 'kota', 'kecamatan', 'kelurahan' TIDAK ADA di database.
        $alamatLengkap = "{$request->alamat}, {$request->kelurahan}, {$request->kecamatan}, {$request->kota}";

        Kost::create([
            'pemilik_id' => $request->pemilik_id,
            // 'nama_kost' => $request->nama, // DIHAPUS (Error Column not found)
            'nama'       => $request->nama,
            'alamat'     => $alamatLengkap, // Menggunakan alamat lengkap gabungan
            'harga'      => $cleanHarga,
            // 'tipe_kost' => $request->tipe, // DIHAPUS (Error Column not found)
            'tipe'       => $request->tipe,
            'fasilitas'  => json_encode($request->fasilitas ?? []),
            'foto'       => json_encode($fotoPaths),
            'status'     => 'pending',
            'deskripsi'  => $request->deskripsi,
            
            // Kolom di bawah ini DIHAPUS dari query insert karena tidak ada di DB
            // 'kota'       => $request->kota,
            // 'kecamatan'  => $request->kecamatan,
            // 'kelurahan'  => $request->kelurahan,
        ]);

        return redirect()->route('admin.kost.index')->with('success', 'Kost berhasil ditambahkan.');
    }

    // 8. EDIT
    public function edit($id)
    {
        $kost = Kost::findOrFail($id);
        $users = User::whereIn('role', ['pemilik', 'owner'])->get();
        
        // Memecah alamat kembali untuk form edit (Opsional, logika sederhana)
        $alamatParts = explode(',', $kost->alamat);
        
        // Ambil bagian belakang sebagai Kota, Kec, Kel jika formatnya sesuai
        // Ini hanya estimasi karena data digabung jadi string
        $totalPart = count($alamatParts);
        $lokasiData = [
            'detail' => $alamatParts[0] ?? $kost->alamat,
            'kel'    => isset($alamatParts[$totalPart-3]) ? trim($alamatParts[$totalPart-3]) : '',
            'kec'    => isset($alamatParts[$totalPart-2]) ? trim($alamatParts[$totalPart-2]) : '',
            'kota'   => isset($alamatParts[$totalPart-1]) ? trim($alamatParts[$totalPart-1]) : '',
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

        // [FIX] Update logika alamat gabungan
        $kelurahanFinal = $request->filled('kelurahan_manual') ? $request->kelurahan_manual : $request->kelurahan;
        
        if($request->filled(['alamat', 'kecamatan', 'kota'])) {
             $alamatDetail = $request->alamat; 
             $alamatFull = "{$alamatDetail}, {$kelurahanFinal}, {$request->kecamatan}, {$request->kota}";
        } else {
            $alamatFull = $kost->alamat;
        }

        $kost->update([
            'pemilik_id' => $request->pemilik_id ?? $kost->pemilik_id,
            'nama'       => $request->nama, // Pastikan pakai 'nama' bukan 'nama_kost'
            'alamat'     => $alamatFull,    // Masuk ke kolom 'alamat'
            'harga'      => $cleanHarga,
            'tipe'       => $request->tipe, // Pastikan pakai 'tipe' bukan 'tipe_kost'
            'fasilitas'  => json_encode($fasilitas),
            'foto'       => json_encode($currentFotos),
            'deskripsi'  => ucfirst($request->deskripsi),
            
            // HAPUS update ke kolom yang tidak ada
            // 'kota'       => ...,
            // 'kecamatan'  => ...,
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

    public function promote($id)
    {
        $kost = Kost::findOrFail($id);
        $kost->is_recommended = !$kost->is_recommended;
        $kost->save();
        $msg = $kost->is_recommended ? 'ditambahkan ke' : 'dihapus dari';
        return back()->with('success', "Kost berhasil {$msg} rekomendasi!");
    }

    public function updateStatus(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);
        $request->validate(['status' => 'required|in:pending,diterima,ditolak']);
        $kost->update(['status' => $request->status]);
        return response()->json(['success' => true, 'message' => 'Status berhasil diubah']);
    }

    public function updateAds(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);
        $request->validate([
            'is_promoted' => 'required|boolean',
            'promoted_start_date' => 'nullable|required_if:is_promoted,true|date',
            'promoted_end_date'   => 'nullable|required_if:is_promoted,true|date|after_or_equal:promoted_start_date',
        ]);

        $kost->update([
            'is_promoted' => $request->is_promoted,
            'promoted_start_date' => $request->is_promoted ? $request->promoted_start_date : null,
            'promoted_end_date'   => $request->is_promoted ? $request->promoted_end_date : null,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Status iklan diperbarui!']);
    }
}
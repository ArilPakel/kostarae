<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KostController extends Controller
{
    // 1. INDEX
    public function index(Request $request)
    {
        // Pastikan relasi di Model Kost bernama 'pemilik' (public function pemilik() { return $this->belongsTo(User::class, 'pemilik_id'); })
        $query = Kost::with('pemilik')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%") // Pastikan kolom database 'nama' atau 'nama_kost'
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kosts = $query->paginate(10);
        
        $totalKost     = Kost::count();
        $totalPending  = Kost::where('status', 'pending')->count();
        $totalApproved = Kost::where('status', 'diterima')->count();
        $totalRejected = Kost::where('status', 'ditolak')->count();

        return view('admin.kost.index', compact('kosts', 'totalKost', 'totalPending', 'totalApproved', 'totalRejected'));
    }

    // 2. SHOW
    public function show($id)
    {
        // PERBAIKAN: Konsisten menggunakan relasi 'pemilik'
        $kost = Kost::with(['pemilik', 'reviews'])->findOrFail($id);
        
        return view('admin.kost.show', compact('kost'));
    }

    // 3. APPROVE
    public function approve($id)
    {
        Kost::findOrFail($id)->update(['status' => 'diterima', 'alasan_penolakan' => null]);
        return back()->with('success', 'Kost berhasil diterima.');
    }

    // 4. REJECT
    public function reject(Request $request, $id)
    {
        $request->validate(['alasan' => 'required|string|min:5']);
        Kost::findOrFail($id)->update(['status' => 'ditolak', 'alasan_penolakan' => $request->alasan]);
        return back()->with('success', 'Kost ditolak.');
    }

    // 5. RESET
    public function resetStatus(Request $request, $id)
    {
        Kost::findOrFail($id)->update(['status' => 'pending', 'alasan_penolakan' => $request->alasan ?? null]);
        return back()->with('success', 'Status reset ke Pending.');
    }

    // 6. CREATE
    public function create()
    {
        $users = User::where('role', 'pemilik')->get();
        return view('admin.kost.create', compact('users'));
    }

    // 7. STORE (BAGIAN YANG DIPERBAIKI TOTAL)
    public function store(Request $request)
    {
        // A. Update nomor WA jika ada request update
        if ($request->filled('owner_phone_update')) {
            $request->validate([
                'owner_phone_update' => 'numeric|digits_between:10,15'
            ]);
            User::where('id', $request->pemilik_id)
                ->update(['phone' => $request->owner_phone_update]);
        }

        // B. Pastikan pemilik punya WA (Cek ulang setelah update)
        $pemilik = User::findOrFail($request->pemilik_id);
        if (empty($pemilik->phone)) {
            return back()->withInput()
                ->with('error', 'Pemilik belum memiliki nomor WhatsApp.');
        }

        // C. Bersihkan harga (Hapus titik/koma)
        $cleanHarga = str_replace(['.', ','], '', $request->harga);

        // D. Validasi Input
        $request->validate([
            'pemilik_id' => 'required|exists:users,id',
            'nama'       => 'required|string|max:255', // Sesuaikan dengan name="nama" di form
            'alamat'     => 'required|string',
            'harga'      => 'required',
            'tipe'       => 'required|string',
            'foto'       => 'required|array|min:1|max:5',
            'foto.*'     => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'foto.max'   => 'Maksimal upload 5 foto.',
            'foto.*.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        // E. Upload Foto
        $fotoPaths = [];
        if($request->hasFile('foto')) {
            foreach($request->file('foto') as $file) {
                // Simpan ke storage/app/public/kosts
                $path = $file->store('kosts', 'public'); 
                $fotoPaths[] = $path;
            }
        }

        // F. Simpan Data ke Database
        // ✅ PERBAIKAN: Langsung masukkan hasil upload ke create()
        // Jangan panggil $kost->save() sebelum variabelnya ada.
        Kost::create([
            'pemilik_id' => $request->pemilik_id,
            'nama'  => $request->nama, // Pastikan kolom DB 'nama_kost' atau 'nama'. Sesuaikan disini.
            'alamat'     => $request->alamat,
            'harga'      => $cleanHarga,
            'tipe_kost'  => $request->tipe, // Pastikan kolom DB 'tipe_kost' atau 'tipe'.
            'fasilitas'  => json_encode($request->fasilitas ?? []), // Encode array ke JSON
            'foto'       => json_encode($fotoPaths),            // Encode array path foto ke JSON
            'status'     => 'pending',
            'deskripsi'  => $request->deskripsi,
            'kota'       => $request->kota,
            'kecamatan'  => $request->kecamatan,
            'kelurahan'  => $request->kelurahan,
        ]);

        return redirect()
            ->route('admin.kost.index')
            ->with('success', 'Kost berhasil ditambahkan dan menunggu validasi.');
    }

    // 8. EDIT
    public function edit($id)
    {
        $kost = Kost::findOrFail($id);
        $users = User::where('role', '!=', 'admin')->get();
        
        // Cek jika alamat mengandung koma baru di explode, untuk menghindari error offset
        $alamatParts = explode(',', $kost->alamat);
        
        $lokasiData = [
            'detail' => isset($alamatParts[0]) ? trim($alamatParts[0]) : $kost->alamat,
            'kel'    => isset($alamatParts[1]) ? trim($alamatParts[1]) : '',
            'kec'    => isset($alamatParts[2]) ? trim($alamatParts[2]) : '',
            'kota'   => isset($alamatParts[3]) ? trim($alamatParts[3]) : '',
        ];

        return view('admin.kost.edit', compact('kost', 'users', 'lokasiData'));
    }

    // 9. UPDATE
    public function update(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);

        // Update Pemilik & No HP jika ada
        if($request->has('pemilik_id')) {
            $pemilik = User::findOrFail($request->pemilik_id);
            if ($request->filled('owner_phone_update')) {
                $request->validate(['owner_phone_update' => 'numeric|digits_between:10,15']);
                $pemilik->update(['phone' => $request->owner_phone_update]);
            }
            if (empty($pemilik->phone) && empty($request->owner_phone_update)) {
                return back()->withInput()->with('error', 'Pemilik wajib memiliki nomor WA.');
            }
        }

        $cleanHarga = str_replace(['.', ','], '', $request->harga);
        $request->merge(['harga' => $cleanHarga]);

        $request->validate([
            'nama'   => 'required|string|max:255',
            'harga'  => 'required|numeric',
            'foto.*' => 'image|max:2048',
        ]);

        // Logic Foto: Gabungkan foto lama dengan yang baru (jika ada)
        // Pastikan foto lama di-decode dulu jika string JSON
        $currentFotos = is_string($kost->foto) ? json_decode($kost->foto, true) : ($kost->foto ?? []);
        
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $index => $file) {
                $path = $file->store('kosts', 'public'); // Samakan foldernya dengan store: 'kosts'
                // Karena struktur di store array simple, kita push path-nya saja
                $currentFotos[] = $path; 
            }
        }

        // Logic Fasilitas
        $fasilitas = $request->fasilitas ?? [];
        if ($request->filled('fasilitas_tambahan')) {
            $tambahan = array_map('trim', explode(',', $request->fasilitas_tambahan));
            $fasilitas = array_merge($fasilitas, $tambahan);
        }

        // Logic Alamat
        $kelurahanFinal = $request->filled('kelurahan_manual') ? $request->kelurahan_manual : $request->kelurahan;
        
        if($request->filled(['alamat', 'kecamatan', 'kota']) || $kelurahanFinal) {
             // Menggunakan input alamat detail, bukan $kost->alamat lama
             $alamatDetail = $request->alamat ?? ''; 
             $alamatFull = "{$alamatDetail}, {$kelurahanFinal}, {$request->kecamatan}, {$request->kota}";
        } else {
            $alamatFull = $kost->alamat;
        }

        $kost->update([
            'pemilik_id' => $request->pemilik_id ?? $kost->pemilik_id,
            'nama_kost'  => $request->nama, // Sesuaikan nama kolom DB
            'alamat'     => $alamatFull,
            'harga'      => $cleanHarga,
            'tipe_kost'  => $request->tipe, // Sesuaikan nama kolom DB
            'fasilitas'  => json_encode($fasilitas), // Encode JSON
            'foto'       => json_encode($currentFotos), // Encode JSON
            'deskripsi'  => ucfirst($request->deskripsi),
        ]);

        return redirect()->route('admin.kost.index')->with('success', 'Data kost berhasil diperbarui.');
    }

    // 10. DESTROY
    public function destroy($id)
    {
        $kost = Kost::findOrFail($id);
        
        // Decode foto jika JSON string
        $fotos = is_string($kost->foto) ? json_decode($kost->foto, true) : $kost->foto;

        if ($fotos && is_array($fotos)) {
            foreach ($fotos as $item) {
                // Cek apakah item string path atau array (tergantung cara simpan sebelumnya)
                $path = is_array($item) ? ($item['path'] ?? null) : $item;
                
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
        $kost->delete();
        return back()->with('success', 'Data dihapus.');
    }

    public function management()
    {
        $kosts = Kost::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('is_promoted', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.kost.management', compact('kosts'));
    }

    // ==========================================
    // METHOD PROMOTE
    // ==========================================
    public function promote(Request $request, $id)
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

        return response()->json([
            'status' => 'success',
            'message' => 'Status promosi berhasil diperbarui!'
        ]);
    }

    // --- METHOD UPDATE STATUS VIA AJAX ---
    public function updateStatus(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,diterima,ditolak'
        ]);

        $kost->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status kost berhasil diperbarui menjadi ' . ucfirst($request->status)
        ]);
    }
}
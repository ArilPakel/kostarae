<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Kost;
use App\Models\User;

class OwnerProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data kost milik user ini
        $kosts = Kost::where('pemilik_id', $user->id)->latest()->get();

        // Hitung Statistik Sederhana
        $stats = [
            'total_kost' => $kosts->count(),
            'active_kost' => $kosts->where('status', 'aktif')->count(),
            'total_rooms' => $kosts->sum('jumlah_kamar') ?? 0,
            'total_views' => 0, 
        ];

        return view('pemilik.profil.index', compact('user', 'kosts', 'stats'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('pemilik.profil.edit', compact('user')); 
    }

    /**
     * Method untuk memproses update profil
     */
    public function update(Request $request)
    {
        // [PERBAIKAN 1] Ambil ID User dari Auth
        $userId = Auth::id();

        // [PERBAIKAN 2] Cari User menggunakan Model agar terbaca sebagai Eloquent Instance
        $user = User::findOrFail($userId);

        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$userId, // Abaikan email sendiri
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // 2. Logic Upload Foto
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada dan file-nya eksis
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Simpan foto baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 3. Update Data Lain
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Cek input phone (Pastikan kolom 'phone' ada di database!)
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        // [EKSEKUSI] Simpan perubahan
        // Jika masih error di sini, kemungkinan besar kolom 'phone' atau 'avatar' belum ada di tabel 'users'
        $user->save(); 

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

     public function editPassword()
    {
        return view('pemilik.profil.keamanan');
    }

    /**
     * Proses update password pemilik
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi lama tidak sesuai.',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
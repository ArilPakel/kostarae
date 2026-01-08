<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Kost;
use App\Models\User; // Pastikan Model User di-import

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
            'active_kost' => $kosts->where('status', 'aktif')->count(), // Pastikan status sesuai DB ('aktif'/'active')
            'total_rooms' => $kosts->sum('jumlah_kamar') ?? 0,
            'total_views' => 0, 
        ];

        return view('pemilik.profil.index', compact('user', 'kosts', 'stats'));
    }

    public function edit()
    {
        $user = Auth::user();
        // Mengarah ke resources/views/pemilik/profil/edit.blade.php
        return view('pemilik.profil.edit', compact('user'));
    }

    /**
     * Method untuk memproses update profil (Nama, Email, Foto)
     */
    public function update(Request $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId); // Pakai findOrFail agar aman

        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$userId,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Logic Upload Foto
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 3. Update Data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at = null;
        
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        $user->save(); 

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Halaman Ganti Password
     */
    public function editPassword()
    {
        // [PENTING] Pastikan Anda membuat file view ini: 
        // resources/views/pemilik/profil/keamanan.blade.php
        return view('pemilik.profil.keamanan');
    }

    /**
     * Proses Update Password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Gunakan User::find agar objeknya fresh dan bisa di-save
        $user = User::find(Auth::id());

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi lama tidak sesuai.',
            ]);
        }

        // Update password baru
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
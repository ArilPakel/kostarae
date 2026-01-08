<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

class GoogleController extends Controller
{
    /**
     * Mengarahkan user ke halaman login Google
     * Menyimpan role (user/pemilik) ke session untuk proses register
     */
    public function redirectToGoogle($role = 'user')
    {
        session(['register_role' => $role]);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Menangani callback dari Google setelah user login
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // 1. Cari User (Berdasarkan Google ID atau Email)
            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            // 2. Jika User Ditemukan (Login)
            if ($user) {
                // Jika user lama login pakai email biasa, tautkan Google ID-nya
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar'     => $googleUser->avatar,
                    ]);
                }

                Auth::login($user, true);
                return $this->redirectBasedOnRole($user->role);
            }

            // 3. Jika User Belum Ada (Register Baru)
            $user = User::create([
                'name'              => $googleUser->name,
                'email'             => $googleUser->email,
                'google_id'         => $googleUser->id,
                'avatar'            => $googleUser->avatar,
                'role'              => session('register_role', 'user'), // Ambil role dari session
                'email_verified_at' => now(), // Google dianggap sudah terverifikasi
                'password'          => null, // Password null karena login sosmed
            ]);

            // Hapus session role agar bersih
            session()->forget('register_role');

            Auth::login($user, true);
            return $this->redirectBasedOnRole($user->role);

        } catch (Exception $e) {
            // Log error jika perlu: \Log::error($e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Login Google gagal, silakan coba lagi.');
        }
    }

    /**
     * Helper untuk redirect sesuai role menggunakan Route Name
     * [PENTING] Ini yang memperbaiki error 404
     */
    protected function redirectBasedOnRole($role)
    {
        return match ($role) {
            // Admin ke Dashboard Admin
            'admin'   => redirect()->route('admin.dashboard'),
            
            // [PERBAIKAN] Pemilik ke Halaman Profil (Dashboard Pemilik)
            // Jangan pakai redirect('/pemilik/dashboard'), itu route lama yang sudah dihapus.
            'pemilik' => redirect()->route('pemilik.profile'), 
            
            // User Biasa ke Dashboard Pencari Kost
            default   => redirect()->route('dashboard'),
        };
    }
}
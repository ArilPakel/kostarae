<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    // 1. Fungsi Redirect (DIPERBAIKI)
    // Menambahkan default value 'pencari' agar tidak error saat diakses dari halaman Login
    public function redirectToGoogle($role = 'pencari')
    {
        // SIMPAN ROLE KE SESSION
        session(['register_role' => $role]);

        return Socialite::driver('google')->redirect();
    }

    // 2. Fungsi Callback
    public function handleGoogleCallback()
    {
        try {
            // Gunakan stateless() untuk menghindari error invalid state di localhost
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Cek apakah user sudah ada di database
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // --- KONDISI A: USER SUDAH TERDAFTAR ---
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }

                Auth::login($user);
                
                // Redirect sesuai role ASLI di database
                return $this->redirectBasedOnRole($user->role);

            } else {
                // --- KONDISI B: USER BARU ---
                
                // Ambil role dari session, default ke 'pencari' jika session expired
                $role = session('register_role', 'pencari');

                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'role' => $role,
                    'password' => null,
                    'email_verified_at' => now(),
                ]);

                Auth::login($newUser);
                session()->forget('register_role');

                return $this->redirectBasedOnRole($newUser->role);
            }

        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Login Google Gagal: ' . $e->getMessage());
        }
    }

    // Helper function
    protected function redirectBasedOnRole($role)
    {
        if ($role === 'pemilik') {
            // Ubah '/owner/dashboard' menjadi '/pemilik/dashboard'
            return redirect()->intended('/pemilik/dashboard'); 
        } 
        
        // Default ke pencari
        return redirect()->intended('/dashboard'); // Pastikan ini juga sesuai dengan route pencari Anda
    }
}
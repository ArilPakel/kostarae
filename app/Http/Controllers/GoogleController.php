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
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->id)
            ->orWhere('email', $googleUser->email)
            ->first();

        if ($user) {
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser->id]);
            }

            Auth::login($user);
            return $this->redirectBasedOnRole($user->role);
        }

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

    } catch (Exception $e) {
        return redirect()->route('login')
            ->with('error', 'Login Google gagal, silakan coba lagi.');
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
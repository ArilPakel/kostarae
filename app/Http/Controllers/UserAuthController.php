<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        // Jika sudah login, langsung arahkan sesuai role
        if (Auth::check()) {
            return Auth::user()->role === 'pemilik'
                ? redirect()->route('pemilik.kost.index')
                : redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ], [
            'phone.required' => 'Nomor telepon wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Attempt login
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect sesuai role
            return Auth::user()->role === 'pemilik'
                ? redirect()->route('pemilik.kost.index')
                : redirect()->route('home');
        }

        // Jika gagal login
        return back()->withErrors([
            'login' => 'Nomor telepon atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit password.
     */
    public function editPassword()
    {
        return view('user.password.edit');
    }

    /**
     * Memproses update password.
     */
    public function updatePassword(Request $request)
    {
        // 1. Validasi
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // 2. Update
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Redirect
        // Cek role untuk redirect ke profil yang benar
        $redirectRoute = $request->user()->role === 'pemilik' ? 'owner.profile' : 'user.profile';

        return redirect()->route($redirectRoute)->with('status', 'password-updated');
    }
}
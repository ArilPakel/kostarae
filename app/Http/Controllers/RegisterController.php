<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    
    public function showUserForm()
    {
        return view('auth.user'); 
    }

    
    public function showOwnerForm()
    {
        return view('auth.owner');
    }

    // ==========================
    // REGISTER USER
    // ==========================
    public function registerUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'phone'    => 'required|string|max:20|unique:users,phone',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat, silahkan login');
    }

    // ==========================
    // REGISTER PEMILIK
    // ==========================
    public function registerOwner(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'phone'    => 'required|string|max:20|unique:users,phone',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'pemilik',
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun pemilik berhasil dibuat, silahkan login');
    }
}

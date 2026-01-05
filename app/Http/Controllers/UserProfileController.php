<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Activitylog\Models\Activity;

class UserProfileController extends Controller
{
    /**
     * 1. HALAMAN PROFIL USER
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        // Redirect khusus pemilik
        if ($user->role === 'pemilik') {
            return redirect()->route('pemilik.profile');
        }

        $favorites = collect([]);

        // Ambil 5 aktivitas terakhir user
        $activities = class_exists(Activity::class)
            ? Activity::where('causer_id', $user->id)
                ->latest()
                ->limit(5)
                ->get()
            : collect([]);

        $preferences = [
            'budget'  => 'Rp 500rb - 1.5jt',
            'kampus'  => 'ITH Parepare',
        ];

        return view('user.profile.index', compact(
            'user',
            'favorites',
            'activities',
            'preferences'
        ));
    }

    /**
     * 2. FORM EDIT PROFIL
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('user.profile.edit', compact('user'));
    }

    /**
     * 3. UPDATE DATA PROFIL
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Validasi
        $validated = $request->validate([
            'name'    => 'required|string|min:3|max:255',
            'email'   => ['required', 'email:dns', Rule::unique('users')->ignore($user->id)],
            'phone'   => 'required|string|min:10|max:15',
            'address' => 'required|string|max:500',
            'avatar'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /**
         * Normalisasi nomor WhatsApp
         */
        $phone = preg_replace('/[^0-9]/', '', $validated['phone']);
        if (substr($phone, 0, 2) === '08') {
            $phone = '62' . substr($phone, 1);
        }

        /**
         * Update data utama
         */
        $user->fill([
            'name'    => ucwords(strtolower(strip_tags($validated['name']))),
            'email'   => $validated['email'],
            'phone'   => $phone,
            'address' => strip_tags($validated['address']),
        ]);

        /**
         * Upload avatar (jika ada)
         */
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        /**
         * Reset verifikasi email jika berubah
         */
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        /**
         * Simpan perubahan jika ada
         */
        if ($user->isDirty()) {
            $user->save();

            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->log('✏️ Memperbarui data profil');
        }

        $route = $user->role === 'pemilik'
            ? 'pemilik.dashboard'
            : 'user.profile';

        return redirect()->route($route)
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * 4. UPDATE PASSWORD
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers(),
            ],
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('🔐 Mengubah password akun');

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * 5. KIRIM ULANG VERIFIKASI EMAIL
     */
    public function resendVerification()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return back()->with('success', 'Akun sudah terverifikasi.');
        }

        $user->sendEmailVerificationNotification();

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('📩 Mengirim ulang link verifikasi email');

        return back()->with(
            'success',
            'Link verifikasi telah dikirim. Silakan cek email.'
        );
    }
}

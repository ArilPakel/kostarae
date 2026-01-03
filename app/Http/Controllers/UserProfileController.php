<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash; // ✅ TAMBAHAN: Wajib ada untuk Hash::make
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Auth\Events\Verified;

class UserProfileController extends Controller
{
    // 1. HALAMAN PROFIL (READ ONLY)
    public function index()
    {
        $user = Auth::user();

        // Cek Role: Jika Owner, lempar ke halaman khusus Owner
        if ($user->role === 'pemilik') {
            return redirect()->route('owner.profile');
        } // ✅ PERBAIKAN: Kurung kurawal ditutup di sini agar kode di bawahnya jalan untuk user biasa

        // Data Dummy (Silakan ganti dengan relasi asli jika sudah ada)
        $favorites = collect([]);
        // Pastikan activity log package sudah terinstall
        $activities = class_exists(Activity::class) 
            ? Activity::where('causer_id', $user->id)->latest()->take(5)->get() 
            : collect([]); 
            
        $preferences = ['budget' => 'Rp 500rb - 1.5jt', 'kampus' => 'ITH Parepare'];

        return view('user.profile.index', compact('user', 'favorites', 'activities', 'preferences'));
    }

    // 2. HALAMAN FORM EDIT
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    // 3. PROSES UPDATE DATA (FULL LOGIC)
    public function update(Request $request)
    {
        $user = Auth::user();

        // A. Validasi Input Strict
        $request->validate([
            'name'   => 'required|string|max:255|min:3',
            'email'  => ['required', 'email:dns', Rule::unique('users')->ignore($user->id)],
            'phone'  => 'required|string|min:10|max:15', // Regex di handle di logika bawah
            'address' => 'required|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.unique'  => 'Email ini sudah digunakan oleh pengguna lain.',
            'avatar.max'    => 'Ukuran foto maksimal 2MB.',
            'avatar.image'  => 'File harus berupa gambar (JPG/PNG).',
            'address.required' => 'Alamat domisili wajib diisi.',
            'address.max'      => 'Alamat tidak boleh lebih dari 500 karakter.',
        ]);

        // 2. Simpan Data
        $user = auth()->user();
        
        $user->update([
            'name'    => strip_tags($request->name), // Sanitasi dasar
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => strip_tags($request->address), // Sanitasi alamat
        ]);

        // 3. Redirect kembali (Cek role agar redirect tepat)
        $route = $user->role === 'pemilik' ? 'owner.profile' : 'user.profile';
        
        return redirect()->route($route)->with('status', 'profile-updated');

        // B. Handle Upload Avatar
        if ($request->hasFile('avatar')) {
            // 1. Hapus avatar lama (Kecuali default)
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            // 2. Simpan baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // C. Normalisasi Nomor WhatsApp (08xx / +62xx -> 62xx)
        $phone = $request->phone;
        // Hapus karakter non-angka
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Ubah 08 menjadi 628
        if (substr($phone, 0, 2) === '08') {
            $phone = '62' . substr($phone, 1);
        }
        // Jika input 628 (tanpa +), biarkan.
        
        $user->phone = $phone;

        // D. Update Data Text
        $user->name = ucwords(strtolower($request->name)); // Auto Capitalize

        // E. Cek Perubahan Email (Reset Verifikasi jika berubah)
        if ($user->email !== $request->email) {
            $user->email = $request->email;
            $user->email_verified_at = null; // Reset status verifikasi
            // Opsional: $user->sendEmailVerificationNotification();
        }
        
        // F. Simpan Data
        if ($user->isDirty()) {
            $user->save();

            // Catat Log Aktivitas
            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->log('✏️ Memperbarui data profil');

            return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui!');
        }

        return redirect()->route('user.profile')->with('info', 'Tidak ada perubahan data.');
    }

    // 4. PROSES GANTI PASSWORD (SECURE & LOGGED)
    public function updatePassword(Request $request)
    {
        // Validasi Ketat Sesuai Standar Modern
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'], // Validasi bawaan Laravel
            'password' => [
                'required', 
                'confirmed', 
                'min:8', // Syntax alternatif yang lebih ringkas
                Password::min(8) // Minimal 8 karakter
                    ->letters()  // Wajib ada huruf
                    ->mixedCase() // Wajib huruf besar & kecil
                    ->numbers()   // Wajib angka
            ],
        ], [
            'current_password.current_password' => 'Password saat ini tidak cocok.',
            'password.confirmed' => 'Konfirmasi password baru tidak sama.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.mixed' => 'Password harus mengandung huruf besar dan kecil.',
            'password.numbers' => 'Password harus mengandung angka.',
        ]);

        $user = Auth::user();

        // Update Password (Hashed)
        $user->update([
            'password' => Hash::make($validated['password']) // ✅ Hash sekarang berfungsi karena Facade sudah di-import
        ]);

        // Catat Log Aktivitas (Tanpa menyimpan password asli)
        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('🔐 Berhasil mengubah password akun');

        return back()->with('success', 'Password berhasil diperbarui! Akun Anda kini lebih aman.');
    }

    // 5. KIRIM ULANG VERIFIKASI EMAIL (DENGAN VALIDASI & LOG)
    public function resendVerification(Request $request)
    {
        $user = Auth::user();

        // Cek lagi apakah user iseng klik padahal sudah verifikasi
        if ($user->hasVerifiedEmail()) {
            return back()->with('success', 'Akun Anda sudah terverifikasi sebelumnya.');
        }

        // Kirim Notifikasi (Laravel Built-in)
        $user->sendEmailVerificationNotification();

        // Catat Log Aktivitas
        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('📩 Mengirim ulang link verifikasi email');

        return back()->with('success', 'Link verifikasi baru telah dikirim! Silakan cek inbox atau folder spam email Anda.');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash; // Wajib ada untuk update password
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
        } 

        // Data Tambahan (Pastikan handling error jika package Activity log belum ada)
        $favorites = collect([]);
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

    // 3. PROSES UPDATE DATA (LOGIKA YANG SUDAH DIPERBAIKI)
    public function update(Request $request)
    {
        $user = Auth::user();

        // A. Validasi Input
        $request->validate([
            'name'    => 'required|string|max:255|min:3',
            'email'   => ['required', 'email:dns', Rule::unique('users')->ignore($user->id)],
            'phone'   => 'required|string|min:10|max:15',
            'address' => 'required|string|max:500',
            'avatar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ], [
            'name.required'    => 'Nama lengkap wajib diisi.',
            'email.unique'     => 'Email ini sudah digunakan oleh pengguna lain.',
            'avatar.max'       => 'Ukuran foto maksimal 2MB.',
            'avatar.image'     => 'File harus berupa gambar (JPG/PNG).',
            'address.required' => 'Alamat domisili wajib diisi.',
            'address.max'      => 'Alamat tidak boleh lebih dari 500 karakter.',
        ]);

        // --- MULAI PROSES DATA (JANGAN SAVE DULU) ---

        // B. Normalisasi Nomor WhatsApp (08xx -> 62xx)
        $phone = preg_replace('/[^0-9]/', '', $request->phone); // Hapus karakter selain angka
        if (substr($phone, 0, 2) === '08') {
            $phone = '62' . substr($phone, 1);
        }
        $user->phone = $phone;

        // C. Update Data Teks
        $user->name = ucwords(strtolower(strip_tags($request->name))); // Kapitalisasi Nama
        $user->address = strip_tags($request->address);

        // D. Cek Perubahan Email (Reset Verifikasi jika berubah)
        if ($user->email !== $request->email) {
            $user->email = $request->email;
            $user->email_verified_at = null; // Reset status verifikasi
            // Opsional: $user->sendEmailVerificationNotification();
        }

        // E. Handle Upload Avatar (Hapus lama, Upload baru)
        if ($request->hasFile('avatar')) {
            // 1. Hapus avatar lama (Kecuali jika null)
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            // 2. Simpan avatar baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // F. Simpan ke Database (Hanya satu kali di akhir)
        // Gunakan isDirty() untuk mengecek apakah ada data yang berubah
        if ($user->isDirty()) {
            $user->save();

            // Catat Log Aktivitas (Jika package terinstall)
            if (class_exists(Activity::class)) {
                activity()
                    ->performedOn($user)
                    ->causedBy($user)
                    ->log('✏️ Memperbarui data profil');
            }

            // Redirect sesuai role
            $route = $user->role === 'pemilik' ? 'owner.profile' : 'user.profile';
            return redirect()->route($route)->with('success', 'Profil berhasil diperbarui!');
        }

        // Jika tidak ada perubahan sama sekali
        $route = $user->role === 'pemilik' ? 'owner.profile' : 'user.profile';
        return redirect()->route($route)->with('info', 'Tidak ada perubahan data.');
    }

    // 4. PROSES GANTI PASSWORD
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'], 
            'password' => [
                'required', 
                'confirmed', 
                'min:8', 
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
        ], [
            'current_password.current_password' => 'Password saat ini tidak cocok.',
            'password.confirmed' => 'Konfirmasi password baru tidak sama.',
            'password.min'      => 'Password minimal 8 karakter.',
            'password.mixed'    => 'Password harus mengandung huruf besar dan kecil.',
            'password.numbers'  => 'Password harus mengandung angka.',
        ]);

        $user = Auth::user();

        // Update Password
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        // Catat Log Aktivitas
        if (class_exists(Activity::class)) {
            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->log('🔐 Berhasil mengubah password akun');
        }

        return back()->with('success', 'Password berhasil diperbarui! Akun Anda kini lebih aman.');
    }

    // 5. KIRIM ULANG VERIFIKASI EMAIL
    public function resendVerification(Request $request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return back()->with('success', 'Akun Anda sudah terverifikasi sebelumnya.');
        }

        $user->sendEmailVerificationNotification();

        if (class_exists(Activity::class)) {
            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->log('📩 Mengirim ulang link verifikasi email');
        }

        return back()->with('success', 'Link verifikasi baru telah dikirim! Silakan cek inbox email Anda.');
    }
}
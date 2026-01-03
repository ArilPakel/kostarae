<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report; // Pastikan Model Report sudah ada

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input (Diperbarui agar lebih aman & spesifik)
        $request->validate([
            'name'    => 'required|string|max:255',
            // UBAH: Gunakan Regex untuk validasi nomor HP Indonesia (+62, 62, atau 08)
            'phone'   => ['required', 'string', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,11}$/'],
            // UBAH: Tambahkan :dns untuk memastikan domain email valid
            'email'   => 'required|email:dns',
            // UBAH: Tambahkan minimal karakter agar pesan tidak terlalu pendek
            'message' => 'required|string|min:10',
        ], [
            // TAMBAHAN: Pesan error kustom (agar muncul teks bahasa Indonesia yang jelas)
            'phone.regex' => 'Format nomor HP tidak valid. Gunakan awalan 08 atau +62.',
            'email.email' => 'Alamat email tidak valid.',
            'message.min' => 'Pesan terlalu pendek, mohon jelaskan lebih detail (min. 10 karakter).',
        ]);

        // 2. Simpan ke Database (TIDAK BERUBAH)
        Report::create([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'message' => $request->message,
        ]);

        // 3. Kembali ke halaman kontak dengan pesan sukses (TIDAK BERUBAH)
        // Session 'success' inilah yang akan memicu Modal Pop-up di frontend
        return redirect()->back()->with('success', 'Laporan berhasil dikirim! Terima kasih.');
    }
}
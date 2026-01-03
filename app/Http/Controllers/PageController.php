<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost; 
use Carbon\Carbon; // <--- WAJIB ADA: Untuk mengecek tanggal iklan

class PageController extends Controller
{
    public function home()
    {
        $now = \Carbon\Carbon::now(); // Ambil waktu sekarang

        // 1. AMBIL IKLAN KOST (MANUAL & BERBAYAR)
        // Syarat: Status diterima, is_promoted aktif, dan tanggal masih berlaku
        $iklanKost = Kost::active() // ScopeActive (status = diterima)
            ->where('is_promoted', true)
            ->whereNotNull('promoted_start_date')
            ->whereNotNull('promoted_end_date')
            ->where('promoted_start_date', '<=', $now)
            ->where('promoted_end_date', '>=', $now)
            ->with(['reviews', 'pemilik']) // Load relasi
            ->withAvg('reviews', 'rating') // Hitung rata-rata rating
            ->inRandomOrder() // Acak urutan iklan agar adil
            ->take(3) // Batasi maksimal 3 iklan tampil
            ->get();

        // Ambil ID dari kost yang sudah jadi iklan agar tidak muncul lagi di bawah
        $iklanIds = $iklanKost->pluck('id')->toArray();

        // 2. AMBIL REKOMENDASI KOST (OTOMATIS & ORGANIK)
        // Syarat: Status diterima, BUKAN iklan yang sedang tampil di atas
        $rekomendasiKost = Kost::active()
            ->whereNotIn('id', $iklanIds) // Exclude/Kecualikan kost iklan
            ->with(['reviews', 'pemilik'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            // Filter Kualitas (Rating tinggi & ada ulasan)
            ->having('reviews_avg_rating', '>=', 4.0) 
            ->having('reviews_count', '>=', 2)
            ->latest() // Urutkan dari yang terbaru
            ->take(8)  // Batasi 8 rekomendasi
            ->get();

        // Filter tambahan: Pastikan data lengkap (menggunakan Accessor is_recommendable di Model)
        $rekomendasiKost = $rekomendasiKost->filter(function ($kost) {
            return $kost->is_recommendable; 
        });

        // Kirim data ke View
        // PENTING: Nama variabel harus sama dengan yang di home.blade.php ($iklanKost & $rekomendasiKost)
        return view('pages.home', compact('iklanKost', 'rekomendasiKost'));
    
    }
    
    // --- Method Lain Tetap Sama ---
    public function kontak() { return view('pages.kontak'); }
    public function panduan() { return view('pages.panduan'); }
    public function sdank() { return view('pages.sdank'); }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost; 
use App\Models\Review; // [TAMBAHAN] Import Model Review
use Carbon\Carbon; 

class PageController extends Controller
{
    public function home()
    {
        $now = Carbon::now();

        // -----------------------------------------------------------
        // 1. AMBIL IKLAN KOST (Ads Berbayar)
        // -----------------------------------------------------------
        // Diubah menjadi take(4) agar grid rapi 4 kolom
        $iklanKost = Kost::active() 
            ->where('is_promoted', true)
            ->whereNotNull('promoted_start_date')
            ->whereNotNull('promoted_end_date')
            ->where('promoted_start_date', '<=', $now)
            ->where('promoted_end_date', '>=', $now)
            ->with(['reviews', 'pemilik']) 
            ->withAvg('reviews', 'rating')
            ->withCount('reviews') // [TAMBAHAN] Agar jumlah ulasan muncul
            ->inRandomOrder()
            ->take(4) // [UBAH] Jadi 4
            ->get();

        $iklanIds = $iklanKost->pluck('id')->toArray();

        // -----------------------------------------------------------
        // 2. AMBIL REKOMENDASI (SINKRON DENGAN ADMIN)
        // -----------------------------------------------------------
        // PRIORITAS A: Pilihan Manual Admin (Bintang)
        $rekomendasiKost = Kost::active()
            ->whereNotIn('id', $iklanIds)
            ->where('is_recommended', true) 
            ->with(['reviews', 'pemilik']) 
            ->withAvg('reviews', 'rating') 
            ->withCount('reviews') // [TAMBAHAN] Sinkron dengan Admin
            ->latest()
            ->take(4) // [UBAH] Jadi 4 sesuai permintaan
            ->get();

        // PRIORITAS B: Otomatis (Jika Admin tidak memilih apapun)
        if ($rekomendasiKost->isEmpty()) {
            $rekomendasiKost = Kost::active()
                ->whereNotIn('id', $iklanIds)
                ->with(['reviews', 'pemilik'])
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->orderByDesc('reviews_avg_rating') 
                ->orderByDesc('reviews_count')      
                ->take(4) // [TETAP] 4
                ->get();
        }

        // -----------------------------------------------------------
        // 3. KOST TERBARU (Opsional)
        // -----------------------------------------------------------
        $terbaru = Kost::active()
            ->whereNotIn('id', $iklanIds)
            ->latest()
            ->take(8) // Terbaru boleh lebih banyak (misal 8 untuk slider/grid 2 baris)
            ->get();

        // Kirim data ke View
        return view('pages.home', [
            'iklanKost'       => $iklanKost,
            'rekomendasiKost' => $rekomendasiKost, 
            'recommendations' => $rekomendasiKost, // Alias untuk kompatibilitas view lama
            'terbaru'         => $terbaru          
        ]);
    }

    // ==========================================
    // METHOD BARU: HALAMAN SEMUA ULASAN
    // ==========================================
    public function reviews()
    {
        // Ambil ulasan yang TIDAK disembunyikan admin
        $reviews = Review::with(['user', 'kost'])
            ->where('is_hidden', false) 
            ->latest() 
            ->paginate(12); // Tampilkan 12 per halaman

        // Hitung statistik ringkas untuk header halaman
        $stats = [
            'avg'   => Review::where('is_hidden', false)->avg('rating'),
            'count' => Review::where('is_hidden', false)->count()
        ];

        // Pastikan Anda sudah membuat file view: resources/views/pages/reviews.blade.php
        return view('pages.reviews', compact('reviews', 'stats'));
    }
    
    // --- Method Halaman Statis ---
    public function kontak() { return view('pages.kontak'); }
    public function panduan() { return view('pages.panduan'); }
    public function sdank() { return view('pages.sdank'); }
}
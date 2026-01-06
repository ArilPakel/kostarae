<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost; 
use Carbon\Carbon; 

class PageController extends Controller
{
    public function home()
    {
        $now = Carbon::now();

        // -----------------------------------------------------------
        // 1. AMBIL IKLAN KOST (MANUAL & BERBAYAR)
        // -----------------------------------------------------------
        $iklanKost = Kost::active() 
            ->where('is_promoted', true)
            ->whereNotNull('promoted_start_date')
            ->whereNotNull('promoted_end_date')
            ->where('promoted_start_date', '<=', $now)
            ->where('promoted_end_date', '>=', $now)
            ->with(['reviews', 'pemilik']) // HAPUS 'kostImages' agar tidak error
            ->withAvg('reviews', 'rating')
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Ambil ID iklan agar tidak muncul double di bawah
        $iklanIds = $iklanKost->pluck('id')->toArray();

        // -----------------------------------------------------------
        // 2. AMBIL REKOMENDASI (SORTING RATING)
        // -----------------------------------------------------------
        $rekomendasiKost = Kost::active()
            ->whereNotIn('id', $iklanIds)
            ->with(['reviews', 'pemilik']) // HAPUS 'kostImages'
            ->withAvg('reviews', 'rating') // Hitung Rating
            ->withCount('reviews')         // Hitung Jumlah Ulasan
            
            // LOGIKA PINTAR: Urutkan rating tertinggi, lalu ulasan terbanyak
            ->orderByDesc('reviews_avg_rating') 
            ->orderByDesc('reviews_count')      
            ->take(8)
            ->get();

        // -----------------------------------------------------------
        // 3. FALLBACK (JARING PENGAMAN)
        // -----------------------------------------------------------
        // Jika belum ada kost yang direview sama sekali, ambil kost TERBARU
        if ($rekomendasiKost->isEmpty()) {
            $rekomendasiKost = Kost::active()
                ->whereNotIn('id', $iklanIds)
                ->with(['reviews', 'pemilik']) // HAPUS 'kostImages'
                ->withAvg('reviews', 'rating')
                ->latest() // Urutkan dari yang terbaru
                ->take(8)
                ->get();
        }

        // Kirim data ke View
        return view('pages.home', [
            'iklanKost'       => $iklanKost,
            'rekomendasiKost' => $rekomendasiKost, 
            'recommendations' => $rekomendasiKost // Variabel cadangan
        ]);
    }
    
    // --- Method Lain Tetap Sama ---
    public function kontak() { return view('pages.kontak'); }
    public function panduan() { return view('pages.panduan'); }
    public function sdank() { return view('pages.sdank'); }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // ==========================================
        // 🔹 BAGIAN 1: QUERY IKLAN KOST (PROMOSI)
        // ==========================================
        // Kriteria: Status Aktif + Flag Promosi True + Dalam Periode Tanggal
        $iklanKost = Kost::active() // Menggunakan scopeActive
            ->where('is_promoted', true)
            ->whereDate('promoted_start_date', '<=', $now)
            ->whereDate('promoted_end_date', '>=', $now)
            ->with(['pemilik', 'reviews']) // Eager load
            ->withAvg('reviews', 'rating') // Tetap hitung rating untuk display, tapi tidak untuk filter
            ->inRandomOrder() // Supaya adil bagi pengiklan, urutan acak setiap refresh
            ->take(4) // Batasi jumlah iklan (misal 3 slot)
            ->get();


        // ==========================================
        // 🔹 BAGIAN 2: QUERY REKOMENDASI (KUALITAS)
        // ==========================================
        // Kriteria: Status Aktif + Rating >= 4.0 + Min 2 Review
        // exclude($iklanKost) -> Opsional: Agar kost yang sudah muncul di iklan tidak double di rekomendasi
        
        $idsIklan = $iklanKost->pluck('id')->toArray();

        $rekomendasiKost = Kost::active()
            ->whereNotIn('id', $idsIklan) // Cegah duplikasi tampilan jika kost iklan juga bagus ratingnya
            ->with(['pemilik', 'reviews'])
            ->withAvg('reviews', 'rating') // Menghasilkan kolom virtual 'reviews_avg_rating'
            ->withCount('reviews')         // Menghasilkan kolom virtual 'reviews_count'
            ->having('reviews_avg_rating', '>=', 4.0) // Filter Rating
            ->having('reviews_count', '>=', 2)        // Filter Jumlah Ulasan
            ->orderByDesc('reviews_avg_rating')       // Urutkan dari rating tertinggi
            ->orderByDesc('reviews_count')            // Lalu dari jumlah ulasan terbanyak
            ->take(6)
            ->get();

        // ==========================================
        // 🔹 PENANGANAN FALLBACK (Jika Rekomendasi Kosong)
        // ==========================================
        // Jika sistem masih baru dan belum ada review, tampilkan kost terbaru sebagai rekomendasi
        if ($rekomendasiKost->isEmpty()) {
            $rekomendasiKost = Kost::active()
                ->whereNotIn('id', $idsIklan)
                ->with(['pemilik'])
                ->withAvg('reviews', 'rating')
                ->latest() // Fallback ke updated_at terbaru
                ->take(6)
                ->get();
        }

        return view('welcome', compact('iklanKost', 'rekomendasiKost'));
    }
}
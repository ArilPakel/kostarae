<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kost;
use App\Models\Report; // Menggunakan Report untuk pesan masuk (sesuai kode Anda)
use Spatie\Activitylog\Models\Activity; // Menggunakan Spatie untuk log aktivitas
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK UTAMA
        // Disatukan dalam array '$stats' agar rapi dan sesuai dengan pemanggilan di View
        $stats = [
            'total_kost'    => Kost::count(),
            'pending'       => Kost::where('status', 'pending')->count(),
            'active'        => Kost::where('status', 'diterima')->count(),
            'rejected'      => Kost::where('status', 'ditolak')->count(),
        ];

        // 2. PESAN MASUK (5 Terbaru)
        // Kita ambil dari model Report sesuai struktur database Anda sebelumnya
        $latestMessages = Report::latest()->take(5)->get();

        // 3. LOG AKTIVITAS TERBARU
        // Mengambil data dari tabel activity_log (Spatie)
        // Pastikan Anda sudah menginstall Spatie Activitylog
        $activities = Activity::latest()->with('causer')->take(6)->get();


        // =================================================================
        // 4. LOGIKA REKOMENDASI BARU (STRICT FILTER)
        // =================================================================
        // Hanya mengambil kost yang memenuhi syarat 'is_recommendable' di Model
        $recommendedKosts = Kost::with(['pemilik'])
            ->withAvg('reviews', 'rating') // Wajib load agar rating terbaca
            ->withCount('reviews')         // Wajib load agar jumlah review terbaca
            ->where('status', 'diterima')
            ->get() // Ambil semua data aktif dulu untuk difilter PHP
            ->filter(function ($kost) {
                // Filter hanya yang memenuhi syarat: Rating >=4, Review >=2, Data 100%
                return $kost->is_recommendable; 
            })
            ->sortByDesc('reviews_avg_rating') // Urutkan dari rating tertinggi
            ->take(5); // Ambil 5 terbaik

        return view('admin.dashboard.index', compact(
            'stats', 
            'latestMessages', 
            'activities',
            'recommendedKosts' 
        ));
    }

}
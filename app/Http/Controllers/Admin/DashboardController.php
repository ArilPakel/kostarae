<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kost;
use App\Models\Report; 
use App\Models\User; // [TAMBAHAN] Import Model User
use Spatie\Activitylog\Models\Activity; 
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK UTAMA (TETAP)
        $stats = [
            'total_kost'    => Kost::count(),
            'pending'       => Kost::where('status', 'pending')->count(),
            'active'        => Kost::whereIn('status', ['diterima', 'aktif'])->count(),
            'rejected'      => Kost::where('status', 'ditolak')->count(),
        ];

        // 2. PESAN MASUK (TETAP)
        $latestMessages = Report::latest()->take(5)->get();

        // 3. LOG AKTIVITAS TERBARU (TETAP)
        $activities = Activity::latest()->with('causer')->take(6)->get();

        // 4. USER ONLINE (BARU - LOGIKA REALTIME)
        // Memeriksa cache user yang aktif dalam 5 menit terakhir
        // Pastikan Anda sudah menambahkan method isOnline() di Model User
        $onlineUsersCount = User::all()->filter->isOnline()->count();

        // =================================================================
        // 5. LOGIKA REKOMENDASI BARU (SINKRONISASI BERANDA)
        // =================================================================
        
        // A. Cek Kost yang Dicentang Manual oleh Admin
        $rekomendasiBeranda = Kost::with(['pemilik'])
            ->whereIn('status', ['diterima', 'aktif'])
            ->where('is_recommended', true)
            ->latest()
            ->take(5)
            ->get();

        // B. Cek Mode: Apakah ada rekomendasi manual?
        $isManualMode = $rekomendasiBeranda->isNotEmpty();

        // C. Fallback: Jika Admin BELUM mencentang apapun, gunakan Rating Tertinggi
        if (!$isManualMode) {
            $rekomendasiBeranda = Kost::with(['pemilik'])
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->whereIn('status', ['diterima', 'aktif'])
                ->orderByDesc('reviews_avg_rating')
                ->orderByDesc('reviews_count')
                ->take(5)
                ->get();
        }

        return view('admin.dashboard.index', compact(
            'stats', 
            'latestMessages', 
            'activities',
            'rekomendasiBeranda', 
            'isManualMode',
            'onlineUsersCount' // [TAMBAHAN] Kirim ke View
        ));
    }
}
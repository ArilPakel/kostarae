<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

// --- [IMPORT YANG WAJIB DITAMBAHKAN] ---
use Spatie\Activitylog\Models\Activity; // Untuk function index (Activity Log)
use App\Models\User;                    // Untuk function exportPdf
use App\Models\Kost;                    // Untuk function exportPdf
use App\Models\Review;                  // Untuk function exportPdf
use Barryvdh\DomPDF\Facade\Pdf;         // Untuk library PDF
// ---------------------------------------

class ReportController extends Controller
{
    /**
     * Menampilkan Halaman Laporan Aktivitas (Log System)
     */
    public function index(Request $request)
    {
        // 1. STATISTIK RINGKAS
        $today = Carbon::today();
        
        $stats = [
            'total'    => Activity::count(),
            'today'    => Activity::whereDate('created_at', $today)->count(),
            'login'    => Activity::where('description', 'like', '%login%')
                                  ->orWhere('description', 'like', '%masuk%')->count(),
            'critical' => Activity::where('description', 'like', '%hapus%')
                                  ->orWhere('description', 'like', '%delete%')->count(),
        ];

        // 2. QUERY UTAMA
        $query = Activity::with('causer')->latest(); 

        // Filter: Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        } elseif ($request->filled('date_filter') && $request->date_filter == 'today') {
            $query->whereDate('created_at', $today);
        }

        // Filter: Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('causer', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // 3. PAGINATION
        $activities = $query->paginate(20)->withQueryString();

        return view('admin.reports.index', compact('activities', 'stats'));
    }

    /**
     * Detail Laporan Aktivitas
     */
    public function show($id)
    {
        $report = Activity::with('causer')->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    /**
     * Export PDF Laporan Ekosistem
     * (Digunakan oleh tombol di halaman Laporan Ekosistem)
     */
    public function exportPdf()
    {
        // 1. AMBIL DATA STATISTIK EKOSISTEM
        $stats = [
            'total_user'   => User::where('role', 'user')->count(),
            'total_owner'  => User::where('role', 'pemilik')->count(),
            'total_kost'   => Kost::where('status', 'diterima')->count(),
            'pending_kost' => Kost::where('status', 'pending')->count(),
            'avg_rating'   => Review::avg('rating') ?? 0,
            'total_review' => Review::count(),
        ];

        // 2. AMBIL DATA TOP KOST (Sampel Data untuk Tabel PDF)
        $topKosts = Kost::with('pemilik')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', 'diterima')
            ->orderByDesc('reviews_avg_rating')
            ->take(10) // Batasi 10 baris agar muat di PDF A4
            ->get();

        // 3. SETUP DATA UNTUK VIEW PDF
        $data = [
            'title'     => 'Laporan Ekosistem Kostarae',
            'date'      => Carbon::now()->translatedFormat('d F Y'),
            'time'      => Carbon::now()->format('H:i'),
            'admin'     => auth()->user()->name,
            'stats'     => $stats,
            'topKosts'  => $topKosts
        ];

        // 4. RENDER PDF
        // Pastikan Anda sudah membuat file view: resources/views/admin/reports/pdf.blade.php
        $pdf = Pdf::loadView('admin.reports.pdf', $data);
        
        // Set ukuran kertas
        $pdf->setPaper('a4', 'portrait');

        // Stream (Buka di browser)
        return $pdf->download('Laporan_Ekosistem_Kostarae_' . date('Ymd_His') . '.pdf');
    }
}
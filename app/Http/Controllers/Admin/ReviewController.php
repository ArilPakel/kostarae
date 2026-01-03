<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Kost;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        // ==========================================
        // 1. STATISTIK KARTU (Cards)
        // ==========================================
        $stats = [
            'total_user'   => User::count(),
            'total_kost'   => Kost::count(),
            'total_owner'  => User::where('role', 'pemilik')->count(),
            'pending_kost' => Kost::where('status', 'pending')->count(),
            'avg_rating'   => Review::avg('rating') ?? 0,
            'total_review' => Review::count(),
        ];

        // ==========================================
        // 2. QUERY DATA ULASAN (Table)
        // ==========================================
        $query = $this->buildFilterQuery($request);
        $reviews = $query->latest()->paginate(10)->withQueryString();

        // ==========================================
        // 3. STATISTIK DASHBOARD (Top/Low Kost)
        // ==========================================
        $needModeration = Review::where('rating', '<=', 2)->orWhere('is_hidden', true)->count();

        // Top 5 Kost
        $topKosts = Kost::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->having('reviews_count', '>', 0)
            ->orderByDesc('reviews_avg_rating')
            ->take(5)->get();

        // Low 5 Kost (Terburuk)
        $lowKosts = Kost::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->having('reviews_count', '>', 0)
            ->orderBy('reviews_avg_rating', 'asc')
            ->take(5)->get();

        // ==========================================
        // 4. CHART DATA (GRAFIK PERTUMBUHAN)
        // ==========================================
        $chartData = [
            'labels' => [],
            'users'  => [],
            'kosts'  => []
        ];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $formattedDate = $date->format('Y-m-d');
            
            $chartData['labels'][] = $date->format('D'); 
            $chartData['users'][] = User::whereDate('created_at', $formattedDate)->count();
            $chartData['kosts'][] = Kost::whereDate('created_at', $formattedDate)->count();
        }

        // ==========================================
        // 5. KIRIM SEMUA KE VIEW
        // ==========================================
        return view('admin.reviews.index', compact(
            'reviews', 
            'stats', 
            'needModeration', 
            'topKosts', 
            'lowKosts',
            'chartData'
        ));
    }

    // --- Helper Query Filter ---
    private function buildFilterQuery(Request $request)
    {
        $query = Review::with(['user', 'kost.pemilik']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('kost', fn ($k) => $k->where('nama_kost', 'like', "%$search%"))
                  ->orWhere('comment', 'like', "%$search%");
            });
        }
        
        if ($request->filled('rating')) {
            $request->rating === 'low' ? $query->where('rating', '<=', 2) : $query->where('rating', $request->rating);
        }

        if ($request->filled('status')) {
            $query->where('is_hidden', $request->status === 'hidden');
        }

        return $query;
    }

    // --- Fungsi Lain ---
    public function toggleVisibility($id) {
        $r = Review::findOrFail($id);
        $r->is_hidden = !$r->is_hidden;
        $r->save();
        return back()->with('success', 'Status ulasan diperbarui.');
    }

    public function destroy($id) {
        Review::findOrFail($id)->delete();
        return back()->with('success', 'Ulasan dihapus.');
    }
    
    // --- FUNGSI EXPORT PDF YANG SUDAH DIPERBAIKI ---
    public function exportPdf()
    {
        // 1. SIAPKAN DATA STATISTIK ($stats)
        // Wajib ada karena PDF Laporan Ekosistem membutuhkannya
        $stats = [
            'total_user'   => User::where('role', 'user')->count(),
            'total_owner'  => User::where('role', 'pemilik')->count(),
            'total_kost'   => Kost::where('status', 'diterima')->count(),
            'pending_kost' => Kost::where('status', 'pending')->count(),
            'avg_rating'   => Review::avg('rating') ?? 0,
            'total_review' => Review::count(),
        ];

        // 2. SIAPKAN DATA TOP KOST ($topKosts)
        // Wajib ada untuk tabel "Top 5 Kualitas Mitra" di PDF
        $topKosts = Kost::with('pemilik')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', 'diterima')
            ->orderByDesc('reviews_avg_rating')
            ->take(5)
            ->get();

        // 3. SIAPKAN DATA UTAMA
        $data = [
            'title'     => 'Laporan Ekosistem Kostarae',
            'date'      => Carbon::now()->translatedFormat('d F Y'),
            'admin'     => auth()->user()->name,
            'stats'     => $stats,     // <-- Variable ini yang sebelumnya error
            'topKosts'  => $topKosts   // <-- Variable ini juga dibutuhkan
        ];

        // 4. RENDER PDF
        $pdf = Pdf::loadView('admin.reviews.pdf', $data);
        
        // Ubah ke Portrait karena desain Laporan Ekosistem bentuknya vertikal
        $pdf->setPaper('a4', 'portrait'); 

        return $pdf->download('Laporan_Ekosistem_Kostarae_' . date('Ymd_His') . '.pdf');
    }
}
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
            'avg_rating'   => number_format(Review::avg('rating') ?? 0, 1),
            'total_review' => Review::count(),
        ];

        // ==========================================
        // 2. QUERY DATA ULASAN
        // ==========================================
        $query = $this->buildFilterQuery($request);
        
        $reviews = $query->with(['user', 'kost.pemilik'])
                         ->latest()
                         ->paginate(10);

        $reviews->appends($request->all());

        // ==========================================
        // 3. STATISTIK DASHBOARD
        // ==========================================
        $needModeration = Review::where('rating', '<=', 2)->orWhere('is_hidden', true)->count();

        $topKosts = Kost::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->having('reviews_count', '>', 0)
            ->orderByDesc('reviews_avg_rating')
            ->take(5)->get();

        $lowKosts = Kost::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->having('reviews_count', '>', 0)
            ->orderBy('reviews_avg_rating', 'asc')
            ->take(5)->get();

        // ==========================================
        // 4. CHART DATA
        // ==========================================
        $chartData = [
            'labels' => [],
            'users'  => [],
            'kosts'  => []
        ];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->locale('id');
            $formattedDate = $date->format('Y-m-d');
            
            $chartData['labels'][] = $date->translatedFormat('D'); 
            $chartData['users'][]  = User::whereDate('created_at', $formattedDate)->count();
            $chartData['kosts'][]  = Kost::whereDate('created_at', $formattedDate)->count();
        }

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
        $query = Review::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('kost', fn ($k) => $k->where('nama_kost', 'like', "%$search%"))
                  ->orWhere('comment', 'like', "%$search%");
            });
        }
        
        if ($request->filled('rating')) {
            if ($request->rating === 'low') {
                $query->where('rating', '<=', 2);
            } else {
                $query->where('rating', $request->rating);
            }
        }

        if ($request->filled('status')) {
            $isHidden = $request->status === 'hidden';
            $query->where('is_hidden', $isHidden);
        }

        return $query;
    }

    public function toggleVisibility($id) {
        $r = Review::findOrFail($id);
        $r->is_hidden = !$r->is_hidden;
        $r->save();
        return back()->with('success', 'Status visibilitas ulasan berhasil diperbarui.');
    }

    public function destroy($id) {
        Review::findOrFail($id)->delete();
        return back()->with('success', 'Ulasan berhasil dihapus secara permanen.');
    }
    
    // ==========================================
    // PERBAIKAN DI SINI (METHOD EXPORT PDF)
    // ==========================================
    public function exportPdf()
    {
        // 1. Data Statistik Ringkas (LENGKAP)
        // PERBAIKAN: Menambahkan 'total_kost' dan 'pending_kost'
        $stats = [
            'total_kost'    => Kost::count(), 
            'active_kost'   => Kost::whereIn('status', ['diterima', 'aktif'])->count(),
            'pending_kost'  => Kost::where('status', 'pending')->count(), 
            'total_user'    => User::where('role', 'user')->count(),
            'total_owner'   => User::where('role', 'pemilik')->count(),
            'avg_rating'    => number_format(Review::avg('rating') ?? 0, 1),
            'total_review'  => Review::count(),
        ];

        // 2. Data Top Kost
        $topKosts = Kost::with('pemilik')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->whereIn('status', ['diterima', 'aktif']) // Sesuaikan status aktif Anda
            ->having('reviews_count', '>', 0)
            ->orderByDesc('reviews_avg_rating')
            ->take(5)
            ->get();

        // 3. Data Ulasan Terbaru
        $reviews = Review::with(['user', 'kost'])
            ->latest()
            ->limit(50) 
            ->get();

        // 4. Packing Data
        $data = [
            'title'     => 'Laporan Ekosistem Kostarae',
            'date'      => Carbon::now()->locale('id')->translatedFormat('l, d F Y'),
            'admin'     => auth()->user()->name ?? 'Administrator',
            'stats'     => $stats,
            'topKosts'  => $topKosts,
            'reviews'   => $reviews
        ];

        // 5. Render PDF
        $pdf = Pdf::loadView('admin.reviews.pdf', $data);
        $pdf->setPaper('a4', 'portrait'); 

        return $pdf->download('Laporan_Ekosistem_Kostarae_' . date('Y-m-d_His') . '.pdf');
    }
}
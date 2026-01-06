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
            'avg_rating'   => number_format(Review::avg('rating') ?? 0, 1), // Dibulatkan 1 desimal
            'total_review' => Review::count(),
        ];

        // ==========================================
        // 2. QUERY DATA ULASAN (Table dengan Filter)
        // ==========================================
        // Menggunakan helper function di bawah
        $query = $this->buildFilterQuery($request);
        
        // Eager Loading relasi user & kost agar tidak N+1 Problem di View
        $reviews = $query->with(['user', 'kost.pemilik'])
                         ->latest()
                         ->paginate(10);

        $reviews->appends($request->all());

        // ==========================================
        // 3. STATISTIK DASHBOARD (Top/Low Kost)
        // ==========================================
        $needModeration = Review::where('rating', '<=', 2)->orWhere('is_hidden', true)->count();

        // Top 5 Kost Terbaik
        $topKosts = Kost::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->having('reviews_count', '>', 0)
            ->orderByDesc('reviews_avg_rating')
            ->take(5)->get();

        // Top 5 Kost Terburuk (Low)
        $lowKosts = Kost::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->having('reviews_count', '>', 0)
            ->orderBy('reviews_avg_rating', 'asc') // Ascending (Kecil ke Besar)
            ->take(5)->get();

        // ==========================================
        // 4. CHART DATA (GRAFIK PERTUMBUHAN)
        // ==========================================
        $chartData = [
            'labels' => [],
            'users'  => [],
            'kosts'  => []
        ];

        // Loop 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->locale('id'); // Set locale ID
            $formattedDate = $date->format('Y-m-d');
            
            // ✅ PERBAIKAN: Gunakan translatedFormat agar hari muncul "Sen", "Sel", dst.
            $chartData['labels'][] = $date->translatedFormat('D'); 
            $chartData['users'][]  = User::whereDate('created_at', $formattedDate)->count();
            $chartData['kosts'][]  = Kost::whereDate('created_at', $formattedDate)->count();
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

    // --- Helper Query Filter (Agar Index lebih rapi) ---
    private function buildFilterQuery(Request $request)
    {
        $query = Review::query();

        // Filter Pencarian (Nama User, Nama Kost, atau Isi Komentar)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('kost', fn ($k) => $k->where('nama_kost', 'like', "%$search%")) // Pastikan kolom DB 'nama_kost' atau 'nama'
                  ->orWhere('comment', 'like', "%$search%");
            });
        }
        
        // Filter Rating
        if ($request->filled('rating')) {
            if ($request->rating === 'low') {
                $query->where('rating', '<=', 2);
            } else {
                $query->where('rating', $request->rating);
            }
        }

        // Filter Status (Disembunyikan/Tampil)
        if ($request->filled('status')) {
            $isHidden = $request->status === 'hidden';
            $query->where('is_hidden', $isHidden);
        }

        return $query;
    }

    // --- Toggle Hide/Show Review ---
    public function toggleVisibility($id) {
        $r = Review::findOrFail($id);
        $r->is_hidden = !$r->is_hidden;
        $r->save();
        return back()->with('success', 'Status visibilitas ulasan berhasil diperbarui.');
    }

    // --- Hapus Review ---
    public function destroy($id) {
        Review::findOrFail($id)->delete();
        return back()->with('success', 'Ulasan berhasil dihapus secara permanen.');
    }
    
    // --- FUNGSI EXPORT PDF (FINAL FIX) ---
    public function exportPdf()
    {
        // 1. Data Statistik Ringkas
        $stats = [
            'total_user'   => User::where('role', 'user')->count(),
            'total_owner'  => User::where('role', 'pemilik')->count(),
            'total_kost_aktif' => Kost::where('status', 'diterima')->count(),
            'avg_rating'   => number_format(Review::avg('rating') ?? 0, 1),
            'total_review' => Review::count(),
        ];

        // 2. Data Top Kost (Untuk Highlight Laporan)
        $topKosts = Kost::with('pemilik')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', 'diterima')
            ->having('reviews_count', '>', 0)
            ->orderByDesc('reviews_avg_rating')
            ->take(5)
            ->get();

        // 3. ✅ TAMBAHAN: Data Ulasan Terbaru (List Tabel)
        // Kita ambil 50 ulasan terbaru agar PDF tidak terlalu berat/panjang
        $reviews = Review::with(['user', 'kost'])
            ->latest()
            ->limit(50) 
            ->get();

        // 4. Packing Data
        $data = [
            'title'     => 'Laporan Ekosistem Kostarae',
            'date'      => Carbon::now()->locale('id')->translatedFormat('l, d F Y'), // Format tanggal Indo lengkap
            'admin'     => auth()->user()->name ?? 'Administrator',
            'stats'     => $stats,
            'topKosts'  => $topKosts,
            'reviews'   => $reviews // Dikirim ke View PDF agar bisa di-loop
        ];

        // 5. Render PDF
        $pdf = Pdf::loadView('admin.reviews.pdf', $data);
        
        // Set ukuran kertas A4 Portrait
        $pdf->setPaper('a4', 'portrait'); 

        return $pdf->download('Laporan_Ekosistem_Kostarae_' . date('Y-m-d_His') . '.pdf');
    }
}
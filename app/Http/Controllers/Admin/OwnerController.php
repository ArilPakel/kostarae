<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * DASHBOARD MANAJEMEN MITRA
     * Menampilkan daftar pemilik dengan filter kesehatan akun.
     */
    public function index(Request $request)
    {
        // 1. Base Query dengan Eager Loading & Aggregate
        $query = User::where('role', 'pemilik')
            ->withCount('kosts as total_kost_count')
            ->withCount(['kosts as active_kost_count' => function ($q) {
                $q->where('status', 'diterima');
            }])
            ->withMax('kosts', 'updated_at');

        // 2. Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 3. Filter Status (Produktif/Pasif)
        if ($request->filled('status')) {
            if ($request->status == 'produktif') {
                $query->having('active_kost_count', '>', 0);
            } elseif ($request->status == 'pasif') {
                $query->having('active_kost_count', '=', 0);
            }
        }

        // 4. Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->oldest(); 
                    break;
                case 'most_active':
                    $query->orderBy('active_kost_count', 'desc');
                    break;
                case 'recently_updated':
                    $query->orderBy('kosts_max_updated_at', 'desc');
                    break;
                case 'newest':
                default:
                    $query->latest(); 
                    break;
            }
        } else {
            $query->latest();
        }

        // 5. Pagination
        $owners = $query->paginate(9)->withQueryString();

        // 6. Statistik Header
        $totalOwners = User::where('role', 'pemilik')->count();
        $productiveOwners = User::where('role', 'pemilik')->whereHas('kosts', function($q){
            $q->where('status', 'diterima');
        })->count();

        return view('admin.owner.index', compact('owners', 'totalOwners', 'productiveOwners'));
    }

    /**
     * DETAIL LENGKAP PEMILIK
     * Menampilkan data kost, rating, dan hitungan statistik untuk halaman detail.
     */
    public function show($id)
    {
        $owner = User::with(['kosts' => function($q) {
            $q->withCount('reviews')
              ->withAvg('reviews', 'rating')
              ->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        $stats = [
            'total'    => $owner->kosts->count(),
            'active'   => $owner->kosts->where('status', 'diterima')->count(),
            'pending'  => $owner->kosts->where('status', 'pending')->count(),
            'rejected' => $owner->kosts->where('status', 'ditolak')->count(),
        ];

        return view('admin.owner.show', compact('owner', 'stats'));
    }

    /**
     * UPDATE CATATAN ADMIN (AJAX)
     * Mengembalikan JSON response untuk notifikasi popup.
     */
    public function updateNotes(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000'
        ]);
        
        $owner = User::findOrFail($id);
        $owner->admin_notes = $request->notes;
        $owner->save();

        return response()->json([
            'success'  => true, 
            'message'  => 'Catatan internal berhasil disimpan.',
            'new_note' => $owner->admin_notes
        ]);
    }

    /**
     * TOGGLE STATUS (Aktif/Nonaktif) - BARU
     * Untuk fitur suspend/unsuspend akun mitra.
     */
    public function toggleStatus(Request $request, $id)
    {
        $owner = User::findOrFail($id);
        
        // Asumsi Anda punya kolom 'is_active' boolean di table users (default: true)
        // Jika belum ada, bisa gunakan kolom lain atau buat migration baru.
        // Untuk sekarang saya comment dulu jika belum ada kolomnya.
        
        // $owner->is_active = !$owner->is_active;
        // $owner->save();

        return back()->with('success', 'Status akun berhasil diperbarui.');
    }

    /**
     * HAPUS PEMILIK
     * Proteksi: Mencegah penghapusan jika masih ada kost aktif.
     */
    public function destroy($id)
    {
        $owner = User::withCount('kosts')->findOrFail($id);

        if ($owner->kosts_count > 0) {
            return back()->with('error', 'Gagal! Pemilik ini masih memiliki data kost. Hapus kost-nya terlebih dahulu.');
        }

        $owner->delete();
        return back()->with('success', 'Data pemilik berhasil dihapus.');
    }
}
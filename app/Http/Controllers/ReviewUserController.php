<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth; 

class ReviewUserController extends Controller
{
    
    public function store(Request $request, $kostId)
    {
        // 1. Cek Login (Safety First)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek Role (Ganti abort dengan redirect error agar notifikasi muncul)
        if (Auth::user()->role !== 'user') {
            return back()->with('error', 'Maaf, hanya pencari kost (User) yang dapat memberikan ulasan.');
        }

        // 3. Validasi Input
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:5|max:500', // Tambah min:5 & max:500
        ], [
            'rating.required' => 'Wajib memberikan bintang rating.',
            'komentar.required' => 'Isi ulasan tidak boleh kosong.',
            'komentar.min' => 'Ulasan terlalu pendek (minimal 5 karakter).',
        ]);

        // 4. Cegah double review
        $exists = Review::where('kost_id', $kostId)
            ->where('user_id', Auth::id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah pernah memberikan ulasan untuk kost ini.');
        }

        // 5. Simpan ke Database
        Review::create([
            'kost_id' => $kostId,
            'user_id' => Auth::id(),
            'rating'  => $request->rating,
            'komentar'=> $request->komentar,
        ]);

        // 6. Return Sukses (Akan ditangkap oleh alert hijau di Blade)
        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }

    /**
     * Update review (Opsional)
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        // Pastikan pemilik sendiri
        if ($review->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengedit ulasan ini.');
        }

        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:5|max:500',
        ]);

        $review->update([
            'rating'   => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Ulasan berhasil diperbarui!');
    }

   
    public function destroy($id)
    {
       
        $review = Review::findOrFail($id);

       
        if ($review->user_id !== Auth::id()) {
            return back()->with('error', 'Tindakan ilegal. Anda tidak bisa menghapus ulasan orang lain.');
        }

       
        $review->delete();

        
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
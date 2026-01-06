<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewUserController extends Controller
{
    /**
     * Simpan review baru
     */
    public function store(Request $request, $kostId)
    {
        // Pastikan hanya USER
        if (auth()->user()->role !== 'user') {
            abort(403, 'Hanya user yang bisa memberi ulasan');
        }

        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        // Cegah double review
        $exists = Review::where('kost_id', $kostId)
            ->where('user_id', auth()->id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah memberi ulasan untuk kost ini.');
        }

        Review::create([
            'kost_id' => $kostId,
            'user_id' => auth()->id(),
            'rating'  => $request->rating,
            'komentar'=> $request->komentar,
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }

    /**
     * Update review
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        $review->update([
            'rating'   => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Ulasan berhasil diperbarui!');
    }

    /**
     * Hapus review
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus!');
    }
}

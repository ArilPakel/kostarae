<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review; // ← pastikan pakai Review

class ReviewUserController extends Controller
{
    
    public function store(Request $request, $kostId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        Review::create([
            'kost_id' => $kostId,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }

    // Update review
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->update([
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Ulasan berhasil diupdate!');
    }

    // Hapus review
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

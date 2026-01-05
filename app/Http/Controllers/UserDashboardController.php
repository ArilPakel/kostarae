<?php

namespace App\Http\Controllers;

use App\Models\KostView;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Proteksi role
        if ($user->role !== 'user' && $user->role !== 'pencari') {
            abort(403);
        }

        $riwayatKost = KostView::with('kost')
            ->where('user_id', $user->id)
            ->latest('updated_at')
            ->limit(5)
            ->get();

        return view('dashboard.user', compact('riwayatKost'));
    }
}

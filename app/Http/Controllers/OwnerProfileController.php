<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kost; 

class OwnerProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data kost milik user ini (Eager loading untuk performa)
        // Asumsi relasi di Model User: public function kosts() { return $this->hasMany(Kost::class); }
        $kosts = Kost::where('pemilik_id', $user->id)->latest()->get();

        // Hitung Statistik Sederhana
        $stats = [
            'total_kost' => $kosts->count(),
            'active_kost' => $kosts->where('status', 'active')->count(),
            'total_rooms' => 0, // Ganti dengan logika jumlah kamar Anda: $kosts->sum('total_rooms')
            'total_views' => 0, // Ganti dengan logika view Anda
        ];

        return view('pemilik.profil.index', compact('user', 'kosts', 'stats'));
    }
}
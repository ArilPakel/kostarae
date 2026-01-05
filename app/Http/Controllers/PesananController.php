<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function store(Request $request, $kostId)
    {
        $user = Auth::user();

        // =============================
        // VALIDASI ROLE
        // =============================
        if ($user->role === 'pemilik') {
            abort(403, 'Pemilik kost tidak dapat melakukan pemesanan.');
        }

        // =============================
        // AMBIL DATA KOST
        // =============================
        $kost = Kost::with('pemilik')
            ->where('status', 'diterima')
            ->findOrFail($kostId);

        if ($kost->pemilik_id === $user->id) {
            abort(403, 'Tidak bisa memesan kost sendiri.');
        }

        // =============================
        // CEK / BUAT PESANAN (ANTI DUPLIKAT)
        // =============================
        $pesanan = Pesanan::firstOrCreate(
            [
                'kost_id' => $kost->id,
                'user_id' => $user->id,
            ],
            [
                'status' => 'pending',
            ]
        );

        // =============================
        // VALIDASI NOMOR PEMILIK
        // =============================
        if (!$kost->pemilik || !$kost->pemilik->phone) {
            return back()->with('error', 'Nomor WhatsApp pemilik belum tersedia.');
        }

        // =============================
        // FORMAT WHATSAPP
        // =============================
        $phone = preg_replace('/[^0-9]/', '', $kost->pemilik->phone);

        $message = urlencode(
            "Halo, saya ingin memesan kost:\n\n" .
            "Nama Kost: {$kost->nama}\n" .
            "Harga: Rp " . number_format($kost->harga, 0, ',', '.') . "/bulan\n" .
            "Alamat: {$kost->alamat}\n\n" .
            "Mohon info ketersediaannya. Terima kasih."
        );

        return redirect("https://wa.me/{$phone}?text={$message}");
    }
}

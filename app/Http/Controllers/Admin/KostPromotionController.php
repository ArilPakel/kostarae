<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kost;
use Carbon\Carbon;

class KostPromotionController extends Controller
{
    public function update(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);

        // 1. Validasi Input
        $request->validate([
            'is_promoted' => 'required|boolean',
            'promoted_start_date' => 'nullable|date',
            'promoted_end_date' => 'nullable|date|after_or_equal:promoted_start_date',
        ]);

        $isPromoted = $request->boolean('is_promoted');
        $startDate = $request->promoted_start_date;
        $endDate = $request->promoted_end_date;

        // 2. Logika Default Otomatis (Jika diaktifkan tapi tanggal kosong)
        if ($isPromoted) {
            if (!$startDate) {
                $startDate = Carbon::now();
            }
            if (!$endDate) {
                // Default 7 hari jika kosong
                $endDate = Carbon::parse($startDate)->addDays(7);
            }
        } else {
            // Jika dimatikan, reset tanggal (opsional, agar bersih)
            $startDate = null;
            $endDate = null;
        }

        // 3. Simpan ke Database
        $kost->update([
            'is_promoted' => $isPromoted,
            'promoted_start_date' => $startDate,
            'promoted_end_date' => $endDate,
        ]);

        // 4. Return JSON untuk AJAX
        return response()->json([
            'status' => 'success',
            'message' => $isPromoted ? 'Iklan berhasil diaktifkan!' : 'Iklan dinonaktifkan.',
            'data' => [
                'is_promoted' => $isPromoted,
                // Format tanggal untuk update tampilan badge realtime (opsional)
                'status_label' => $isPromoted ? 'IKLAN AKTIF' : 'Tidak Dipromosikan',
                'end_date_human' => $endDate ? Carbon::parse($endDate)->format('d M Y') : '-'
            ]
        ]);
    }
}
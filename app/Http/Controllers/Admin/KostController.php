<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kost;
use Illuminate\Http\Request;

class KostController extends Controller
{
    // ================================
    // LIST KOST
    // ================================
    public function index()
    {
        $kosts = Kost::with('pemilik')->latest()->get();

        return view('admin.kost.index', compact('kosts'));
    }

    public function approve(Kost $kost)
    {
        $kost->update([
            'status' => 'diterima',
            'alasan_penolakan' => null,
        ]);

        return back()->with('success', 'Kost berhasil disetujui.');
    }

    // ================================
    // REJECT
    // ================================
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        $kost = Kost::findOrFail($id);

        $kost->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return back()->with('success', 'Kost berhasil ditolak.');
    }

    // ================================
    // EDIT
    // ================================
    public function edit($id)
    {
        $kost = Kost::findOrFail($id);

        return view('admin.kost.edit', compact('kost'));
    }

    // ================================
    // UPDATE
    // ================================
    public function update(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);

        $kost->update($request->all());

        return back()->with('success', 'Data kost berhasil diperbarui.');
    }

    // ================================
    // DELETE
    // ================================
    public function destroy($id)
    {
        $kost = Kost::findOrFail($id);
        $kost->delete();

        return back()->with('success', 'Kost berhasil dihapus.');
    }
}

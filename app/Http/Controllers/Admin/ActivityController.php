<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
// PENTING: Gunakan Alias 'ActivityModel' untuk menghindari bentrok nama class
use Spatie\Activitylog\Models\Activity as ActivityModel;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        // 1. QUERY DASAR (Gunakan Alias ActivityModel)
        $query = ActivityModel::with(['causer', 'subject'])->latest();

        // 2. FILTER PENCARIAN
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            
            // Filter Cepat (Chips) - Menggunakan Closure function($q) agar query OR tidak bocor
            if ($search == 'login') {
                $query->where(function($q) {
                    $q->where('description', 'like', '%login%')
                      ->orWhere('description', 'like', '%masuk%');
                });
            } elseif ($search == 'update') {
                $query->where(function($q) {
                    $q->where('description', 'like', '%update%')
                      ->orWhere('description', 'like', '%edit%')
                      ->orWhere('description', 'like', '%ubah%');
                });
            } elseif ($search == 'delete') {
                $query->where(function($q) {
                    $q->where('description', 'like', '%delete%')
                      ->orWhere('description', 'like', '%hapus%');
                });
            } elseif ($search == 'system') {
                $query->whereNull('causer_id'); 
            } else {
                // Pencarian Text Biasa
                $query->where(function($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%")
                      ->orWhereHas('causer', function($user) use ($search) {
                          $user->where('name', 'like', "%{$search}%");
                      });
                });
            }
        }

        // 3. PAGINATION
        $logs = $query->paginate(20);

        // 4. STATISTIK (Dashboard Atas)
        // Hitung User Online (Unik dalam 15 menit terakhir)
        $onlineUsers = ActivityModel::where('created_at', '>=', Carbon::now()->subMinutes(15))
            ->whereNotNull('causer_id')
            ->distinct('causer_id')
            ->count('causer_id');

        // Hitung Total Hari Ini
        $todayActivityCount = ActivityModel::whereDate('created_at', Carbon::today())->count();

        // Hitung Aksi Kritis
        $criticalActionCount = ActivityModel::where(function($q) {
            $q->where('description', 'like', '%hapus%')
              ->orWhere('description', 'like', '%delete%')
              ->orWhere('description', 'like', '%destroy%');
        })->count();

        return view('admin.activity.index', compact('logs', 'onlineUsers', 'todayActivityCount', 'criticalActionCount'));
    }

    public function show($id)
    {
        // FIX FINAL: Gunakan ActivityModel (Alias)
        $log = ActivityModel::with(['causer', 'subject'])->findOrFail($id);
        
        return view('admin.activity.show', compact('log'));
    }
}
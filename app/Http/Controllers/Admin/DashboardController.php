<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kost;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        
        $jumlahKost = Kost::count();

        
        $jumlahKostPending = Kost::where('status', 'pending')->count();

        
        $jumlahUser = User::count();

       
        $jumlahPemilik = User::where('role', 'owner')->count();

        return view('admin.dashboard', compact(
            'jumlahKost',
            'jumlahKostPending',
            'jumlahUser',
            'jumlahPemilik'
        ));
    }
}

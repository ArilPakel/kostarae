<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost; 

class PageController extends Controller
{
    public function home()
    {
       
        $kost = Kost::where('status', 'diterima')->get();

       
        return view('pages.home', compact('kost'));
    }
    
    public function kontak()
    {
        return view('pages.kontak');
    }

    public function panduan()
    {
        return view('pages.panduan');
    }

    public function sdank()
    {
        return view('pages.sdank');
    }
}

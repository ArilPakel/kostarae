<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function terms()
    {
        return view('admin.pages.terms');
    }

    public function contact()
    {
        return view('admin.pages.contact');
    }

    public function guide()
    {
        return view('admin.pages.guide');
    }
}

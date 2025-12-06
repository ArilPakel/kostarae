<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.reviews.index');
    }
}

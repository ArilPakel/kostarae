<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class OwnerController extends Controller
{
    public function index()
    {
        return view('admin.owner.index');
    }
}

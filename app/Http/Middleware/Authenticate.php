<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // 2. LOGIKA BARU: Cek apakah URL yang dituju mengandung kata 'admin'
        if ($request->is('admin') || $request->is('admin/*')) {
            // Jika ya, lempar ke Halaman Login Admin
            return route('admin.login'); 
        }

        // 3. Default: Jika bukan admin, lempar ke Halaman Login User biasa
        return route('login');
    }
}

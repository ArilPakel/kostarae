<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
   
    public function handle($request, Closure $next, $role)
    {
        if (auth()->user()->role !== $role) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}

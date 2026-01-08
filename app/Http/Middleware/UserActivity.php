<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class UserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Simpan status Online di Cache selama 5 menit
            // Cache lebih ringan daripada update Database setiap detik
            $expiresAt = now()->addMinutes(5);
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);

            // Update Database (last_seen) agar admin bisa lihat kapan terakhir login
            // Kita update hanya jika user belum update dalam 5 menit terakhir (agar database tidak berat)
            $user = Auth::user();
            if (is_null($user->last_seen) || $user->last_seen->diffInMinutes(now()) > 5) {
                User::where('id', $user->id)->update(['last_seen' => now()]);
            }
        }
        return $next($request);
    }
}
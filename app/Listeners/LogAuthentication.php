<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogAuthentication
{
    /**
     * Handle the event.
     */
    public function handle($event)
    {
        // 1. Cek apakah ada user di event ini (Mencegah error jika guest)
        if (!isset($event->user) || !$event->user) {
            return;
        }

        $user = $event->user;
        $action = '';
        $description = '';

        // 2. Tentukan apakah Login atau Logout
        if ($event instanceof Login) {
            $action = 'login';
            $description = 'Masuk ke dalam sistem';
        } elseif ($event instanceof Logout) {
            $action = 'logout';
            $description = 'Keluar dari sistem';
        }

        // 3. Simpan ke Database
        try {
            ActivityLog::create([
                'user_id'       => $user->id,
                'user_role'     => $user->role ?? 'user', // Ambil role, default 'user' jika null
                'action'        => $action,
                'description'   => $description,
                'subject_type'  => get_class($user), // Menyimpan tipe User
                'subject_id'    => $user->id,
                'properties'    => ['email' => $user->email], // Metadata tambahan
                'ip_address'    => request()->ip(),
                'user_agent'    => request()->header('User-Agent'),
            ]);
        } catch (\Exception $e) {
            // Jika error, biarkan aplikasi tetap jalan (jangan crash saat login)
            // Anda bisa log error ini ke laravel.log jika perlu:
            // \Log::error('Gagal mencatat log aktivitas: ' . $e->getMessage());
        }
    }
}
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use LogsActivity;

    /**
     * FIELD YANG BOLEH DI-UPDATE
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'avatar',         
        'role',
        'google_id',
        'email_verified_at',
        'last_seen', // [TAMBAHAN] Agar bisa diupdate oleh middleware
    ];

    /**
     * FIELD TERSEMBUNYI
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * CASTING FIELD
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // [PERBAIKAN UTAMA] Ubah string jadi datetime agar diffInMinutes() jalan
        'last_seen' => 'datetime', 
    ];

    /**
     * RELASI: PEMILIK → BANYAK KOST
     */
    public function kosts()
    {
        return $this->hasMany(Kost::class, 'pemilik_id');
    }

    /**
     * RELASI: USER → VIEW KOST
     */
    public function kostViews()
    {
        return $this->hasMany(KostView::class);
    }

    /**
     * KONFIGURASI ACTIVITY LOG
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->setDescriptionForEvent(
                fn (string $eventName) => "Data user telah di-{$eventName}"
            );
    }

    /**
     * Cek apakah user sedang online (via Cache)
     */
    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Kost;

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
    ];

    /**
     * RELASI: PEMILIK → BANYAK KOST
     */
    public function kosts()
    {
        return $this->hasMany(Kost::class, 'pemilik_id');
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

    public function kostViews()
    {
    return $this->hasMany(\App\Models\KostView::class);
    }
}

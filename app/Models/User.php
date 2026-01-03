<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Kost; // Pastikan Model Kost di-import
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',       // Penting untuk fitur verifikasi WA
        'role',        // Penting untuk membedakan admin/pemilik
        'google_id',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * RELASI TAMBAHAN (PENTING)
     * Agar OwnerController bisa memanggil $user->kosts
     */
    public function kosts()
    {
        // Parameter kedua 'pemilik_id' adalah nama kolom di tabel 'kosts'
        // yang menghubungkan ke tabel 'users'
        return $this->hasMany(Kost::class, 'pemilik_id');
    }

    // 3. Konfigurasi Pencatatan (Wajib ada)
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()             // Catat semua field
            ->logOnlyDirty()       // Hanya catat yang berubah saja
            ->setDescriptionForEvent(fn(string $eventName) => "Data User ini telah di-{$eventName}");
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi mass assignment
     */
    protected $fillable = [
        'kost_id',
        'user_id',
        'rating',
        'komentar',
        'is_hidden',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'is_hidden' => 'boolean',
        'rating'    => 'integer',
    ];

    /**
     * AKTIFKAN TIMESTAMPS (WAJIB)
     */
    public $timestamps = true;

    /**
     * Relasi ke Kost
     */
    public function kost()
    {
        return $this->belongsTo(Kost::class, 'kost_id');
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

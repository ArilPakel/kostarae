<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Menambahkan 'is_hidden' agar bisa di-update massal atau via controller
    protected $fillable = [
        'kost_id',
        'user_id',
        'rating',
        'komentar',
        'is_hidden', // <--- PENTING: Tambahan baru untuk fitur moderasi
    ];

    // Casting tipe data agar output konsisten
    protected $casts = [
        'is_hidden' => 'boolean', // Memastikan nilai jadi true/false (bukan 0/1)
        'rating'    => 'integer', // Memastikan rating terbaca sebagai angka
    ];
    
    /**
     * Relasi ke Kost (Many to One)
     * Setiap ulasan milik satu kost.
     */
    public function kost()
    {
        // Parameter ke-2 'kost_id' mempertegas Foreign Key di tabel reviews
        return $this->belongsTo(Kost::class, 'kost_id');
    }

    /**
     * Relasi ke User (Many to One)
     * Setiap ulasan ditulis oleh satu user.
     */
    public function user()
    {
        // Parameter ke-2 'user_id' mempertegas Foreign Key di tabel reviews
        return $this->belongsTo(User::class, 'user_id');
    }
}
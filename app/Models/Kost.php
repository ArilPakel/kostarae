<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    protected $table = 'kosts';

    protected $fillable = [
        'pemilik_id',
        'nama',
        'alamat',
        'harga',
        'tipe',
        'fasilitas',
        'foto',
        'status',
        'alasan_penolakan',
    ];

    protected $casts = [
        'fasilitas' => 'array',
        'foto' => 'array',
        'harga' => 'integer',
    ];

    // Relasi ke pemilik (User)
    public function pemilik()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Relasi ke review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}

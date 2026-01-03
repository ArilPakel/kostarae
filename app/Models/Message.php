<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Kita akan buat tabel baru bernama 'messages' di langkah 2
    protected $table = 'reports'; 

    protected $guarded = ['id'];
}
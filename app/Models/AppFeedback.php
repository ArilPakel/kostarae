<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppFeedback extends Model
{
    use HasFactory;

    // INI PENTING: Paksa model membaca tabel yang pakai 's'
    protected $table = 'app_feedbacks';

    // Izinkan pengisian kolom
    protected $guarded = ['id'];
}
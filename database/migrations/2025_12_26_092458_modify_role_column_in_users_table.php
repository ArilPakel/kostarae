<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahkan ini

return new class extends Migration
{
    public function up()
    {
        // Memaksa kolom role menjadi VARCHAR(255) agar muat menampung 'pencari'/'pemilik'
        DB::statement("ALTER TABLE users MODIFY role VARCHAR(255) DEFAULT 'pencari'");
    }

    public function down()
    {
        // Tidak perlu di-rollback untuk kasus ini
    }
};
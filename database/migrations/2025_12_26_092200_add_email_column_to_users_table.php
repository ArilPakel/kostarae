<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Tambahkan kolom email jika belum ada
            if (!Schema::hasColumn('users', 'email')) {
                // Kita buat nullable dulu agar tidak konflik dengan data lama
                $table->string('email')->unique()->nullable()->after('name'); 
            }

            // 2. Ubah kolom 'phone' jadi boleh kosong (nullable)
            // KARENA: User yang daftar lewat Google belum punya no telepon
            if (Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->change();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'email')) {
                $table->dropColumn('email');
            }
            // Kembalikan phone jadi wajib (hati-hati jika ada data null)
            // $table->string('phone')->nullable(false)->change(); 
        });
    }
};
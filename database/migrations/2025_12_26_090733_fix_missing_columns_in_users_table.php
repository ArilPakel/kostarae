<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Cek apakah kolom google_id belum ada? Kalau belum, buatkan.
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable(); 
            }

            // 2. Cek apakah kolom role belum ada? Kalau belum, buatkan.
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('pencari'); 
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'google_id')) {
                $table->dropColumn('google_id');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
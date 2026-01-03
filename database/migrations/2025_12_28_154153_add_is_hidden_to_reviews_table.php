<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // SOLUSI ANTI ERROR:
            // Cek dulu apakah kolom 'is_hidden' SUDAH ADA di tabel 'reviews'?
            // Jika TIDAK ADA (!), baru kita buat.
            if (!Schema::hasColumn('reviews', 'is_hidden')) {
                $table->boolean('is_hidden')->default(false)->after('rating');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Cek dulu, kalau ada baru dihapus
            if (Schema::hasColumn('reviews', 'is_hidden')) {
                $table->dropColumn('is_hidden');
            }
        });
    }
};
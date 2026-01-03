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
        Schema::table('users', function (Blueprint $table) {
            // 1. Tambah kolom Role (Cek dulu biar aman)
            if (!Schema::hasColumn('users', 'role')) {
                // Hapus ->after('email') agar tidak error
                $table->string('role')->default('pencari'); 
            }

            // 2. Tambah kolom Google ID (PENTING untuk login Google)
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable();
            }
            
            // 3. Pastikan kolom password boleh kosong (nullable)
            // Ini opsional, tapi berguna jika user daftar lewat Google tanpa password
            // if (Schema::hasColumn('users', 'password')) {
            //    $table->string('password')->nullable()->change();
            // }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $columnsToDrop = [];
            
            if (Schema::hasColumn('users', 'role')) {
                $columnsToDrop[] = 'role';
            }
            if (Schema::hasColumn('users', 'google_id')) {
                $columnsToDrop[] = 'google_id';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
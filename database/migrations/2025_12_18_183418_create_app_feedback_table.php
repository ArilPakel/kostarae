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
        // PERBAIKAN 1: Tambahkan 's' pada nama tabel (app_feedbacks)
        Schema::create('app_feedbacks', function (Blueprint $table) {
            $table->id();
            
            // PERBAIKAN 2: Tambahkan kolom relasi ke user (siapa yang memberi nilai)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // PERBAIKAN 3: Kolom Rating (1-5)
            $table->integer('rating');
            
            // PERBAIKAN 4: Kolom Masukan/Komentar
            $table->text('masukan')->nullable();
            
            // PERBAIKAN 5: Status (Wajib pakai 'approved', bukan 'disetujui')
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Pastikan nama tabel di sini juga pakai 's'
        Schema::dropIfExists('app_feedbacks');
    }
};
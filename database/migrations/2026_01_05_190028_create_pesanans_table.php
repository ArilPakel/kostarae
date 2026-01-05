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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();

            // RELASI
            $table->foreignId('kost_id')
                ->constrained('kosts')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // DATA PESANAN
            $table->date('tanggal_mulai')->nullable();
            $table->text('catatan')->nullable();

            // STATUS PESANAN
            $table->enum('status', ['pending', 'diterima', 'ditolak'])
                ->default('pending');

            $table->timestamps();

            // MENCEGAH USER PESAN KOST SAMA 2X
            $table->unique(['kost_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};

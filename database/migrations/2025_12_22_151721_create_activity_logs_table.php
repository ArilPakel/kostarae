<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Baris ini PENTING: Hapus tabel lama jika ada (Solusi anti-error)
        Schema::dropIfExists('activity_logs');

        // 2. Buat tabel baru dengan struktur yang benar
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // Siapa yang melakukan?
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('user_role')->nullable(); 
            
            // Apa yang dilakukan?
            $table->string('action'); // ex: 'created', 'updated', 'login'
            $table->string('description'); // ex: 'Menambahkan kost baru'
            
            // Terhadap objek apa? (Polymorphic)
            $table->nullableMorphs('subject'); // creates subject_id & subject_type
            
            // Data teknis & Audit trail
            $table->json('properties')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
            
            // Indexing untuk performa
            $table->index(['user_id', 'created_at']);
            $table->index('action');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};
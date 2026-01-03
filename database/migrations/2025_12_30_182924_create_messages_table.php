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
        Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->string('name');           // Nama Pengirim
        $table->string('email');          // Email Pengirim
        $table->string('subject')->nullable(); // Subjek Pesan
        $table->text('message');          // Isi Pesan
        $table->boolean('is_read')->default(false); // Status Dibaca
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};

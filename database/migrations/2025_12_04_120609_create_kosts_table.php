<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemilik_id')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->text('alamat');
            $table->unsignedBigInteger('harga')->default(0);
            $table->string('tipe')->nullable(); 
            $table->json('fasilitas')->nullable()->default(json_encode([]));
            $table->json('foto')->nullable();
            $table->enum('status', ['pending','diterima','ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};

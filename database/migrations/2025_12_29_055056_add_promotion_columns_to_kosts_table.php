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
        Schema::table('kosts', function (Blueprint $table) {
            // Penanda apakah kost ini sedang dipromosikan
            $table->boolean('is_promoted')->default(false)->after('status'); 

            // Tanggal mulai dan selesai iklan (untuk otomatisasi)
            $table->timestamp('promoted_start_date')->nullable()->after('is_promoted');
            $table->timestamp('promoted_end_date')->nullable()->after('promoted_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kosts', function (Blueprint $table) {
            //
        });
    }

};

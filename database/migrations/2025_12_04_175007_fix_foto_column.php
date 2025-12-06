<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // ← WAJIB TAMBAHKAN INI

return new class extends Migration
{
    public function up()
    {
        // Pastikan semua row null berubah jadi []
        DB::table('kosts')
            ->whereNull('foto')
            ->update(['foto' => json_encode([])]);

        // Ubah kolom jadi JSON nullable tanpa default
        Schema::table('kosts', function (Blueprint $table) {
            $table->json('foto')->nullable()->change();
        });
    }
};

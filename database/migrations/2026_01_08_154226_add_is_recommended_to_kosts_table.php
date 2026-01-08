<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('kosts', function (Blueprint $table) {
            // Kolom boolean, default false (tidak rekomendasi)
            $table->boolean('is_recommended')->default(false)->after('status');
        });
    }

    public function down()
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->dropColumn('is_recommended');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Role wajib ada, default user
            $table->string('role')
                ->default('user')
                ->change();

            // Google ID nullable & unique
            $table->string('google_id')
                ->nullable()
                ->unique()
                ->change();

            // Email verified nullable (untuk Google login)
            $table->timestamp('email_verified_at')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('role')->nullable()->change();
            $table->string('google_id')->nullable()->change();
            $table->timestamp('email_verified_at')->nullable()->change();
        });
    }
};

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat User (Pemilik Kost)
        $ownerId = DB::table('users')->insertGetId([
            'name' => 'Bapak Kost',
            'email' => 'pemilik@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'owner', // Sesuaikan dengan kolom role di tabel user Anda
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 2. Buat User (Penyewa untuk Review)
        $userId = DB::table('users')->insertGetId([
            'name' => 'Anak Rantau',
            'email' => 'penyewa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 3. Buat Data Kost
        $kostId = DB::table('kosts')->insertGetId([
            'nama_kost' => 'Kost Mawar Indah',
            'user_id' => $ownerId,
            'deskripsi' => 'Kost nyaman tengah kota',
            'alamat' => 'Jl. Merdeka No 45',
            'harga' => 1500000,
            // Pastikan kolom lain yang NOT NULL diisi juga (sesuaikan struktur tabel Anda)
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 4. Buat Data Review (Agar muncul di dashboard)
        DB::table('reviews')->insert([
            [
                'user_id' => $userId,
                'kost_id' => $kostId,
                'rating' => 5,
                'ulasan' => 'Tempatnya bersih banget, ibu kost ramah!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $userId,
                'kost_id' => $kostId,
                'rating' => 2,
                'ulasan' => 'Air sering mati, tolong diperbaiki.',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ]
        ]);

        // 5. Buat Data Rating Web (AppFeedbacks)
        DB::table('app_feedbacks')->insert([
            'user_id' => $userId,
            'rating' => 5,
            'masukan' => 'Websitenya kencang dan mudah dipakai.',
            'status' => 'approved',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
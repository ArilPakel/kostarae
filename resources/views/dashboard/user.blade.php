@extends('layouts.main')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Selamat Datang, {{ Auth::user()->name }} 👋
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        
        <div class="bg-white rounded-2xl p-5 shadow hover:shadow-md transition">
            <h3 class="font-semibold text-lg mb-2">Riwayat Kost</h3>
            <p class="text-gray-600 text-sm">Lihat kost yang pernah kamu booking.</p>
        </div>

        
        <div class="bg-white rounded-2xl p-5 shadow hover:shadow-md transition">
            <h3 class="font-semibold text-lg mb-2">Favorit</h3>
            <p class="text-gray-600 text-sm">Daftar kost favoritmu.</p>
        </div>

       
        <div class="bg-white rounded-2xl p-5 shadow hover:shadow-md transition">
            <h3 class="font-semibold text-lg mb-2">Pengaturan Akun</h3>
            <p class="text-gray-600 text-sm">Atur profil, password, dan keamanan.</p>
        </div>

    </div>
</div>
@endsection

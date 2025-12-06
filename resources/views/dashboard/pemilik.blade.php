@extends('layouts.main')

@section('content')
<div class="max-w-6xl mx-auto p-6">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Dashboard Pemilik Kost
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        
        <div class="bg-white rounded-2xl p-5 shadow hover:shadow-lg transition">
            <h3 class="font-semibold text-lg mb-2">Jumlah Kost</h3>
            <p class="text-gray-600">{{ Auth::user()->kost_count ?? '0' }} terdaftar.</p>
        </div>

        
        <div class="bg-white rounded-2xl p-5 shadow hover:shadow-lg transition">
            <h3 class="font-semibold text-lg mb-2">Penyewa</h3>
            <p class="text-gray-600">Pantau siapa saja yang menyewa kost Anda.</p>
        </div>

        
        <div class="bg-white rounded-2xl p-5 shadow hover:shadow-lg transition">
            <h3 class="font-semibold text-lg mb-2">Ulasan</h3>
            <p class="text-gray-600">Lihat review dari penyewa.</p>
        </div>

        
        <div class="bg-white rounded-2xl p-5 shadow hover:shadow-lg transition md:col-span-3">
            <a href="{{ route('pemilik.kost.index') }}" class="block">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-xl">Kelola Kost</h3>
                    <span class="text-orange-600 font-semibold">Lihat &rarr;</span>
                </div>
                <p class="text-gray-600 mt-2">Tambah, edit, dan hapus data kost.</p>
            </a>
        </div>

    </div>
</div>
@endsection

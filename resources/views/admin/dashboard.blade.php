@extends('admin.layouts')
@section('content')

<h2 class="text-2xl font-bold mb-6 ">Dashboard</h2>

{{-- 3 Statistik Atas --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="p-5 rounded-xl bg-white shadow">
        <h3 class="text-gray-500 text-sm "> Jumlah Kost </h3>
        <p class="text-3xl font-semibold mt-2">128</p>
    </div>
    <div class="p-5 rounded-xl bg-white shadow">
        <h3 class="text-gray-500 text-sm "> Jumlah Pengguna </h3>
        <p class="text-3xl font-semibold mt-2">500</p>
    </div>
    <div class="p-5 rounded-xl bg-white shadow">
        <h3 class="text-gray-500 text-sm "> Pemilik Kost </h3>
        <p class="text-3xl font-semibold mt-2">20</p>
    </div>

    {{-- Grafik & Statistik --}}
    <div class="grid grid-cols-2 gap-6">
        <div class="p-5 bg-white rounded-xl shadow">
            <h3 class="font-semibold text-gray-600 mb-3">Aktivitas Pencarian</h3>
            <div class="border rounded h-64 flex items-center justify-center text-gray-400">
                Grafik Disini
            </div>

        </div>

        <div class="p-5 bg-white rounded-xl shadow">
            <h3 class="font-semibold text-gray-600 mb-3"> Review Pengguna </h3>
            <div class="border rounder h-64 flex items-center justify-center text-gray-400">
                Chart Disini
            </div>
        </div>

    </div>

</div>
@endsection
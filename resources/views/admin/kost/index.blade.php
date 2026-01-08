@extends('admin.layouts')
@section('title', 'Manajemen Data Kost')

@section('content')
<div class="space-y-8">

    {{-- 1. STATISTIK UTAMA (TETAP) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Kost --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Kost</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalKost ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        {{-- Menunggu --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Perlu Review</p>
                <h3 class="text-3xl font-bold text-amber-600 mt-1">{{ $totalPending ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        {{-- Diterima --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Aktif</p>
                <h3 class="text-3xl font-bold text-emerald-600 mt-1">{{ $totalApproved ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        {{-- Ditolak --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ditolak</p>
                <h3 class="text-3xl font-bold text-rose-600 mt-1">{{ $totalRejected ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    {{-- 2. HEADER & FILTER (TETAP) --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-indigo-600">
                    <path fill-rule="evenodd" d="M3 2.25a.75.75 0 000 1.5v16.5h-.75a.75.75 0 000 1.5H16.5a.75.75 0 000-1.5H15.75V3.75a.75.75 0 000-1.5H3zM18 2.25a.75.75 0 000 1.5v16.5a.75.75 0 000 1.5H21.75a.75.75 0 000 1.5H21a.75.75 0 000-1.5V2.25z" clip-rule="evenodd" />
                </svg>
                Data Kost
            </h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data kost, rekomendasi, dan iklan.</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Search Bar --}}
            <form method="GET" action="{{ route('admin.kost.index') }}" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kost..." 
                       class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-64 shadow-sm">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                </div>
            </form>

            {{-- Tombol Tambah --}}
            <a href="{{ route('admin.kost.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <span>Tambah Data</span>
            </a>
        </div>
    </div>

    {{-- 3. TABEL DATA --}}
    <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
        
        {{-- Filter Status (TETAP) --}}
        <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap gap-2 bg-gray-50/50">
            @php $currentStatus = request('status'); @endphp
            <a href="{{ route('admin.kost.index') }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1.5 {{ !$currentStatus ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                Semua
            </a>
            <a href="{{ route('admin.kost.index', ['status' => 'pending']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1.5 {{ $currentStatus == 'pending' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                Menunggu
            </a>
            <a href="{{ route('admin.kost.index', ['status' => 'diterima']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1.5 {{ $currentStatus == 'diterima' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                Aktif
            </a>
            <a href="{{ route('admin.kost.index', ['status' => 'ditolak']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1.5 {{ $currentStatus == 'ditolak' ? 'bg-rose-500 text-white border-rose-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                Ditolak
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-semibold uppercase tracking-wider text-xs">
                    <tr>
                        <th class="px-6 py-4">Info Kost</th>
                        <th class="px-6 py-4">Pemilik</th>
                        <th class="px-6 py-4 text-center">Verifikasi</th>
                        <th class="px-6 py-4 text-center">Status / Promosi</th> {{-- HEADER UPDATE --}}
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($kosts as $kost)
                    <tr class="hover:bg-indigo-50/30 transition group">
                        
                        {{-- 1. INFO KOST (TETAP) --}}
                        <td class="px-6 py-4">
                            <div class="flex items-start gap-4">
                                {{-- Logic Gambar --}}
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0 flex items-center justify-center text-gray-400 shadow-sm mt-1">
                                    @php
                                        $imgSrc = asset('kost/default.jpg');
                                        if ($kost->relationLoaded('kostImages') && $kost->kostImages->isNotEmpty()) {
                                             $imgSrc = asset('storage/' . $kost->kostImages->first()->path);
                                        } elseif (!empty($kost->foto)) {
                                            $foto = $kost->foto;
                                            if (is_string($foto)) {
                                                $decoded = json_decode($foto, true);
                                                $foto = is_array($decoded) ? ($decoded[0] ?? null) : $foto;
                                            } elseif (is_array($foto)) {
                                                $foto = $foto[0] ?? null;
                                            }
                                            if ($foto) {
                                                $path = is_array($foto) ? ($foto['path'] ?? null) : $foto;
                                                if ($path) $imgSrc = asset('storage/'.$path);
                                            }
                                        }
                                    @endphp
                                    <img src="{{ $imgSrc }}" class="w-full h-full object-cover" alt="Foto Kost" loading="lazy" onerror="this.src='{{ asset('kost/default.jpg') }}'">
                                </div>
                                
                                <div class="flex flex-col gap-1 min-w-[200px] max-w-[300px]">
                                    <span class="text-base font-bold text-gray-900 leading-tight line-clamp-2 hover:text-indigo-600 transition-colors cursor-help" 
                                          title="{{ $kost->nama_kost ?? $kost->nama }}">
                                        {{ $kost->nama_kost ?? $kost->nama ?? 'Nama Tidak Tersedia' }}
                                    </span>
                                    <div class="flex items-start gap-1 text-xs text-gray-500">
                                        <span class="line-clamp-1">{{ $kost->alamat ?? '-' }}</span>
                                    </div>
                                    <span class="text-xs font-bold text-indigo-600 mt-0.5">
                                        Rp {{ number_format($kost->harga ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        {{-- 2. PEMILIK (TETAP) --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                    {{ substr($kost->pemilik->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800 text-xs">{{ $kost->pemilik->name ?? 'Unknown' }}</div>
                                    @if($kost->pemilik && $kost->pemilik->phone)
                                        @php $waPhone = preg_replace('/^0/', '62', $kost->pemilik->phone); @endphp
                                        <a href="https://wa.me/{{ $waPhone }}" target="_blank" class="text-[10px] text-green-600 flex items-center gap-1 hover:underline font-medium bg-green-50 px-2 py-0.5 rounded-full w-fit mt-1">
                                            Chat WA
                                        </a>
                                    @else
                                        <span class="text-[10px] text-gray-400">No WA -</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- 3. VERIFIKASI (TETAP) --}}
                        <td class="px-6 py-4 text-center">
                            <div class="relative inline-block">
                                <select onchange="updateStatusVerifikasi({{ $kost->id }}, this.value)" 
                                    class="appearance-none cursor-pointer text-xs font-bold rounded-full pl-3 pr-8 py-1.5 border-0 ring-1 ring-inset outline-none transition hover:ring-2 focus:ring-2
                                    {{ $kost->status == 'diterima' ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : '' }}
                                    {{ $kost->status == 'pending' ? 'bg-amber-50 text-amber-700 ring-amber-200' : '' }}
                                    {{ $kost->status == 'ditolak' ? 'bg-rose-50 text-rose-700 ring-rose-200' : '' }}">
                                    <option value="diterima" {{ $kost->status == 'diterima' ? 'selected' : '' }}>Aktif</option>
                                    <option value="pending" {{ $kost->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="ditolak" {{ $kost->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                        </td>

                        {{-- 4. STATUS IKLAN & REKOMENDASI (DIPERBAIKI) --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-2">
                                {{-- A. IKLAN BERBAYAR --}}
                                @php
                                    $isActivePromo = $kost->is_promoted && now()->between($kost->promoted_start_date, $kost->promoted_end_date);
                                @endphp
                                @if($isActivePromo)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-1 text-[10px] font-bold text-amber-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M13.5 4.938a7 7 0 11-9.006 1.737c.202-.257.59-.218.793.039.313.398.648.775 1 1.135 1.25.32 2.5 1.5 3 2.5a.75.75 0 001.214-.523c-.1-1.01.077-2.062.5-3.04.42-1.002.5-2.052.5-3.041a.75.75 0 00-1.214-.523 7.02 7.02 0 00-2.787 1.625z" clip-rule="evenodd" />
                                        </svg>
                                        Iklan Aktif
                                    </span>
                                @endif

                                {{-- B. REKOMENDASI ADMIN (FITUR BARU) --}}
                                @if($kost->is_recommended)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-purple-100 px-2 py-1 text-[10px] font-bold text-purple-700 border border-purple-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                        </svg>
                                        Rekomendasi
                                    </span>
                                @endif

                                @if(!$isActivePromo && !$kost->is_recommended)
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </div>
                        </td>

                        {{-- 5. AKSI (DIPERBAIKI) --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                
                                {{-- A. Tombol Toggle Rekomendasi (FITUR BARU) --}}
                                <form action="{{ route('admin.kost.promote', $kost->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                        class="w-9 h-9 flex items-center justify-center rounded-full transition shadow-sm border
                                        {{ $kost->is_recommended ? 'bg-purple-50 text-purple-600 border-purple-100 hover:bg-purple-100' : 'bg-gray-50 text-gray-400 border-gray-100 hover:bg-purple-50 hover:text-purple-600' }}"
                                        title="{{ $kost->is_recommended ? 'Hapus Rekomendasi' : 'Jadikan Rekomendasi' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $kost->is_recommended ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.563.045.797.77.375 1.141l-4.225 3.733a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.225-3.733c-.422-.371-.188-1.096.375-1.141l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                    </button>
                                </form>

                                {{-- B. Tombol Iklan Berbayar (Modal JS) --}}
                                <button onclick="openPromoModal({{ $kost->id }}, {{ $kost->is_promoted ? 1 : 0 }}, '{{ $kost->promoted_start_date }}', '{{ $kost->promoted_end_date }}')" 
                                    class="w-9 h-9 flex items-center justify-center rounded-full bg-amber-50 text-amber-600 hover:bg-amber-100 hover:scale-105 transition shadow-sm border border-amber-100" title="Atur Iklan Berbayar">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V4.875C21.75 3.84 20.91 3 19.875 3H4.125zM12 5.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zm0 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zm0 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zM5.8 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" clip-rule="evenodd" />
                                        <path d="M11.25 16.5a.75.75 0 00-1.5 0h-4.5a.75.75 0 00-.75.75v.75a.75.75 0 001.5 0v-.75h3.75v.75a.75.75 0 001.5 0v-.75z" />
                                    </svg>
                                </button>

                                {{-- C. Tombol Detail --}}
                                <a href="{{ route('admin.kost.show', $kost->id) }}" 
                                   class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 hover:scale-105 transition shadow-sm border border-blue-100" title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>

                                {{-- D. Tombol Hapus --}}
                                <form action="{{ route('admin.kost.destroy', $kost->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kost ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="w-9 h-9 flex items-center justify-center rounded-full bg-rose-50 text-rose-600 hover:bg-rose-100 hover:scale-105 transition shadow-sm border border-rose-100" title="Hapus Kost">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.49 1.478l-.56-.092v13.386a2.25 2.25 0 01-2.25 2.25H6.942a2.25 2.25 0 01-2.25-2.25V6.603l-.56.092a.75.75 0 01-.49-1.478 48.831 48.831 0 013.876-.512v-.227c0-1.136.953-2.115 2.088-2.202 4.19-.321 8.358-.321 12.549 0 1.135.087 2.088 1.066 2.088 2.202zM8.25 6.75h7.5v13.5h-7.5V6.75zm1.5 2.25a.75.75 0 01.75.75v7.5a.75.75 0 01-1.5 0v-7.5a.75.75 0 01.75-.75zm4.5 0a.75.75 0 01.75.75v7.5a.75.75 0 01-1.5 0v-7.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            <div class="flex justify-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 opacity-30">
                                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="text-sm">Data kost tidak ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($kosts->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $kosts->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

{{-- MODAL PROMOSI (TETAP SAMA UNTUK FITUR IKLAN BERBAYAR) --}}
<div id="promoModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 flex items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 transform transition-all scale-100 border border-gray-100">
        
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-amber-50 rounded-full flex items-center justify-center text-amber-600">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V4.875C21.75 3.84 20.91 3 19.875 3H4.125zM12 5.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zm0 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zm0 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zM5.8 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" clip-rule="evenodd" />
                    <path d="M11.25 16.5a.75.75 0 00-1.5 0h-4.5a.75.75 0 00-.75.75v.75a.75.75 0 001.5 0v-.75h3.75v.75a.75.75 0 001.5 0v-.75z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Promosi Kost (Ads)</h3>
        </div>
        
        {{-- Form ini akan menggunakan route untuk updateAds (Fitur berbayar) --}}
        <form id="promoForm">
            <input type="hidden" id="kostId">
            
            <div class="flex items-center justify-between mb-6 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                <div>
                    <span class="text-gray-800 font-bold text-sm block">Status Iklan</span>
                    <span class="text-xs text-gray-500">Tampilkan di slot premium</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="promoSwitch" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                </label>
            </div>

            <div id="dateInputs" class="space-y-4 transition-all duration-300">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Mulai Promosi</label>
                    <input type="datetime-local" id="startDate" class="block w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-500 focus:ring-amber-500 p-2.5">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Berakhir Promosi</label>
                    <input type="datetime-local" id="endDate" class="block w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-500 focus:ring-amber-500 p-2.5">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit" id="btnSave" class="px-5 py-2.5 text-sm font-bold text-white bg-amber-500 rounded-xl hover:bg-amber-600 shadow-lg shadow-amber-200 transition flex items-center gap-2">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    async function updateStatusVerifikasi(id, newStatus) {
        document.body.style.cursor = 'wait';
        try {
            const response = await fetch(`/admin/kost/${id}/update-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            });
            const result = await response.json();
            if (result.success) {
                location.reload(); 
            } else {
                alert('Gagal mengubah status.');
            }
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan sistem.');
        } finally {
            document.body.style.cursor = 'default';
        }
    }

    // Modal Logic untuk Iklan Berbayar
    function openPromoModal(id, isPromoted, start, end) {
        document.getElementById('kostId').value = id;
        document.getElementById('promoSwitch').checked = isPromoted == 1;
        if(start) document.getElementById('startDate').value = start.replace(' ', 'T');
        if(end) document.getElementById('endDate').value = end.replace(' ', 'T');
        toggleInputs();
        document.getElementById('promoModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('promoModal').classList.add('hidden');
    }

    document.getElementById('promoSwitch').addEventListener('change', toggleInputs);

    function toggleInputs() {
        const isChecked = document.getElementById('promoSwitch').checked;
        const inputs = document.getElementById('dateInputs');
        if(isChecked) {
            inputs.classList.remove('opacity-50', 'pointer-events-none');
        } else {
            inputs.classList.add('opacity-50', 'pointer-events-none');
        }
    }

    // Ajax untuk Simpan Iklan (Ads)
    document.getElementById('promoForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('kostId').value;
        const btn = document.getElementById('btnSave');
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Menyimpan...';
        btn.disabled = true;

        try {
            // URL ini mungkin perlu disesuaikan jika Anda menamai route Ads berbeda
            // Namun berdasarkan controller, Anda mungkin perlu membuat route khusus untuk Ads
            // Karena method 'promote' di controller sekarang dipakai untuk toggle rekomendasi.
            // Asumsi: Anda punya route '/admin/kost/ads/{id}' atau semacamnya untuk updateAds.
            // Sesuai kode sebelumnya, AJAX ini hit 'admin/kost/promotion'. 
            // Pastikan route ini mengarah ke method yang benar (Ads).
            const response = await fetch(`/admin/kost/ads/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    is_promoted: document.getElementById('promoSwitch').checked,
                    promoted_start_date: document.getElementById('startDate').value,
                    promoted_end_date: document.getElementById('endDate').value
                })
            });

            const result = await response.json();
            
            if (response.ok && result.status === 'success') {
                alert(result.message);
                location.reload();
            } else {
                alert('Gagal: ' + (result.message || 'Periksa input tanggal Anda.'));
            }
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan sistem.');
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
            closeModal();
        }
    });
</script>
@endsection
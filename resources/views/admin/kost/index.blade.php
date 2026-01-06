@extends('admin.layouts')
@section('title', 'Manajemen Data Kost')

@section('content')
<div class="space-y-8">

    {{-- 1. STATISTIK UTAMA --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Kost --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Kost</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalKost ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                {{-- ICON: Home/Building --}}
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
                {{-- ICON: Clock --}}
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
                {{-- ICON: Check Circle --}}
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
                {{-- ICON: X Circle --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    {{-- 2. HEADER & FILTER --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                {{-- ICON: Building --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-indigo-600">
                    <path fill-rule="evenodd" d="M3 2.25a.75.75 0 000 1.5v16.5h-.75a.75.75 0 000 1.5H16.5a.75.75 0 000-1.5H15.75V3.75a.75.75 0 000-1.5H3zM18 2.25a.75.75 0 000 1.5v16.5a.75.75 0 000 1.5H21.75a.75.75 0 000 1.5H21a.75.75 0 000-1.5V2.25z" clip-rule="evenodd" />
                </svg>
                Data Kost
            </h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data kost, verifikasi status, dan atur promosi.</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Search Bar --}}
            <form method="GET" action="{{ route('admin.kost.index') }}" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kost..." 
                       class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-64 shadow-sm">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    {{-- ICON: Magnifying Glass --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                </div>
            </form>

            {{-- Tombol Tambah --}}
            <a href="{{ route('admin.kost.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                {{-- ICON: Plus --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <span>Tambah Data</span>
            </a>
        </div>
    </div>

    {{-- 3. TABEL DATA --}}
    <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
        
        {{-- Filter Status Pills (SVG Icons) --}}
        <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap gap-2 bg-gray-50/50">
            @php $currentStatus = request('status'); @endphp
            <a href="{{ route('admin.kost.index') }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1.5 {{ !$currentStatus ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                Semua
            </a>
            <a href="{{ route('admin.kost.index', ['status' => 'pending']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1.5 {{ $currentStatus == 'pending' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                {{-- ICON: Clock --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                </svg>
                Menunggu
            </a>
            <a href="{{ route('admin.kost.index', ['status' => 'diterima']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1.5 {{ $currentStatus == 'diterima' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                {{-- ICON: Check --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                Aktif
            </a>
            <a href="{{ route('admin.kost.index', ['status' => 'ditolak']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1.5 {{ $currentStatus == 'ditolak' ? 'bg-rose-500 text-white border-rose-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                {{-- ICON: X --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
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
                        <th class="px-6 py-4 text-center">Status Iklan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($kosts as $kost)
                    <tr class="hover:bg-indigo-50/30 transition group">
                        
                        {{-- INFO KOST --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                {{-- Logic Gambar Aman --}}
                                <div class="w-14 h-14 rounded-2xl bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0 flex items-center justify-center text-gray-400 shadow-sm">
                                    @php
                                        // LOGIKA FOTO (JANGAN DIHAPUS)
                                        $foto = null;
                                        if (is_string($kost->foto)) {
                                            $decoded = json_decode($kost->foto, true);
                                            if (is_array($decoded)) {
                                                $foto = $decoded[0] ?? null;
                                            } else {
                                                $foto = $kost->foto;
                                            }
                                        } elseif (is_array($kost->foto)) {
                                            $foto = $kost->foto[0] ?? null;
                                        }
                                        if (is_array($foto)) $foto = $foto['path'] ?? null;
                                        $imgSrc = $foto ? asset('storage/'.$foto) : null;
                                    @endphp
                                    
                                    @if($imgSrc)
                                        <img src="{{ $imgSrc }}" class="w-full h-full object-cover" alt="Foto Kost" onerror="this.src='{{ asset('kost/default.jpg') }}'">
                                    @else
                                        {{-- ICON: Photo/Image (Placeholder) --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition">{{ $kost->nama_kost }}</div>
                                    <div class="text-xs text-gray-500 truncate w-40 mt-0.5">{{ $kost->alamat }}</div>
                                    <div class="text-xs font-bold text-indigo-600 mt-1">
                                        Rp {{ number_format($kost->harga, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- PEMILIK --}}
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
                                            {{-- ICON: Phone --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                            </svg>
                                            Chat WA
                                        </a>
                                    @else
                                        <span class="text-[10px] text-gray-400">No WA -</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- STATUS VERIFIKASI (DROPDOWN AJAX) --}}
                        <td class="px-6 py-4 text-center">
                            {{-- Catatan: Emoji di dalam <option> dihapus untuk kebersihan UI (SVG tidak bisa di dalam option) --}}
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
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </td>

                        {{-- STATUS IKLAN --}}
                        <td class="px-6 py-4 text-center">
                            @php
                                $isActivePromo = $kost->is_promoted && now()->between($kost->promoted_start_date, $kost->promoted_end_date);
                            @endphp
                            
                            @if($isActivePromo)
                                <div class="inline-flex flex-col items-center">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-1 text-[10px] font-bold text-amber-700">
                                        {{-- ICON: Fire (Promoted) --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M13.5 4.938a7 7 0 11-9.006 1.737c.202-.257.59-.218.793.039.313.398.648.775 1 1.135 1.25.32 2.5 1.5 3 2.5a.75.75 0 001.214-.523c-.1-1.01.077-2.062.5-3.04.42-1.002.5-2.052.5-3.041a.75.75 0 00-1.214-.523 7.02 7.02 0 00-2.787 1.625z" clip-rule="evenodd" />
                                        </svg>
                                        Iklan Aktif
                                    </span>
                                    <span class="text-[10px] text-gray-400 mt-1">
                                        s/d {{ \Carbon\Carbon::parse($kost->promoted_end_date)->format('d M') }}
                                    </span>
                                </div>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-[10px] font-bold text-gray-400 border border-gray-100">
                                    Off
                                </span>
                            @endif
                        </td>

                        {{-- AKSI (SVG ICONS) --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                
                                {{-- Promosi --}}
                                <button onclick="openPromoModal({{ $kost->id }}, {{ $kost->is_promoted ? 1 : 0 }}, '{{ $kost->promoted_start_date }}', '{{ $kost->promoted_end_date }}')" 
                                    class="w-9 h-9 flex items-center justify-center rounded-full bg-amber-50 text-amber-600 hover:bg-amber-100 hover:scale-105 transition shadow-sm border border-amber-100" 
                                    title="Atur Promosi">
                                    {{-- ICON: Megaphone --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V4.875C21.75 3.84 20.91 3 19.875 3H4.125zM12 5.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zm0 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zm0 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zM5.8 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" clip-rule="evenodd" />
                                        <path d="M11.25 16.5a.75.75 0 00-1.5 0h-4.5a.75.75 0 00-.75.75v.75a.75.75 0 001.5 0v-.75h3.75v.75a.75.75 0 001.5 0v-.75z" />
                                    </svg>
                                </button>

                                {{-- Detail --}}
                                <a href="{{ route('admin.kost.show', $kost->id) }}" 
                                   class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 hover:scale-105 transition shadow-sm border border-blue-100" 
                                   title="Lihat Detail">
                                    {{-- ICON: Eye --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.kost.destroy', $kost->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kost ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="w-9 h-9 flex items-center justify-center rounded-full bg-rose-50 text-rose-600 hover:bg-rose-100 hover:scale-105 transition shadow-sm border border-rose-100" 
                                        title="Hapus Kost">
                                        {{-- ICON: Trash --}}
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
                            {{-- ICON: Home (Empty State) --}}
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

{{-- MODAL PROMOSI --}}
<div id="promoModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 flex items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 transform transition-all scale-100 border border-gray-100">
        
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-amber-50 rounded-full flex items-center justify-center text-amber-600">
                {{-- ICON: Megaphone --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V4.875C21.75 3.84 20.91 3 19.875 3H4.125zM12 5.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zm0 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zm0 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zM5.8 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" clip-rule="evenodd" />
                    <path d="M11.25 16.5a.75.75 0 00-1.5 0h-4.5a.75.75 0 00-.75.75v.75a.75.75 0 001.5 0v-.75h3.75v.75a.75.75 0 001.5 0v-.75z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Promosi Kost</h3>
        </div>
        
        <form id="promoForm">
            <input type="hidden" id="kostId">
            
            <div class="flex items-center justify-between mb-6 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                <div>
                    <span class="text-gray-800 font-bold text-sm block">Status Iklan</span>
                    <span class="text-xs text-gray-500">Tampilkan di halaman utama</span>
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

{{-- SCRIPT (TETAP) --}}
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

    document.getElementById('promoForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('kostId').value;
        const btn = document.getElementById('btnSave');
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Menyimpan...';
        btn.disabled = true;

        try {
            const response = await fetch(`/admin/kost/promotion/${id}`, {
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
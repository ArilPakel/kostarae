@extends('admin.layouts')

@section('content')
<div class="space-y-8 pb-12 font-sans text-gray-800">

    {{-- ===============================================================
       1. HEADER SECTION
       =============================================================== --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-gray-100 pb-5">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                Dashboard Overview
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Pantau performa Kostarae dan ambil tindakan cepat.
            </p>
        </div>
        <div>
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm text-sm text-gray-600">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    </div>

    {{-- ===============================================================
       2. KEY METRICS (STATISTIK)
       Tujuan: Scan cepat kondisi sistem.
       Grid: 4 Kolom seimbang.
       =============================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- A. Action Required (Urgent) --}}
        <a href="{{ route('admin.kost.index', ['status' => 'pending']) }}" 
           class="group bg-white p-6 rounded-xl border border-amber-200 shadow-sm hover:shadow-md hover:border-amber-300 transition-all relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-2">Perlu Review</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 group-hover:text-amber-600 transition">
                        {{ $stats['pending'] }}
                    </h3>
                </div>
                <div class="p-2 bg-amber-50 rounded-lg text-amber-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4 flex items-center gap-1">
                Menunggu persetujuan
                <span class="text-amber-500 group-hover:translate-x-1 transition-transform">→</span>
            </p>
        </a>

        {{-- B. Negative State (Info) --}}
        <a href="{{ route('admin.kost.index', ['status' => 'ditolak']) }}" 
           class="group bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-red-200 transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Ditolak</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 group-hover:text-red-500 transition">
                        {{ $stats['rejected'] }}
                    </h3>
                </div>
                <div class="p-2 bg-gray-50 rounded-lg text-gray-400 group-hover:text-red-500 group-hover:bg-red-50 transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">Pengajuan tidak valid</p>
        </a>

        {{-- C. Positive State (Primary) --}}
        <a href="{{ route('admin.kost.index', ['status' => 'diterima']) }}" 
           class="group bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Kost Aktif</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 group-hover:text-emerald-600 transition">
                        {{ $stats['active'] }}
                    </h3>
                </div>
                <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">Tayang di publik</p>
        </a>

        {{-- D. General Info (Neutral) --}}
        <a href="{{ route('admin.kost.index') }}" 
           class="group bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-blue-200 transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Total Unit</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 group-hover:text-blue-600 transition">
                        {{ $stats['total_kost'] }}
                    </h3>
                </div>
                <div class="p-2 bg-gray-50 rounded-lg text-gray-400 group-hover:text-blue-500 group-hover:bg-blue-50 transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">Database keseluruhan</p>
        </a>
    </div>

    {{-- ===============================================================
       3. FEATURE HIGHLIGHT: REKOMENDASI SISTEM
       Tujuan: Menampilkan "Pilihan Editor/Sistem" dengan visual menonjol.
       Grid: 12 Kolom (Full Width).
       =============================================================== --}}
    <div class="bg-gradient-to-r from-gray-50 to-white rounded-2xl border border-gray-200 p-1">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            {{-- Header Highlight --}}
            <div class="px-8 py-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="text-xl">🏆</span> Rekomendasi Sistem
                    </h3>
                    <p class="text-sm text-gray-500 mt-1 max-w-2xl">
                        Kost "Elite" yang lolos seleksi ketat (Rating > 4.0, Data Lengkap, Reputasi Baik). 
                        Prioritaskan unit ini untuk promosi.
                    </p>
                </div>
                <a href="{{ route('admin.kost.index', ['sort' => 'rating']) }}" class="px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold rounded-lg transition shadow-md">
                    Lihat Semua Kandidat
                </a>
            </div>

            {{-- Content Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/50 text-gray-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="px-8 py-4">Unit Kost</th>
                            <th class="px-6 py-4">Skor & Reputasi</th>
                            <th class="px-6 py-4">Kualifikasi</th>
                            <th class="px-8 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($recommendedKosts as $kost)
                        <tr class="hover:bg-blue-50/30 transition group">
                            {{-- Info Unit --}}
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0">
                                        @if(!empty($kost->foto) && is_array($kost->foto))
                                            <img src="{{ asset('storage/'.$kost->foto[0]) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        @else
                                            <div class="flex items-center justify-center h-full text-[10px] text-gray-400">No Img</div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-base mb-0.5">{{ $kost->nama }}</div>
                                        <div class="text-xs text-gray-500">Owner: {{ $kost->pemilik->name ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Skor --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 mb-1">
                                    <div class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded text-xs font-bold border border-yellow-200">
                                        ⭐ {{ number_format($kost->reviews_avg_rating, 1) }}
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $kost->reviews_count }} Ulasan</span>
                                </div>
                            </td>

                            {{-- Badges --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        Data 100%
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Terpercaya
                                    </span>
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-8 py-4 text-right">
                                <a href="{{ route('admin.kost.show', $kost->id) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-10 text-center">
                                <p class="text-sm text-gray-500 italic">Belum ada kost yang memenuhi standar rekomendasi sistem.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ===============================================================
       4. SPLIT SECTION: AKTIVITAS & PESAN
       Tujuan: Memisahkan log teknis dan komunikasi user.
       Grid: 12 Kolom (8 untuk Aktivitas, 4 untuk Pesan).
       =============================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        {{-- KOLOM KIRI (Aktivitas - 8 Kolom) --}}
        <div class="lg:col-span-8 bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Aktivitas Terbaru
                </h3>
                <a href="{{ route('admin.activity.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-900 transition">Lihat Log Penuh</a>
            </div>
            
            <div class="p-6">
                <div class="space-y-6 relative before:absolute before:inset-y-0 before:left-[17px] before:w-0.5 before:bg-gray-100">
                    @forelse($activities as $activity)
                    <div class="relative pl-8 group">
                        {{-- Dot Indikator (Warna sesuai tipe aksi) --}}
                        <div class="absolute left-3 top-1.5 w-2.5 h-2.5 rounded-full border-2 border-white shadow-sm z-10 
                            {{ $activity->description == 'created' ? 'bg-emerald-500' : ($activity->description == 'deleted' ? 'bg-red-500' : 'bg-blue-500') }}">
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
                            <div class="text-sm text-gray-600">
                                <span class="font-bold text-gray-900">{{ $activity->causer->name ?? 'System' }}</span>
                                <span class="mx-1 text-gray-400">•</span>
                                <span>{{ $activity->description }}</span>
                                <span class="font-medium bg-gray-50 px-1.5 rounded text-gray-700">
                                    {{ class_basename($activity->subject_type) }}
                                    @if(isset($activity->properties['attributes']['nama']))
                                        "{{ Str::limit($activity->properties['attributes']['nama'], 20) }}"
                                    @endif
                                </span>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-400 italic text-sm pl-8">Belum ada aktivitas tercatat.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN (Pesan - 4 Kolom) --}}
        <div class="lg:col-span-4 bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col h-full">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                    Pesan Masuk
                </h3>
            </div>
            
            <div class="flex-1 overflow-y-auto max-h-[400px]">
                @forelse($latestMessages as $msg)
                <a href="{{ route('admin.messages.show', $msg->id) }}" class="block px-6 py-4 hover:bg-gray-50 transition border-b border-gray-50 last:border-0 group">
                    <div class="flex items-start gap-3">
                        {{-- Avatar Inisial --}}
                        <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                            {{ substr($msg->name ?? 'A', 0, 1) }}
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-0.5">
                                <h4 class="text-sm font-bold text-gray-900 truncate group-hover:text-indigo-600 transition">{{ $msg->name }}</h4>
                                <span class="text-[10px] text-gray-400">{{ $msg->created_at->diffForHumans(null, true) }}</span>
                            </div>
                            <p class="text-xs text-gray-500 truncate">
                                {{ $msg->message }}
                            </p>
                        </div>
                    </div>
                </a>
                @empty
                <div class="flex flex-col items-center justify-center h-48 text-center px-6">
                    <div class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center mb-3 text-gray-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                    </div>
                    <p class="text-xs text-gray-500">Inbox kosong.</p>
                </div>
                @endforelse
            </div>

            <div class="p-4 bg-gray-50 rounded-b-2xl border-t border-gray-100">
                <a href="{{ route('admin.messages.index') }}" class="block w-full text-center py-2 bg-white border border-gray-200 hover:border-indigo-200 hover:text-indigo-600 text-gray-600 font-bold text-xs rounded-lg transition shadow-sm">
                    Buka Inbox
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
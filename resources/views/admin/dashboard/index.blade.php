@extends('admin.layouts')

@section('content')
<div class="space-y-8 pb-12 font-sans text-gray-800">

    {{-- ===============================================================
       1. HEADER SECTION (DIPERBARUI: USER ONLINE & TANGGAL)
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
        
        {{-- [PERBAIKAN] Menampilkan User Online & Tanggal Berdampingan --}}
        <div class="flex items-center gap-3">
            
            {{-- Indikator User Online --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm text-sm text-gray-600">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                </span>
                <span class="font-bold text-gray-900">{{ $onlineUsersCount ?? 0 }}</span>
                <span class="hidden sm:inline">Online</span>
            </div>

            {{-- Tanggal --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm text-sm text-gray-600">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    </div>

    {{-- ===============================================================
       2. KEY METRICS (STATISTIK)
       =============================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- A. Action Required --}}
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
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-amber-500 group-hover:translate-x-1 transition-transform">
                    <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                </svg>
            </p>
        </a>

        {{-- B. Negative State --}}
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

        {{-- C. Positive State --}}
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

        {{-- D. General Info --}}
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
       3. FEATURE HIGHLIGHT: REKOMENDASI BERANDA (SINKRON)
       =============================================================== --}}
    <div class="bg-gradient-to-r from-gray-50 to-white rounded-2xl border border-gray-200 p-1">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            {{-- Header Highlight --}}
            <div class="px-8 py-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-amber-500">
                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                        </svg>
                        Rekomendasi Beranda
                    </h3>
                    
                    {{-- [PERBAIKAN] Indikator & Tombol Reset Mode --}}
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-sm text-gray-500">Status Tampilan:</span>
                        @if($isManualMode)
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200">
                                    Mode Manual (Pilihan Admin)
                                </span>
                                {{-- TOMBOL RESET KE OTOMATIS --}}
                                <form action="{{ route('admin.kost.reset_recommendation') }}" method="POST" onsubmit="return confirm('Kembali ke Mode Otomatis? Semua pilihan manual akan dihapus.')">
                                    @csrf
                                    <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 underline cursor-pointer" title="Hapus semua centang rekomendasi">
                                        (Reset ke Otomatis)
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                Mode Otomatis (Rating Tertinggi)
                            </span>
                        @endif
                    </div>
                </div>
                
                {{-- Tombol Aksi --}}
                <div class="flex gap-2">
                    @if(!$isManualMode)
                        <a href="{{ route('admin.kost.index') }}" class="px-4 py-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 text-xs font-bold rounded-lg transition border border-indigo-100">
                            + Pilih Manual
                        </a>
                    @endif
                    <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold rounded-lg transition shadow-md flex items-center gap-2">
                        Lihat Website <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
            </div>

            {{-- Content Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/50 text-gray-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="px-8 py-4">Unit Kost</th>
                            <th class="px-6 py-4">Skor Review</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-8 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($rekomendasiBeranda as $kost)
                        <tr class="hover:bg-blue-50/30 transition group">
                            {{-- Info Unit --}}
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0 relative">
                                        @php
                                            $foto = is_string($kost->foto) ? json_decode($kost->foto, true) : $kost->foto;
                                            $imgSrc = is_array($foto) ? ($foto[0]['path'] ?? $foto[0] ?? null) : $foto;
                                        @endphp
                                        
                                        @if($imgSrc)
                                            <img src="{{ asset('storage/'.$imgSrc) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        @else
                                            <div class="flex items-center justify-center h-full text-[10px] text-gray-400">No Img</div>
                                        @endif

                                        {{-- Badge Manual --}}
                                        @if($kost->is_recommended)
                                            <div class="absolute top-0 right-0 p-1 bg-purple-500 rounded-bl-lg shadow-sm" title="Dipilih Manual">
                                                <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-base mb-0.5 line-clamp-1">{{ $kost->nama_kost ?? $kost->nama }}</div>
                                        <div class="text-xs text-gray-500">Owner: {{ $kost->pemilik->name ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Skor --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 mb-1">
                                    <div class="bg-amber-100 text-amber-700 px-2 py-0.5 rounded text-xs font-bold border border-amber-200 flex items-center gap-1">
                                        ★ {{ number_format($kost->reviews_avg_rating ?? 0, 1) }}
                                    </div>
                                    <span class="text-xs text-gray-500">({{ $kost->reviews_count ?? 0 }} ulasan)</span>
                                </div>
                            </td>

                            {{-- Harga --}}
                            <td class="px-6 py-4 font-bold text-gray-700 text-sm">
                                Rp {{ number_format($kost->harga, 0, ',', '.') }}
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
                                <p class="text-sm text-gray-500 italic">Belum ada kost aktif untuk ditampilkan.</p>
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
       =============================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        {{-- KOLOM KIRI (Aktivitas) --}}
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
                        <div class="absolute left-3 top-1.5 w-2.5 h-2.5 rounded-full border-2 border-white shadow-sm z-10 
                            {{ $activity->description == 'created' ? 'bg-emerald-500' : ($activity->description == 'deleted' ? 'bg-red-500' : 'bg-blue-500') }}">
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
                            <div class="text-sm text-gray-600">
                                <span class="font-bold text-gray-900">{{ $activity->causer->name ?? 'System' }}</span>
                                <span class="mx-1 text-gray-400">&bull;</span>
                                <span>{{ $activity->description }}</span>
                                <span class="font-medium bg-gray-50 px-1.5 rounded text-gray-700">
                                    {{ class_basename($activity->subject_type) }}
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

        {{-- KOLOM KANAN (Pesan) --}}
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
                        <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                            {{ substr($msg->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-0.5">
                                <h4 class="text-sm font-bold text-gray-900 truncate group-hover:text-indigo-600 transition">{{ $msg->name }}</h4>
                                <span class="text-[10px] text-gray-400">{{ $msg->created_at->diffForHumans(null, true) }}</span>
                            </div>
                            <p class="text-xs text-gray-500 truncate">{{ $msg->message }}</p>
                        </div>
                    </div>
                </a>
                @empty
                <div class="flex flex-col items-center justify-center h-48 text-center px-6">
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
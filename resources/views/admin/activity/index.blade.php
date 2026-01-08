@extends('admin.layouts')
@section('title', 'Jejak Aktivitas')

@section('content')
<div class="space-y-8 pb-12 font-sans text-gray-800">

    {{-- ===============================================================
       1. HEADER SECTION (Redesigned: Bersih & Fokus)
       =============================================================== --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-gray-100 pb-5">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                {{-- ICON: Activity/Pulse --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-emerald-600">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5 .75.75 0 000 1.5z" clip-rule="evenodd" />
                </svg>
                Jejak Aktivitas
            </h1>
            <p class="text-sm text-gray-500 mt-1 ml-1">
                Memantau riwayat perubahan data dan tindakan pengguna dalam sistem.
            </p>
        </div>
        
        {{-- Action Button --}}
        <div class="flex items-center gap-3">
             <a href="{{ route('admin.activity.index') }}" class="bg-white hover:bg-gray-50 text-gray-600 border border-gray-200 px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                    <path fill-rule="evenodd" d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z" clip-rule="evenodd" />
                </svg>
                Refresh Data
            </a>
        </div>
    </div>

    {{-- ===============================================================
       2. QUICK FILTERS & SEARCH
       =============================================================== --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        
        {{-- Filter Chips --}}
        <div class="flex flex-wrap gap-2 w-full md:w-auto">
            <a href="{{ route('admin.activity.index') }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1 {{ !request('search') ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-300' }}">
                Semua
            </a>
            <a href="{{ route('admin.activity.index', ['search' => 'login']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white text-emerald-600 border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition">
                Login
            </a>
            <a href="{{ route('admin.activity.index', ['search' => 'update']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white text-amber-600 border-gray-200 hover:bg-amber-50 hover:border-amber-200 transition">
                Update
            </a>
            <a href="{{ route('admin.activity.index', ['search' => 'delete']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white text-rose-600 border-gray-200 hover:bg-rose-50 hover:border-rose-200 transition">
                Hapus
            </a>
        </div>

        {{-- Search Bar --}}
        <div class="w-full md:w-64">
            <form action="{{ route('admin.activity.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas..." 
                       class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-xs focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition shadow-sm">
                <svg class="w-4 h-4 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
        </div>
    </div>

    {{-- ===============================================================
       3. TIMELINE CONTENT (Redesigned)
       =============================================================== --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            
            {{-- Container Timeline --}}
            <div class="relative border-l-2 border-gray-100 ml-3 space-y-8">

                {{-- Gunakan variabel $logs dari controller Anda --}}
                @forelse($logs as $log)
                    @php
                        // --- LOGIC VISUAL & COLOR (Diadaptasi dari kode lama) ---
                        $desc = strtolower($log->description);
                        
                        // Default Style (General)
                        $dotColor = 'bg-blue-400';
                        $borderColor = 'border-blue-400';
                        $badgeClass = 'bg-blue-50 text-blue-700';
                        
                        // Custom Style based on Action
                        if (Str::contains($desc, ['hapus', 'delete', 'destroy'])) {
                            $dotColor = 'bg-rose-500';
                            $borderColor = 'border-rose-500';
                            $badgeClass = 'bg-rose-50 text-rose-700';
                        } elseif (Str::contains($desc, ['update', 'edit', 'ubah'])) {
                            $dotColor = 'bg-amber-400';
                            $borderColor = 'border-amber-400';
                            $badgeClass = 'bg-amber-50 text-amber-700';
                        } elseif (Str::contains($desc, ['login', 'masuk', 'create', 'buat'])) {
                            $dotColor = 'bg-emerald-500';
                            $borderColor = 'border-emerald-500';
                            $badgeClass = 'bg-emerald-50 text-emerald-700';
                        } elseif (Str::contains($desc, ['logout', 'keluar'])) {
                            $dotColor = 'bg-gray-400';
                            $borderColor = 'border-gray-400';
                            $badgeClass = 'bg-gray-50 text-gray-600';
                        }

                        // --- CAUSER & SUBJECT INFO ---
                        $causerName = $log->causer->name ?? 'System / Guest';
                        // Ambil role jika ada relationship, atau fallback
                        $causerRole = $log->causer->role ?? 'System'; 
                        
                        $subjectLink = '#';
                        $subjectName = '';
                        if ($log->subject_type && $log->subject_id) {
                            $shortSubject = class_basename($log->subject_type);
                            if (Str::contains($log->subject_type, 'User')) {
                                $subjectName = 'Pengguna';
                                $subjectLink = route('admin.users.edit', $log->subject_id);
                            } elseif (Str::contains($log->subject_type, 'Kost')) {
                                $subjectName = 'Kost';
                                $subjectLink = route('admin.kost.show', $log->subject_id);
                            } else {
                                $subjectName = $shortSubject;
                            }
                        }
                    @endphp

                    <div class="relative pl-8 sm:pl-10 group">
                        
                        {{-- 2.A. Indikator Visual (Simple Dot) --}}
                        <div class="absolute -left-[9px] top-1 bg-white border-2 {{ $borderColor }} rounded-full w-5 h-5 flex items-center justify-center transition-transform group-hover:scale-110">
                            <div class="w-2 h-2 rounded-full {{ $dotColor }}"></div>
                        </div>

                        {{-- 2.B. Card Content (Modern & Clean) --}}
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 p-4 rounded-2xl hover:bg-gray-50 border border-transparent hover:border-gray-100 transition-all duration-200">
                            
                            {{-- Info Utama --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                    {{-- Badge Tipe Aksi --}}
                                    <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold tracking-wider border border-transparent {{ $badgeClass }}">
                                        {{ $log->description }}
                                    </span>
                                    
                                    {{-- Waktu Relatif --}}
                                    <span class="text-xs text-gray-400 font-medium">
                                        &bull; {{ $log->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <h3 class="text-sm text-gray-900 leading-relaxed">
                                    <span class="font-bold text-gray-800">{{ $causerName }}</span>
                                    <span class="text-gray-500">({{ $causerRole }})</span>
                                    <span class="text-gray-400 mx-1">-</span>
                                    <span class="text-gray-600">{{ $log->description }}</span>
                                    
                                    @if($subjectName)
                                        pada <a href="{{ $subjectLink }}" class="font-medium text-indigo-600 hover:text-indigo-800 hover:underline transition">
                                            {{ $subjectName }} #{{ $log->subject_id }}
                                        </a>
                                    @endif
                                </h3>

                                {{-- Waktu Detail (Absolute Time) --}}
                                <p class="text-xs text-gray-400 mt-2 flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 opacity-70">
                                        <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $log->created_at->format('d M Y, H:i') }} WIB
                                </p>
                            </div>

                            {{-- Tombol Aksi (Subtle & Tidak Dominan) --}}
                            <div class="pt-1">
                                <a href="{{ route('admin.activity.show', $log->id) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-gray-500 bg-white border border-gray-200 rounded-lg hover:text-emerald-600 hover:border-emerald-200 hover:bg-emerald-50 transition shadow-sm whitespace-nowrap">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="flex flex-col items-center justify-center py-16 text-center border-2 border-dashed border-gray-100 rounded-2xl bg-gray-50/50">
                        <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-gray-900 font-bold text-sm">Tidak Ada Aktivitas</h3>
                        <p class="text-gray-500 text-xs mt-1">Belum ada log aktivitas yang tercatat saat ini.</p>
                        @if(request('search'))
                            <a href="{{ route('admin.activity.index') }}" class="text-emerald-600 hover:text-emerald-700 text-xs font-bold mt-3 underline">
                                Reset Pencarian
                            </a>
                        @endif
                    </div>
                @endforelse

            </div>
        </div>

        {{-- Pagination (Footer) --}}
        @if(method_exists($logs, 'links') && $logs->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $logs->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
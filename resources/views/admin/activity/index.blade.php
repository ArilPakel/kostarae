@extends('admin.layouts')
@section('title', 'Jejak Aktivitas')

@section('content')
<div class="space-y-8 pb-20">

    {{-- 1. HEADER & RINGKASAN --}}
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                {{-- ICON: Compass (Ganti 🧭) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-indigo-600">
                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
                Jejak Aktivitas
            </h1>
            <p class="text-sm text-gray-500 mt-1">Pusat audit dan monitoring seluruh aktivitas sistem Kostarae.</p>
        </div>
        
        <div class="flex gap-2">
            <a href="{{ route('admin.activity.index') }}" class="bg-white hover:bg-gray-50 text-gray-600 border border-gray-200 px-4 py-2.5 rounded-xl text-sm font-bold transition shadow-sm flex items-center gap-2">
                {{-- ICON: Arrow Path/Refresh (Ganti 🔄) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z" clip-rule="evenodd" />
                </svg>
                Refresh Data
            </a>
        </div>
    </div>

    {{-- 2. STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- User Online --}}
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 relative overflow-hidden">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                {{-- ICON: User Circle (Ganti 🟢) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 animate-pulse">
                    <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">User Online</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">
                    {{ $onlineUsersCount ?? 0 }} 
                    <span class="text-xs font-medium text-gray-400">User</span>
                </h3>
            </div>
        </div>

        {{-- Aktivitas Hari Ini --}}
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                {{-- ICON: Clipboard List (Ganti 🧾) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M15.97 2.47a.75.75 0 011.06 0l4.5 4.5a.75.75 0 010 1.06l-4.5 4.5a.75.75 0 11-1.06-1.06l3.22-3.22H7.5a.75.75 0 00-1.061-1.06l3.22-3.22a.75.75 0 010 1.06zm-7.94 7.94a.75.75 0 010 1.06l-3.22 3.22H16.5a.75.75 0 011.061 1.06l-3.22 3.22a.75.75 0 010-1.06l3.22-3.22H7.5a.75.75 0 00-1.061 1.06l-3.22 3.22a.75.75 0 11-1.06-1.06l4.5-4.5a.75.75 0 011.06 0z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Aktivitas Hari Ini</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">
                    {{ $todayActivityCount ?? 0 }}
                    <span class="text-xs font-medium text-gray-400">Logs</span>
                </h3>
            </div>
        </div>

        {{-- Aksi Kritis --}}
        <div class="bg-white p-5 rounded-3xl border border-rose-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                {{-- ICON: Trash (Ganti 🗑️) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.49 1.478l-.56-.092v13.386a2.25 2.25 0 01-2.25 2.25H6.942a2.25 2.25 0 01-2.25-2.25V6.603l-.56.092a.75.75 0 01-.49-1.478 48.831 48.831 0 013.876-.512v-.227c0-1.136.953-2.115 2.088-2.202 4.19-.321 8.358-.321 12.549 0 1.135.087 2.088 1.066 2.088 2.202zM8.25 6.75h7.5v13.5h-7.5V6.75zm1.5 2.25a.75.75 0 01.75.75v7.5a.75.75 0 01-1.5 0v-7.5a.75.75 0 01.75-.75zm4.5 0a.75.75 0 01.75.75v7.5a.75.75 0 01-1.5 0v-7.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-rose-400 uppercase tracking-wider">Aksi Kritis</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">
                    {{ $criticalActionCount ?? 0 }}
                    <span class="text-xs font-medium text-gray-400">Data</span>
                </h3>
            </div>
        </div>
    </div>

    {{-- 3. QUICK FILTERS (CHIPS) --}}
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.activity.index') }}" 
           class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1 {{ !request('search') ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-300' }}">
            Semua
        </a>
        <a href="{{ route('admin.activity.index', ['search' => 'login']) }}" 
           class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white text-emerald-600 border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition flex items-center gap-1">
            {{-- ICON: Key --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                <path fill-rule="evenodd" d="M8 7a5 5 0 113.61 4.804l-1.903 1.903A1 1 0 019 14H8v1a1 1 0 01-1 1H6v1a1 1 0 01-1 1H3a1 1 0 01-1-1v-2a1 1 0 01.293-.707L8.196 8.39A5.002 5.002 0 018 7zm5-3a.75.75 0 000 1.5A1.5 1.5 0 0114.5 7 .75.75 0 0016 7a3 3 0 00-3-3z" clip-rule="evenodd" />
            </svg>
            Login
        </a>
        <a href="{{ route('admin.activity.index', ['search' => 'update']) }}" 
           class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white text-amber-600 border-gray-200 hover:bg-amber-50 hover:border-amber-200 transition flex items-center gap-1">
            {{-- ICON: Pencil --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
            </svg>
            Update
        </a>
        <a href="{{ route('admin.activity.index', ['search' => 'delete']) }}" 
           class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white text-rose-600 border-gray-200 hover:bg-rose-50 hover:border-rose-200 transition flex items-center gap-1">
            {{-- ICON: Trash --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
            </svg>
            Hapus
        </a>
    </div>

    {{-- 4. SEARCH BAR --}}
    <div class="bg-white p-2 rounded-2xl border border-gray-100 shadow-sm">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                {{-- ICON: Magnifying Glass (Ganti 🔍) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </div>
            <form action="{{ route('admin.activity.index') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama user, nama kost, atau jenis aktivitas..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border-transparent rounded-xl text-sm focus:bg-white focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 transition">
            </form>
        </div>
    </div>

    {{-- 5. TIMELINE UTAMA --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6">
            <h3 class="font-bold text-gray-800 mb-8 flex items-center gap-2">
                {{-- ICON: Calendar Days (Ganti 📅) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-indigo-600">
                    <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                    <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                </svg>
                Timeline Real-Time
            </h3>

            <div class="relative border-l-2 border-gray-100 ml-4 space-y-8">
                
                @forelse($logs as $log)
                    @php
                        // --- LOGIC: VISUAL & WARNA (DENGAN SVG) ---
                        $desc = strtolower($log->description);
                        $color = 'bg-blue-50 text-blue-600 border-blue-100';
                        $borderColor = 'border-l-blue-500';
                        
                        // Default Icon: Clock
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" /></svg>';

                        if (Str::contains($desc, ['hapus', 'delete', 'destroy'])) {
                            $color = 'bg-rose-50 text-rose-600 border-rose-100';
                            $borderColor = 'border-l-rose-500';
                            // Icon: Trash
                            $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" /></svg>';
                        } elseif (Str::contains($desc, ['update', 'edit', 'ubah'])) {
                            $color = 'bg-amber-50 text-amber-600 border-amber-100';
                            $borderColor = 'border-l-amber-500';
                            // Icon: Pencil
                            $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" /></svg>';
                        } elseif (Str::contains($desc, ['login', 'masuk'])) {
                            $color = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                            $borderColor = 'border-l-emerald-500';
                            // Icon: Key
                            $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" /></svg>';
                        } elseif (Str::contains($desc, ['logout', 'keluar'])) {
                            $color = 'bg-gray-100 text-gray-500 border-gray-200';
                            $borderColor = 'border-l-gray-400';
                            // Icon: Arrow Right On Rectangle (Exit)
                            $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>';
                        }

                        // --- LOGIC: CAUSER NAME & ROLE ---
                        $causerName = $log->causer->name ?? 'System / Guest';
                        $causerRole = $log->causer->role ?? 'System';
                        $roleBadgeColor = match(strtolower($causerRole)) {
                            'admin' => 'bg-emerald-100 text-emerald-700',
                            'pemilik', 'owner' => 'bg-purple-100 text-purple-700',
                            default => 'bg-blue-100 text-blue-700'
                        };

                        // --- LOGIC: SUBJECT LINK ---
                        $subjectLink = '#';
                        $subjectName = '';
                        if ($log->subject_type && $log->subject_id) {
                            if (Str::contains($log->subject_type, 'User')) {
                                $subjectName = 'Pengguna';
                                $subjectLink = route('admin.users.edit', $log->subject_id);
                            } elseif (Str::contains($log->subject_type, 'Kost')) {
                                $subjectName = 'Kost';
                                $subjectLink = route('admin.kost.show', $log->subject_id);
                            }
                        }
                    @endphp

                    <div class="relative pl-8 group">
                        {{-- Timeline Icon --}}
                        <div class="absolute -left-[21px] top-0 w-11 h-11 rounded-full border-4 border-white flex items-center justify-center shadow-sm {{ $color }} z-10">
                            {!! $icon !!}
                        </div>

                        {{-- Card Utama --}}
                        <div class="flex flex-col p-5 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-md transition-all relative">
                            
                            {{-- Indikator Warna di Kiri Card --}}
                            <div class="absolute left-0 top-4 bottom-4 w-1 rounded-r {{ str_replace('border-l-', 'bg-', $borderColor) }}"></div>

                            <div class="pl-3">
                                {{-- Baris Atas: Pelaku & Waktu --}}
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-bold text-gray-900 text-sm">{{ $causerName }}</span>
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase {{ $roleBadgeColor }}">
                                            {{ $causerRole }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-400 font-medium whitespace-nowrap">
                                        {{ $log->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                {{-- Deskripsi --}}
                                <div class="text-sm text-gray-600 mb-4 leading-relaxed">
                                    {{ $log->description }}
                                    @if($subjectName)
                                        pada <a href="{{ $subjectLink }}" class="font-bold text-indigo-600 hover:underline">{{ $subjectName }} #{{ $log->subject_id }}</a>
                                    @endif
                                </div>

                                {{-- Baris Bawah: Tombol Detail (SELALU MUNCUL) --}}
                                <div class="flex items-center justify-end border-t border-gray-50 pt-3">
                                    <a href="{{ route('admin.activity.show', $log->id) }}" 
                                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-bold hover:bg-indigo-100 hover:text-indigo-700 transition border border-indigo-100 shadow-sm">
                                        {{-- ICON: Eye (Ganti 👁️) --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                            <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        Lihat Detail Lengkap
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                        {{-- ICON: Search (Empty State) --}}
                        <div class="flex justify-center mb-3 text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12">
                                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada aktivitas yang sesuai filter.</p>
                        <a href="{{ route('admin.activity.index') }}" class="text-indigo-600 hover:underline text-sm mt-2 block">Reset Filter</a>
                    </div>
                @endforelse

            </div>
        </div>

        {{-- PAGINATION --}}
        @if(method_exists($logs, 'links'))
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $logs->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
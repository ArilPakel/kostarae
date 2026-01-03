@extends('admin.layouts')
@section('title', 'Jejak Aktivitas')

@section('content')
<div class="space-y-8 pb-20">

    {{-- 1. HEADER & RINGKASAN --}}
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                🧭 Jejak Aktivitas
            </h1>
            <p class="text-sm text-gray-500 mt-1">Pusat audit dan monitoring seluruh aktivitas sistem Kostarae.</p>
        </div>
        
        <div class="flex gap-2">
            <a href="{{ route('admin.activity.index') }}" class="bg-white hover:bg-gray-50 text-gray-600 border border-gray-200 px-4 py-2.5 rounded-xl text-sm font-bold transition shadow-sm flex items-center gap-2">
                <span>🔄</span> Refresh Data
            </a>
        </div>
    </div>

    {{-- 2. STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- User Online --}}
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 relative overflow-hidden">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl animate-pulse">
                🟢
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
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl">
                🧾
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
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl">
                🗑️
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
           class="px-4 py-1.5 rounded-full text-xs font-bold border transition {{ !request('search') ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-300' }}">
            Semua
        </a>
        <a href="{{ route('admin.activity.index', ['search' => 'login']) }}" 
           class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white text-emerald-600 border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition flex items-center gap-1">
            🔑 Login
        </a>
        <a href="{{ route('admin.activity.index', ['search' => 'update']) }}" 
           class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white text-amber-600 border-gray-200 hover:bg-amber-50 hover:border-amber-200 transition flex items-center gap-1">
            ✏️ Update
        </a>
        <a href="{{ route('admin.activity.index', ['search' => 'delete']) }}" 
           class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white text-rose-600 border-gray-200 hover:bg-rose-50 hover:border-rose-200 transition flex items-center gap-1">
            🗑️ Hapus
        </a>
    </div>

    {{-- 4. SEARCH BAR --}}
    <div class="bg-white p-2 rounded-2xl border border-gray-100 shadow-sm">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-400">🔍</span>
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
                📅 Timeline Real-Time
            </h3>

            <div class="relative border-l-2 border-gray-100 ml-4 space-y-8">
                
                @forelse($logs as $log)
                    @php
                        // --- LOGIC: VISUAL & WARNA ---
                        $desc = strtolower($log->description);
                        $color = 'bg-blue-50 text-blue-600 border-blue-100';
                        $borderColor = 'border-l-blue-500';
                        $icon = '🔵';

                        if (Str::contains($desc, ['hapus', 'delete', 'destroy'])) {
                            $color = 'bg-rose-50 text-rose-600 border-rose-100';
                            $borderColor = 'border-l-rose-500';
                            $icon = '🗑️';
                        } elseif (Str::contains($desc, ['update', 'edit', 'ubah'])) {
                            $color = 'bg-amber-50 text-amber-600 border-amber-100';
                            $borderColor = 'border-l-amber-500';
                            $icon = '✏️';
                        } elseif (Str::contains($desc, ['login', 'masuk'])) {
                            $color = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                            $borderColor = 'border-l-emerald-500';
                            $icon = '🔑';
                        } elseif (Str::contains($desc, ['logout', 'keluar'])) {
                            $color = 'bg-gray-100 text-gray-500 border-gray-200';
                            $borderColor = 'border-l-gray-400';
                            $icon = '🚪';
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
                        <div class="absolute -left-[21px] top-0 w-11 h-11 rounded-full border-4 border-white flex items-center justify-center text-lg shadow-sm {{ $color }} z-10">
                            {{ $icon }}
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
                                        👁️ Lihat Detail Lengkap
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                        <div class="text-5xl opacity-30 mb-3 grayscale">🔍</div>
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
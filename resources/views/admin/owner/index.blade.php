@extends('admin.layouts')
@section('title', 'Manajemen Mitra Pemilik')

@section('content')
<div class="space-y-8 pb-20">

    {{-- 1. HEADER & SUMMARY STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Total Mitra --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center z-10">
                {{-- ICON: Briefcase --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                    <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h9a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5h-9zM6 5.25h9v13.5h-9V5.25zM10.5 1.5a.75.75 0 01.75.75v.75h1.5v-.75a.75.75 0 011.5 0v.75H18a3 3 0 013 3v13.5a3 3 0 01-3 3H6a3 3 0 01-3-3V5.25a3 3 0 013-3h3.75v-.75A.75.75 0 0110.5 1.5zM9 3.75v.75h6v-.75a.75.75 0 00-.75-.75h-4.5a.75.75 0 00-.75.75z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="z-10">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Mitra</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $totalOwners ?? 0 }}</h3>
            </div>
        </div>

        {{-- Produktif --}}
        <div class="bg-emerald-50/50 p-6 rounded-3xl border border-emerald-100 shadow-sm flex items-center gap-4 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-100/50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center z-10">
                {{-- ICON: Trending Up --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                    <path fill-rule="evenodd" d="M15.22 6.268a.75.75 0 01.968-.432l5.942 2.28a.75.75 0 01.431.97l-2.28 5.941a.75.75 0 11-1.4-.537l1.63-4.251-1.086.483a6 6 0 00-3.143 5.109.75.75 0 01-1.5 0 7.5 7.5 0 013.928-6.387l1.086-.484-4.251 1.631a.75.75 0 01-.537-1.402l5.941-2.28z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M1.5 7.5c0 5.799 4.701 10.5 10.5 10.5a10.481 10.481 0 008.7-4.63.75.75 0 111.233.856c-2.316 3.33-6.19 5.274-10.333 5.274-6.904 0-12.5-5.596-12.5-12.5C1.5 3.31 5.274-.564 8.604 1.752a.75.75 0 11-.856 1.233A10.481 10.481 0 001.5 7.5z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="z-10">
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Produktif</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $productiveOwners ?? 0 }}</h3>
                <p class="text-[10px] text-emerald-600 font-medium">Memiliki Kost Aktif</p>
            </div>
        </div>

        {{-- Pasif --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gray-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="w-14 h-14 rounded-2xl bg-gray-100 text-gray-500 flex items-center justify-center z-10">
                {{-- ICON: Moon/Sleep --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                    <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="z-10">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pasif (0 Kost)</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ ($totalOwners ?? 0) - ($productiveOwners ?? 0) }}</h3>
                <p class="text-[10px] text-gray-400 font-medium">Perlu Follow-up</p>
            </div>
        </div>
    </div>

    {{-- 2. TOOLBAR (Search & Filter) --}}
    <div class="flex flex-col lg:flex-row justify-between items-center gap-4 bg-white p-2 rounded-2xl border border-gray-100 shadow-sm">
        {{-- Search --}}
        <div class="relative w-full lg:w-96">
            <form action="{{ route('admin.owners.index') }}" method="GET">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    {{-- ICON: Magnifying Glass --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mitra..." 
                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border-transparent rounded-xl text-sm focus:bg-white focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 transition">
            </form>
        </div>

        {{-- Filters --}}
        <div class="flex gap-2 w-full lg:w-auto overflow-x-auto pb-1 lg:pb-0">
            <form id="filterForm" action="{{ route('admin.owners.index') }}" method="GET" class="flex gap-2 w-full">
                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                
                <select name="status" onchange="this.form.submit()" class="flex-1 lg:flex-none px-5 py-3 bg-gray-50 border-transparent rounded-xl text-sm font-bold text-gray-600 focus:bg-white focus:border-indigo-300 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="produktif" {{ request('status') == 'produktif' ? 'selected' : '' }}>Produktif</option>
                    <option value="pasif" {{ request('status') == 'pasif' ? 'selected' : '' }}>Pasif</option>
                </select>

                <select name="sort" onchange="this.form.submit()" class="flex-1 lg:flex-none px-5 py-3 bg-gray-50 border-transparent rounded-xl text-sm font-bold text-gray-600 focus:bg-white focus:border-indigo-300 cursor-pointer">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru Gabung</option>
                    <option value="most_active" {{ request('sort') == 'most_active' ? 'selected' : '' }}>Kost Terbanyak</option>
                </select>
            </form>
        </div>
    </div>

    {{-- 3. GRID CARD MITRA --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($owners as $owner)
            @php 
                $isProductive = $owner->active_kost_count > 0;
                $statusColor = $isProductive ? 'bg-emerald-500' : 'bg-gray-300';
                $cardBorder = $isProductive ? 'border-emerald-100' : 'border-gray-100';
            @endphp
            
            <div class="group bg-white rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full border {{ $cardBorder }} relative overflow-hidden">
                
                {{-- Status Bar Atas --}}
                <div class="h-1.5 w-full {{ $statusColor }}"></div>

                <div class="p-6 flex flex-col h-full">
                    
                    {{-- Header Profil --}}
                    <div class="flex items-start gap-4 mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-gray-50 text-gray-600 flex items-center justify-center font-bold text-xl shadow-inner border border-gray-100 flex-shrink-0">
                            {{ substr($owner->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-gray-900 text-lg truncate" title="{{ $owner->name }}">
                                {{ $owner->name }}
                            </h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded-md bg-gray-50 text-[10px] font-bold text-gray-500 border border-gray-100">
                                    Member sejak {{ $owner->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Admin Note --}}
                    @if($owner->admin_notes)
                    <div class="mb-5 bg-amber-50 border border-amber-100 p-3 rounded-xl text-xs text-amber-800 flex items-start gap-2">
                        {{-- ICON: Document Text --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
                            <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
                        </svg>
                        <span class="line-clamp-2 italic">"{{ $owner->admin_notes }}"</span>
                    </div>
                    @endif

                    {{-- Statistik Utama --}}
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="bg-gray-50 rounded-2xl p-3 text-center border border-gray-100">
                            <span class="block text-[10px] font-bold text-gray-400 uppercase">Kost Dimiliki</span>
                            <span class="block text-2xl font-bold {{ $isProductive ? 'text-gray-800' : 'text-gray-400' }} mt-1">
                                {{ $owner->active_kost_count }}
                            </span>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-3 text-center border border-gray-100 flex flex-col justify-center items-center">
                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Status</span>
                            @if($isProductive)
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                                    {{-- ICON: Check Circle --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                    Produktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-200 text-gray-500 text-[10px] font-bold">
                                    {{-- ICON: Pause Circle --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path fill-rule="evenodd" d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm5-2.25A.75.75 0 017.75 7h.5a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75h-.5a.75.75 0 01-.75-.75v-4.5zm4 0a.75.75 0 01.75-.75h.5a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75h-.5a.75.75 0 01-.75-.75v-4.5z" clip-rule="evenodd" />
                                    </svg>
                                    Pasif
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between gap-2">
                        
                        {{-- WhatsApp --}}
                        @if($owner->phone)
                            @php $wa = preg_replace('/^0/', '62', $owner->phone); @endphp
                            <a href="https://wa.me/{{ $wa }}" target="_blank" 
                               class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl bg-emerald-50 text-emerald-600 font-bold text-sm hover:bg-emerald-500 hover:text-white transition group/wa border border-emerald-100">
                                {{-- ICON: Phone --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                </svg>
                                <span class="hidden sm:inline">WhatsApp</span>
                            </a>
                        @else
                            <button disabled class="flex-1 py-2.5 rounded-xl bg-gray-50 text-gray-300 font-bold text-sm cursor-not-allowed border border-gray-100 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                </svg>
                                <span class="hidden sm:inline">No WA</span>
                            </button>
                        @endif

                        {{-- Grup Aksi Admin --}}
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.owners.show', $owner->id) }}" 
                               class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition border border-blue-100" title="Detail">
                                {{-- ICON: Eye --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <button onclick="openNoteModal({{ $owner->id }}, '{{ addslashes($owner->admin_notes ?? '') }}')" 
                                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-100 transition border border-amber-100" title="Catatan">
                                {{-- ICON: Pencil --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                    <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                </svg>
                            </button>
                            <form action="{{ route('admin.owners.destroy', $owner->id) }}" method="POST" onsubmit="return confirm('Hapus mitra ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 transition border border-rose-100" title="Hapus">
                                    {{-- ICON: Trash --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-gray-100 border-dashed">
                <div class="flex justify-center mb-4 text-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16">
                        <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h9a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5h-9zM6 5.25h9v13.5h-9V5.25zM10.5 1.5a.75.75 0 01.75.75v.75h1.5v-.75a.75.75 0 011.5 0v.75H18a3 3 0 013 3v13.5a3 3 0 01-3 3H6a3 3 0 01-3-3V5.25a3 3 0 013-3h3.75v-.75A.75.75 0 0110.5 1.5zM9 3.75v.75h6v-.75a.75.75 0 00-.75-.75h-4.5a.75.75 0 00-.75.75z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Belum ada mitra ditemukan</h3>
                <p class="text-gray-500 mt-2">Silakan tunggu pendaftaran mitra baru.</p>
            </div>
        @endforelse
    </div>

    {{-- 4. PAGINATION --}}
    @if($owners->hasPages())
        <div class="mt-8 px-4 border-t border-gray-100 pt-6">
            {{ $owners->withQueryString()->links() }}
        </div>
    @endif

</div>

{{-- MODAL NOTE --}}
<div id="noteModal" class="fixed inset-0 z-50 hidden bg-gray-900/40 flex items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 transform transition-all scale-100 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                {{-- ICON: Document Text --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-indigo-600">
                    <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
                </svg>
                Catatan Admin
            </h3>
            <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-100 transition">✕</button>
        </div>
        
        <form id="noteForm">
            <input type="hidden" id="modalOwnerId">
            <textarea id="modalNoteText" rows="4" 
                      class="w-full rounded-2xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm p-4 bg-gray-50 placeholder-gray-400 resize-none" 
                      placeholder="Contoh: 'Respon cepat', 'Perlu verifikasi ulang data diri'"></textarea>
            
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" id="btnSaveNote" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                    Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    function openNoteModal(id, note) {
        document.getElementById('modalOwnerId').value = id;
        document.getElementById('modalNoteText').value = note; 
        document.getElementById('noteModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('noteModal').classList.add('hidden');
    }

    window.onclick = function(event) {
        const modal = document.getElementById('noteModal');
        if (event.target === modal) closeModal();
    }

    document.getElementById('noteForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('modalOwnerId').value;
        const note = document.getElementById('modalNoteText').value;
        const btn = document.getElementById('btnSaveNote');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = 'Menyimpan...';
        btn.disabled = true;

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`/admin/owners/${id}/notes`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: JSON.stringify({ notes: note })
            });
            const data = await response.json();

            if (response.ok) {
                closeModal();
                alert("Status Berhasil Diperbarui: " + data.message); 
                location.reload(); 
            } else {
                throw new Error(data.message || 'Error.');
            }
        } catch (error) {
            alert("Gagal memperbarui: " + error.message);
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });
</script>
@endsection
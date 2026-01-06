@extends('admin.layouts')
@section('title', 'Laporan Aktivitas')

@push('styles')
<style>
    /* CSS KHUSUS PRINT (Agar saat dicetak tetap rapi) */
    @media print {
        @page { size: A4 portrait; margin: 1cm; }
        body { background: white !important; color: black !important; -webkit-print-color-adjust: exact !important; }
        
        /* Sembunyikan elemen web interaktif */
        nav, aside, header, footer, .no-print, .print\:hidden { display: none !important; }
        
        /* Reset container */
        main, .page-content { margin: 0 !important; padding: 0 !important; width: 100% !important; max-width: 100% !important; box-shadow: none !important; }
        
        /* Tabel hitam putih */
        table { border-collapse: collapse !important; width: 100% !important; font-size: 10pt !important; }
        th, td { border: 1px solid #ccc !important; padding: 5px !important; color: black !important; }
        thead th { background-color: #eee !important; font-weight: bold !important; }
        
        /* Hilangkan badge warna saat print */
        .badge { border: none !important; background: none !important; color: black !important; padding: 0 !important; }
        
        /* Sembunyikan bayangan */
        .shadow-sm, .shadow-md, .shadow-lg { box-shadow: none !important; }
    }
</style>
@endpush

@section('content')
<div class="space-y-6 font-sans text-gray-900">

    {{-- 1. HEADER HALAMAN (Judul & Tombol Export) --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 print:hidden">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                {{-- ICON: Clipboard/Report --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-indigo-600">
                    <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 004.25 22.5h15.5a1.875 1.875 0 001.865-2.071l-1.263-12a1.875 1.875 0 00-1.865-1.679H16.5V6a4.5 4.5 0 10-9 0zM12 3a3 3 0 00-3 3v.75h6V6a3 3 0 00-3-3zm-3 8.25a3 3 0 106 0v-.75a.75.75 0 011.5 0v.75a4.5 4.5 0 11-9 0v-.75a.75.75 0 011.5 0v.75z" clip-rule="evenodd" />
                </svg>
                Laporan Aktivitas
            </h1>
            <p class="text-sm text-gray-500 mt-1">Pantau dan audit seluruh aktivitas pengguna sistem.</p>
        </div>
        <div class="flex gap-2">
            {{-- Tombol Refresh --}}
            <a href="{{ route('admin.reports.index') }}" class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-xl text-sm font-bold hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                {{-- ICON: Arrow Path --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z" clip-rule="evenodd" />
                </svg>
                Reset
            </a>
            
            {{-- Tombol Export PDF --}}
            <a href="{{ route('admin.reports.export') }}" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-sm flex items-center gap-2">
                {{-- ICON: Document --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm4.75 6.75a.75.75 0 011.5 0v4.44l2.22-2.22a.75.75 0 111.06 1.06l-3.5 3.5a.75.75 0 01-1.06 0l-3.5-3.5a.75.75 0 111.06-1.06l2.22 2.22V8.75z" clip-rule="evenodd" />
                </svg>
                Export PDF
            </a>
        </div>
    </div>

    {{-- HEADER KHUSUS PRINT (Hanya muncul di kertas) --}}
    <div class="hidden print:block border-b-2 border-gray-800 pb-4 mb-6">
        <h1 class="text-2xl font-bold uppercase">KOSTARAE - Laporan Aktivitas</h1>
        <p class="text-sm">Dicetak pada: {{ now()->format('d F Y H:i') }} oleh {{ Auth::user()->name }}</p>
    </div>

    {{-- 2. STATISTIK RINGKAS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 print:grid-cols-4 print:gap-2">
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm print:shadow-none print:border-black">
            <p class="text-xs font-bold text-gray-400 uppercase print:text-black">Total Aktivitas</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm print:shadow-none print:border-black">
            <p class="text-xs font-bold text-gray-400 uppercase print:text-black">Hari Ini</p>
            <p class="text-2xl font-bold text-indigo-600 print:text-black">{{ number_format($stats['today']) }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm print:shadow-none print:border-black">
            <p class="text-xs font-bold text-gray-400 uppercase print:text-black">Login User</p>
            <p class="text-2xl font-bold text-emerald-600 print:text-black">{{ number_format($stats['login']) }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm print:shadow-none print:border-black">
            <p class="text-xs font-bold text-red-400 uppercase print:text-black">Aktivitas Kritis</p>
            <p class="text-2xl font-bold text-red-600 print:text-black">{{ number_format($stats['critical']) }}</p>
        </div>
    </div>

    {{-- 3. FORM PENCARIAN & FILTER (Hilang saat Print) --}}
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm print:hidden">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            
            {{-- Filter Tanggal Mulai --}}
            <div class="md:col-span-3">
                <label class="block text-xs font-bold text-gray-500 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 cursor-pointer">
            </div>

            {{-- Filter Tanggal Sampai --}}
            <div class="md:col-span-3">
                <label class="block text-xs font-bold text-gray-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 cursor-pointer">
            </div>

            {{-- Search Box --}}
            <div class="md:col-span-4">
                <label class="block text-xs font-bold text-gray-500 mb-1">Cari Deskripsi / User</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        {{-- ICON: Magnifying Glass --}}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: update kost..." class="w-full pl-10 border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            {{-- Tombol Cari --}}
            <div class="md:col-span-2">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition text-sm flex items-center justify-center gap-2">
                    {{-- ICON: Funnel/Filter --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                    </svg>
                    Filter Data
                </button>
            </div>
        </form>
    </div>

    {{-- 4. TABEL DATA --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden print:border-none print:shadow-none">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase border-b border-gray-200 print:bg-gray-100 print:text-black">
                    <tr>
                        <th class="px-6 py-4 print:px-2 print:py-2">Waktu</th>
                        <th class="px-6 py-4 print:px-2 print:py-2">User / Pelaku</th>
                        <th class="px-6 py-4 print:px-2 print:py-2">Role</th>
                        <th class="px-6 py-4 print:px-2 print:py-2">Deskripsi</th>
                        <th class="px-6 py-4 text-center print:hidden">Aksi</th> {{-- Aksi disembunyikan saat print --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 print:divide-gray-300">
                    @forelse($activities as $log)
                    <tr class="hover:bg-gray-50 transition print:hover:bg-transparent">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 print:px-2 print:py-2">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 print:px-2 print:py-2">
                            <span class="font-bold text-gray-900 block">{{ $log->causer->name ?? 'System' }}</span>
                            <span class="text-xs text-gray-400 print:hidden">{{ $log->causer->email ?? '' }}</span>
                        </td>
                        <td class="px-6 py-4 print:px-2 print:py-2">
                            <span class="px-2 py-1 bg-gray-100 rounded text-xs text-gray-600 font-medium badge">
                                {{ ucfirst($log->causer->role ?? '-') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700 print:px-2 print:py-2">
                            {{ $log->description }}
                        </td>
                        <td class="px-6 py-4 text-center print:hidden">
                            <a href="{{ route('admin.reports.show', $log->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition shadow-sm">
                                {{-- ICON: Eye --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                            Tidak ada data aktivitas ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination (Hilang saat print) --}}
        <div class="px-6 py-4 border-t border-gray-100 print:hidden">
            {{ $activities->links() }}
        </div>
    </div>

</div>
@endsection
@extends('admin.layouts')
@section('title', 'Laporan & Analitik')

@section('content')
<div class="space-y-8 pb-20">

    {{-- HEADER & TOOLS --}}
    <div class="flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                {{-- ICON: Chart Bar --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-indigo-600">
                    <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0zm1.5 0v.002c0 .019 0 .037.001.056l.002.068v.048a6.75 6.75 0 006.75 6.75h6.75a6.75 6.75 0 006.75-6.75v-.05l.001-.064c.001-.02.001-.039.001-.059v-.002A6.75 6.75 0 0012.75 6.75h-6.75a6.75 6.75 0 00-6.75 6.75zM12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z" clip-rule="evenodd" />
                </svg>
                Laporan Ekosistem
            </h1>
            <p class="text-sm text-gray-500 mt-1">Pantau pertumbuhan pengguna dan kualitas kost secara real-time.</p>
        </div>
        
        <div class="flex gap-2 relative z-50">
            <div class="bg-white border border-gray-100 rounded-xl px-4 py-2.5 flex items-center gap-2 shadow-sm">
                {{-- ICON: Calendar --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-500">
                    <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm text-gray-600 font-bold">{{ date('F Y') }}</span>
            </div>

            {{-- TOMBOL EXPORT PDF --}}
            <a href="{{ route('admin.reviews.export') }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5 cursor-pointer relative z-50">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm4.75 6.75a.75.75 0 011.5 0v4.44l2.22-2.22a.75.75 0 111.06 1.06l-3.5 3.5a.75.75 0 01-1.06 0l-3.5-3.5a.75.75 0 111.06-1.06l2.22 2.22V8.75z" clip-rule="evenodd" />
                </svg>
                Export PDF
            </a>
        </div>
    </div>

    {{-- 1. SUMMARY CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total User --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total User</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_user'] }}</h3>
                    <div class="mt-2 inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">
                        <span>+ Pengguna Baru</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd" /><path d="M5.082 14.254a6.741 6.741 0 00-4.562 3.243.75.75 0 00.372.568A12.696 12.696 0 006 19.5c.34 0 .675-.013 1.007-.037a8.256 8.256 0 01-.925-5.21zM18.918 14.254a6.741 6.741 0 014.562 3.243.75.75 0 01-.372.568A12.696 12.696 0 0118 19.5c-.34 0-.675-.013-1.007-.037a8.256 8.256 0 00.925-5.21z" /></svg>
                </div>
            </div>
        </div>

        {{-- Total Kost --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Unit Kost Aktif</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_kost'] }}</h3>
                    <p class="text-[10px] text-gray-400 mt-2 font-medium">Dari {{ $stats['total_owner'] }} Mitra</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg>
                </div>
            </div>
        </div>

        {{-- Pending Kost --}}
        <a href="{{ route('admin.kost.index', ['status' => 'pending']) }}" class="bg-white p-6 rounded-3xl border border-amber-100 shadow-sm relative overflow-hidden group hover:shadow-md transition cursor-pointer">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Perlu Review</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_kost'] }}</h3>
                    <p class="text-[10px] text-gray-400 mt-2 font-medium">Klik untuk verifikasi</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl animate-pulse group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" /></svg>
                </div>
            </div>
        </a>

        {{-- Rating Avg --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kualitas Ekosistem</p>
                    <div class="flex items-center gap-2 mt-2">
                        <h3 class="text-3xl font-bold text-gray-900">{{ number_format($stats['avg_rating'], 1) }}</h3>
                        <span class="text-sm text-gray-400 font-medium">/ 5.0</span>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-2 font-medium">Dari {{ $stats['total_review'] }} Ulasan</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" /></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. CHARTS SECTION --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Chart Growth --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-indigo-600"><path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0zm1.5 0v.002c0 .019 0 .037.001.056l.002.068v.048a6.75 6.75 0 006.75 6.75h6.75a6.75 6.75 0 006.75-6.75v-.05l.001-.064c.001-.02.001-.039.001-.059v-.002A6.75 6.75 0 0012.75 6.75h-6.75a6.75 6.75 0 00-6.75 6.75zM12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z" clip-rule="evenodd" /></svg>
                    Tren Pertumbuhan
                </h3>
                <span class="text-xs font-medium text-gray-400 bg-gray-50 px-3 py-1 rounded-full border border-gray-100">7 Hari Terakhir</span>
            </div>
            <div class="flex-1 min-h-[300px] relative">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        {{-- Chart Status --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col">
            <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-emerald-600"><path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0zm1.5 0v.002c0 .019 0 .037.001.056l.002.068v.048a6.75 6.75 0 006.75 6.75h6.75a6.75 6.75 0 006.75-6.75v-.05l.001-.064c.001-.02.001-.039.001-.059v-.002A6.75 6.75 0 0012.75 6.75h-6.75a6.75 6.75 0 00-6.75 6.75zM12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z" clip-rule="evenodd" /></svg>
                Status Kost
            </h3>
            <div class="flex-1 flex flex-col items-center justify-center relative min-h-[250px]">
                <div class="w-56 h-56 relative">
                    <canvas id="statusChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-4xl font-extrabold text-gray-800 tracking-tight">{{ $stats['total_kost'] + $stats['pending_kost'] }}</span>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Total Unit</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-3">
                <a href="{{ route('admin.kost.index', ['status' => 'aktif']) }}" class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50 hover:bg-emerald-50 border border-transparent hover:border-emerald-100 transition group cursor-pointer">
                    <span class="flex items-center gap-2 text-xs font-bold text-gray-600 group-hover:text-emerald-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Aktif
                    </span>
                    <span class="text-xs font-extrabold text-gray-800">{{ $stats['total_kost'] }}</span>
                </a>
                <a href="{{ route('admin.kost.index', ['status' => 'pending']) }}" class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50 hover:bg-amber-50 border border-transparent hover:border-amber-100 transition group cursor-pointer">
                    <span class="flex items-center gap-2 text-xs font-bold text-gray-600 group-hover:text-amber-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                    </span>
                    <span class="text-xs font-extrabold text-gray-800">{{ $stats['pending_kost'] }}</span>
                </a>
            </div>
        </div>
    </div>

    {{-- 3. TABEL TOP PERFORMING --}}
    <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-amber-500"><path fill-rule="evenodd" d="M5.166 2.621v.858c-1.035.148-2.059.33-3.071.543a.75.75 0 00-.584.859 6.753 6.753 0 006.138 5.6 6.73 6.73 0 002.77.549 6.75 6.75 0 002.555-.492 6.75 6.75 0 006.75 0 6.75 6.75 0 002.554.492 6.75 6.75 0 002.769-.549 6.753 6.753 0 006.139-5.6.75.75 0 00-.585-.858 47.767 47.767 0 00-3.07-.543V2.62a.75.75 0 00-.658-.744 49.22 49.22 0 00-6.093-.377c-2.063 0-4.096.128-6.093.377a.75.75 0 00-.657.744zm0 2.629c0 1.196.312 2.32.857 3.294A5.266 5.266 0 013.16 5.337a45.6 45.6 0 012.006-.348zm13.668 8.04l-1.313-1.313 2.953-2.953a.75.75 0 00-1.06-1.06l-2.953 2.953-1.313-1.313a.75.75 0 10-1.06 1.06l1.844 1.843a.75.75 0 001.06 0l1.844-1.843a.75.75 0 00-1.061-1.06l-1.844 1.843-1.313-1.313z" clip-rule="evenodd" /><path d="M10.5 19.5a1.5 1.5 0 003 0v-1.5a1.5 1.5 0 00-3 0v1.5z" /><path fill-rule="evenodd" d="M7.125 6.75a.75.75 0 00-1.5 0v10.5c0 1.657 1.343 3 3 3h6.75c1.657 0 3-1.343 3-3V6.75a.75.75 0 00-1.5 0v10.5a1.5 1.5 0 01-1.5 1.5h-6.75a1.5 1.5 0 01-1.5-1.5V6.75z" clip-rule="evenodd" /></svg>
                Top 5 Kost Paling Diminati
            </h3>
            <a href="{{ route('admin.kost.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-3 py-1.5 rounded-lg transition">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nama Kost</th>
                        <th class="px-6 py-4">Pemilik</th>
                        <th class="px-6 py-4 text-center">Rating</th>
                        <th class="px-6 py-4 text-center">Total Ulasan</th>
                        <th class="px-6 py-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($topKosts as $item)
                    <tr class="hover:bg-indigo-50/30 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-xl overflow-hidden border border-gray-200">
                                    @php $foto = is_array($item->foto) ? ($item->foto[0]['path'] ?? $item->foto[0]) : $item->foto; @endphp
                                    @if($foto) <img src="{{ asset('storage/'.$foto) }}" class="w-full h-full object-cover">
                                    @else 
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="font-bold text-gray-900 text-sm">{{ $item->nama }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->pemilik->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-yellow-50 text-yellow-700 text-xs font-bold border border-yellow-100">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3"><path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" /></svg>
                                {{ number_format($item->reviews_avg_rating, 1) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm font-bold text-gray-800">{{ $item->reviews_count }}</td>
                        <td class="px-6 py-4 text-right">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">Aktif</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Belum ada data review.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- BAGIAN BARU: TABEL MANAJEMEN SEMUA ULASAN --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm mt-8">
        
        {{-- Header Tabel & Filter Pencarian --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-indigo-600"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" /></svg>
                    Daftar Semua Ulasan
                </h3>
                <p class="text-xs text-gray-500 mt-1">Kelola dan moderasi ulasan masuk.</p>
            </div>

            <form action="{{ route('admin.reviews.index') }}" method="GET" class="flex gap-2 w-full md:w-auto">
                <select name="status" class="bg-gray-50 border border-gray-200 text-gray-700 text-xs rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                    <option value="">Semua Status</option>
                    <option value="visible" {{ request('status') == 'visible' ? 'selected' : '' }}>Tampil</option>
                    <option value="hidden" {{ request('status') == 'hidden' ? 'selected' : '' }}>Disembunyikan</option>
                </select>
                
                <div class="relative w-full md:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="block w-full p-2.5 pl-3 text-xs text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500" 
                           placeholder="Cari user, kost, atau review...">
                    <button type="submit" class="absolute right-0 top-0 h-full px-3 text-white bg-indigo-600 rounded-r-lg hover:bg-indigo-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Pengguna</th>
                        <th class="px-6 py-3">Kost Dinilai</th>
                        <th class="px-6 py-3 text-center">Rating</th>
                        <th class="px-6 py-3">Komentar</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reviews as $review)
                    <tr class="bg-white hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($review->created_at)
                                <span class="font-bold text-gray-900">{{ $review->created_at->format('d M Y') }}</span><br>
                                <span class="text-xs text-gray-400">{{ $review->created_at->format('H:i') }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">
                                    {{ substr($review->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 text-xs">{{ $review->user->name ?? 'User Terhapus' }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $review->user->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.kost.show', $review->kost_id) }}" class="text-indigo-600 hover:text-indigo-800 font-bold text-xs hover:underline">
                                {{ $review->kost->nama_kost ?? $review->kost->nama ?? 'Kost Terhapus' }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded border border-amber-200">
                                ★ {{ $review->rating }}
                            </span>
                        </td>

                        {{-- Kolom Isi Komentar --}}
                        <td class="px-6 py-4">
                            <div class="relative group cursor-help">
                                @php
                                    // LOGIKA PENDETEKSI KOLOM OTOMATIS
                                    // Mencari kolom mana yang berisi data
                                    $isiKomentar = $review->comment 
                                                ?? $review->komentar 
                                                ?? $review->isi 
                                                ?? $review->review 
                                                ?? $review->body 
                                                ?? null;
                                @endphp

                                <p class="italic text-gray-600 truncate max-w-[200px]">
                                    @if(empty($isiKomentar))
                                        {{-- Fallback jika kosong --}}
                                        <span class="text-gray-400 not-italic">- Tidak ada komentar -</span>
                                    @else
                                        {{-- Jika ada isinya --}}
                                        "{{ Str::limit($isiKomentar, 40) }}"
                                    @endif
                                </p>
                                
                                {{-- Tooltip Hover (Hanya muncul jika ada isi) --}}
                                @if(!empty($isiKomentar))
                                    <div class="absolute bottom-full left-0 mb-2 w-64 p-3 bg-gray-800 text-white text-xs rounded shadow-lg hidden group-hover:block z-50 leading-relaxed border border-gray-700">
                                        <strong class="block border-b border-gray-600 pb-1 mb-1 text-gray-300">Isi Lengkap:</strong>
                                        {{ $isiKomentar }}
                                    </div>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($review->is_hidden)
                                <span class="bg-red-50 text-red-600 text-[10px] font-bold px-2 py-1 rounded-full border border-red-100">Disembunyikan</span>
                            @else
                                <span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2 py-1 rounded-full border border-emerald-100">Tampil</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('admin.reviews.toggle', $review->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="p-1.5 rounded-lg border border-gray-200 hover:bg-gray-50 transition {{ $review->is_hidden ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-600' }}" title="{{ $review->is_hidden ? 'Tampilkan' : 'Sembunyikan' }}">
                                        @if($review->is_hidden)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                        @endif
                                    </button>
                                </form>

                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg border border-red-100 text-red-500 hover:bg-red-50 transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-400">
                            <p class="text-sm">Tidak ada ulasan ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    </div>

</div>

{{-- SCRIPT CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.borderColor = 'rgba(0,0,0,0.03)';

    const usersData = @json($chartData['users']);
    const kostsData = @json($chartData['kosts']);
    const labels = @json($chartData['labels']);

    const ctxGrowth = document.getElementById('growthChart').getContext('2d');
    const gradientUser = ctxGrowth.createLinearGradient(0, 0, 0, 300);
    gradientUser.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
    gradientUser.addColorStop(1, 'rgba(99, 102, 241, 0)');

    const gradientKost = ctxGrowth.createLinearGradient(0, 0, 0, 300);
    gradientKost.addColorStop(0, 'rgba(34, 197, 94, 0.2)');
    gradientKost.addColorStop(1, 'rgba(34, 197, 94, 0)');

    new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'User Baru',
                data: usersData,
                borderColor: '#6366F1',
                backgroundColor: gradientUser,
                borderWidth: 2,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointBackgroundColor: '#6366F1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                fill: true,
                tension: 0.3
            }, {
                label: 'Kost Baru',
                data: kostsData,
                borderColor: '#22C55E',
                backgroundColor: gradientKost,
                borderWidth: 2,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointBackgroundColor: '#22C55E',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8, padding: 20, font: { size: 11, weight: 'bold' } } },
                tooltip: { backgroundColor: '#1e293b', padding: 12, titleFont: { size: 13 }, bodyFont: { size: 12 }, displayColors: true, cornerRadius: 8 }
            },
            scales: { y: { beginAtZero: true, grid: { borderDash: [4, 4], drawBorder: false }, ticks: { padding: 10, font: { size: 11 } } }, x: { grid: { display: false }, ticks: { padding: 10, font: { size: 11 } } } }
        }
    });

    const ctxStatus = document.getElementById('statusChart');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Pending', 'Ditolak'],
            datasets: [{
                data: [{{ $stats['total_kost'] }}, {{ $stats['pending_kost'] }}, 0],
                backgroundColor: ['#22C55E', '#F59E0B', '#EF4444'],
                borderWidth: 0, hoverOffset: 10
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '80%',
            plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', bodyFont: { size: 12 }, callbacks: { label: function(context) { return ' ' + context.label + ': ' + context.raw + ' Unit'; } } } },
            onClick: (evt, elements) => {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    const statusMap = ['aktif', 'pending', 'ditolak'];
                    window.location.href = `{{ route('admin.kost.index') }}?status=${statusMap[index]}`;
                }
            },
            onHover: (event, chartElement) => { event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default'; }
        }
    });
</script>
@endsection
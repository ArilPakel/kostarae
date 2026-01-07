@extends('layouts.main')

@section('content')
    <div class="min-h-screen bg-gray-50/50 py-10 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">

            {{-- =========================================================
               1. HEADER DASHBOARD PEMILIK
            ========================================================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                {{-- Banner Background --}}
                <div class="h-32 bg-[#2D4A53] relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
                    <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-white/10 to-transparent"></div>
                </div>

                <div class="px-6 md:px-8 pb-6 flex flex-col md:flex-row items-start md:items-end -mt-12 gap-6">

                    {{-- Avatar --}}
                    <div class="relative flex-shrink-0">
                        <img src="{{ Auth::user()->avatar
                            ? asset('storage/' . Auth::user()->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=2D4A53&color=fff&bold=true' }}"
                            class="w-24 h-24 rounded-full border-[4px] border-white shadow-md object-cover bg-white">
                    </div>

                    {{-- Info & Action --}}
                    <div class="flex-1 w-full flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-extrabold text-gray-900 leading-tight">
                                Halo, {{ explode(' ', Auth::user()->name)[0] }} 👋
                            </h1>
                            <p class="text-sm text-gray-500 mt-1">
                                Kelola properti kost Anda dengan mudah dan pantau performanya.
                            </p>
                        </div>

                        {{-- Tombol Tambah Kost --}}
                        <div class="mb-1 md:mb-0">
                            <a href="{{ route('pemilik.kost.create') }}" 
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#ff7a00] hover:bg-orange-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/20 transition transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Kost Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- =========================================================
               2. STATISTIK RINGKAS
            ========================================================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                {{-- Total --}}
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Kost</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $kosts->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>

                {{-- Aktif --}}
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kost Aktif</p>
                        <p class="text-3xl font-extrabold text-emerald-600">{{ $kosts->where('status', 'aktif')->count() }}</p>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-full text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                {{-- Pending --}}
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Menunggu Verifikasi</p>
                        <p class="text-3xl font-extrabold text-orange-500">{{ $kosts->where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-full text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            {{-- =========================================================
               3. GRID LIST KOST
            ========================================================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($kosts as $kost)
                    @php
                        // Logic Gambar Aman (Priority: Relation -> JSON -> Default)
                        $image = asset('images/default-kost.jpg');
                        
                        if ($kost->relationLoaded('kostImages') && $kost->kostImages->count() > 0) {
                            $image = asset('storage/' . $kost->kostImages->first()->path);
                        } elseif (!empty($kost->foto)) {
                            $decoded = is_string($kost->foto) ? json_decode($kost->foto, true) : $kost->foto;
                            if (is_array($decoded) && count($decoded) > 0) {
                                $path = is_array($decoded[0]) ? ($decoded[0]['path'] ?? '') : $decoded[0];
                                if($path) $image = asset($path);
                            }
                        }
                    @endphp

                    <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden">

                        {{-- Image Area --}}
                        <div class="relative h-44 bg-gray-100 overflow-hidden">
                            <img src="{{ $image }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            
                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>

                            {{-- Badge Status --}}
                            <span class="absolute top-3 left-3 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide rounded-md text-white shadow-sm backdrop-blur-md
                                @if ($kost->status === 'aktif') bg-emerald-500/90
                                @elseif($kost->status === 'pending') bg-orange-500/90
                                @else bg-red-500/90 @endif">
                                {{ $kost->status }}
                            </span>
                        </div>

                        {{-- Body --}}
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex-1">
                                <h3 class="text-base font-bold text-gray-900 truncate mb-1" title="{{ $kost->nama }}">{{ $kost->nama }}</h3>
                                <p class="text-xs text-gray-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="truncate">{{ $kost->alamat }}</span>
                                </p>
                            </div>

                            <div class="mt-5 pt-4 border-t border-dashed border-gray-100 flex items-center justify-between">
                                <span class="text-sm font-extrabold text-[#ff7a00]">
                                    Rp {{ number_format($kost->harga, 0, ',', '.') }}
                                </span>

                                <div class="flex gap-2">
                                    <a href="{{ route('pemilik.kost.edit', $kost->id) }}"
                                        class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form action="{{ route('pemilik.kost.destroy', $kost->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kost ini? Data tidak bisa dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- EMPTY STATE --}}
                    <div class="col-span-full flex flex-col items-center justify-center py-16 px-4 text-center bg-white rounded-2xl border border-dashed border-gray-300">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada kost yang terdaftar</h3>
                        <p class="text-sm text-gray-500 mb-6">Mulai kelola bisnis kost Anda dengan menambahkan properti pertama Anda.</p>
                        <a href="{{ route('pemilik.kost.create') }}" class="px-6 py-2.5 bg-[#2D4A53] hover:bg-[#1f3f46] text-white text-sm font-bold rounded-xl shadow-md transition">
                            Tambah Kost Sekarang
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection
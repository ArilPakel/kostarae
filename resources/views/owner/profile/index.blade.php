@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 py-8" x-data="{ activeTab: 'kost' }"> {{-- Default tab: Kost Saya --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- ================= 1. HEADER PROFIL PEMILIK ================= --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8 relative">
            <div class="h-32 bg-gradient-to-r from-orange-100 to-amber-50"></div> {{-- Cover Art --}}
            <div class="px-8 pb-8 flex flex-col md:flex-row items-center md:items-end -mt-12 gap-6">
                
                {{-- Foto Profil --}}
                <div class="relative group">
                    <img src="{{ Auth::user()->avatar ?? asset('images/default-avatar.png') }}" 
                         alt="Profile" 
                         class="w-32 h-32 rounded-full border-4 border-white shadow-md object-cover">
                    {{-- Badge Upload (Visual Only - Logic di Halaman Edit) --}}
                    <div class="absolute bottom-2 right-2 bg-orange-500 text-white p-1.5 rounded-full border-2 border-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                    </div>
                </div>

                {{-- Info Utama --}}
                <div class="flex-1 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-1">
                        <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                        {{-- Badge Pemilik --}}
                        <span class="px-3 py-1 bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-bold rounded-full shadow-sm flex items-center gap-1">
                            👑 Pemilik Kost
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-center md:justify-start gap-4 text-sm text-gray-500 mb-2">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ Auth::user()->email }}
                            @if(Auth::user()->hasVerifiedEmail())
                                <svg class="w-4 h-4 text-emerald-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            @else
                                <svg class="w-4 h-4 text-amber-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            @endif
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Bergabung {{ Auth::user()->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>

                {{-- Tombol Edit Profil (Link Terpisah) --}}
                <div class="mb-2">
                    <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:text-orange-600 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Profil
                    </a>
                </div>
            </div>

            {{-- ================= 2. TAB NAVIGASI ================= --}}
            <div class="border-t border-gray-100 px-8">
                <nav class="flex gap-8 overflow-x-auto whitespace-nowrap scrollbar-hide">
                    
                    {{-- Helper Button Class --}}
                    @php 
                        $btnBase = "py-4 text-sm font-medium border-b-2 transition-colors duration-200 flex items-center gap-2";
                        $btnActive = "border-orange-500 text-orange-600";
                        $btnInactive = "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300";
                    @endphp

                    <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? '{{$btnActive}}' : '{{$btnInactive}}'">
                        👤 Data Profil
                    </button>
                    <button @click="activeTab = 'kost'" :class="activeTab === 'kost' ? '{{$btnActive}}' : '{{$btnInactive}}'">
                        🏠 Kost Saya
                    </button>
                    <button @click="activeTab = 'stats'" :class="activeTab === 'stats' ? '{{$btnActive}}' : '{{$btnInactive}}'">
                        📊 Statistik
                    </button>
                    <button @click="activeTab = 'activity'" :class="activeTab === 'activity' ? '{{$btnActive}}' : '{{$btnInactive}}'">
                        🔔 Aktivitas
                    </button>
                    <button @click="activeTab = 'security'" :class="activeTab === 'security' ? '{{$btnActive}}' : '{{$btnInactive}}'">
                        🔐 Keamanan
                    </button>
                </nav>
            </div>
        </div>

        {{-- AREA KONTEN (ISI TAB) ADA DI BAWAH --}}

        {{-- TAB: KOST SAYA --}}
        <div x-show="activeTab === 'kost'" style="display: none;" class="space-y-6">
            
            {{-- Header Tab --}}
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Properti Kost Anda</h2>
                <a href="{{-- route('kost.create') --}}" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-200 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Kost Baru
                </a>
            </div>

            {{-- Grid Daftar Kost --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($kosts as $kost)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
                        {{-- Gambar --}}
                        <div class="h-48 bg-gray-200 relative">
                            <img src="{{-- $kost->image_url --}}" alt="{{ $kost->name }}" class="w-full h-full object-cover">
                            {{-- Badge Status --}}
                            <div class="absolute top-3 right-3">
                                @if($kost->status == 'active')
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full border border-emerald-200 shadow-sm">🟢 Aktif</span>
                                @elseif($kost->status == 'pending')
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full border border-amber-200 shadow-sm">🟡 Menunggu Review</span>
                                @else
                                    <span class="px-3 py-1 bg-rose-100 text-rose-700 text-xs font-bold rounded-full border border-rose-200 shadow-sm">🔴 Ditolak</span>
                                @endif
                            </div>
                        </div>

                        {{-- Konten --}}
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-1">{{ $kost->name }}</h3>
                            <p class="text-sm text-gray-500 mb-3 flex items-center gap-1">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $kost->city ?? 'Lokasi Kost' }}
                            </p>
                            <p class="text-orange-600 font-bold text-lg mb-4">Rp {{ number_format($kost->price, 0, ',', '.') }} <span class="text-xs text-gray-400 font-normal">/ bulan</span></p>
                            
                            {{-- Tombol Aksi --}}
                            <div class="mt-auto grid grid-cols-3 gap-2 border-t border-gray-100 pt-4">
                                <button class="flex flex-col items-center justify-center gap-1 text-xs font-medium text-gray-500 hover:text-orange-500 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                    Promosi
                                </button>
                                <a href="#" class="flex flex-col items-center justify-center gap-1 text-xs font-medium text-gray-500 hover:text-blue-600 transition border-x border-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Detail
                                </a>
                                <button class="flex flex-col items-center justify-center gap-1 text-xs font-medium text-gray-500 hover:text-red-500 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                        <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-4 text-orange-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Belum ada kost terdaftar</h3>
                        <p class="text-gray-500 mb-6">Mulai bisnis Anda dengan menambahkan properti pertama.</p>
                        <a href="#" class="px-6 py-2 bg-orange-500 text-white rounded-xl font-bold text-sm shadow hover:bg-orange-600">Tambah Kost Sekarang</a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- TAB: DATA PROFIL --}}
        <div x-show="activeTab === 'profile'" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Kolom Kiri: Data Diri --}}
                <div class="md:col-span-2 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1 h-6 bg-orange-500 rounded-full"></span> Informasi Pribadi
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" value="{{ Auth::user()->name }}" disabled class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded-xl px-4 py-2.5 cursor-not-allowed">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Email</label>
                                <div class="relative">
                                    <input type="text" value="{{ Auth::user()->email }}" disabled class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded-xl px-4 py-2.5 cursor-not-allowed pl-10">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">WhatsApp</label>
                                <div class="relative">
                                    {{-- Logika Format WA sederhana (Sebaiknya di Model) --}}
                                    @php $wa = preg_replace('/^0/', '+62', Auth::user()->phone ?? '-'); @endphp
                                    <input type="text" value="{{ $wa }}" disabled class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded-xl px-4 py-2.5 cursor-not-allowed pl-10">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Ringkasan --}}
                <div class="bg-gradient-to-br from-gray-900 to-gray-800 p-6 rounded-3xl shadow-lg text-white">
                    <h3 class="text-lg font-bold mb-4 text-orange-400">Status Mitra</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-gray-700 pb-3">
                            <span class="text-sm text-gray-300">Level Akun</span>
                            <span class="font-bold">Starter</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-700 pb-3">
                            <span class="text-sm text-gray-300">Total Kost</span>
                            <span class="font-bold">{{ $stats['total_kost'] }} Unit</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-300">Bergabung</span>
                            <span class="font-bold">{{ Auth::user()->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB: STATISTIK --}}
        <div x-show="activeTab === 'stats'" style="display: none;">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                {{-- Card 1 --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $stats['total_kost'] }}</span>
                    <span class="text-sm text-gray-500">Total Kost</span>
                </div>
                {{-- Tambahkan Card Lainnya (Kamar, Views, Favorit) dengan pola yang sama --}}
            </div>
        </div>

        {{-- TAB: AKTIVITAS (Contoh UI Timeline) --}}
        <div x-show="activeTab === 'activity'" style="display: none;" class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Riwayat Aktivitas</h3>
            <div class="border-l-2 border-gray-100 ml-3 space-y-8">
                {{-- Item 1 --}}
                <div class="relative pl-8">
                    <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-orange-500 border-2 border-white shadow"></span>
                    <p class="text-sm font-bold text-gray-900">Login Berhasil</p>
                    <p class="text-xs text-gray-500">2 menit yang lalu melalui Chrome Desktop</p>
                </div>
                {{-- Item 2 --}}
                <div class="relative pl-8">
                    <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white shadow"></span>
                    <p class="text-sm font-bold text-gray-900">Menambahkan Kost Baru</p>
                    <p class="text-xs text-gray-500">Kemarin, 14:30 WITA</p>
                </div>
            </div>
        </div>

        {{-- TAB: KEAMANAN --}}
        <div x-show="activeTab === 'security'" style="display: none;">
            {{-- Masukkan kode Verifikasi Email & Ganti Password yang sudah Anda punya di sini --}}
            @include('profile.partials.update-password-form') {{-- Contoh include --}}
        </div>
        {{-- ... Kode Langkah 3, 4, dst ditaruh di sini ... --}}

    </div>
</div>
@endsection
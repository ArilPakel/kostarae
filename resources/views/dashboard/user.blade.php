@extends('layouts.main')

@section('content')
    <div class="min-h-screen bg-gray-50/50 py-10 font-sans">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">

            {{-- ========================================================================
           1. HEADER DASHBOARD (Identitas Pengguna)
           ======================================================================== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                {{-- Banner Accent --}}
                <div class="h-28 bg-[#2D4A53] relative overflow-hidden">
                    <div
                        class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]">
                    </div>
                </div>

                <div class="px-8 pb-6 flex flex-col md:flex-row items-start md:items-end -mt-10 gap-6">

                    {{-- Avatar Wrapper --}}
                    <div class="relative flex-shrink-0">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3b82f6&color=fff&bold=true' }}"
                            alt="Foto Profil"
                            class="w-24 h-24 rounded-full border-[5px] border-white shadow-md object-cover bg-white">

                        {{-- Status Indikator (Hijau = Online) --}}
                        <div class="absolute bottom-1 right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center"
                            title="Status Aktif">
                            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                    {{-- Info User --}}
                    <div class="flex-1 w-full pt-2 md:pt-0">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h1 class="text-2xl font-bold text-gray-900 leading-tight">Halo,
                                        {{ explode(' ', Auth::user()->name)[0] }}!</h1>
                                    <span
                                        class="px-2.5 py-0.5 bg-blue-50 text-blue-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-blue-100">
                                        Pencari Kost
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500">Selamat datang di dashboard pencarian kost Anda.</p>
                            </div>

                            {{-- Tombol Aksi Utama --}}
                            <div class="flex items-center gap-3">
                                <a href="{{ route('user.profile') }}"
                                    class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-50 hover:text-orange-600 hover:border-orange-200 transition shadow-sm">
                                    ⚙️ Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================================================
           2. STATUS AKUN & KELENGKAPAN (Pengganti Statistik Kosong)
           ======================================================================== --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                {{-- Card 1: Status Email --}}
                <div
                    class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between group hover:border-orange-200 transition">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Status Verifikasi</p>
                        @if (Auth::user()->hasVerifiedEmail())
                            <p class="text-lg font-bold text-emerald-600 flex items-center gap-1">
                                ✅ Terverifikasi
                            </p>
                        @else
                            <p class="text-lg font-bold text-amber-500 flex items-center gap-1">
                                ⚠️ Belum Verifikasi
                            </p>
                        @endif
                    </div>
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center {{ Auth::user()->hasVerifiedEmail() ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Card 2: Kelengkapan Profil (Logic Sederhana) --}}
                @php
                    $isProfileComplete = Auth::user()->phone && Auth::user()->address;
                @endphp
                <div
                    class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between group hover:border-orange-200 transition">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Data Diri</p>
                        <p class="text-lg font-bold {{ $isProfileComplete ? 'text-blue-600' : 'text-gray-900' }}">
                            {{ $isProfileComplete ? 'Lengkap' : 'Perlu Dilengkapi' }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>

                {{-- Card 3: Bergabung Sejak --}}
                <div
                    class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between group hover:border-orange-200 transition">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Bergabung Sejak</p>
                        <p class="text-lg font-bold text-gray-900">{{ Auth::user()->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="w-10 h-10 bg-gray-50 text-gray-600 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- ========================================================================
           3. KONTEN UTAMA (Pencarian & Rekomendasi Cepat)
           ======================================================================== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: Panel Pencarian (Area Utama) --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Panel Pencarian Cepat --}}
                    <div class="bg-[#2D4A53] rounded-2xl p-8 text-white shadow-md relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold mb-2">Mau cari kost di mana?</h3>
                            <p class="text-gray-300 mb-6 text-sm">Temukan hunian nyaman sesuai budget dan lokasimu.</p>

                            <form action="{{ route('kost.public') }}" method="GET">
                                <div class="flex gap-2 bg-white p-1.5 rounded-xl shadow-lg">
                                    <input type="text" name="search" placeholder="Ketik lokasi atau nama kost..."
                                        class="w-full px-4 py-2.5 rounded-lg text-gray-900 outline-none text-sm placeholder-gray-400">
                                    <button type="submit"
                                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-bold text-sm transition">
                                        Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                        {{-- Decor --}}
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                    </div>

                    {{-- Empty State Riwayat (Lebih Ramah) --}}
                    <div class="bg-white rounded-2xl border border-gray-100 p-6">
                        <h3 class="text-sm font-bold text-gray-900 mb-4">
                            Riwayat Kost yang Pernah Dilihat
                        </h3>

                        @if ($riwayatKost->count())
                            <div class="space-y-4">
                                @foreach ($riwayatKost as $item)
                                    @if ($item->kost)
                                        <a href="{{ route('kost.detail', $item->kost->id) }}"
                                            class="flex gap-4 items-center p-3 rounded-xl border border-gray-100
                           hover:border-orange-200 hover:bg-gray-50 transition">

                                            {{-- FOTO --}}
                                            @php
                                                $foto = $item->kost->foto;

                                                if (is_array($foto) && count($foto) > 0) {
                                                    // Jika foto[0] masih array, ambil string pertamanya
                                                    $firstFoto = is_array($foto[0]) ? $foto[0][0] ?? null : $foto[0];
                                                } else {
                                                    $firstFoto = null;
                                                }

                                                $thumbnail = is_string($firstFoto)
                                                    ? asset($firstFoto)
                                                    : 'https://via.placeholder.com/160x120?text=No+Image';
                                            @endphp

                                            <img src="{{ $thumbnail }}"
                                                class="w-20 h-16 rounded-lg object-cover flex-shrink-0">



                                            {{-- INFO --}}
                                            <div class="flex-1">
                                                <p class="font-bold text-gray-900 text-sm">
                                                    {{ $item->kost->nama }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $item->kost->alamat }}
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    Dilihat {{ $item->updated_at->diffForHumans() }}
                                                </p>
                                            </div>

                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 text-sm font-semibold">
                                    Riwayat pencarian masih kosong
                                </p>
                                <p class="text-gray-400 text-xs mt-1">
                                    Kost yang Anda lihat akan muncul di sini
                                </p>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- KOLOM KANAN: Aktivitas & Bantuan --}}
                <div class="space-y-6">

                    {{-- Aktivitas Terbaru --}}
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="text-sm font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span> Aktivitas Terbaru
                        </h3>

                        <div class="relative border-l-2 border-gray-50 ml-2 space-y-6 pl-6">
                            {{-- Log Item --}}
                            <div class="relative group">
                                <span
                                    class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-white"></span>
                                <p class="text-sm font-bold text-gray-800">Login Berhasil</p>
                                <p class="text-xs text-gray-400 mt-0.5">Baru saja</p>
                            </div>

                            @if (!$isProfileComplete)
                                {{-- Log Item Suggestion --}}
                                <div class="relative group">
                                    <span
                                        class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-blue-200 ring-4 ring-white animate-pulse"></span>
                                    <p class="text-sm font-bold text-gray-800">Lengkapi Profil Anda</p>
                                    <a href="{{ route('user.profile') }}"
                                        class="text-xs text-blue-600 hover:underline mt-0.5 block">Tambahkan no HP & alamat
                                        &rarr;</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Banner Bantuan --}}
                    <div
                        class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                        <div
                            class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-gray-900 font-bold text-sm mb-1">Butuh Bantuan?</h3>
                        <p class="text-gray-500 text-xs mb-4">Baca panduan lengkap cara menyewa kost.</p>
                        <a href="{{ route('panduan') }}"
                            class="px-4 py-2 bg-gray-50 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-100 transition border border-gray-200 w-full">
                            Baca Panduan
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

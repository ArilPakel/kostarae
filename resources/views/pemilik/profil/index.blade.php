@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans">

    {{-- ========================================================================
       1. BACKGROUND HEADER (Gradient + Pattern) - DESAIN BARU
       ======================================================================== --}}
    <div class="relative bg-gradient-to-r from-[#2D4A53] to-[#263e46] h-48 md:h-64 overflow-hidden">
        {{-- Pattern Dot Halus --}}
        <div class="absolute inset-0 opacity-10" 
             style="background-image: radial-gradient(#ffffff 1.5px, transparent 1.5px); background-size: 24px 24px;">
        </div>
        
        {{-- Dekorasi Circle Blur --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-orange-500/10 rounded-full blur-2xl"></div>
    </div>

    {{-- ========================================================================
       WRAPPER KONTEN (Agar Floating Card & Data Diri Rata Tengah)
       ======================================================================== --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 relative -mt-24 pb-12">
        
        {{-- ========================================================================
           2. FLOATING CARD PROFIL - DESAIN BARU
           ======================================================================== --}}
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 md:p-8 flex flex-col md:flex-row items-center md:items-start gap-6 md:gap-10 mb-8">
            
            {{-- A. FOTO PROFIL --}}
            <div class="relative flex-shrink-0 group">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border-[6px] border-white shadow-md overflow-hidden bg-gray-100 relative">
                    <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=2D4A53&color=fff&size=256' }}" 
                         alt="Foto Profil {{ Auth::user()->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>

                {{-- Indikator Status Verifikasi --}}
                @if(Auth::user()->hasVerifiedEmail())
                    <div class="absolute bottom-2 right-2 md:bottom-3 md:right-3 bg-emerald-500 text-white p-1.5 rounded-full border-[3px] border-white shadow-sm" title="Akun Terverifikasi">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    </div>
                @else
                    <div class="absolute bottom-2 right-2 md:bottom-3 md:right-3 bg-amber-500 text-white p-1.5 rounded-full border-[3px] border-white shadow-sm animate-pulse" title="Email Belum Verifikasi">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01" /></svg>
                    </div>
                @endif
            </div>

            {{-- B. HEADER INFO USER --}}
            <div class="flex-1 w-full text-center md:text-left pt-2">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-2">{{ Auth::user()->name }}</h1>
                        
                        {{-- Badge Role & Status --}}
                        <div class="flex items-center justify-center md:justify-start gap-3">
                            @if(Auth::user()->role === 'pemilik' || Auth::user()->role === 'owner')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-orange-50 text-orange-700 border border-orange-100">
                                    🏠 Pemilik Kost
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-blue-50 text-blue-700 border border-blue-100">
                                    🔍 Pencari Kost
                                </span>
                            @endif

                            @if(Auth::user()->hasVerifiedEmail())
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    Belum Verifikasi
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol Edit Profil --}}
                    <a href="{{ route('profile.edit') }}" 
                       class="inline-flex justify-center items-center gap-2 px-6 py-3 bg-white border border-gray-300 rounded-xl text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 hover:text-[#2D4A53] hover:border-[#2D4A53] transition-all transform hover:-translate-y-0.5 focus:ring-2 focus:ring-offset-2 focus:ring-[#2D4A53]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profil
                    </a>
                </div>

                <div class="border-t border-gray-100 my-4"></div>

                {{-- Meta Info --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div class="flex items-center justify-center md:justify-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-xs text-gray-400 font-bold uppercase">Email</p>
                            <p class="font-medium text-gray-900 break-all">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-center md:justify-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-xs text-gray-400 font-bold uppercase">Bergabung Sejak</p>
                            <p class="font-medium text-gray-900">{{ Auth::user()->created_at->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================================
           3. DATA DIRI TERPADU (KODE LAMA ANDA)
           ======================================================================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI: Detail Biodata --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center gap-3 mb-6 border-b border-gray-50 pb-4">
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Biodata Diri</h3>
                        <p class="text-xs text-gray-400">Informasi pribadi yang terdaftar di sistem.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                    {{-- Item --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1.5">Nama Lengkap</label>
                        <p class="text-base font-medium text-gray-900 border-b border-gray-100 pb-2">{{ Auth::user()->name }}</p>
                    </div>
                    
                    {{-- Item --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1.5">Email</label>
                        <p class="text-base font-medium text-gray-900 border-b border-gray-100 pb-2">{{ Auth::user()->email }}</p>
                    </div>

                    {{-- Item --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1.5">WhatsApp</label>
                        <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                            @if(Auth::user()->phone)
                                <span class="text-base font-medium text-gray-900">{{ Auth::user()->phone }}</span>
                                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" title="Valid Format"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            @else
                                <span class="text-sm text-gray-400 italic">Belum diatur</span>
                            @endif
                        </div>
                    </div>

                    {{-- Item --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1.5">Domisili / Alamat</label>
                        <p class="text-base font-medium text-gray-900 border-b border-gray-100 pb-2">
                            {{ Auth::user()->address ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Keamanan Akun --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 h-fit">
                <div class="flex items-center gap-3 mb-6 border-b border-gray-50 pb-4">
                    <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Keamanan</h3>
                        <p class="text-xs text-gray-400">Status & proteksi akun.</p>
                    </div>
                </div>

                <div class="space-y-6">
                    {{-- Status Email --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Verifikasi Email</label>
                        @if(Auth::user()->hasVerifiedEmail())
                            <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 rounded-xl p-3">
                                <div class="bg-emerald-100 p-1 rounded-full">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <span class="text-sm font-bold text-emerald-700">Sudah Terverifikasi</span>
                            </div>
                        @else
                            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                    <span class="text-sm font-bold text-amber-700">Belum Terverifikasi</span>
                                </div>
                                <form action="{{ route('verification.send') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-2 bg-white border border-amber-200 text-amber-700 text-xs font-bold rounded-lg hover:bg-amber-100 transition shadow-sm">
                                        Kirim Link Verifikasi
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    {{-- Ganti Password (Sudah diperbaiki) --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Kata Sandi</label>
                        <a href="{{ auth()->user()->role === 'pemilik'? route('pemilik.password.edit') : route('password.edit') }}"class="flex items-center justify-between w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 transition group cursor-pointer decoration-0">
                            <span class="text-sm font-medium text-gray-700 group-hover:text-orange-600 transition">Ubah Kata Sandi</span>
                            <div class="bg-white p-1.5 rounded-lg border border-gray-200 group-hover:border-orange-200">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
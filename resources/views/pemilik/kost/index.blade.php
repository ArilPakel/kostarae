@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50/50 py-10 font-sans" x-data="{ activeTab: 'data_diri' }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        {{-- ========================================================================
           1. HEADER PROFIL (Compact, Professional, & Clean)
           ======================================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            {{-- Background Accent Minimalis --}}
            <div class="h-24 bg-gradient-to-r from-[#2D4A53] to-[#263e46]"></div>
            
            <div class="px-8 pb-6 flex flex-col md:flex-row items-start md:items-end -mt-10 gap-5">
                
                {{-- Avatar Wrapper --}}
                <div class="relative flex-shrink-0">
                    <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=f97316&color=fff&bold=true' }}" 
                         alt="Foto Profil" 
                         class="w-20 h-20 md:w-24 md:h-24 rounded-full border-[4px] border-white shadow-md object-cover bg-white">
                    
                    {{-- Status Indikator (Dot Only) --}}
                    @if(Auth::user()->hasVerifiedEmail())
                        <div class="absolute bottom-1 right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center" title="Akun Terverifikasi">
                            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                    @else
                        <div class="absolute bottom-1 right-1 w-5 h-5 bg-amber-500 border-2 border-white rounded-full flex items-center justify-center" title="Email Belum Verifikasi">
                            <span class="text-white text-[10px] font-bold">!</span>
                        </div>
                    @endif
                </div>

                {{-- User Info --}}
                <div class="flex-1 w-full pt-1">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h1 class="text-2xl font-bold text-gray-900 leading-none">{{ Auth::user()->name }}</h1>
                                {{-- BADGE PEMILIK KOST (Konsisten) --}}
                                <span class="px-2.5 py-0.5 bg-orange-50 text-orange-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-orange-100">
                                    Pemilik Kost
                                </span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-500">
                                <span>{{ Auth::user()->email }}</span>
                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                <span>Bergabung {{ Auth::user()->created_at->translatedFormat('F Y') }}</span>
                            </div>
                        </div>

                        {{-- Tombol Edit (Aksi Tunggal) --}}
                        <a href="{{ route('profile.edit') }}" class="inline-flex justify-center items-center gap-2 px-5 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:text-orange-600 hover:border-orange-200 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            {{-- TAB NAVIGASI (Tanpa 'Kost Saya') --}}
            <div class="px-8 mt-2 border-t border-gray-50">
                <nav class="flex gap-8 overflow-x-auto whitespace-nowrap scrollbar-hide">
                    @foreach([
                        'data_diri' => 'Data Profil',
                        'statistik' => 'Statistik',
                        'aktivitas' => 'Aktivitas',
                        'keamanan'  => 'Keamanan'
                    ] as $key => $label)
                        <button @click="activeTab = '{{ $key }}'" 
                                :class="activeTab === '{{ $key }}' 
                                    ? 'border-orange-500 text-orange-600 font-bold' 
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200 font-medium'"
                                class="py-4 text-sm border-b-[3px] transition-all duration-200 outline-none">
                            {{ $label }}
                        </button>
                    @endforeach
                </nav>
            </div>
        </div>

        {{-- ========================================================================
           2. KONTEN TAB (Ringkas & Informatif)
           ======================================================================== --}}
        
        {{-- A. DATA PROFIL --}}
        <div x-show="activeTab === 'data_diri'" style="display: none;" x-transition.opacity.duration.300ms>
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span> Informasi Akun
                    </h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                    <div class="group">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Nama Lengkap</label>
                        <p class="text-gray-900 font-medium text-base border-b border-gray-50 pb-2">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="group">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Email</label>
                        <p class="text-gray-900 font-medium text-base border-b border-gray-50 pb-2">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="group">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">WhatsApp</label>
                        <p class="text-gray-900 font-medium text-base border-b border-gray-50 pb-2">{{ Auth::user()->phone ?? 'Belum diatur' }}</p>
                    </div>
                    <div class="group">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Role Akun</label>
                        <div class="pt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-emerald-50 text-emerald-700">
                                Pemilik Kost (Verified)
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- B. STATISTIK RINGKAS --}}
        <div x-show="activeTab === 'statistik'" style="display: none;" x-transition.opacity.duration.300ms>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                {{-- Banner Dashboard --}}
                <div class="md:col-span-3 bg-[#2D4A53] rounded-2xl p-6 text-white shadow-md relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="relative z-10">
                        <h3 class="text-lg font-bold">Ringkasan Properti</h3>
                        <p class="text-blue-100/80 text-xs mt-1">Kelola detail kost dan kamar di Dashboard Utama.</p>
                    </div>
                    <div class="relative z-10">
                        <a href="{{ route('pemilik.kost.index') }}" class="px-5 py-2.5 bg-white text-[#2D4A53] text-xs font-bold rounded-xl hover:bg-gray-100 transition shadow-sm inline-flex items-center gap-2">
                            Buka Dashboard Pemilik <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                    {{-- Decor --}}
                    <div class="absolute right-0 top-0 w-32 h-32 bg-white/5 rounded-full blur-2xl -mr-10 -mt-10"></div>
                </div>

                {{-- Stat Cards Minimalis --}}
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm text-center">
                    <span class="block text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_kost'] ?? 0 }}</span>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Kost</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm text-center">
                    <span class="block text-3xl font-bold text-emerald-600 mb-1">{{ $stats['active_kost'] ?? 0 }}</span>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Kost Aktif</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm text-center">
                    <span class="block text-3xl font-bold text-orange-500 mb-1">{{ $stats['total_views'] ?? 0 }}</span>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Dilihat</span>
                </div>
            </div>
        </div>

        {{-- C. AKTIVITAS --}}
        <div x-show="activeTab === 'aktivitas'" style="display: none;" x-transition.opacity.duration.300ms>
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-base font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span> Riwayat Akun
                </h3>
                <div class="space-y-6 ml-2 border-l-2 border-gray-50 pl-6 relative">
                    {{-- Item --}}
                    <div class="relative">
                        <span class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-white"></span>
                        <p class="text-sm font-bold text-gray-800">Login Berhasil</p>
                        <p class="text-xs text-gray-400 mt-0.5">Sesi aktif saat ini</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- D. KEAMANAN --}}
        <div x-show="activeTab === 'keamanan'" style="display: none;" x-transition.opacity.duration.300ms>
            <div class="space-y-6">
                {{-- Password --}}
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="text-base font-bold text-gray-900 mb-6">Ganti Password</h3>
                    <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                        @csrf @method('put')
                        <div class="space-y-4">
                            <input type="password" name="current_password" placeholder="Password Lama" class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-orange-500 focus:border-orange-500">
                            <input type="password" name="password" placeholder="Password Baru" class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-orange-500 focus:border-orange-500">
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password Baru" class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div class="pt-2 text-right">
                            <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-800 transition">Update Password</button>
                        </div>
                    </form>
                </div>

                {{-- Logout Zone --}}
                <div class="bg-red-50 p-6 rounded-2xl border border-red-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-red-700">Zona Keluar</p>
                        <p class="text-xs text-red-600/70">Akhiri sesi di perangkat ini.</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-5 py-2 bg-white text-red-600 border border-red-200 text-xs font-bold rounded-lg hover:bg-red-600 hover:text-white transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
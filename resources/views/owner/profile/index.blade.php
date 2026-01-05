@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50/50 py-10 font-sans" x-data="{ activeTab: 'data_diri' }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        {{-- ================= HEADER PROFIL ================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="h-24 bg-gradient-to-r from-[#2D4A53] to-[#263e46]"></div>

            <div class="px-8 pb-6 flex flex-col md:flex-row items-start md:items-end -mt-10 gap-5">

                {{-- Avatar --}}
                <div class="relative">
                    <img
                        src="{{ Auth::user()->avatar
                            ? asset('storage/' . Auth::user()->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=f97316&color=fff&bold=true' }}"
                        class="w-20 h-20 md:w-24 md:h-24 rounded-full border-4 border-white shadow-md object-cover"
                        alt="Avatar">

                    {{-- Status --}}
                    @if(Auth::user()->hasVerifiedEmail())
                        <span class="absolute bottom-1 right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                    @else
                        <span class="absolute bottom-1 right-1 w-5 h-5 bg-amber-500 border-2 border-white rounded-full flex items-center justify-center text-white text-[10px] font-bold">!</span>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 w-full">
                    <div class="flex flex-col md:flex-row justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                                <span class="px-2.5 py-0.5 bg-orange-50 text-orange-700 text-[10px] font-bold rounded-md border border-orange-100">
                                    PEMILIK KOST
                                </span>
                            </div>
                            <p class="text-sm text-gray-500">
                                {{ Auth::user()->email }} · Bergabung {{ Auth::user()->created_at->translatedFormat('F Y') }}
                            </p>
                        </div>

                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center gap-2 px-5 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold hover:border-orange-300 hover:text-orange-600 transition">
                            ✏️ Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="px-8 border-t border-gray-100">
                <nav class="flex gap-8">
                    @foreach([
                        'data_diri' => 'Data Profil',
                        'statistik' => 'Statistik',
                        'aktivitas' => 'Aktivitas',
                        'keamanan'  => 'Keamanan'
                    ] as $key => $label)
                        <button
                            @click="activeTab='{{ $key }}'"
                            class="py-4 text-sm border-b-2 transition
                            "
                            :class="activeTab === '{{ $key }}'
                                ? 'border-orange-500 text-orange-600 font-bold'
                                : 'border-transparent text-gray-500 hover:text-gray-700'">
                            {{ $label }}
                        </button>
                    @endforeach
                </nav>
            </div>
        </div>

        {{-- ================= TAB CONTENT ================= --}}

        {{-- DATA DIRI --}}
        <div x-show="activeTab==='data_diri'" x-transition>
            <div class="bg-white p-8 rounded-2xl border shadow-sm">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Nama</label>
                        <p class="text-gray-900 font-medium">{{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Email</label>
                        <p class="text-gray-900 font-medium">{{ Auth::user()->email }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">WhatsApp</label>
                        <p class="text-gray-900 font-medium">{{ Auth::user()->phone ?? 'Belum diatur' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Status</label>
                        <span class="inline-block px-3 py-1 text-xs bg-emerald-50 text-emerald-700 rounded-lg font-bold">
                            Pemilik Kost
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div x-show="activeTab==='statistik'" x-transition>
            <div class="grid md:grid-cols-3 gap-5">
                <div class="md:col-span-3 bg-[#2D4A53] text-white p-6 rounded-2xl flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-lg">Ringkasan Kost</h3>
                        <p class="text-xs opacity-80">Kelola properti dari dashboard pemilik</p>
                    </div>
                    <a href="{{ route('pemilik.kost.index') }}"
                       class="bg-white text-[#2D4A53] px-5 py-2 rounded-xl text-xs font-bold">
                        Dashboard →
                    </a>
                </div>

                <x-stat title="Total Kost" :value="$stats['total_kost'] ?? 0"/>
                <x-stat title="Kost Aktif" :value="$stats['active_kost'] ?? 0" color="text-emerald-600"/>
                <x-stat title="Total Dilihat" :value="$stats['total_views'] ?? 0" color="text-orange-500"/>
            </div>
        </div>

        {{-- AKTIVITAS --}}
        <div x-show="activeTab==='aktivitas'" x-transition>
            <div class="bg-white p-8 rounded-2xl border shadow-sm">
                <p class="text-sm font-bold">Login Berhasil</p>
                <p class="text-xs text-gray-400">Sesi aktif saat ini</p>
            </div>
        </div>

        {{-- KEAMANAN --}}
        <div x-show="activeTab==='keamanan'" x-transition>
            <div class="space-y-6">
                <div class="bg-white p-8 rounded-2xl border shadow-sm">
                    <h3 class="font-bold mb-4">Ganti Password</h3>
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf @method('PUT')
                        <input type="password" name="current_password" placeholder="Password Lama" class="input">
                        <input type="password" name="password" placeholder="Password Baru" class="input">
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="input">
                        <button class="px-6 py-2 bg-gray-900 text-white rounded-xl text-sm font-bold">
                            Update Password
                        </button>
                    </form>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="bg-red-50 p-6 rounded-2xl flex justify-between items-center">
                    @csrf
                    <div>
                        <p class="font-bold text-red-700">Keluar</p>
                        <p class="text-xs text-red-600">Akhiri sesi</p>
                    </div>
                    <button class="px-5 py-2 bg-white border border-red-200 text-red-600 rounded-lg font-bold text-xs">
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

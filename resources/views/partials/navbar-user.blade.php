<nav id="navbar" x-data="{ mobileOpen: false, userDropdownOpen: false }" class="fixed top-0 left-0 right-0 w-full z-50 transition-all duration-300 h-14 flex items-center bg-transparent">
    
    <div class="w-full px-4 sm:px-6 lg:px-8 h-full flex items-center justify-between">
        
        {{-- 1. Logo + Brand --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <img src="{{ asset('images/logokost.png') }}" alt="Logo Kostarae" class="h-8 w-auto object-contain transition-transform group-hover:scale-105">
            <span class="text-white font-bold text-xl tracking-wide">Kostaraé</span>
        </a>

        {{-- 2. Desktop Menu --}}
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}" class="text-sm font-medium text-white hover:text-[#E07B3C] transition-colors tracking-wide">Beranda</a>
            <a href="{{ route('sdank') }}" class="text-sm font-medium text-white hover:text-[#E07B3C] transition-colors tracking-wide">Syarat & Ketentuan</a>
            <a href="{{ route('panduan') }}" class="text-sm font-medium text-white hover:text-[#E07B3C] transition-colors tracking-wide">Panduan</a>
            <a href="{{ route('kontak') }}" class="text-sm font-medium text-white hover:text-[#E07B3C] transition-colors tracking-wide">Kontak</a>

            {{-- Tambah Kost (Khusus Pemilik) --}}
            @if(Auth::check() && (Auth::user()->role === 'pemilik' || Auth::user()->role === 'owner'))
                <a href="{{ route('pemilik.kost.create') }}"
                   class="bg-white text-[#2D4A53] border border-transparent px-3 py-1.5 rounded-lg font-bold text-xs hover:bg-[#E07B3C] hover:text-white hover:border-white transition shadow-sm">
                    + Tambah Kost
                </a>
            @endif
        </div>

        {{-- 3. Right Section: User Dropdown / Login Button + Mobile Toggle --}}
        <div class="flex items-center gap-4">
            
            @auth
                {{-- USER DROPDOWN (LOGGED IN) --}}
                <div class="relative">
                    <button @click="userDropdownOpen = !userDropdownOpen" @click.outside="userDropdownOpen = false" class="flex items-center gap-3 focus:outline-none group">
                        {{-- Avatar --}}
                        <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=E07B3C&color=fff' }}"
                             class="w-8 h-8 rounded-full border-2 border-white/20 group-hover:border-white shadow-sm object-cover transition-all">
                        
                        {{-- Name (Hidden di Mobile) --}}
                        <div class="hidden md:block text-left">
                            <span class="block text-white font-semibold text-sm leading-tight">{{ Auth::user()->name }}</span>
                        </div>
                        
                        {{-- Icon Chevron --}}
                        <svg class="w-4 h-4 text-white opacity-70 group-hover:opacity-100 transition hidden md:block" :class="{'rotate-180': userDropdownOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown Content --}}
                    <div x-show="userDropdownOpen" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-4 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 py-2 origin-top-right ring-1 ring-black ring-opacity-5"
                         style="display: none;">

                        {{-- [SECTION 1] AKUN SAYA --}}
                        <div class="px-4 py-2 border-b border-gray-50 mb-1">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Akun Saya</p>
                        </div>

                        @if(Auth::user()->role === 'pemilik' || Auth::user()->role === 'owner')
                            <a href="{{ route('pemilik.profile') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 text-gray-700 font-medium transition-colors group">
                                <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 group-hover:bg-orange-100 transition">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <div>
                                    <span class="block text-sm">Profil Pemilik</span>
                                    <span class="block text-[10px] text-gray-400 font-normal">Identitas & Keamanan</span>
                                </div>
                            </a>
                        @else
                            <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 text-gray-700 font-medium transition-colors group">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-100 transition">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <div>
                                    <span class="block text-sm">Profil Pencari</span>
                                    <span class="block text-[10px] text-gray-400 font-normal">Identitas & Preferensi</span>
                                </div>
                            </a>
                        @endif

                        {{-- [SECTION 2] AKTIVITAS UTAMA --}}
                        <div class="px-4 py-2 border-t border-gray-50 mt-1 mb-1">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Aktivitas Utama</p>
                        </div>

                        @if (Auth::user()->role === 'pemilik' || Auth::user()->role === 'owner')
                            <a href="{{ route('pemilik.kost.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-emerald-50 text-gray-700 font-medium transition-colors group">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-100 transition">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-gray-900">Dashboard Pemilik</span>
                                    <span class="block text-[10px] text-gray-400 font-normal">Kelola Kost & Kamar</span>
                                </div>
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-emerald-50 text-gray-700 font-medium transition-colors group">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-100 transition">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-gray-900">Dashboard Pencari</span>
                                    <span class="block text-[10px] text-gray-400 font-normal">Favorit & Riwayat</span>
                                </div>
                            </a>
                        @endif

                        <div class="border-t border-gray-100 my-2"></div>

                        {{-- Logout --}}
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 w-full px-4 py-2 text-red-600 hover:bg-red-50 font-medium text-sm transition-colors rounded-b-xl">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                {{-- TOMBOL LOGIN (GUEST) - Jaga-jaga jika ter-include --}}
                <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-bold text-white border border-white rounded-full hover:bg-[#E07B3C] hover:border-[#E07B3C] transition transform hover:-translate-y-0.5">
                    Masuk
                </a>
            @endauth

            {{-- 4. Hamburger Button (Mobile Only) --}}
            <button @click="mobileOpen = !mobileOpen" class="md:hidden text-white hover:text-[#E07B3C] focus:outline-none p-1 rounded-md hover:bg-white/10 transition">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    {{-- 5. Mobile Menu (Dropdown Full Width) --}}
    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-[#2D4A53] border-t border-white/10 absolute w-full left-0 top-14 shadow-xl overflow-hidden"
         style="display: none;">
         
        <div class="px-4 py-4 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-2.5 text-sm font-medium text-white hover:bg-white/10 hover:text-[#E07B3C] rounded-lg transition">Beranda</a>
            <a href="{{ route('sdank') }}" class="block px-4 py-2.5 text-sm font-medium text-white hover:bg-white/10 hover:text-[#E07B3C] rounded-lg transition">Syarat & Ketentuan</a>
            <a href="{{ route('panduan') }}" class="block px-4 py-2.5 text-sm font-medium text-white hover:bg-white/10 hover:text-[#E07B3C] rounded-lg transition">Panduan</a>
            <a href="{{ route('kontak') }}" class="block px-4 py-2.5 text-sm font-medium text-white hover:bg-white/10 hover:text-[#E07B3C] rounded-lg transition">Kontak</a>
            
            @if(Auth::check() && (Auth::user()->role === 'pemilik' || Auth::user()->role === 'owner'))
                <a href="{{ route('pemilik.kost.create') }}" class="block w-full text-center mt-3 bg-white text-[#2D4A53] px-4 py-2.5 rounded-lg font-bold shadow-md">
                    + Tambah Kost
                </a>
            @endif
        </div>
    </div>

</nav>
<nav x-data="{ mobileOpen: false, userDropdownOpen: false }" class="fixed top-0 left-0 w-full z-50 bg-[#2D4A53] shadow-md font-sans">
    
    <div class="px-4 py-3 flex items-center justify-between">
        
        {{-- 1. Logo + Brand --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logokost.png') }}" alt="Logo Kostarae" class="h-12">
                <span class="text-white font-semibold text-2xl">Kostarae`</span>
            </a>
        </div>

        {{-- 2. Desktop Menu (Hidden di Mobile) --}}
        <div class="hidden md:flex items-center gap-6">
            <a href="{{ route('home') }}" class="text-white hover:text-gray-200 transition font-medium ">Beranda</a>
            <a href="{{ route('sdank') }}" class="text-white hover:text-gray-200 transition font-medium">Syarat & Ketentuan</a>
            <a href="{{ route('panduan') }}" class="text-white hover:text-gray-200 transition font-medium">Panduan</a>
            <a href="{{ route('kontak') }}" class="text-white hover:text-gray-200 transition font-medium">Kontak</a>

            {{-- Tambah Kost (Khusus Pemilik) --}}
            @if(Auth::check() && (Auth::user()->role === 'pemilik' || Auth::user()->role === 'owner'))
                <a href="{{ route('pemilik.kost.create') }}"
                   class="bg-white text-[#2D4A53] px-3 py-1 rounded-lg font-semibold hover:bg-gray-200 transition">
                    + Tambah Kost
                </a>
            @endif
        </div>

        {{-- 3. Right Section: User Dropdown + Mobile Toggle --}}
        <div class="flex items-center gap-3">
            
            {{-- USER DROPDOWN --}}
            @auth
            <div class="relative">
                <button @click="userDropdownOpen = !userDropdownOpen" @click.outside="userDropdownOpen = false" class="flex items-center gap-3 focus:outline-none">
                    {{-- Avatar --}}
                    <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                         class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
                    
                    {{-- Name (Hidden di Mobile) --}}
                    <span class="hidden md:block text-white font-semibold">{{ Auth::user()->name }}</span>
                    
                    {{-- Icon Chevron --}}
                    <svg width="20" height="20" class="text-white opacity-80 transition hidden md:block" :class="{'rotate-180': userDropdownOpen}"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </button>

                {{-- Dropdown Content --}}
                <div x-show="userDropdownOpen" x-transition 
                     class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 py-2 origin-top-right"
                     style="display: none;">

                    {{-- [SECTION 1] AKUN SAYA (Identitas) --}}
                    <div class="px-4 py-2 border-b border-gray-50 mb-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Akun Saya</p>
                    </div>

                    @if(Auth::user()->role === 'pemilik' || Auth::user()->role === 'owner')
                        {{-- MENU PEMILIK --}}
                        <a href="{{ route('pemilik.profile') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 text-gray-700 font-medium transition-colors">
                            <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center text-orange-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <div>
                                <span class="block text-sm">Profil Pemilik</span>
                                <span class="block text-[10px] text-gray-400 font-normal">Identitas & Keamanan</span>
                            </div>
                        </a>
                    @else
                        {{-- MENU PENCARI (Sekarang punya subtitle juga) --}}
                        <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 text-gray-700 font-medium transition-colors">
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <div>
                                <span class="block text-sm">Profil Pencari</span>
                                <span class="block text-[10px] text-gray-400 font-normal">Identitas & Preferensi</span>
                            </div>
                        </a>
                    @endif

                    {{-- [SECTION 2] AKTIVITAS UTAMA (Dashboard) --}}
                    <div class="px-4 py-2 border-t border-gray-50 mt-1 mb-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Aktivitas Utama</p>
                    </div>

                    @if (Auth::user()->role === 'pemilik' || Auth::user()->role === 'owner')
                        {{-- DASHBOARD PEMILIK --}}
                        <a href="{{ route('pemilik.kost.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-emerald-50 text-gray-700 font-medium transition-colors">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-gray-900">Dashboard Pemilik</span>
                                <span class="block text-[10px] text-gray-400 font-normal">Kelola Kost & Kamar</span>
                            </div>
                        </a>
                    @else
                        {{-- DASHBOARD PENCARI (Sekarang punya subtitle juga) --}}
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-emerald-50 text-gray-700 font-medium transition-colors">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
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
                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-2 text-red-600 hover:bg-red-50 font-medium text-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
            @endauth

            {{-- 4. Hamburger Button --}}
            <button @click="mobileOpen = !mobileOpen" class="md:hidden text-white focus:outline-none ml-2">
                <svg x-show="!mobileOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    {{-- 5. Mobile Menu --}}
    <div x-show="mobileOpen" x-transition class="md:hidden bg-[#263e46] border-t border-[#375e6b]">
        <div class="px-4 pt-2 pb-4 space-y-1">
            <a href="{{ route('home') }}" class="block text-white hover:bg-[#375e6b] px-3 py-3 rounded-md text-base font-medium">Beranda</a>
            <a href="{{ route('sdank') }}" class="block text-white hover:bg-[#375e6b] px-3 py-3 rounded-md text-base font-medium">Syarat & Ketentuan</a>
            <a href="{{ route('panduan') }}" class="block text-white hover:bg-[#375e6b] px-3 py-3 rounded-md text-base font-medium">Panduan</a>
            <a href="{{ route('kontak') }}" class="block text-white hover:bg-[#375e6b] px-3 py-3 rounded-md text-base font-medium">Kontak</a>
            
            @if(Auth::check() && (Auth::user()->role === 'pemilik' || Auth::user()->role === 'owner'))
                <a href="{{ route('pemilik.kost.create') }}" class="block text-center mt-4 bg-white text-[#2D4A53] px-3 py-2 rounded-lg font-bold">
                    + Tambah Kost
                </a>
            @endif
        </div>
    </div>

</nav>
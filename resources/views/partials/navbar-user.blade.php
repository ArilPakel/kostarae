<nav class="fixed-top flex items-center justify-between px-4 py-3 bg-[#2D4A53] shadow-md font-sans">

    {{-- Logo + Brand --}}
    <div class="flex items-center gap-2">
        <img src="{{ asset('images/logokost.png') }}" alt="Logo Kostarae" class="h-12">
        <span class="text-white font-semibold text-2xl">Kostarae`</span>
    </div>

    {{-- Menu --}}
    <div class="hidden md:flex items-center gap-6">
        <a href="{{ route('home') }}" class="text-white hover:text-gray-200 transition font-medium">Beranda</a>
        <a href="{{ route('sdank') }}" class="text-white hover:text-gray-200 transition font-medium">Syarat & Ketentuan</a>
        <a href="{{ route('panduan') }}" class="text-white hover:text-gray-200 transition font-medium">Panduan</a>
        <a href="{{ route('kontak') }}" class="text-white hover:text-gray-200 transition font-medium">Kontak</a>

        {{-- Tambah Kost untuk pemilik --}}
        @if(Auth::check() && Auth::user()->role == 'pemilik')
            <a href="{{ route('pemilik.kost.create') }}"
               class="bg-white text-[#2D4A53] px-3 py-1 rounded-lg font-semibold hover:bg-gray-200 transition">
               + Tambah Kost
            </a>
        @endif
    </div>

    {{-- USER DROPDOWN --}}
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">
            {{-- Avatar --}}
            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                 class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
            {{-- Name --}}
            <span class="text-white font-semibold">{{ Auth::user()->name }}</span>
            {{-- Icon --}}
            <svg width="20" height="20" class="text-white opacity-80 transition"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9l6 6 6-6" />
            </svg>
        </button>

        {{-- Dropdown Menu --}}
        <div x-show="open" x-transition @click.outside="open = false" x-cloak
             class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border z-50 py-2 animate-fadeIn">

            {{-- Profil --}}
            <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 rounded-lg text-gray-700 font-medium">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12z" />
                    <path d="M4.8 21.6c0-4 3.2-7.2 7.2-7.2s7.2 3.2 7.2 7.2" />
                </svg>
                Profil Saya
            </a>

            {{-- Dashboard / Kelola Kost --}}
            @if (Auth::user()->role == 'pemilik')
                <a href="{{ route('pemilik.kost.index') }}"
                   class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 rounded-lg text-gray-700 font-medium">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12l9-9 9 9" />
                        <path d="M9 21V12h6v9" />
                    </svg>
                    Kelola Kost
                </a>
            @else
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 rounded-lg text-gray-700 font-medium">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="6" height="6" />
                        <rect x="15" y="3" width="6" height="6" />
                        <rect x="3" y="15" width="6" height="6" />
                        <rect x="15" y="15" width="6" height="6" />
                    </svg>
                    Dashboard Saya
                </a>
            @endif

            {{-- Logout --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 w-full px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg font-medium">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4v18h-4" />
                        <path d="M10 17l5-5-5-5" />
                    </svg>
                    Logout
                </button>
            </form>

        </div>
    </div>

</nav>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn { animation: fadeIn .18s ease-out; }
</style>

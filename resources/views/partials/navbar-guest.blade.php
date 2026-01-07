<nav id="navbar" x-data="{ open: false }" class="fixed top-0 left-0 right-0 w-full z-50 transition-all duration-300 h-14 flex items-center bg-transparent">
    
    <div class="w-full px-4 sm:px-6 lg:px-8 flex justify-between items-center h-full">

        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <img src="{{ asset('images/logokost.png') }}" alt="Logo Kostarae" class="h-8 w-auto object-contain transition-transform group-hover:scale-105">
            <span class="text-white font-bold text-xl tracking-wide">Kostaraé</span>
        </a>

        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}" class="text-sm font-medium text-white hover:text-[#E07B3C] transition-colors tracking-wide">
                Beranda
            </a>
            <a href="{{ route('sdank') }}" class="text-sm font-medium text-white hover:text-[#E07B3C] transition-colors tracking-wide">
                Syarat & Ketentuan
            </a>
            <a href="{{ route('panduan') }}" class="text-sm font-medium text-white hover:text-[#E07B3C] transition-colors tracking-wide">
                Panduan
            </a>
            <a href="{{ route('kontak') }}" class="text-sm font-medium text-white hover:text-[#E07B3C] transition-colors tracking-wide">
                Kontak
            </a>
        </div>

        <div class="hidden md:block">
            <button onclick="openModal()"
                class="px-5 py-2 rounded-lg font-bold text-sm text-white bg-[#E07B3C] hover:bg-[#cf6f32] transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                Daftar
            </button>
        </div>

        <div class="flex items-center md:hidden">
            <button @click="open = ! open" class="text-white hover:text-[#E07B3C] focus:outline-none p-1 rounded-md hover:bg-white/10 transition">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.away="open = false"
         class="md:hidden bg-[#2D4A53] border-t border-white/10 absolute w-full left-0 top-14 shadow-xl overflow-hidden">
        
        <div class="pt-2 pb-4 px-4 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-2.5 text-sm font-medium text-white hover:bg-white/5 hover:text-[#E07B3C] rounded-lg transition">
                Beranda
            </a>
            <a href="{{ route('sdank') }}" class="block px-4 py-2.5 text-sm font-medium text-white hover:bg-white/5 hover:text-[#E07B3C] rounded-lg transition">
                Syarat & Ketentuan
            </a>
            <a href="{{ route('panduan') }}" class="block px-4 py-2.5 text-sm font-medium text-white hover:bg-white/5 hover:text-[#E07B3C] rounded-lg transition">
                Panduan
            </a>
            <a href="{{ route('kontak') }}" class="block px-4 py-2.5 text-sm font-medium text-white hover:bg-white/5 hover:text-[#E07B3C] rounded-lg transition">
                Kontak
            </a>
            <div class="pt-3 mt-2 border-t border-white/10">
                <button onclick="openModal()" class="w-full text-center px-6 py-2.5 rounded-lg font-bold text-white bg-[#E07B3C] hover:bg-[#cf6f32] transition shadow-md">
                    Daftar Sekarang
                </button>
            </div>
        </div>
    </div>
</nav>
<nav
    class="fixed-top flex items-center justify-between px-4 py-2 shadow-sm bg-[#2D4A53] transition-colors duration-400 font-sans">
    <div class="flex items-center gap-2">
        <img src="{{ asset('images/logokost.png') }}" alt="Logo Kostarae" class="h-13">
        <span class="text-white font-semibold text-2xl"> Kostarae`</span>
    </div>

    <div class="flex items-center gap-6">
        <a href="{{ route('home') }}" class="text-white font-semibold text-base no-underline hover:text-gray-200 transition">
            Beranda
        </a>
        <a href="{{ route('sdank') }}" class="text-white font-semibold text-base no-underline hover:text-gray-200 transition">
            syarat dan ketentuan
        </a>
        <a href="{{ route('panduan') }}" class="text-white font-semibold text-base no-underline hover:text-gray-200 transition">
            panduan
        </a>
        <a href="{{ route('kontak') }}" class="text-white font-semibold text-base no-underline hover:text-gray-200 transition">
            kontak
        </a>
    </div>

    <div>
        <button onclick="openModal()"
            class="px-6 py-2 rounded-lg font-semibold text-white bg-[#E07B3C] hover:bg-[#cf6f32] transition">
            Daftar
        </button>
    </div>
</nav>

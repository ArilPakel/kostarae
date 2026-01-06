<footer class="bg-[#1f3f46] text-white pt-10 pb-6 border-t border-white/10">
    <div class="max-w-6xl mx-auto px-4">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-6">

            <div class="flex flex-col items-center md:items-start">
                <div class="flex items-center gap-3 mb-3">
                    {{-- Pastikan file gambar ada, jika tidak, gunakan text --}}
                    @if(file_exists(public_path('images/logokost.png')))
                        <img src="{{ asset('images/logokost.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                    @else
                        {{-- Fallback Logo SVG jika gambar tidak ada --}}
                        <svg class="w-10 h-10 text-[#ff7a00]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 12h3v8h6v-6h2v6h6v-8h3L12 2z"/></svg>
                    @endif
                    <h4 class="text-xl font-bold tracking-wide">Kostaraé</h4>
                </div>
                <p class="text-white/60 text-sm text-center md:text-left leading-relaxed">
                    Platform pencarian kost modern, aman, dan terpercaya.
                </p>
            </div>

            <div class="text-center md:text-left">
                <h6 class="uppercase font-bold mb-4 text-sm tracking-wider text-[#ff7a00]">Menu</h6>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}"
                            class="text-gray-300 hover:text-[#ff7a00] transition inline-block hover:translate-x-1">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sdank') }}"
                            class="text-gray-300 hover:text-[#ff7a00] transition inline-block hover:translate-x-1">
                            Syarat dan Ketentuan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('panduan') }}"
                            class="text-gray-300 hover:text-[#ff7a00] transition inline-block hover:translate-x-1">
                            Panduan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kontak') }}"
                            class="text-gray-300 hover:text-[#ff7a00] transition inline-block hover:translate-x-1">
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <div class="text-center md:text-left">
                <h6 class="uppercase font-bold mb-4 text-sm tracking-wider text-[#ff7a00]">Kontak</h6>
                <div class="flex flex-col items-center md:items-start gap-3 text-sm text-gray-300">
                    <p class="flex items-center gap-2">
                        {{-- Ganti <i> dengan SVG --}}
                        <svg class="w-4 h-4 text-[#ff7a00]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        support@kostarae.com
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#ff7a00]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        +62 812-3456-7890
                    </p>
                </div>
            </div>

            <div class="text-center md:text-left">
                <h6 class="uppercase font-bold mb-4 text-sm tracking-wider text-[#ff7a00]">Sosial Media</h6>
                <div class="flex md:justify-start justify-center gap-3">

                    <a href="#"
                        class="flex items-center justify-center w-10 h-10 border border-white/20 rounded-full text-white hover:bg-[#ff7a00] hover:border-[#ff7a00] transition transform hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12.07C22 6.48 17.52 2 11.93 2 6.35 2 2 6.48 2 12.07c0 4.99 3.66 9.13 8.44 9.93v-7.03H8.1v-2.9h2.34V9.86c0-2.3 1.37-3.57 3.47-3.57.99 0 2.02.18 2.02.18v2.23h-1.14c-1.12 0-1.47.7-1.47 1.42v1.71h2.51l-.4 2.9h-2.11v7.03c4.78-.8 8.44-4.94 8.44-9.93z" />
                        </svg>
                    </a>

                    <a href="#"
                        class="flex items-center justify-center w-10 h-10 border border-white/20 rounded-full text-white hover:bg-[#ff7a00] hover:border-[#ff7a00] transition transform hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm10.5 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM12 7a5 5 0 110 10 5 5 0 010-10zm0 2.2a2.8 2.8 0 100 5.6 2.8 2.8 0 000-5.6z" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <div class="my-8 border-t border-white/10"></div>

        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-white/60 text-sm">
            <span>&copy; {{ date('Y') }} Kostaraé. All rights reserved.</span>
            <span class="flex gap-4">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="#" class="hover:text-white transition">Terms of Service</a>
            </span>
        </div>
    </div>
</footer>
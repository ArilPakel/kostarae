<footer class="bg-[#2D4A53] text-white pt-8 pb-4">
    <div class="max-w-6xl mx-auto px-4">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <!-- Logo + Title -->
            <div class="flex flex-col items-center md:items-start">
                <div class="flex items-center gap-2 mb-2">
                    <img src="{{ asset('images/logokost.png') }}" alt="Logo" class="w-12 h-12">
                    <h4 class="text-xl font-semibold">Kostaraé</h4>
                </div>
            </div>

            <!-- Menu -->
            <div>
                <h6 class="uppercase font-semibold mb-3 text-sm">Menu</h6>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('home') }}"
                            class="text-gray-300 hover:text-[#E07B3C] transition inline-block hover:translate-x-1">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sdank') }}"
                            class="text-gray-300 hover:text-[#E07B3C] transition inline-block hover:translate-x-1">
                            Syarat dan Ketentuan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('panduan') }}"
                            class="text-gray-300 hover:text-[#E07B3C] transition inline-block hover:translate-x-1">
                            Panduan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kontak') }}"
                            class="text-gray-300 hover:text-[#E07B3C] transition inline-block hover:translate-x-1">
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h6 class="uppercase font-semibold mb-3 text-sm">Contact Information</h6>
                <p class="flex items-center gap-2 text-gray-300 mb-1">
                    <i class="bi bi-telephone-fill"></i> +62 320 666 790
                </p>
                <p class="flex items-center gap-2 text-gray-300 mb-1">
                    <i class="bi bi-envelope-fill"></i> KostTarae`@.com
                </p>
            </div>

            <!-- Social Media -->
            <div>
                <h6 class="uppercase font-semibold mb-3 text-sm">Social Media</h6>
                <div class="flex md:justify-start justify-center gap-3">

                    <!-- Facebook -->
                    <a href="#"
                        class="flex items-center justify-center w-10 h-10 border border-white/30 rounded-full text-white hover:bg-[#E07B3C] hover:border-[#E07B3C] transition transform hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22 12.07C22 6.48 17.52 2 11.93 2 6.35 2 2 6.48 2 12.07c0 4.99 3.66 9.13 8.44 9.93v-7.03H8.1v-2.9h2.34V9.86c0-2.3 1.37-3.57 3.47-3.57.99 0 2.02.18 2.02.18v2.23h-1.14c-1.12 0-1.47.7-1.47 1.42v1.71h2.51l-.4 2.9h-2.11v7.03c4.78-.8 8.44-4.94 8.44-9.93z" />
                        </svg>
                    </a>

                    <!-- Instagram -->
                    <a href="#"
                        class="flex items-center justify-center w-10 h-10 border border-white/30 rounded-full text-white hover:bg-[#E07B3C] hover:border-[#E07B3C] transition transform hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm10.5 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM12 7a5 5 0 110 10 5 5 0 010-10zm0 2.2a2.8 2.8 0 100 5.6 2.8 2.8 0 000-5.6z" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <!-- Divider -->
        <div class="my-5 border-t border-white/20"></div>

        <div class="text-center text-white/70 text-sm">
            &copy; {{ date('Y') }} Kostaraé. All rights reserved.
        </div>
    </div>
</footer>

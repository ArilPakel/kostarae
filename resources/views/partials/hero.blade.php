<section
    class="relative h-[90vh] flex justify-center items-center text-white text-center pt-20 bg-cover bg-center bg-no-repeat"
    style="background-image:url('/images/hero.png');">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-[rgba(15,15,15,0.55)]"></div>

    <div class="container mx-auto px-4 relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold leading-snug mb-4">
            Temukan Kost <span class="text-[#E07B3C]">Impianmu</span><br>
            Dengan Nyaman dan Modern
        </h1>

        <p class="text-sm md:text-base text-gray-200 mb-6">
            Jelajahi pilihan kost eksklusif dengan lokasi strategis, harga bersahabat, dan desain kekinian.
        </p>

        <!-- FORM FILTER -->
        <form class="bg-white text-gray-900 shadow-xl rounded-2xl max-w-3xl mx-auto p-5 md:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- LOKASI -->
                <div class="col-span-full text-left">
                    <label class="font-semibold text-sm mb-1 block">Kota, tujuan, atau nama kost</label>
                    <div class="relative">
                        <!-- ICON SEARCH -->
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                            <!-- HEROICON -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                            </svg>
                        </span>

                        <input type="text" placeholder="Cari kost..."
                            class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300
                            focus:border-[#E07B3C] focus:ring-2 
                            focus:ring-[#E07B3C]/30 outline-none" />
                    </div>
                </div>

                <!-- HARGA MIN -->
                <div>
                    <label class="font-semibold text-sm block mb-1">Harga Minimum</label>
                    <input type="number" placeholder="Rp 200.000"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300
                        focus:border-[#E07B3C] focus:ring-2 focus:ring-[#E07B3C]/30 outline-none" />
                </div>

                <!-- HARGA MAX -->
                <div>
                    <label class="font-semibold text-sm block mb-1">Harga Maksimum</label>
                    <input type="number" placeholder="Rp 2.000.000"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300
                        focus:border-[#E07B3C] focus:ring-2 focus:ring-[#E07B3C]/30 outline-none" />
                </div>

                <!-- TIPE KOST -->
                <div>
                    <label class="font-semibold text-sm block mb-1">Tipe Kost</label>
                    <select
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white
                        focus:border-[#E07B3C] focus:ring-2 focus:ring-[#E07B3C]/30 outline-none">
                        <option selected>Tipe Kost</option>
                        <option>Putra</option>
                        <option>Putri</option>
                        <option>Campur</option>
                    </select>
                </div>

                <!-- KELENGKAPAN -->
                <div>
                    <label class="font-semibold text-sm block mb-1">Kelengkapan</label>
                    <select
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white
                        focus:border-[#E07B3C] focus:ring-2 focus:ring-[#E07B3C]/30 outline-none">
                        <option selected>Kelengkapan</option>
                        <option>Siap Huni</option>
                        <option>Sebagian</option>
                        <option>Kosong</option>
                    </select>
                </div>

            </div>
        </form>
    </div>
</section>

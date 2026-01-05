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
        <form action="{{ route('kost.public') }}" method="GET"
            class="bg-white text-gray-900 shadow-xl rounded-2xl max-w-3xl mx-auto p-5 md:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- LOKASI / NAMA KOST -->
                <div class="col-span-full text-left">
                    <label class="font-semibold text-sm mb-1 block">Kota, tujuan, atau nama kost</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                            <!-- icon search -->
                        </span>
                        <input type="text" name="search" placeholder="Cari kost..."
                            class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 focus:border-[#E07B3C] focus:ring-2 focus:ring-[#E07B3C]/30 outline-none" />
                    </div>
                </div>

                <!-- HARGA MIN -->
                <div>
                    <label class="font-semibold text-sm block mb-1">Harga Minimum</label>
                    <input type="number" name="min_price" placeholder="Rp 200.000"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-[#E07B3C] focus:ring-2 focus:ring-[#E07B3C]/30 outline-none" />
                </div>

                <!-- HARGA MAX -->
                <div>
                    <label class="font-semibold text-sm block mb-1">Harga Maksimum</label>
                    <input type="number" name="max_price" placeholder="Rp 2.000.000"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-[#E07B3C] focus:ring-2 focus:ring-[#E07B3C]/30 outline-none" />
                </div>

                <!-- TIPE KOST -->
                <div>
                    <label class="font-semibold text-sm block mb-1">Tipe Kost</label>
                    <select name="tipe"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white focus:border-[#E07B3C] focus:ring-2 focus:ring-[#E07B3C]/30 outline-none">
                        <option value="">Tipe Kost</option>
                        <option value="Putra">Putra</option>
                        <option value="Putri">Putri</option>
                        <option value="Campur">Campur</option>
                    </select>
                </div>

                <!-- KELENGKAPAN -->
                <div>
                    <label class="font-semibold text-sm block mb-1">Kelengkapan</label>
                    <select name="kelengkapan"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white focus:border-[#E07B3C] focus:ring-2 focus:ring-[#E07B3C]/30 outline-none">
                        <option value="">Kelengkapan</option>
                        <option value="AC">AC</option>
                        <option value="Wifi">Wifi</option>
                        <option value="Kamar Mandi Dalam">KM Dalam</option>
                    </select>
                </div>

            </div>
            <button type="submit"
                class="mt-4 w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-lg font-bold">Cari
                Kost</button>
        </form>
    </div>
</section>

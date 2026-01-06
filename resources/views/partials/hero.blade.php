<section class="relative min-h-[60vh] md:min-h-[75vh] flex items-center justify-center text-white text-center pt-20 pb-12 overflow-hidden">
    
    {{-- 1. BACKGROUND IMAGE --}}
    <div class="absolute inset-0 z-0">
        <img src="/images/hero.png" alt="Background Kost" class="w-full h-full object-cover object-center">
        {{-- Gradient Overlay: Agar teks putih terbaca jelas di atas gambar --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-[#1f3f46]/70 to-black/80 mix-blend-multiply"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        {{-- 2. HEADLINE --}}
        <div class="max-w-4xl mx-auto mb-10">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 font-sans drop-shadow-lg">
                Temukan Kost <span class="text-[#ff7a00]">Impianmu</span><br>
                Dengan Nyaman dan Modern
            </h1>
            <p class="text-sm md:text-lg text-gray-200 font-medium max-w-2xl mx-auto opacity-90">
                Jelajahi pilihan kost eksklusif dengan lokasi strategis, harga bersahabat, dan desain kekinian.
            </p>
        </div>

        {{-- 3. SEARCH FORM --}}
        <form action="{{ route('kost.public') }}" method="GET"
            class="bg-white/95 backdrop-blur-sm shadow-2xl rounded-2xl max-w-5xl mx-auto p-5 md:p-6 border border-white/20 text-left">
            
            {{-- Grid Container: 1 Kolom (Mobile), 2 Kolom (Tablet), 4 Kolom (Desktop) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">

                {{-- Input 1: Pencarian Utama (Full Width di Mobile/Tablet, 2 Kolom di Desktop) --}}
                <div class="col-span-1 md:col-span-2 lg:col-span-4">
                    <label class="font-bold text-xs text-gray-500 uppercase tracking-wider mb-2 block ml-1">Cari Lokasi / Nama Kost</label>
                    <div class="relative group">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#ff7a00] transition-colors">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </span>
                        <input type="text" name="search" placeholder="Contoh: Jakarta Selatan, Kost Melati..."
                            class="w-full pl-11 pr-4 h-12 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#ff7a00] focus:ring-2 focus:ring-[#ff7a00]/20 outline-none text-[#1e293b] placeholder-gray-400 transition-all text-sm font-medium">
                    </div>
                </div>

                {{-- Input 2: Harga Min --}}
                <div>
                    <label class="font-bold text-xs text-gray-500 uppercase tracking-wider mb-2 block ml-1">Harga Min</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold">Rp</span>
                        <input type="number" name="min_price" placeholder="0"
                            class="w-full pl-10 pr-4 h-12 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#ff7a00] focus:ring-2 focus:ring-[#ff7a00]/20 outline-none text-[#1e293b] placeholder-gray-400 transition-all text-sm font-medium">
                    </div>
                </div>

                {{-- Input 3: Harga Max --}}
                <div>
                    <label class="font-bold text-xs text-gray-500 uppercase tracking-wider mb-2 block ml-1">Harga Max</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold">Rp</span>
                        <input type="number" name="max_price" placeholder="Max Budget"
                            class="w-full pl-10 pr-4 h-12 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#ff7a00] focus:ring-2 focus:ring-[#ff7a00]/20 outline-none text-[#1e293b] placeholder-gray-400 transition-all text-sm font-medium">
                    </div>
                </div>

                {{-- Input 4: Tipe Kost --}}
                <div>
                    <label class="font-bold text-xs text-gray-500 uppercase tracking-wider mb-2 block ml-1">Tipe</label>
                    <div class="relative">
                        <select name="tipe" class="w-full pl-4 pr-10 h-12 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#ff7a00] focus:ring-2 focus:ring-[#ff7a00]/20 outline-none text-[#1e293b] appearance-none cursor-pointer transition-all text-sm font-medium">
                            <option value="">Semua Tipe</option>
                            <option value="Putra">Putra</option>
                            <option value="Putri">Putri</option>
                            <option value="Campur">Campur</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- Input 5: Fasilitas --}}
                <div>
                    <label class="font-bold text-xs text-gray-500 uppercase tracking-wider mb-2 block ml-1">Fasilitas</label>
                    <div class="relative">
                        <select name="kelengkapan" class="w-full pl-4 pr-10 h-12 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#ff7a00] focus:ring-2 focus:ring-[#ff7a00]/20 outline-none text-[#1e293b] appearance-none cursor-pointer transition-all text-sm font-medium">
                            <option value="">Semua Fasilitas</option>
                            <option value="AC">AC</option>
                            <option value="Wifi">WiFi</option>
                            <option value="Kamar Mandi Dalam">KM Dalam</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- Button CTA --}}
                <div class="col-span-1 md:col-span-2 lg:col-span-4 mt-2">
                    <button type="submit"
                        class="w-full h-12 bg-[#ff7a00] hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg hover:shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm md:text-base">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        Cari Kost Sekarang
                    </button>
                </div>

            </div>
        </form>
    </div>
</section>
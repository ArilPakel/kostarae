<section class="py-14 bg-linear-to-b from-white to-gray-100">
    <div class="max-w-7xl mx-auto px-4">

        {{-- ========================================== --}}
        {{-- BAGIAN 1: IKLAN KOST (PROMOSI)             --}}
        {{-- ========================================== --}}
        @if(isset($iklanKost) && $iklanKost->count() > 0)
            <h2 class="text-3xl md:text-4xl font-bold text-center text-[#2D4A53] mb-10">
                Promo Spesial 🔥
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-7 mb-16">
                @foreach ($iklanKost as $item)
                    @php
                        // FOTO UTAMA (anti error)
                        $fotoArray = is_array($item->foto) ? $item->foto : json_decode($item->foto, true);
                        $fotoUtama = $fotoArray[0] ?? 'kost/default.jpg';
                        $imageSrc = asset($fotoUtama);

                        // Fasilitas
                        $fasilitas = is_array($item->fasilitas) ? $item->fasilitas : json_decode($item->fasilitas, true);
                    @endphp

                    <a href="{{ route('kost.detail', $item->id) }}" class="group block bg-white rounded-3xl border-2 border-yellow-400 shadow-sm hover:shadow-md transition-all duration-300 relative">
                        
                        {{-- IMAGE --}}
                        <div class="relative h-52 overflow-hidden rounded-t-[22px]">
                            <img src="{{ $imageSrc }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">

                            {{-- Badge Sponsored --}}
                            <div class="absolute top-0 right-0">
                                <span class="bg-yellow-400 text-white text-[11px] px-3 py-1 rounded-bl-xl shadow-sm font-bold">
                                    Sponsored
                                </span>
                            </div>

                            {{-- Badge Tipe --}}
                            @if ($item->tipe)
                                <div class="absolute bottom-3 right-3">
                                    <span class="bg-white/85 text-gray-700 text-[11px] px-3 py-1 rounded-full border shadow-sm backdrop-blur-sm">
                                        {{ ucfirst($item->tipe) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- BODY --}}
                        <div class="p-5">
                            <h3 class="font-semibold text-lg text-gray-900 mb-1 line-clamp-1 group-hover:text-orange-600 transition">
                                {{ $item->nama }}
                            </h3>

                            <p class="text-sm text-gray-500 flex items-center gap-1 mb-3 line-clamp-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 0a5.53 5.53 0 00-5.5 5.5C2.5 9.75 8 16 8 16s5.5-6.25 5.5-10.5A5.53 5.53 0 008 0z" />
                                    <path d="M8 7.5a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                                {{ $item->alamat }}
                            </p>

                            <p class="text-orange-600 font-bold text-xl mb-4">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                                <span class="text-gray-500 text-sm font-medium">/bulan</span>
                            </p>

                            {{-- Fasilitas --}}
                            @if (!empty($fasilitas))
                                <div class="flex flex-wrap gap-2 mb-5">
                                    @foreach (array_slice($fasilitas, 0, 2) as $f)
                                        <span class="text-[11px] bg-gray-50 px-3 py-1 rounded-xl border text-gray-600 shadow-sm">
                                            {{ $f }}
                                        </span>
                                    @endforeach
                                    @if (count($fasilitas) > 2)
                                        <span class="text-[11px] bg-gray-100 px-3 py-1 rounded-xl border text-gray-600">
                                            +{{ count($fasilitas) - 2 }} lainnya
                                        </span>
                                    @endif
                                </div>
                            @endif

                            {{-- Button --}}
                            <button class="w-full rounded-2xl py-3 text-sm font-semibold text-white bg-linear-to-r from-orange-500 to-orange-400 shadow-[0_4px_12px_rgba(255,140,0,0.25)] hover:shadow-[0_6px_18px_rgba(255,140,0,0.35)] hover:brightness-110 hover:-translate-y-0.5 active:translate-y-px transition-all duration-300 ease-out flex items-center justify-center gap-2 group">
                                Lihat Detail
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transform group-hover:translate-x-1 transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- ========================================== --}}
        {{-- BAGIAN 2: REKOMENDASI (Data Utama)         --}}
        {{-- ========================================== --}}
        <h2 class="text-3xl md:text-4xl font-bold text-center text-[#2D4A53] mb-10">
            Rekomendasi Kost Terbaik
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-7">
            @foreach ($rekomendasiKost as $item)
                @php
                    $fotoArray = is_array($item->foto) ? $item->foto : json_decode($item->foto, true);
                    $fotoUtama = $fotoArray[0] ?? 'kost/default.jpg';
                    $imageSrc = asset($fotoUtama);

                    $fasilitas = is_array($item->fasilitas) ? $item->fasilitas : json_decode($item->fasilitas, true);
                @endphp

                <a href="{{ route('kost.detail', $item->id) }}" class="group block bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
                    
                    {{-- IMAGE --}}
                    <div class="relative h-52 overflow-hidden rounded-t-3xl">
                        <img src="{{ $imageSrc }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">

                        {{-- Badge Status --}}
                        <div class="absolute top-3 left-3">
                            <span class="bg-orange-500/85 text-white text-[11px] px-3 py-1 rounded-full shadow-sm backdrop-blur-sm">
                                Tersedia
                            </span>
                        </div>

                        {{-- Badge Rating --}}
                        @if(isset($item->reviews_avg_rating))
                        <div class="absolute top-3 right-3">
                            <span class="bg-white/90 text-gray-800 text-[11px] px-2 py-1 rounded-full shadow-sm backdrop-blur-sm font-bold flex items-center gap-1">
                                ⭐ {{ number_format($item->reviews_avg_rating, 1) }}
                            </span>
                        </div>
                        @endif

                        {{-- Badge Tipe --}}
                        @if ($item->tipe)
                            <div class="absolute bottom-3 right-3">
                                <span class="bg-white/85 text-gray-700 text-[11px] px-3 py-1 rounded-full border shadow-sm backdrop-blur-sm">
                                    {{ ucfirst($item->tipe) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- BODY --}}
                    <div class="p-5">
                        <h3 class="font-semibold text-lg text-gray-900 mb-1 line-clamp-1 group-hover:text-orange-600 transition">
                            {{ $item->nama }}
                        </h3>

                        <p class="text-sm text-gray-500 flex items-center gap-1 mb-3 line-clamp-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 0a5.53 5.53 0 00-5.5 5.5C2.5 9.75 8 16 8 16s5.5-6.25 5.5-10.5A5.53 5.53 0 008 0z" />
                                <path d="M8 7.5a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                            {{ $item->alamat }}
                        </p>

                        <p class="text-orange-600 font-bold text-xl mb-4">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                            <span class="text-gray-500 text-sm font-medium">/bulan</span>
                        </p>

                        @if (!empty($fasilitas))
                            <div class="flex flex-wrap gap-2 mb-5">
                                @foreach (array_slice($fasilitas, 0, 2) as $f)
                                    <span class="text-[11px] bg-gray-50 px-3 py-1 rounded-xl border text-gray-600 shadow-sm">
                                        {{ $f }}
                                    </span>
                                @endforeach
                                @if (count($fasilitas) > 2)
                                    <span class="text-[11px] bg-gray-100 px-3 py-1 rounded-xl border text-gray-600">
                                        +{{ count($fasilitas) - 2 }} lainnya
                                    </span>
                                @endif
                            </div>
                        @endif

                        <button class="w-full rounded-2xl py-3 text-sm font-semibold text-white bg-linear-to-r from-orange-500 to-orange-400 shadow-[0_4px_12px_rgba(255,140,0,0.25)] hover:shadow-[0_6px_18px_rgba(255,140,0,0.35)] hover:brightness-110 hover:-translate-y-0.5 active:translate-y-px transition-all duration-300 ease-out flex items-center justify-center gap-2 group">
                            Lihat Detail
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transform group-hover:translate-x-1 transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

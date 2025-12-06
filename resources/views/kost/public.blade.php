<section class="py-14 bg-linear-to-b from-white to-gray-100">
    <div class="max-w-7xl mx-auto px-4">

        <h2 class="text-3xl md:text-4xl font-bold text-center text-[#2D4A53] mb-10">
            Rekomendasi Kost Terbaik
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-7">

            @foreach ($kost as $item)
                @if ($item->status === 'diterima')
                    @php
                        $foto = is_array($item->foto) ? $item->foto : json_decode($item->foto, true);
                        $fasilitas = is_array($item->fasilitas)
                            ? $item->fasilitas
                            : json_decode($item->fasilitas, true);
                    @endphp

                    <a href="{{ route('kost.detail', $item->id) }}"
                        class="group block bg-white rounded-3xl border border-gray-100 
                   shadow-sm hover:shadow-md transition-all duration-300">

                        {{-- IMAGE --}}
                        <div class="relative h-52 overflow-hidden rounded-t-3xl">
                            <img src="{{ asset($foto[0] ?? 'storage/kost/default.jpg') }}"
                                class="w-full h-full object-cover transition duration-500 group-hover:scale-105">

                            {{-- Badge Status --}}
                            <div class="absolute top-3 left-3">
                                <span
                                    class="bg-orange-500/85 text-white text-[11px] px-3 py-1 
                                 rounded-full shadow-sm backdrop-blur-sm">
                                    Tersedia
                                </span>
                            </div>

                            {{-- Badge Tipe --}}
                            @if ($item->tipe)
                                <div class="absolute bottom-3 right-3">
                                    <span
                                        class="bg-white/85 text-gray-700 text-[11px] px-3 py-1 rounded-full 
                                     border shadow-sm backdrop-blur-sm">
                                        {{ ucfirst($item->tipe) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- BODY --}}
                        <div class="p-5">

                            {{-- Title --}}
                            <h3
                                class="font-semibold text-lg text-gray-900 mb-1 line-clamp-1 
                           group-hover:text-orange-600 transition">
                                {{ $item->nama }}
                            </h3>

                            {{-- Location --}}
                            <p class="text-sm text-gray-500 flex items-center gap-1 mb-3 line-clamp-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0a5.53 5.53 0 00-5.5 5.5C2.5 9.75 8 16 8 16s5.5-6.25 5.5-10.5A5.53 5.53 0 008 0z" />
                                    <path d="M8 7.5a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                                {{ $item->alamat }}
                            </p>

                            {{-- Price --}}
                            <p class="text-orange-600 font-bold text-xl mb-4">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                                <span class="text-gray-500 text-sm font-medium">/bulan</span>
                            </p>

                            {{-- Fasilitas --}}
                            @if (!empty($fasilitas))
                                <div class="flex flex-wrap gap-2 mb-5">
                                    @foreach (array_slice($fasilitas, 0, 2) as $f)
                                        <span
                                            class="text-[11px] bg-gray-50 px-3 py-1 rounded-xl border text-gray-600 shadow-sm">
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
                            <button
                                class="w-full rounded-2xl py-3 text-sm font-semibold text-white 
           bg-linear-to-r from-orange-500 to-orange-400
           shadow-[0_4px_12px_rgba(255,140,0,0.25)]
           hover:shadow-[0_6px_18px_rgba(255,140,0,0.35)]
           hover:brightness-110 hover:-translate-y-0.5
           active:translate-y-px
           transition-all duration-300 ease-out
           flex items-center justify-center gap-2 group">

                                Lihat Detail

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 transform group-hover:translate-x-1 transition duration-300"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                        </div>
                    </a>
                @endif
            @endforeach




        </div>

        {{-- VIEW ALL --}}
        <div class="text-center mt-14">
            <a href="{{ route('kost.public') }}"
                class="inline-flex items-center gap-2 bg-orange-500 text-white px-7 py-3.5 rounded-xl shadow 
                       hover:bg-orange-600 hover:shadow-xl transition font-semibold text-base">

                Lihat Semua Kost
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

    </div>
</section>

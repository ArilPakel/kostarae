@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-25">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-gray-900">
            Hasil Pencarian Kost
        </h2>

        {{-- TOMBOL KEMBALI --}}
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                  border border-gray-200 bg-white text-sm font-semibold text-gray-600
                  hover:text-orange-600 hover:border-orange-300 hover:bg-orange-50
                  transition-all shadow-sm">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15 19l-7-7 7-7" />
            </svg>

            Kembali ke daftar kost
        </a>
    </div>

    {{-- GRID CARD --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-7">

        @forelse($kosts as $kost)
            <a href="{{ route('kost.detail', $kost->id) }}"
               class="group block bg-white rounded-3xl border border-gray-100
                      shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">

                {{-- IMAGE --}}
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ $kost->image }}"
                         alt="{{ $kost->nama }}"
                         class="w-full h-full object-cover transition duration-500 group-hover:scale-105">

                    {{-- STATUS --}}
                    <span class="absolute top-3 left-3 bg-orange-500/90
                                 text-white text-[11px] px-3 py-1 rounded-full
                                 shadow-sm backdrop-blur-sm">
                        Tersedia
                    </span>

                    {{-- TIPE --}}
                    @if($kost->tipe)
                        <span class="absolute bottom-3 right-3 bg-white/90
                                     text-gray-700 text-[11px] px-3 py-1 rounded-full
                                     border shadow-sm backdrop-blur-sm">
                            {{ ucfirst($kost->tipe) }}
                        </span>
                    @endif
                </div>

                {{-- BODY --}}
                <div class="p-5">
                    <h3 class="font-semibold text-lg text-gray-900 mb-1 line-clamp-1
                               group-hover:text-orange-600 transition">
                        {{ $kost->nama }}
                    </h3>

                    <p class="text-sm text-gray-500 flex items-center gap-1 mb-3 line-clamp-1">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 text-orange-500"
                             fill="currentColor"
                             viewBox="0 0 16 16">
                            <path d="M8 0a5.53 5.53 0 00-5.5 5.5C2.5 9.75 8 16 8 16s5.5-6.25 5.5-10.5A5.53 5.53 0 008 0z"/>
                            <path d="M8 7.5a2 2 0 110-4 2 2 0 010 4z"/>
                        </svg>
                        {{ $kost->alamat }}
                    </p>

                    <p class="text-orange-600 font-bold text-xl mb-4">
                        Rp {{ number_format($kost->harga, 0, ',', '.') }}
                        <span class="text-gray-500 text-sm font-medium">/bulan</span>
                    </p>

                    {{-- FASILITAS --}}
                    @if($kost->fasilitas)
                        <div class="flex flex-wrap gap-2 mb-5">
                            @foreach(array_slice($kost->fasilitas, 0, 2) as $f)
                                <span class="text-[11px] bg-gray-50 px-3 py-1
                                             rounded-xl border text-gray-600 shadow-sm">
                                    {{ $f }}
                                </span>
                            @endforeach

                            @if(count($kost->fasilitas) > 2)
                                <span class="text-[11px] bg-gray-100 px-3 py-1
                                             rounded-xl border text-gray-600">
                                    +{{ count($kost->fasilitas) - 2 }} lainnya
                                </span>
                            @endif
                        </div>
                    @endif

                    {{-- CTA --}}
                    <div class="w-full rounded-2xl py-3 text-sm font-semibold text-white
                                bg-gradient-to-r from-orange-500 to-orange-400
                                shadow-[0_4px_12px_rgba(255,140,0,0.25)]
                                hover:shadow-[0_6px_18px_rgba(255,140,0,0.35)]
                                transition-all flex items-center justify-center gap-2">

                        Lihat Detail

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 transform group-hover:translate-x-1 transition"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-20 text-gray-400">
                Kost tidak ditemukan
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-10">
        {{ $kosts->links() }}
    </div>
</div>
@endsection

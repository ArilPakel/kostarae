@extends('layouts.main')

@section('content')

{{-- 
    1. HERO / HEADER SECTION (Seamless Integration) 
    --------------------------------------------------
    - bg-[#2D4A53]: Warna dasar SAMA PERSIS dengan Navbar agar menyatu.
    - bg-gradient-to-b: Membuat transisi halus ke bawah (sedikit lebih gelap) untuk kedalaman.
    - pb-36: Padding bawah diperbesar (Breathing Room) agar card tidak menabrak judul.
--}}
<div class="relative w-full bg-gradient-to-b from-[#2D4A53] via-[#263f47] to-[#eef2f5] pt-32 pb-40 px-4 rounded-b-[3rem] overflow-hidden">

    
    {{-- Aksen Visual (Opacity dikurangi agar menyatu/tidak kontras) --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        {{-- Blob atas --}}
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/5 rounded-full blur-3xl opacity-60"></div>
        {{-- Blob tengah --}}
        <div class="absolute top-1/2 left-1/4 w-64 h-64 bg-emerald-400/5 rounded-full blur-3xl opacity-40"></div>
    </div>

    {{-- Konten Judul (Typography Hierarchy) --}}
    <div class="relative z-10 container mx-auto text-center">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4 tracking-tight leading-tight drop-shadow-sm">
            Rekomendasi Kost Pilihan
        </h1>
        {{-- Opacity teks dikurangi sedikit (text-emerald-100/90) agar blend dengan background --}}
        <p class="text-emerald-100/90 text-sm md:text-base font-medium max-w-2xl mx-auto leading-relaxed">
            Temukan hunian nyaman, lokasi strategis, dan harga terbaik untuk kenyamanan Anda.
        </p>
    </div>
</div>

{{-- 
    2. MAIN CONTENT (Overlap Halus)
    --------------------------------------------------
    - -mt-24: Card ditarik lebih tinggi ke area "kosong" hero untuk menutup gap visual.
--}}
<div class="relative z-20 -mt-24 min-h-screen pb-20 font-sans bg-[#f8fafc]">
     <div class="absolute inset-x-0 top-0 h-32 
        bg-gradient-to-b from-[#eef2f5] to-transparent pointer-events-none">
    </div>
    <div class="container mx-auto px-4">

        {{-- GRID CARD --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 justify-center">
            
            @forelse($kosts as $kost)
                {{-- CARD WRAPPER (Refined Shadows & Borders) --}}
                {{-- Shadow card diganti ke 'shadow-lg' yang lebih menyebar tapi lembut --}}
                {{-- Border dibuat sangat tipis/transparan (border-white/60) agar tidak ada garis keras --}}
                <div class="group flex flex-col h-full bg-white rounded-2xl border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    
                    {{-- AREA GAMBAR --}}
                    {{-- bg-gray-50: Warna netral halus jika gambar loading --}}
                    <div class="relative h-52 bg-gray-50 overflow-hidden shrink-0">
                        @php
                            $image = asset('images/default-kost.jpg');
                            if ($kost->relationLoaded('kostImages') && $kost->kostImages->count() > 0) {
                                $image = asset('storage/' . $kost->kostImages->first()->path);
                            } elseif (!empty($kost->foto)) {
                                $decoded = is_string($kost->foto) ? json_decode($kost->foto, true) : $kost->foto;
                                if (is_array($decoded) && count($decoded) > 0) {
                                    $first = $decoded[0];
                                    $path = is_array($first) ? ($first['path'] ?? '') : $first;
                                    if ($path) $image = asset($path);
                                }
                            }
                        @endphp
                        
                        <img src="{{ $image }}" 
                             alt="{{ $kost->nama }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        
                        {{-- Overlay Gradient pada Gambar (Untuk Badge) --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-black/20 opacity-80"></div>

                        {{-- Badge Status --}}
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-white/95 text-emerald-700 shadow-sm backdrop-blur-sm tracking-wide">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span>
                                Tersedia
                            </span>
                        </div>

                        {{-- Badge Tipe --}}
                        <div class="absolute top-3 right-3">
                            @php
                                $typeColor = match($kost->tipe) {
                                    'Putra' => 'bg-blue-600',
                                    'Putri' => 'bg-pink-600',
                                    default => 'bg-purple-600',
                                };
                            @endphp
                            <span class="{{ $typeColor }} text-white text-[10px] font-bold px-3 py-1 rounded-lg shadow-sm uppercase tracking-wider backdrop-blur-md bg-opacity-90">
                                {{ $kost->tipe }}
                            </span>
                        </div>
                    </div>

                    {{-- BODY CONTENT --}}
                    <div class="flex-1 flex flex-col p-5">
                        
                        {{-- Nama Kost --}}
                        <div class="mb-2">
                            <h3 class="text-lg font-bold text-gray-900 leading-snug line-clamp-1 group-hover:text-[#ff7a00] transition-colors" title="{{ $kost->nama }}">
                                {{ $kost->nama }}
                            </h3>
                        </div>

                        {{-- Alamat --}}
                        <div class="flex items-start gap-2 mb-4 min-h-[32px]">
                            <svg class="w-4 h-4 mt-0.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">{{ $kost->alamat }}</p>
                        </div>

                        {{-- Fasilitas --}}
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if(!empty($kost->fasilitas))
                                @foreach(array_slice($kost->fasilitas, 0, 2) as $fasilitas)
                                    <span class="inline-flex items-center px-2.5 py-1 bg-gray-50 border border-gray-100 text-gray-600 text-[10px] font-medium rounded-md truncate max-w-[100px]">
                                        {{ $fasilitas }}
                                    </span>
                                @endforeach
                                @if(count($kost->fasilitas) > 2)
                                    <span class="inline-flex items-center px-2.5 py-1 bg-gray-50 border border-gray-100 text-gray-500 text-[10px] font-medium rounded-md">
                                        +{{ count($kost->fasilitas) - 2 }}
                                    </span>
                                @endif
                            @else
                                <span class="text-[10px] text-gray-400 italic">Fasilitas standar</span>
                            @endif
                        </div>

                        {{-- FOOTER (Harga & Tombol) --}}
                        <div class="mt-auto pt-4 border-t border-dashed border-gray-100">
                            <div class="flex items-baseline gap-1 mb-3">
                                <span class="text-lg font-extrabold text-[#ff7a00]">
                                    Rp {{ number_format($kost->harga, 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-gray-400 font-medium">/ bulan</span>
                            </div>

                            <a href="{{ route('kost.detail', $kost->id) }}" 
                               class="flex items-center justify-center w-full py-2.5 bg-[#ff7a00] hover:bg-orange-600 text-white text-sm font-bold rounded-xl transition-all shadow-md hover:shadow-orange-500/25 active:scale-95 group-hover:translate-y-0">
                                Lihat Detail
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                {{-- EMPTY STATE (Clean) --}}
                <div class="col-span-full py-24 text-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border border-gray-100">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Belum ada kost tersedia</h3>
                    <p class="text-gray-500 mt-1">Silakan cek kembali nanti.</p>
                </div>
            @endforelse

        </div>

        {{-- PAGINATION --}}
        <div class="mt-16 flex justify-center">
            {{ $kosts->links() }}
        </div>

    </div>
</div>
@endsection
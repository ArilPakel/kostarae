@extends('layouts.main')

@section('content')

{{-- 
    1. HERO SECTION (AMBIENT & SEAMLESS)
    --------------------------------------------------
    - Base Color: Hijau Tua Branding (#2D4A53).
    - Ambient Light: Blob warna Emerald & Orange transparan agar background "hidup".
    - Padding Bottom (pb-64): Dibuat sangat besar untuk memberi ruang bagi card yang akan "naik".
    - The Blender: Gradasi di bagian bawah hero yang warnanya sama dengan background konten (#f8fafc).
--}}
<div class="relative w-full bg-[#2D4A53] pt-32 pb-64 overflow-hidden isolate">
    
    {{-- Aksen Visual: Ambient Blobs (Efek Cahaya Halus) --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        {{-- Cahaya Emerald di Kiri Atas --}}
        <div class="absolute -top-40 -left-20 w-[40rem] h-[40rem] bg-emerald-500/10 rounded-full blur-[100px] opacity-40 mix-blend-screen animate-pulse-slow"></div>
        {{-- Cahaya Orange di Kanan Bawah --}}
        <div class="absolute top-20 -right-20 w-[35rem] h-[35rem] bg-orange-400/10 rounded-full blur-[100px] opacity-30 mix-blend-screen"></div>
    </div>

    {{-- Pattern Halus (Noise Texture) - Opsional untuk tekstur --}}
    <div class="absolute inset-0 opacity-[0.02] bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>

    {{-- Konten Text Hero --}}
    <div class="relative z-10 container mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 tracking-tight drop-shadow-sm leading-tight">
            Rekomendasi Kost Pilihan
        </h1>
        <p class="text-emerald-50/90 text-sm md:text-base font-medium max-w-2xl mx-auto leading-relaxed antialiased">
            Temukan hunian nyaman, lokasi strategis, dan harga terbaik untuk kenyamanan Anda.
        </p>
    </div>

    {{-- THE BLENDER: Gradasi Transparan ke Solid --}}
    {{-- Ini kunci agar Hero menyatu dengan konten di bawahnya tanpa garis potong --}}
    <div class="absolute bottom-0 left-0 w-full h-48 bg-gradient-to-t from-[#f8fafc] via-[#f8fafc]/90 to-transparent pointer-events-none"></div>
</div>

{{-- 
    2. MAIN CONTENT (ELEVATED CARDS)
    --------------------------------------------------
    - Background: #f8fafc (Slate-50) -> Putih tulang modern, membuat card putih lebih pop-up.
    - Negative Margin (-mt-48): Menarik grid card ke atas agar menumpuk di Hero.
--}}
<div class="relative z-20 -mt-48 min-h-screen pb-24 bg-[#f8fafc] font-sans">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- GRID CARD --}}
        {{-- items-stretch wajib agar tinggi card seragam --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8 items-stretch justify-center">
            
            @forelse($kosts as $kost)
                
                {{-- Logic Data Fasilitas --}}
                @php
                    $fasilitasArray = $kost->fasilitas;
                    if (is_string($fasilitasArray)) {
                        $fasilitasArray = json_decode($fasilitasArray, true);
                    }
                    if (!is_array($fasilitasArray)) {
                        $fasilitasArray = [];
                    }
                @endphp

                {{-- 
                   CARD COMPONENT (Modern Interaction)
                   - h-full: Mengisi tinggi grid column sepenuhnya.
                   - Shadow: Soft diffuse shadow, menajam saat hover.
                   - Hover: Translate Y (Naik) sedikit.
                --}}
                <div class="group flex flex-col h-full bg-white rounded-3xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_15px_30px_-5px_rgba(0,0,0,0.1)] hover:-translate-y-2 transition-all duration-500 ease-out overflow-hidden border border-slate-100 relative isolate">
                    
                    {{-- AREA GAMBAR (Aspect Ratio 4:3) --}}
                    <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden shrink-0">
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
                        
                        {{-- Image Zoom Effect --}}
                        <img src="{{ $image }}" 
                             alt="{{ $kost->nama }}" 
                             loading="lazy"
                             class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                        
                        {{-- Gradient Overlay (Supaya Badge terbaca) --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/5 opacity-60 group-hover:opacity-40 transition-opacity duration-500"></div>

                        {{-- Badge Status (Glassmorphism) --}}
                        <div class="absolute top-4 left-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/95 text-emerald-800 shadow-sm backdrop-blur-md ring-1 ring-black/5">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span>
                                Tersedia
                            </span>
                        </div>

                        {{-- Badge Tipe --}}
                        <div class="absolute top-4 right-4">
                            @php
                                $typeColor = match($kost->tipe) {
                                    'Putra' => 'bg-blue-600',
                                    'Putri' => 'bg-pink-600',
                                    default => 'bg-purple-600',
                                };
                            @endphp
                            <span class="{{ $typeColor }} text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-sm uppercase tracking-wider bg-opacity-90 backdrop-blur-sm border border-white/20">
                                {{ $kost->tipe }}
                            </span>
                        </div>
                    </div>

                    {{-- BODY CONTENT --}}
                    {{-- flex-grow memaksa footer selalu di bawah --}}
                    <div class="flex-1 flex flex-col p-5 bg-white relative">
                        
                        {{-- Judul --}}
                        <div class="mb-1">
                            <h3 class="text-lg font-bold text-slate-800 leading-snug line-clamp-1 group-hover:text-[#ff7a00] transition-colors duration-300" title="{{ $kost->nama }}">
                                {{ $kost->nama }}
                            </h3>
                        </div>

                        {{-- Alamat --}}
                        <div class="flex items-start gap-1.5 text-slate-500 text-xs mb-4 min-h-[20px]">
                            <svg class="w-3.5 h-3.5 mt-0.5 shrink-0 group-hover:text-[#ff7a00]/70 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="line-clamp-1 leading-relaxed">{{ $kost->alamat }}</span>
                        </div>

                        {{-- Fasilitas (Pills Design) --}}
                        {{-- Min-height menjaga layout tidak loncat jika kosong --}}
                        <div class="min-h-[26px] mb-4">
                            @if(!empty($fasilitasArray))
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach(array_slice($fasilitasArray, 0, 2) as $fasilitas)
                                        <span class="inline-flex items-center px-2 py-1 bg-slate-50 border border-slate-100 text-slate-600 text-[10px] font-semibold rounded-lg truncate max-w-[100px] group-hover:border-slate-200 transition-colors">
                                            {{ $fasilitas }}
                                        </span>
                                    @endforeach
                                    @if(count($fasilitasArray) > 2)
                                        <span class="inline-flex items-center px-2 py-1 bg-slate-50 border border-slate-100 text-slate-400 text-[10px] font-semibold rounded-lg">
                                            +{{ count($fasilitasArray) - 2 }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-[10px] text-slate-400 italic flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Fasilitas standar
                                </span>
                            @endif
                        </div>

                        {{-- Separator Halus --}}
                        <div class="w-full h-px bg-slate-50 mb-4 group-hover:bg-slate-100 transition-colors"></div>

                        {{-- FOOTER (Price & Action) --}}
                        <div class="mt-auto flex flex-col gap-3">
                            <div class="flex items-baseline gap-1">
                                <span class="text-lg font-extrabold text-[#ff7a00] tracking-tight group-hover:scale-105 origin-left transition-transform duration-300">
                                    Rp {{ number_format($kost->harga, 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-slate-400 font-medium">/ bulan</span>
                            </div>

                            <a href="{{ route('kost.detail', $kost->id) }}" 
                               class="relative w-full text-center py-2.5 bg-[#ff7a00] hover:bg-[#ff8c1a] text-white text-sm font-bold rounded-xl transition-all duration-300 transform shadow-md shadow-orange-100 hover:shadow-lg hover:shadow-orange-500/25 hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.98]">
                                Lihat Detail
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="col-span-full py-24 text-center">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm ring-1 ring-slate-100 animate-pulse-slow">
                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada kost tersedia</h3>
                    <p class="text-slate-500 text-sm max-w-md mx-auto">Coba ubah kata kunci pencarian atau filter yang Anda gunakan.</p>
                </div>
            @endforelse

        </div>

        {{-- PAGINATION --}}
        <div class="mt-20 flex justify-center">
            {{ $kosts->links() }}
        </div>

    </div>
</div>
@endsection
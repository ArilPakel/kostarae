@extends('layouts.main')

@section('content')

{{-- LOGIC GAMBAR AMAN & HERO IMAGE --}}
@php
    $images = [];
    if ($kost->relationLoaded('kostImages') && $kost->kostImages->count() > 0) {
        foreach($kost->kostImages as $img) $images[] = asset('storage/' . $img->path);
    } elseif (!empty($kost->foto)) {
        $decoded = is_string($kost->foto) ? json_decode($kost->foto, true) : $kost->foto;
        if (is_array($decoded)) {
            foreach($decoded as $item) {
                $path = is_array($item) ? ($item['path'] ?? '') : $item;
                if($path) $images[] = asset($path); 
            }
        }
    }
    if (empty($images)) $images[] = asset('images/default-kost.jpg');
    
    $heroImage = $images[0];
@endphp

{{-- 1. HERO SECTION (BACKGROUND HEADER) --}}
<div class="relative w-full h-[50vh] min-h-[400px] lg:h-[500px]">
    <img src="{{ $heroImage }}" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover filter blur-[3px] scale-105 brightness-75">
    
    {{-- Overlay Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/30 to-gray-50/90"></div>

    {{-- Konten Hero --}}
    <div class="absolute inset-0 flex flex-col justify-center pb-20">
        <div class="container mx-auto px-4">
            
            {{-- [UX CHANGE] TOMBOL KEMBALI (Pengganti Breadcrumb) --}}
            <div class="mb-6">
                <a href="{{ route('kost.public') }}" class="inline-flex items-center gap-2 text-white/90 hover:text-[#ff7a00] transition-colors group font-medium text-sm backdrop-blur-sm bg-white/10 px-4 py-2 rounded-full border border-white/20 hover:bg-white/20">
                    {{-- Ikon Panah Kiri --}}
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Kost
                </a>
            </div>

            {{-- Judul Besar & Badge --}}
            <div class="animate-fade-in-up">
                @if(!empty($kost->tipe))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-4 text-white border border-white/20 backdrop-blur-md shadow-lg
                        {{ $kost->tipe == 'Putra' ? 'bg-blue-600/80' : ($kost->tipe == 'Putri' ? 'bg-pink-600/80' : 'bg-purple-600/80') }}">
                        Kost {{ $kost->tipe }}
                    </span>
                @endif
                
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight drop-shadow-lg mb-3">
                    {{ $kost->nama }}
                </h1>
                
                <div class="flex flex-wrap items-center gap-4 text-white/90 text-sm md:text-lg font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#ff7a00]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                        {{ $kost->alamat }}
                    </div>
                    <span class="hidden md:inline text-white/40">|</span>
                    <div class="flex items-center gap-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="font-bold">{{ number_format($kost->reviews->avg('rating') ?? 0, 1) }}</span>
                        <span class="text-white/70 text-sm">({{ $kost->reviews->count() }} ulasan)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. MAIN CONTENT WRAPPER --}}
<div class="relative z-10 -mt-24 pb-12">
    <div class="container mx-auto px-4">

        {{-- A. GALERI FOTO --}}
        <div class="bg-white p-2 rounded-3xl shadow-2xl border border-gray-100 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-2 h-[300px] md:h-[480px] rounded-2xl overflow-hidden bg-gray-100">
                <div onclick="openImage('{{ $images[0] }}')" class="md:col-span-2 h-full relative group cursor-pointer overflow-hidden">
                    <img src="{{ $images[0] }}" alt="Foto Utama" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition"></div>
                    <div class="absolute bottom-4 left-4 bg-black/60 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-bold pointer-events-none">
                        Foto Utama
                    </div>
                </div>
                <div class="hidden md:grid md:col-span-2 grid-cols-2 gap-2 h-full">
                    @foreach (array_slice($images, 1, 4) as $index => $img)
                        <div onclick="openImage('{{ $img }}')" class="relative overflow-hidden group h-full cursor-pointer">
                            <img src="{{ $img }}" alt="Galeri" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition"></div>
                        </div>
                    @endforeach
                    @if(count($images) < 2)
                        <div class="bg-gray-50 w-full h-full flex flex-col items-center justify-center text-gray-400 col-span-2">
                            <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-xs font-medium">Galeri foto belum lengkap</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- [UX ADDITION] NOTIFIKASI SUKSES (Flash Message) --}}
        {{-- [UX NOTIFICATION] AREA NOTIFIKASI --}}
        
        {{-- 1. Notifikasi Sukses (Hijau) --}}
        @if(session('success'))
            <div id="alert-success" class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex items-start gap-3 transition-all duration-500 ease-in-out transform translate-y-0 opacity-100">
                {{-- Icon Ceklis --}}
                <div class="bg-emerald-100 p-1.5 rounded-full text-emerald-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-emerald-800 text-sm">Berhasil!</h3>
                    <p class="text-sm text-emerald-700 leading-relaxed">{{ session('success') }}</p>
                </div>
                {{-- Tombol Close --}}
                <button onclick="document.getElementById('alert-success').style.display='none'" class="text-emerald-400 hover:text-emerald-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        {{-- 2. Notifikasi Error (Merah) --}}
        @if(session('error'))
            <div id="alert-error" class="mb-8 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm flex items-start gap-3 transition-all duration-500 ease-in-out transform translate-y-0 opacity-100">
                {{-- Icon Tanda Seru --}}
                <div class="bg-rose-100 p-1.5 rounded-full text-rose-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-rose-800 text-sm">Gagal!</h3>
                    <p class="text-sm text-rose-700 leading-relaxed">{{ session('error') }}</p>
                </div>
                {{-- Tombol Close --}}
                <button onclick="document.getElementById('alert-error').style.display='none'" class="text-rose-400 hover:text-rose-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        {{-- 3. Validasi Error Form (Jika user lupa isi rating/komentar) --}}
        @if ($errors->any())
            <div id="alert-validation" class="mb-8 bg-orange-50 border-l-4 border-orange-500 p-4 rounded-r-xl shadow-sm flex items-start gap-3">
                <div class="bg-orange-100 p-1.5 rounded-full text-orange-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-orange-800 text-sm">Periksa Kembali Inputan</h3>
                    <ul class="list-disc list-inside text-sm text-orange-700 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- 3. SPLIT LAYOUT --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- === KOLOM KIRI === --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Deskripsi --}}
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2 border-b border-gray-100 pb-3">
                        <svg class="w-5 h-5 text-[#ff7a00]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Tentang Kost Ini
                    </h3>
                    @if(!empty($kost->deskripsi))
                        <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed text-justify">
                            {!! nl2br(e($kost->deskripsi)) !!}
                        </div>
                    @else
                        <div class="p-6 bg-gray-50 rounded-xl text-gray-400 text-sm text-center border border-dashed border-gray-200">
                            Pemilik belum menambahkan deskripsi detail.
                        </div>
                    @endif
                </div>

                {{-- Fasilitas --}}
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 border-b border-gray-100 pb-3">
                        <svg class="w-5 h-5 text-[#ff7a00]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Fasilitas Tersedia
                    </h3>
                    @if(!empty($kost->fasilitas) && count($kost->fasilitas) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($kost->fasilitas as $fasilitas)
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 hover:border-[#ff7a00]/30 transition group hover:shadow-sm">
                                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-[#ff7a00] shadow-sm border border-gray-100 group-hover:scale-110 transition-transform">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 capitalize">{{ $fasilitas }}</span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 bg-gray-50 rounded-xl text-gray-400 text-sm text-center border border-dashed border-gray-200">
                            Data fasilitas belum diupdate.
                        </div>
                    @endif
                </div>

                {{-- ULASAN --}}
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-gray-100 shadow-sm" id="ulasan-section">
                    <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                        <h3 class="text-lg font-bold text-gray-900">Ulasan Penghuni</h3>
                        <div class="flex items-center gap-2 bg-orange-50 px-3 py-1 rounded-full">
                            <span class="text-sm font-bold text-[#ff7a00]">{{ number_format($kost->reviews->avg('rating') ?? 0, 1) }}</span>
                            <span class="text-xs text-gray-500">({{ $kost->reviews->count() }} Ulasan)</span>
                        </div>
                    </div>

                    {{-- Form Ulasan (Auth Only) --}}
                    @auth
                        @if(auth()->user()->role === 'user')
                        <div class="mb-8 bg-gray-50 p-5 rounded-2xl border border-gray-200">
                            <div class="flex gap-3 mb-3">
                                <div class="w-10 h-10 rounded-full bg-gray-300 overflow-hidden shrink-0">
                                     <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">Bagikan pengalamanmu</h4>
                                    <p class="text-xs text-gray-500">Ulasanmu membantu pencari kost lain.</p>
                                </div>
                            </div>

                            <form action="{{ route('review.store', $kost->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="rating" id="ratingInput" value="0">
                                
                                <div class="flex gap-1 mb-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button" class="rating-btn transition transform hover:scale-110 focus:outline-none" title="Beri nilai {{ $i }}">
                                            <svg class="w-8 h-8 fill-gray-300 hover:fill-yellow-400 transition-colors" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151 -6.064 5.728 1.48 8.266 L12 18.896l-7.416 4.404 1.48-8.266L0 9.306l8.332-1.151z"/></svg>
                                        </button>
                                    @endfor
                                </div>
                                <textarea name="komentar" rows="3" placeholder="Ceritakan kondisi kamar, lingkungan, dll..." class="w-full rounded-xl border-gray-300 focus:border-[#ff7a00] focus:ring focus:ring-[#ff7a00]/20 text-sm mb-3 p-3"></textarea>
                                <button type="submit" class="bg-[#2D4A53] hover:bg-[#1f3f46] text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-md transition w-full md:w-auto">Kirim Ulasan</button>
                            </form>
                        </div>
                        @endif
                    @endauth

                    {{-- List Ulasan (Dengan Fitur Hapus) --}}
                    <div class="space-y-6 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($kost->reviews->where('is_hidden', false) as $review)
                            <div class="flex gap-4 border-b border-gray-100 pb-6 last:border-0 relative group">
                                <div class="shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 overflow-hidden border border-gray-200">
                                        <img src="{{ $review->user->avatar ? asset('storage/'.$review->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($review->user->name ?? 'User') }}" class="w-full h-full object-cover">
                                    </div>
                                </div>
                                <div class="grow">
                                    <div class="flex items-start justify-between mb-1">
                                        <div>
                                            <h5 class="text-sm font-bold text-gray-900">{{ $review->user->name ?? 'Pengguna' }}</h5>
                                            <span class="text-[10px] text-gray-400 bg-gray-50 px-2 py-0.5 rounded-full">
                                                {{ optional($review->created_at)->diffForHumans() ?? '-' }}
                                            </span>
                                        </div>

                                        {{-- [UX ADDITION] TOMBOL HAPUS (Hanya Pemilik Ulasan) --}}
                                        @if(auth()->id() === $review->user_id)
                                            <form action="{{ route('review.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-rose-500 p-1 rounded-md hover:bg-rose-50 transition" title="Hapus Ulasan Saya">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <div class="flex text-yellow-400 mb-2">
                                        @for($i=1; $i<=5; $i++)
                                            <svg class="w-3 h-3 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-xl rounded-tl-none leading-relaxed border border-gray-100">
                                        {{ $review->komentar }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10"><p class="text-gray-400 text-sm">Belum ada ulasan untuk kost ini.</p></div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (Sticky) --}}
            <div class="lg:col-span-1">
                <div class="sticky top-28 space-y-5">
                    
                    {{-- CARD PEMILIK & HARGA --}}
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 relative overflow-hidden">
                        {{-- Aksen Dekoratif --}}
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#ff7a00] to-orange-300"></div>

                        <div class="mb-5 border-b border-gray-100 pb-5">
                            <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-1">Harga Sewa</p>
                            <div class="flex items-end gap-1">
                                <span class="text-3xl font-bold text-[#ff7a00]">Rp {{ number_format($kost->harga, 0, ',', '.') }}</span>
                                <span class="text-gray-500 font-medium mb-1.5 text-sm">/ bulan</span>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-1">*Harga dapat berubah sewaktu-waktu</p>
                        </div>

                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-full bg-[#2D4A53] flex items-center justify-center text-white font-bold border-2 border-white shadow-md overflow-hidden">
                                @if($kost->pemilik->avatar ?? false)
                                    <img src="{{ asset('storage/' . $kost->pemilik->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($kost->pemilik->name ?? 'U', 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 leading-tight">{{ $kost->pemilik->name ?? 'Pemilik Kost' }}</p>
                                <p class="text-[10px] text-green-600 bg-green-50 px-2 py-0.5 rounded-full inline-flex items-center gap-1 mt-1 font-medium border border-green-100">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                    Pemilik Terverifikasi
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @auth
                                @if(auth()->id() === $kost->pemilik_id)
                                    <a href="{{ route('pemilik.kost.edit', $kost->id) }}" class="flex items-center justify-center gap-2 w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition border border-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit Kost Saya
                                    </a>
                                @else
                                    @php 
                                        $phone = $kost->pemilik->phone ?? '';
                                        if(substr($phone, 0, 1) == '0') $phone = '62'.substr($phone, 1);
                                        $waLink = "https://wa.me/{$phone}?text=Halo, saya melihat kost {$kost->nama} di Kostarae dan ingin bertanya ketersediaan kamar.";
                                    @endphp
                                    
                                    {{-- CTA UTAMA --}}
                                    <a href="{{ $waLink }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-4 bg-[#ff7a00] hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-500/30 transform hover:-translate-y-0.5 transition-all group">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.463 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        Hubungi Pemilik
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full py-4 bg-[#2D4A53] hover:bg-[#1f3f46] text-white font-bold rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all">
                                    Login untuk Hubungi
                                </a>
                            @endauth
                        </div>
                    </div>

                    {{-- 2. DISCLAIMER PLATFORM REKOMENDASI --}}
                    <div class="bg-blue-50 p-5 rounded-2xl border border-blue-100 text-blue-800 shadow-sm">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <p class="font-bold text-sm mb-1 text-blue-900">Platform Rekomendasi</p>
                                <p class="text-xs leading-relaxed text-blue-700/80">
                                    Kostarae tidak memproses pembayaran. Transaksi dan survei dilakukan langsung antara Anda dan Pemilik Kost.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- 3. SAFETY TIPS --}}
                    <div class="p-5 rounded-2xl border border-gray-100 bg-white shadow-sm">
                        <p class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Tips Aman Kostarae:
                        </p>
                        <ul class="text-xs text-gray-500 space-y-2 list-disc list-inside">
                            <li>Jangan transfer uang sebelum survei.</li>
                            <li>Pastikan alamat kost sesuai deskripsi.</li>
                            <li>Bertemu pemilik di lokasi kost.</li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL IMAGE ZOOM (Full Screen) --}}
<div id="imgModal" class="fixed inset-0 bg-black/95 hidden items-center justify-center z-[100] p-4 backdrop-blur-sm transition-opacity opacity-0 pointer-events-none">
    <div class="relative w-full max-w-6xl h-full flex flex-col items-center justify-center">
        <button onclick="closeImage()" class="absolute top-4 right-4 z-50 p-2 bg-white/10 hover:bg-white/20 rounded-full text-white transition focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <img id="imgPreview" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl">
        <p class="text-white/50 text-sm mt-4">Klik di area kosong untuk menutup</p>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    const modal = document.getElementById('imgModal');
    const preview = document.getElementById('imgPreview');

    function openImage(src){
        preview.src = src;
        modal.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
        modal.classList.add('flex', 'opacity-100', 'pointer-events-auto');
        document.body.style.overflow = 'hidden'; // Stop scrolling background
    }

    function closeImage() {
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100', 'pointer-events-auto');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300); // Wait for transition
        document.body.style.overflow = 'auto'; // Resume scrolling
    }

    modal?.addEventListener('click', (e) => {
        if(e.target === modal || e.target.closest('.relative') === modal) closeImage();
    });

    // Rating Logic
    const ratingBtns = document.querySelectorAll('.rating-btn');
    const ratingInput = document.getElementById('ratingInput');

    if(ratingBtns.length > 0) {
        ratingBtns.forEach((btn, idx) => {
            btn.addEventListener('click', () => {
                ratingInput.value = idx + 1;
                ratingBtns.forEach((b, i) => {
                    const svg = b.querySelector('svg');
                    if(i <= idx) {
                        svg.classList.remove('fill-gray-300');
                        svg.classList.add('fill-yellow-400');
                    } else {
                        svg.classList.remove('fill-yellow-400');
                        svg.classList.add('fill-gray-300');
                    }
                });
            });
        });
    }

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('[id^="alert-"]');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            setTimeout(() => alert.style.display = 'none', 500); // Wait for fade out
        });
    }, 5000);
</script>
@endsection
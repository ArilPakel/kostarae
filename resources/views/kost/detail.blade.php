@extends('layouts.main')

@section('content')

@php
    $foto = is_array($kost->foto) ? $kost->foto : json_decode($kost->foto, true);
    $fasilitas = is_array($kost->fasilitas) ? $kost->fasilitas : json_decode($kost->fasilitas, true);
    $avgRating = $kost->reviews->avg('rating') ?? 0;
@endphp

<div class="max-w-6xl mx-auto px-6 py-10">

    {{-- Back --}}
    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-orange-600 mb-6">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Kembali
    </a>

    {{-- Top layout: left gallery, right panel --}}
    <div class="grid lg:grid-cols-2 gap-10 items-start">

        {{-- LEFT: Gallery --}}
        <div>
            <div class="rounded-2xl overflow-hidden shadow-lg">
                <img id="mainPhoto" src="{{ asset($foto[0] ?? 'default.jpg') }}" class="w-full h-[520px] object-cover" alt="Foto Kost">
            </div>

            {{-- thumbnails --}}
            @if(!empty($foto) && count($foto) > 1)
            <div class="flex gap-3 mt-4 items-center">
                @foreach($foto as $f)
                    <button type="button" onclick="document.getElementById('mainPhoto').src='{{ asset($f) }}'"
                        class="w-20 h-16 rounded-lg overflow-hidden border border-gray-100 shadow-sm p-0 bg-white hover:scale-105 transition">
                        <img src="{{ asset($f) }}" class="w-full h-full object-cover" alt="thumb">
                    </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- RIGHT: Info panel (deskripsi + price + fasilitas + actions) --}}
        <aside class="space-y-6">
            <div>
                <h1 class="text-2xl lg:text-3xl font-semibold text-gray-900">{{ $kost->nama }}</h1>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.14 2 5 5.14 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.86-3.14-7-7-7z"/>
                    </svg>
                    {{ $kost->alamat }}
                </p>
            </div>

            {{-- Price & rating in one row --}}
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-orange-600 text-3xl font-bold">Rp {{ number_format($kost->harga,0,',','.') }}</p>
                    <p class="text-sm text-gray-500 mt-1">/bulan</p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex">
                        @for($i=1;$i<=5;$i++)
                            <svg viewBox="0 0 24 24" class="w-5 h-5 {{ $i <= round($avgRating) ? 'fill-yellow-400' : 'fill-gray-300' }}">
                                <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.728 1.48 8.266L12 18.896l-7.416 4.404 1.48-8.266L0 9.306l8.332-1.151z"/>
                            </svg>
                        @endfor
                    </div>
                    <div class="text-sm text-gray-500">
                        <div>{{ number_format($avgRating,1) }} / 5</div>
                        <div class="text-xs">{{ $kost->reviews->count() }} ulasan</div>
                    </div>
                </div>
            </div>

            {{-- Fasilitas --}}
            <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <h3 class="font-medium text-gray-800 mb-3">Fasilitas</h3>
                <div class="flex flex-wrap gap-2">
                    @if(!empty($fasilitas))
                        @foreach($fasilitas as $fas)
                            <span class="flex items-center gap-2 text-sm bg-gray-50 border border-gray-100 px-3 py-1 rounded-full shadow-sm">
                                <svg class="w-4 h-4 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.2l-3.5-3.5L4 14.2 9 19l12-12-1.5-1.4z"/>
                                </svg>
                                {{ $fas }}
                            </span>
                        @endforeach
                    @else
                        <span class="text-sm text-gray-400">Tidak ada fasilitas.</span>
                    @endif
                </div>
            </div>

            {{-- Action --}}
            <div class="mt-2">
                <button class="w-full py-3 rounded-xl text-white text-lg font-semibold
                        bg-linear-to-r from-orange-500 to-orange-400 shadow-md hover:shadow-lg transition">
                    Pesan Sekarang
                </button>
            </div>
        </aside>
    </div>

    {{-- Reviews Section --}}
    <section class="mt-12">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Ulasan Penyewa</h2>

        @if($kost->reviews->count())
            <div class="space-y-4">
                @foreach($kost->reviews as $review)
                    <div class="bg-white rounded-xl p-4 shadow-sm border">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ $review->created_at ? $review->created_at->diffForHumans() : '-' }}
                                </p>
                            </div>
                            <div class="flex items-center">
                                @for($i=1;$i<=5;$i++)
                                    <svg viewBox="0 0 24 24" class="w-4 h-4 {{ $i <= $review->rating ? 'fill-yellow-400' : 'fill-gray-300' }}">
                                        <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.728 1.48 8.266L12 18.896l-7.416 4.404 1.48-8.266L0 9.306l8.332-1.151z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <p class="mt-3 text-gray-700 text-sm leading-relaxed">{{ $review->komentar }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Belum ada ulasan.</p>
        @endif
    </section>

    {{-- Review Form (only auth) --}}
    @auth
    <section class="mt-10 bg-white p-6 rounded-2xl shadow-sm border">
        <h3 class="text-lg font-semibold mb-3">Beri Ulasan</h3>

        <form method="POST" action="{{ route('review.store', $kost->id) }}">
            @csrf
            <input type="hidden" name="rating" id="ratingInput">

            <div class="flex items-center gap-2 mb-3">
                @for($i=1;$i<=5;$i++)
                    <button type="button" data-value="{{ $i }}"
                        class="rating-btn w-9 h-9 flex items-center justify-center rounded-lg bg-gray-50 border border-gray-100">
                        <svg viewBox="0 0 24 24" class="w-5 h-5 fill-gray-300">
                            <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.728 1.48 8.266L12 18.896l-7.416 4.404 1.48-8.266L0 9.306l8.332-1.151z"/>
                        </svg>
                    </button>
                @endfor
            </div>

            <textarea name="komentar" rows="4" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-orange-300" placeholder="Ceritakan pengalaman Anda..."></textarea>

            <div class="mt-4 flex justify-end">
                <button type="submit" class="px-6 py-2 rounded-xl bg-orange-500 text-white font-semibold hover:bg-orange-600 transition">
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </section>
    @endauth

</div>

{{-- Rating JS --}}
<script>
    // highlight rating buttons and set hidden input
    document.querySelectorAll('.rating-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            document.getElementById('ratingInput').value = value;

            // reset styles
            document.querySelectorAll('.rating-btn svg').forEach(s => s.classList.replace('fill-yellow-400','fill-gray-300'));
            document.querySelectorAll('.rating-btn').forEach(b => b.classList.remove('bg-yellow-50'));

            // set selected
            for (let i=1; i<=value; i++){
                const b = document.querySelector(`.rating-btn[data-value='${i}'] svg`);
                if (b) b.classList.replace('fill-gray-300','fill-yellow-400');
                const wrapper = document.querySelector(`.rating-btn[data-value='${i}']`);
                if (wrapper) wrapper.classList.add('bg-yellow-50');
            }
        });
    });
</script>

@endsection

@extends('layouts.main')

@section('content')
<section class="py-25 bg-linear-to-b from-white to-gray-100">
    <div class="max-w-7xl mx-auto px-4">

        {{-- BACK --}}
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 mb-10 text-sm font-semibold text-gray-600 hover:text-orange-600 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke daftar kost
        </a>

        {{-- ================= HEADER ================= --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 mb-12">
            <div class="flex flex-col lg:flex-row justify-between gap-8">

                {{-- INFO --}}
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        {{ $kost->nama }}
                    </h1>

                    <p class="text-sm text-gray-500 flex items-center gap-1 mb-3">
                        <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 0a5.53 5.53 0 00-5.5 5.5C2.5 9.75 8 16 8 16s5.5-6.25 5.5-10.5A5.53 5.53 0 008 0z"/>
                            <path d="M8 7.5a2 2 0 110-4 2 2 0 010 4z"/>
                        </svg>
                        {{ $kost->alamat }}
                    </p>

                    {{-- RATING --}}
                    <div class="flex items-center gap-2">
                        <div class="flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= round($kost->reviews->avg('rating')) ? 'fill-yellow-400' : 'fill-gray-300' }}"
                                     viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.568 8.332 1.151
                                             -6.064 5.728 1.48 8.266
                                             L12 18.896l-7.416 4.404
                                             1.48-8.266L0 9.306l8.332-1.151z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500">
                            {{ number_format($kost->reviews->avg('rating') ?? 0, 1) }} / 5
                            ({{ $kost->reviews->count() }} ulasan)
                        </span>
                    </div>
                </div>

                {{-- HARGA --}}
                <div class="text-right">
                    <p class="text-orange-600 font-bold text-3xl">
                        Rp {{ number_format($kost->harga, 0, ',', '.') }}
                    </p>
                    <span class="text-gray-500 text-sm">/ bulan</span>
                </div>
            </div>
        </div>

        {{-- ================= FOTO ================= --}}
        @if (!empty($kost->foto))
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-14">
            @foreach ($kost->foto as $foto)
                <div onclick="openImage('{{ asset($foto) }}')"
                     class="relative group overflow-hidden rounded-3xl cursor-pointer">
                    <img src="{{ asset($foto) }}"
                         class="h-48 w-full object-cover transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition"></div>
                </div>
            @endforeach
        </div>
        @endif

        {{-- ================= FASILITAS ================= --}}
        @if (!empty($kost->fasilitas))
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 mb-12">
            <h2 class="text-xl font-bold mb-6">Fasilitas Kost</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($kost->fasilitas as $f)
                    <div class="flex items-center gap-3 text-sm text-gray-700 border rounded-xl p-3">
                        <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $f }}
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ================= CTA ================= --}}
        <div class="mb-14">
            @auth
                @if(auth()->user()->role === 'user')
                    <form method="POST" action="{{ route('pesanan.store', $kost->id) }}">
                        @csrf
                        <button
                            class="w-full rounded-2xl py-4 font-semibold text-white
                                   bg-linear-to-r from-orange-500 to-orange-400
                                   shadow-[0_4px_12px_rgba(255,140,0,0.25)]
                                   hover:shadow-[0_6px_18px_rgba(255,140,0,0.35)]
                                   hover:-translate-y-0.5 transition">
                            Pesan Kost Sekarang
                        </button>
                    </form>
                @endif
            @else
                {{-- GUEST --}}
                <div class="text-center">
                    <button onclick="openModal()"
                        class="px-6 py-3 rounded-xl font-semibold text-white bg-[#E07B3C] hover:bg-[#cf6f32] transition">
                        Daftar untuk Memesan
                    </button>
                </div>
            @endauth
        </div>

        {{-- ================= FORM ULASAN ================= --}}
        @auth
        @if(auth()->user()->role === 'user')
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 mb-14">
            <h2 class="text-xl font-bold mb-4">Beri Ulasan</h2>

            <form method="POST" action="{{ route('review.store', $kost->id) }}">
                @csrf
                <input type="hidden" name="rating" id="ratingInput">

                <div class="flex gap-2 mb-4">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" class="rating-btn">
                            <svg class="w-7 h-7 fill-gray-300 transition hover:fill-yellow-400"
                                 viewBox="0 0 24 24">
                                <path d="M12 .587l3.668 7.568 8.332 1.151
                                         -6.064 5.728 1.48 8.266
                                         L12 18.896l-7.416 4.404
                                         1.48-8.266L0 9.306l8.332-1.151z"/>
                            </svg>
                        </button>
                    @endfor
                </div>

                <textarea name="komentar" rows="4" required
                          class="w-full border rounded-xl p-3 text-sm focus:ring-orange-500"
                          placeholder="Tulis pengalaman Anda..."></textarea>

                <button class="mt-4 px-6 py-2 bg-orange-500 text-white rounded-xl font-semibold">
                    Kirim Ulasan
                </button>
            </form>
        </div>
        @endif
        @endauth

        {{-- ================= LIST ULASAN ================= --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
            <h2 class="text-xl font-bold mb-6">Ulasan Pengguna</h2>

            @forelse ($kost->reviews->where('is_hidden', false) as $review)
                <div class="border-b pb-5 mb-5 last:border-none">
                    <div class="flex justify-between">
                        <div>
                            <p class="font-semibold">{{ $review->user->name ?? 'Anonim' }}</p>
                            <p class="text-xs text-gray-400">
                                {{ optional($review->created_at)->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-yellow-400' : 'fill-gray-300' }}"
                                     viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.568 8.332 1.151
                                             -6.064 5.728 1.48 8.266
                                             L12 18.896l-7.416 4.404
                                             1.48-8.266L0 9.306l8.332-1.151z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-700">{{ $review->komentar }}</p>
                </div>
            @empty
                <p class="text-gray-500">Belum ada ulasan</p>
            @endforelse
        </div>
    </div>
</section>

{{-- MODAL IMAGE --}}
<div id="imgModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
    <img id="imgPreview" class="max-h-full max-w-full rounded-3xl">
</div>

{{-- SCRIPT --}}
<script>
const modal = document.getElementById('imgModal');
const preview = document.getElementById('imgPreview');

function openImage(src){
    preview.src = src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

modal?.addEventListener('click', () => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
});

const ratingBtns = document.querySelectorAll('.rating-btn');
const ratingInput = document.getElementById('ratingInput');

ratingBtns.forEach((btn, idx) => {
    btn.addEventListener('click', () => {
        ratingInput.value = idx + 1;
        ratingBtns.forEach((b, i) => {
            b.querySelector('svg').classList.toggle('fill-yellow-400', i <= idx);
            b.querySelector('svg').classList.toggle('fill-gray-300', i > idx);
        });
    });
});
</script>
@endsection

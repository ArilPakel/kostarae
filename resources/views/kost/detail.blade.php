@extends('layouts.main')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-25">

    {{-- BACK --}}
    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-xl
              border border-gray-200 bg-white text-sm font-semibold text-gray-600
              hover:text-orange-600 hover:border-orange-300 hover:bg-orange-50
              transition shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke daftar kost
    </a>

    {{-- ================= INFO KOST ================= --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 mb-10">

        <h1 class="text-3xl font-bold text-gray-900 mb-1">
            {{ $kost->nama }}
        </h1>

        <p class="text-sm text-gray-500 flex items-center gap-1 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4 text-orange-500"
                 fill="currentColor"
                 viewBox="0 0 16 16">
                <path d="M8 0a5.53 5.53 0 00-5.5 5.5C2.5 9.75 8 16 8 16s5.5-6.25 5.5-10.5A5.53 5.53 0 008 0z"/>
                <path d="M8 7.5a2 2 0 110-4 2 2 0 010 4z"/>
            </svg>
            {{ $kost->alamat }}
        </p>

        <p class="text-orange-600 font-bold text-2xl mb-2">
            Rp {{ number_format($kost->harga, 0, ',', '.') }}
            <span class="text-gray-500 text-sm font-medium">/bulan</span>
        </p>

        <span class="inline-block mb-4 text-xs px-3 py-1 rounded-full
                     bg-gray-100 text-gray-600 border">
            Tipe: {{ ucfirst($kost->tipe) }}
        </span>

        {{-- FASILITAS --}}
        @if (!empty($kost->fasilitas))
            <div class="mb-6">
                <h3 class="font-semibold text-gray-800 mb-3">Fasilitas</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($kost->fasilitas as $f)
                        <span class="text-xs bg-gray-50 px-3 py-1 rounded-xl
                                     border text-gray-600 shadow-sm">
                            {{ $f }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- FOTO --}}
        @if (!empty($kost->foto) && is_array($kost->foto))
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                @foreach (array_filter($kost->foto) as $foto)
                    @if (is_string($foto))
                        <img src="{{ asset($foto) }}"
                             alt="Foto Kost"
                             class="h-40 w-full object-cover rounded-2xl cursor-pointer
                                    transition duration-300 hover:scale-105"
                             onclick="openImage('{{ asset($foto) }}')">
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    {{-- ================= PESAN ================= --}}
    @auth
        @if (auth()->user()->role === 'user' && auth()->id() !== $kost->pemilik_id)
            <form method="POST" action="{{ route('pesanan.store', $kost->id) }}">
                @csrf
                <button type="submit"
                    class="w-full py-3 rounded-2xl text-sm font-semibold text-white
                           bg-gradient-to-r from-orange-500 to-orange-400
                           shadow-[0_4px_12px_rgba(255,140,0,0.25)]
                           hover:shadow-[0_6px_18px_rgba(255,140,0,0.35)]
                           transition">
                    Pesan Sekarang via WhatsApp
                </button>
            </form>
        @elseif(auth()->id() === $kost->pemilik_id)
            <div class="py-3 text-center bg-gray-100 text-gray-500 rounded-2xl">
                Anda adalah pemilik kost ini
            </div>
        @endif
    @else
        <div class="py-3 text-center bg-gray-100 text-gray-500 rounded-2xl">
            Login untuk memesan kost
        </div>
    @endauth

    {{-- ================= FORM ULASAN ================= --}}
    @auth
        @if (auth()->user()->role !== 'pemilik' && auth()->id() !== $kost->pemilik_id)
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm my-10">
                <h2 class="text-xl font-bold mb-4">Beri Ulasan</h2>

                <form method="POST" action="{{ route('review.store', $kost->id) }}">
                    @csrf
                    <input type="hidden" name="rating" id="ratingInput" required>

                    <div class="flex gap-2 mb-4">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    class="rating-btn p-2 rounded-xl border hover:border-orange-400"
                                    data-value="{{ $i }}">
                                <svg class="w-6 h-6 fill-gray-300" viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.568 8.332 1.151
                                             -6.064 5.728 1.48 8.266
                                             L12 18.896l-7.416 4.404
                                             1.48-8.266L0 9.306l8.332-1.151z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>

                    <textarea name="komentar" rows="4" required
                        class="w-full border rounded-2xl p-3 text-sm focus:ring-orange-500"
                        placeholder="Tulis pengalaman Anda..."></textarea>

                    <div class="text-right mt-4">
                        <button
                            class="px-6 py-2 bg-orange-500 text-white rounded-xl text-sm font-semibold">
                            Kirim Ulasan
                        </button>
                    </div>
                </form>
            </div>
        @endif
    @endauth

    {{-- ================= LIST ULASAN ================= --}}
    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <h2 class="text-xl font-bold mb-6">Ulasan Pengguna</h2>

        @forelse($kost->reviews->where('is_hidden', false) as $review)
            <div class="border-b pb-4 mb-4 last:border-none">
                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">
                            {{ $review->user->name ?? 'Anonim' }}
                        </p>
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

                <p class="mt-2 text-gray-700 text-sm">
                    {{ $review->komentar }}
                </p>
            </div>
        @empty
            <p class="text-gray-500">Belum ada ulasan</p>
        @endforelse
    </div>
</div>

{{-- MODAL IMAGE --}}
<div id="imgModal"
     class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
    <img id="imgPreview" class="max-h-full max-w-full rounded-2xl">
</div>

{{-- SCRIPT --}}
<script>
    const modal = document.getElementById('imgModal');
    const preview = document.getElementById('imgPreview');

    function openImage(src) {
        preview.src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    modal.addEventListener('click', () => {
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

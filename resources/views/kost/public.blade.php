@once
    @push('styles')
    <style>
        /* Utility: Sembunyikan scrollbar tapi tetap bisa di-scroll */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @endpush
@endonce

{{-- =============================================================== --}}
{{-- BAGIAN 1: PROMO SPESIAL (TETAP ADA & PRIORITAS UTAMA) --}}
{{-- =============================================================== --}}
@if(isset($iklanKost) && $iklanKost->count() > 0)
<section class="py-12 md:py-16 bg-white border-b border-[#e5e7eb]">
    <div class="container mx-auto px-4">
        
        {{-- Header Section Promo --}}
        <div class="flex items-center justify-center md:justify-start gap-3 mb-8 border-b border-[#e5e7eb] pb-4">
            <h2 class="text-xl md:text-2xl font-bold text-[#1e293b]">Promo Spesial</h2>
            {{-- Ikon Api/Promo --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff7a00" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
        </div>

        @php
            $countPromo = $iklanKost->count();
            // LOGIKA TAMPILAN PROMO:
            // < 4 item  : Flex Center (Rapi di tengah, tidak rata kiri kosong)
            // >= 4 item : Slider Horizontal (Agar muat banyak tanpa scroll halaman ke bawah)
            $layoutClass = ($countPromo < 4) 
                ? 'flex-wrap justify-center' 
                : 'flex-nowrap overflow-x-auto justify-start snap-x snap-mandatory pb-6 scrollbar-hide';
        @endphp

        <div class="flex gap-6 {{ $layoutClass }} -mx-4 px-4 md:mx-0 md:px-0">
            @foreach ($iklanKost as $item)
                {{-- Memanggil Card dengan Badge PROMO --}}
                <div class="flex-none w-[85vw] md:w-[280px]">
                    @include('partials.single-card', ['item' => $item, 'badge' => 'PROMO'])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- =============================================================== --}}
{{-- BAGIAN 2: REKOMENDASI KOST TERBAIK --}}
{{-- =============================================================== --}}
@php
    // Fallback variable
    $finalList = $rekomendasiKost ?? $kosts ?? collect([]);
    $recCount = $finalList->count();
@endphp

<section class="py-12 md:py-16 bg-[#f8fafc]">
    <div class="container mx-auto px-4">
        
        {{-- Header Section Rekomendasi --}}
        <div class="mb-10 text-center max-w-2xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold text-[#1e293b] mb-2">Rekomendasi Kost Terbaik</h2>
            <p class="text-gray-500 text-sm md:text-base">Pilihan favorit mahasiswa dengan fasilitas lengkap</p>
        </div>

        @if($recCount > 0)
            {{-- LOGIKA TAMPILAN REKOMENDASI: --}}
            @if($recCount < 4)
                {{-- SEDIKIT DATA: Flex Center (Agar 1-3 item presisi di tengah) --}}
                <div class="flex flex-wrap justify-center gap-6 mb-12">
                     @foreach ($finalList as $item)
                        <div class="w-full md:w-[280px]">
                            @include('partials.single-card', ['item' => $item, 'badge' => null])
                        </div>
                    @endforeach
                </div>
            @else
                {{-- BANYAK DATA: Grid System (Agar rapi 4 kolom) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    @foreach ($finalList as $item)
                        @include('partials.single-card', ['item' => $item, 'badge' => null])
                    @endforeach
                </div>
            @endif

            {{-- CTA Button --}}
            <div class="flex justify-center pb-8">
                <a href="{{ url('/kost') }}" class="group inline-flex items-center gap-3 bg-[#ff7a00] text-white px-8 py-3.5 rounded-xl hover:bg-[#e06900] transition-all font-bold shadow-md transform hover:-translate-y-0.5">
                    <span>Lihat Semua Kost</span>
                    <svg class="group-hover:translate-x-1 transition-transform" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>

        @else
            {{-- EMPTY STATE (Jika data kosong) --}}
            <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-50 rounded-full mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Belum ada rekomendasi saat ini</h3>
                <p class="text-gray-500 text-sm mt-1">Silakan cek kembali nanti atau telusuri semua kost.</p>
                <a href="{{ url('/kost') }}" class="mt-4 inline-block text-[#ff7a00] font-semibold hover:underline">Telusuri Kost &rarr;</a>
            </div>
        @endif

    </div>
</section>
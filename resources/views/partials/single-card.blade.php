@php
    // --- LOGIC GAMBAR & DATA ---
    $imagePath = 'assets/images/placeholder.jpg';
    
    // Logic fallback gambar (dipertahankan)
    if ($item->relationLoaded('kostImages') && $item->kostImages->count() > 0) {
        $imagePath = 'storage/' . $item->kostImages->first()->path;
    } elseif (!empty($item->foto)) {
        $rawFoto = $item->foto;
        if (is_string($rawFoto)) {
            $decoded = json_decode($rawFoto, true);
            if (is_array($decoded)) $rawFoto = $decoded;
        }
        if (!is_array($rawFoto)) $rawFoto = [];
        $candidate = $rawFoto[0] ?? null;
        if (is_array($candidate) && isset($candidate['path'])) {
            $imagePath = 'storage/' . $candidate['path'];
        } elseif (is_string($candidate)) {
            $imagePath = 'storage/' . $candidate;
        }
    }
    $imageSrc = asset($imagePath);

    $fasilitas = is_string($item->fasilitas) ? json_decode($item->fasilitas, true) : ($item->fasilitas ?? []);
@endphp

{{-- CARD CONTAINER --}}
{{-- [FIX 1] Pastikan parent grid menggunakan 'items-stretch' --}}
<div class="relative w-full bg-white border border-[#e5e7eb] rounded-[16px] overflow-hidden hover:shadow-lg transition-all duration-300 group flex flex-col h-full">
    
    {{-- IMAGE AREA (4:3 Ratio) --}}
    {{-- [FIX 2] Tambah 'shrink-0' agar gambar tidak gepeng jika teks kepanjangan --}}
    <div class="relative aspect-[4/3] bg-gray-100 overflow-hidden shrink-0">
        <img src="{{ $imageSrc }}" alt="{{ $item->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        
        {{-- BADGE --}}
        @if(isset($badge) && $badge == 'PROMO')
            <div class="absolute top-3 left-3">
                <span class="bg-[#ff7a00] text-white text-[10px] font-bold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1">PROMO</span>
            </div>
        @else
            <div class="absolute top-3 left-3">
                <span class="bg-[#1f3f46]/90 backdrop-blur text-white text-[10px] font-medium px-2.5 py-1 rounded-full shadow-sm">Tersedia</span>
            </div>
        @endif

        {{-- RATING --}}
        @if(isset($item->reviews_avg_rating))
        <div class="absolute top-3 right-3">
            <div class="bg-white/95 px-2 py-1 rounded-lg shadow-sm flex items-center gap-1">
                <svg class="text-yellow-400 w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                <span class="text-xs font-bold text-[#1e293b]">{{ number_format($item->reviews_avg_rating, 1) }}</span>
            </div>
        </div>
        @endif
    </div>

    {{-- CONTENT WRAPPER --}}
    <div class="p-4 flex flex-col flex-grow">
        
        {{-- Judul --}}
        {{-- [FIX 3] Beri margin bottom fix agar jarak ke alamat konsisten --}}
        <div class="mb-1">
            <h3 class="text-base font-semibold text-[#1e293b] truncate" title="{{ $item->nama }}">
                {{ $item->nama ?? $item->nama_kost }}
            </h3>
        </div>

        {{-- Alamat --}}
        {{-- [FIX 4] Beri 'h-[20px]' agar tinggi baris alamat selalu sama --}}
        <div class="flex items-start gap-1.5 text-[#64748b] text-xs mb-3 h-[20px]">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 mt-0.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <span class="truncate">{{ $item->alamat }}</span>
        </div>

        {{-- Fasilitas (Limit 2) --}}
        {{-- [FIX 5] INI KUNCINYA: 'min-h-[28px]' --}}
        {{-- Ini memaksa area fasilitas punya tinggi minimal, walau datanya kosong --}}
        <div class="min-h-[28px] mb-2">
            @if (!empty($fasilitas))
                <div class="flex flex-wrap gap-1">
                    @foreach (array_slice($fasilitas, 0, 2) as $f)
                        <span class="text-[10px] bg-gray-50 text-gray-600 px-2 py-1 rounded-md border border-gray-200 flex items-center gap-1 max-w-[100px] truncate">
                            <svg width="6" height="6" viewBox="0 0 24 24" fill="#1f3f46"><circle cx="12" cy="12" r="12"/></svg>
                            {{ $f }}
                        </span>
                    @endforeach
                    @if (count($fasilitas) > 2)
                        <span class="text-[10px] text-gray-400 px-1 py-1">+{{ count($fasilitas) - 2 }}</span>
                    @endif
                </div>
            @else
                {{-- Placeholder text (Opsional, agar tidak terlihat bolong) --}}
                <span class="text-[10px] text-gray-300 italic">Fasilitas standar</span>
            @endif
        </div>

        {{-- FOOTER & PRICE --}}
        {{-- 'mt-auto' mendorong footer ke dasar card --}}
        <div class="mt-auto pt-3 border-t border-[#e5e7eb]">
            <div class="flex justify-between items-end mb-2">
                <div>
                    @if(isset($badge) && $badge == 'PROMO')
                        <p class="text-[10px] text-gray-400 line-through">Rp {{ number_format($item->harga * 1.1, 0, ',', '.') }}</p>
                    @endif
                    <p class="text-[#ff7a00] text-lg font-bold">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </p>
                </div>
                <span class="text-[10px] text-gray-400 mb-1">/bln</span>
            </div>
            
            <a href="{{ route('kost.detail', $item->id) }}" class="block w-full bg-[#ff7a00] hover:bg-[#e06900] text-white text-center py-2.5 rounded-[12px] transition-all text-sm font-medium shadow-sm">
                Lihat Detail
            </a>
        </div>
    </div>
</div>
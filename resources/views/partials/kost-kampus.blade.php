<section class="py-10 bg-gray-100">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-[#2D4A53]">
                Kost Sekitar Kampus
            </h2>
        </div>

        <!-- List Kampus -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5 justify-center">
            @php
                $kampus = [
                    ['logo' => 'iain.png', 'nama' => 'IAIN', 'alt' => 'IAIN'],
                    ['logo' => 'ias.png', 'nama' => 'IAS', 'alt' => 'IAS'],
                    ['logo' => 'ith.png', 'nama' => 'ITH', 'alt' => 'ITH'],
                    ['logo' => 'unm.png', 'nama' => 'UNM', 'alt' => 'UNM'],
                    ['logo' => 'umpar.png', 'nama' => 'UMPAR', 'alt' => 'UMPAR'],
                ];
            @endphp

            @foreach ($kampus as $item)
                <div class="bg-white rounded-xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer text-center">
                    <img src="{{ asset('images/' . $item['logo']) }}"
                         alt="{{ $item['alt'] }}"
                         class="mx-auto mb-3 w-20 h-20 sm:w-16 sm:h-16 object-contain">
                    <h6 class="font-semibold text-gray-800">
                        {{ $item['nama'] }}
                    </h6>
                </div>
            @endforeach
        </div>
    </div>
</section>

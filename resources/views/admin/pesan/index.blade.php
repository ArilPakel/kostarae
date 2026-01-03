@extends('admin.layouts')

@section('content')
<div class="p-6">
    <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kotak Masuk Laporan</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola pertanyaan, keluhan, dan masukan dari pengguna.</p>
        </div>
        <div class="bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm text-sm text-gray-600">
            Total Pesan: <span class="font-bold text-[#2D4A53]">{{ $reports->count() }}</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase text-gray-400 font-semibold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Pengirim</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4 w-1/2">Pesan</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($reports as $rpt)
                    <tr class="hover:bg-blue-50/30 transition duration-150 group">
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                    {{ substr($rpt->name, 0, 1) }}
                                </div>
                                <span class="font-semibold text-gray-700 text-sm">{{ $rpt->name }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                <a href="mailto:{{ $rpt->email }}" class="text-xs text-blue-600 hover:underline flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    {{ $rpt->email }}
                                </a>
                                <a href="https://wa.me/{{ $rpt->phone }}" target="_blank" class="text-xs text-green-600 hover:underline flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    {{ $rpt->phone }}
                                </a>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div x-data="{ expanded: false }">
                                <p class="text-sm text-gray-600 leading-relaxed" 
                                   :class="expanded ? '' : 'line-clamp-2'">
                                    {{ $rpt->message }}
                                </p>
                                @if(strlen($rpt->message) > 100)
                                    <button @click="expanded = !expanded" class="text-xs text-[#E07B3C] font-semibold mt-1 hover:underline focus:outline-none">
                                        <span x-show="!expanded">Baca Selengkapnya</span>
                                        <span x-show="expanded">Tutup</span>
                                    </button>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-xs text-gray-400 font-medium">
                                {{ $rpt->created_at->format('d M, H:i') }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                             <button class="text-gray-300 hover:text-red-500 transition p-2 rounded-full hover:bg-red-50 opacity-0 group-hover:opacity-100" title="Hapus Pesan">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                             </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p>Tidak ada pesan masuk.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection
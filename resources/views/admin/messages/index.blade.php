@extends('admin.layouts')

@section('content')
<div class="space-y-6">
    
    {{-- NAVIGASI BALIK (DITAMBAHKAN) --}}
    <div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600 transition font-medium mb-4">
            <span>⬅️</span> Kembali
        </a>
    </div>

    {{-- Header --}}
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                💬 Kotak Masuk
            </h1>
            <p class="text-sm text-gray-500 mt-1">Laporan dan pesan masuk dari pengguna.</p>
        </div>
    </div>

    {{-- Tabel Pesan --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-semibold uppercase tracking-wider text-xs">
                    <tr>
                        <th class="px-6 py-4">Pengirim</th>
                        <th class="px-6 py-4">Kontak & Pesan</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($messages as $msg)
                    <tr class="hover:bg-indigo-50/30 transition group">
                        
                        {{-- Pengirim --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm shadow-sm">
                                    {{ substr($msg->name ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">{{ $msg->name }}</div>
                                    <div class="text-xs text-gray-400">ID: #{{ $msg->id }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Kontak & Isi Pesan (No Subject) --}}
                        <td class="px-6 py-4 max-w-md">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-green-50 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-green-100">
                                    📞 {{ $msg->phone ?? '-' }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-xs truncate leading-relaxed">
                                {{ Str::limit($msg->message, 60) }}
                            </p>
                        </td>

                        {{-- Waktu --}}
                        <td class="px-6 py-4 whitespace-nowrap text-gray-400 text-xs font-medium">
                            {{ $msg->created_at->diffForHumans() }}
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.messages.show', $msg->id) }}" 
                                   title="Baca Detail"
                                   class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 hover:scale-105 transition shadow-sm">
                                    👁️
                                </a>
                                
                                {{-- Tombol Hapus (Trigger Modal) --}}
                                <button type="button"
                                        @click="$dispatch('open-delete-modal', { 
                                            nama: 'Pesan dari {{ $msg->name }}', 
                                            pemilik: '{{ $msg->phone }}',
                                            route: '{{ route('admin.messages.destroy', $msg->id) }}' 
                                        })"
                                        title="Hapus Laporan"
                                        class="w-9 h-9 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:scale-105 transition shadow-sm">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl grayscale opacity-50">📭</div>
                            <p class="font-medium text-sm">Tidak ada laporan masuk.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $messages->links() }}
        </div>
    </div>
</div>
@endsection
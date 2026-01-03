@extends('admin.layouts')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    
    {{-- NAVIGASI KEMBALI --}}
    <div class="mb-6">
        <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600 transition font-bold px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100 hover:shadow-md">
            <span>⬅️</span> Kembali ke Kotak Masuk
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- KARTU UTAMA: ISI PESAN --}}
        <div class="md:col-span-2 bg-white rounded-3xl p-8 border border-gray-100 shadow-sm relative">
            
            {{-- Header Pengirim --}}
            <div class="flex items-start justify-between border-b border-gray-50 pb-6 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-2xl shadow-inner">
                        {{ substr($message->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ $message->name }}</h1>
                        <p class="text-gray-400 text-xs mt-1 font-medium">
                            Diterima: {{ $message->created_at->format('d F Y, H:i') }}
                        </p>
                    </div>
                </div>
                
                {{-- Status / Waktu --}}
                <span class="px-3 py-1 rounded-full bg-gray-50 text-gray-500 text-xs font-bold border border-gray-100">
                    {{ $message->created_at->diffForHumans() }}
                </span>
            </div>

            {{-- Isi Laporan (Tanpa Subjek) --}}
            <div class="prose prose-sm max-w-none">
                <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Isi Laporan / Pesan</h3>
                <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100 text-gray-700 leading-relaxed text-base">
                    "{{ $message->message }}"
                </div>
            </div>
        </div>

        {{-- SIDEBAR: KONTAK & AKSI --}}
        <div class="space-y-6">
            
            {{-- Kartu Kontak --}}
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
                <div class="w-16 h-16 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm">
                    📞
                </div>
                <h3 class="font-bold text-gray-800 text-lg">{{ $message->phone ?? '-' }}</h3>
                <p class="text-gray-400 text-xs mb-6">Nomor Telepon Pengirim</p>

                {{-- Logic PHP: Ubah format 08 ke 628 untuk Link WA --}}
                @php
                    $phone = $message->phone;
                    // Hapus karakter non-angka
                    $phone = preg_replace('/[^0-9]/', '', $phone);
                    // Jika diawali 0, ganti dengan 62
                    if(Str::startsWith($phone, '0')) {
                        $phone = '62' . substr($phone, 1);
                    }
                @endphp

                <a href="https://wa.me/{{ $phone }}" target="_blank" 
                   class="w-full py-3 rounded-xl bg-green-500 text-white font-bold text-sm hover:bg-green-600 shadow-lg shadow-green-200 transition flex items-center justify-center gap-2 transform hover:-translate-y-1">
                    💬 Balas via WhatsApp
                </a>
                
                @if($message->email)
                <div class="mt-4 pt-4 border-t border-gray-50">
                    <p class="text-xs text-gray-500 mb-1">Alternatif Email:</p>
                    <a href="mailto:{{ $message->email }}" class="text-indigo-600 font-bold text-xs hover:underline">
                        {{ $message->email }}
                    </a>
                </div>
                @endif
            </div>

            {{-- Kartu Hapus --}}
            <div class="bg-red-50/30 rounded-3xl p-6 border border-red-50 text-center">
                <p class="text-xs text-red-400 mb-4">Tindakan Berbahaya</p>
                
                <button type="button" 
                        @click="$dispatch('open-delete-modal', { 
                            nama: 'Pesan dari {{ $message->name }}', 
                            pemilik: 'Data ini tidak bisa dikembalikan',
                            route: '{{ route('admin.messages.destroy', $message->id) }}' 
                        })"
                        class="w-full py-3 rounded-xl bg-white text-red-600 font-bold text-sm border border-red-100 hover:bg-red-50 transition flex items-center justify-center gap-2">
                    🗑️ Hapus Laporan
                </button>
            </div>

        </div>
    </div>
</div>
@endsection
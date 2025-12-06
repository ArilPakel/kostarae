@extends('layouts.owner')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-[#2D3A42]">Daftar Kost Anda</h2>
</div>

@if($kosts->isEmpty())
    <div class="bg-white p-6 rounded-xl shadow text-center text-gray-500">
        Anda belum memiliki kost.
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($kosts as $k)
        <div class="bg-white rounded-xl shadow p-4 border">

            {{-- Nama Kost --}}
            <h3 class="font-bold text-lg">{{ $k->nama }}</h3>
            <p class="text-gray-600 text-sm">{{ $k->alamat }}</p>
            <p class="mt-2 font-semibold text-[#2D3A42]">
                Rp {{ number_format($k->harga) }}/bulan
            </p>

            {{-- STATUS BADGE --}}
            @if ($k->status == 'pending')
                <span class="inline-block mt-2 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">
                    Menunggu Verifikasi
                </span>

            @elseif ($k->status == 'aktif')
                <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                    Disetujui
                </span>

            @elseif ($k->status == 'ditolak')
                <span class="inline-block mt-2 px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">
                    Ditolak
                </span>

                {{-- ALASAN PENOLAKAN --}}
                <div class="px-3 py-2 bg-red-100 text-red-700 border border-red-300 rounded-xl text-sm mt-3">
                    <strong>Alasan Ditolak:</strong><br>
                    {{ $k->alasan_penolakan ?? 'Tidak ada alasan diberikan.' }}
                </div>
            @endif

            {{-- Tombol Aksi --}}
            <div class="flex justify-between mt-4">
                <a href="{{ route('pemilik.kost.edit', $k->id) }}"
                   class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm">
                    Edit
                </a>

                <form action="{{ route('pemilik.kost.destroy', $k->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus kost?')">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                        Hapus
                    </button>
                </form>
            </div>

        </div>
        @endforeach
    </div>
@endif

@endsection

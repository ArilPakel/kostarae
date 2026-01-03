@extends('admin.layouts')
@section('title', 'Detail Mitra Pemilik')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.owners.index') }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50">
            ← Kembali
        </a>
        <h1 class="text-xl font-bold text-gray-900">Detail Mitra: {{ $owner->name }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kiri: Profil --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm h-fit">
            <div class="text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-3xl mb-3">
                    {{ substr($owner->name, 0, 1) }}
                </div>
                <h3 class="font-bold text-lg">{{ $owner->name }}</h3>
                <p class="text-gray-500 text-sm">{{ $owner->email }}</p>
                <p class="text-gray-500 text-sm mt-1">{{ $owner->phone ?? 'No WA -' }}</p>
            </div>
            <hr class="my-4 border-gray-100">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase mb-2">Catatan Admin</p>
                <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-100 text-sm text-gray-700 italic">
                    "{{ $owner->admin_notes ?? 'Belum ada catatan.' }}"
                </div>
            </div>
        </div>

        {{-- Kanan: Daftar Kost --}}
        <div class="lg:col-span-2 space-y-4">
            <h3 class="font-bold text-gray-800">Daftar Kost Milik {{ $owner->name }}</h3>
            
            @forelse($owner->kosts as $kost)
            <div class="bg-white p-4 rounded-xl border border-gray-200 flex flex-col md:flex-row gap-4 items-start hover:shadow-md transition">
                <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                    @php 
                        $foto = is_array($kost->foto) ? ($kost->foto[0]['path'] ?? $kost->foto[0]) : $kost->foto; 
                    @endphp
                    <img src="{{ asset('storage/'.$foto) }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-gray-900">{{ $kost->nama }}</h4>
                    <p class="text-xs text-gray-500 mb-2">{{ $kost->alamat }}</p>
                    
                    @if($kost->status == 'diterima')
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded">Aktif</span>
                    @elseif($kost->status == 'pending')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded">Pending</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded">Ditolak</span>
                    @endif
                </div>
                <a href="{{ route('admin.kost.show', $kost->id) }}" class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-50">Lihat</a>
            </div>
            @empty
            <div class="text-center py-10 text-gray-400 bg-white rounded-xl border border-dashed border-gray-200">
                Belum ada kost yang didaftarkan.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
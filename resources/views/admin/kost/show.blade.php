@extends('admin.layouts')

@section('title', 'Detail Data Kost')

@section('content')
<div class="space-y-6">
    {{-- HEADER & TOMBOL KEMBALI --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.kost.index') }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $kost->nama }}</h1>
                <p class="text-sm text-gray-500 flex items-center gap-1">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $kost->alamat }}
                </p>
            </div>
        </div>
        
        {{-- STATUS BADGE --}}
        <div>
            @if($kost->status == 'diterima')
                <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold text-sm border border-green-200 shadow-sm flex items-center gap-2">
                    ✅ Terverifikasi
                </span>
            @elseif($kost->status == 'pending')
                <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 font-bold text-sm border border-yellow-200 shadow-sm flex items-center gap-2">
                    ⏳ Menunggu Verifikasi
                </span>
            @else
                <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 font-bold text-sm border border-red-200 shadow-sm flex items-center gap-2">
                    ❌ Ditolak
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: GALERI & DESKRIPSI --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- GALERI FOTO --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Galeri Foto
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @php
                        // Handle foto format JSON atau Array
                        $fotos = is_array($kost->foto) ? $kost->foto : json_decode($kost->foto, true);
                    @endphp
                    
                    @if(!empty($fotos))
                        @foreach($fotos as $foto)
                            @php 
                                $path = is_array($foto) ? ($foto['path'] ?? null) : $foto; 
                            @endphp
                            @if($path)
                                <div class="relative group h-48 rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
                                    <img src="{{ asset('storage/'.$path) }}" alt="Foto Kost" class="w-full h-full object-cover transition transform group-hover:scale-105 duration-300">
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="col-span-full py-10 text-center text-gray-400 bg-gray-50 rounded-xl border-dashed border-2 border-gray-200">
                            Tidak ada foto tersedia
                        </div>
                    @endif
                </div>
            </div>

            {{-- DESKRIPSI & FASILITAS --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                <h3 class="font-bold text-gray-800 mb-3">Deskripsi</h3>
                <div class="text-gray-600 leading-relaxed mb-6 prose max-w-none">
                    {{ $kost->deskripsi ?? 'Tidak ada deskripsi yang tersedia.' }}
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h3 class="font-bold text-gray-800 mb-3">Fasilitas</h3>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $fasilitas = is_array($kost->fasilitas) ? $kost->fasilitas : json_decode($kost->fasilitas, true);
                        @endphp
                        @if(!empty($fasilitas))
                            @foreach($fasilitas as $item)
                                <span class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium border border-blue-100 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    {{ $item }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-gray-400 italic text-sm">Tidak ada data fasilitas</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: INFO HARGA, PEMILIK, & AKSI --}}
        <div class="space-y-6">
            
            {{-- CARD HARGA --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                <p class="text-sm text-gray-500 mb-1 font-medium uppercase tracking-wide">Harga Sewa</p>
                <div class="flex items-baseline gap-1">
                    <h2 class="text-3xl font-extrabold text-indigo-600">
                        Rp {{ number_format($kost->harga, 0, ',', '.') }}
                    </h2>
                    <span class="text-sm text-gray-500 font-medium">/ {{ ucfirst($kost->tipe) }}</span>
                </div>
            </div>

            {{-- CARD PEMILIK --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-3 flex justify-between items-center">
                    <span>Informasi Pemilik</span>
                    <a href="{{ route('admin.owners.show', $kost->pemilik_id) }}" class="text-xs text-blue-600 hover:underline">Lihat Profil</a>
                </h3>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg border border-indigo-100">
                        {{ substr($kost->pemilik->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <div class="font-bold text-gray-900">{{ $kost->pemilik->name ?? 'Unknown' }}</div>
                        <div class="text-xs text-gray-500">{{ $kost->pemilik->email ?? '-' }}</div>
                    </div>
                </div>
                
                @if($kost->pemilik && $kost->pemilik->phone)
                    @php $wa = preg_replace('/^0/', '62', $kost->pemilik->phone); @endphp
                    <a href="https://wa.me/{{ $wa }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 bg-green-50 text-green-700 text-center rounded-xl font-bold hover:bg-green-100 transition border border-green-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.637 3.891 1.685 5.453l-1.108 4.041 3.913-1.193z"/></svg>
                        Chat WhatsApp
                    </a>
                @else
                    <button disabled class="flex items-center justify-center gap-2 w-full py-2.5 bg-gray-100 text-gray-400 text-center rounded-xl font-bold cursor-not-allowed">
                        No WA Tidak Tersedia
                    </button>
                @endif
            </div>

            {{-- CARD AKSI ADMIN --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4">Tindakan Admin</h3>
                
                <div class="space-y-3">
                    {{-- TOMBOL TERIMA (Jika Pending/Ditolak) --}}
                    @if($kost->status == 'pending' || $kost->status == 'ditolak')
                        <form action="{{ route('admin.kost.approve', $kost->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition shadow-sm hover:shadow-md flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Terima Pengajuan
                            </button>
                        </form>
                    @endif

                    {{-- TOMBOL TOLAK (Jika Pending/Diterima) --}}
                    @if($kost->status == 'pending' || $kost->status == 'diterima')
                        <button onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="w-full py-3 bg-white border-2 border-red-100 text-red-600 rounded-xl font-bold hover:bg-red-50 hover:border-red-200 transition flex justify-center items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Tolak Pengajuan
                        </button>
                    @endif

                    <div class="pt-2 border-t border-gray-100 mt-2">
                        <form action="{{ route('admin.kost.destroy', $kost->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus permanen? Tindakan ini tidak bisa dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-2 text-gray-400 hover:text-red-600 text-sm font-medium transition flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Data Permanen
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL TOLAK --}}
<div id="rejectModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform transition-all scale-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Alasan Penolakan</h3>
        <form action="{{ route('admin.kost.reject', $kost->id) }}" method="POST">
            @csrf
            <textarea name="alasan" rows="4" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 p-3 bg-gray-50 placeholder-gray-400" placeholder="Tulis alasan kenapa kost ini ditolak..." required></textarea>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-bold shadow-sm">Kirim Penolakan</button>
            </div>
        </form>
    </div>
</div>
@endsection
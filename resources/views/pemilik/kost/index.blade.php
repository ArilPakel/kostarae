@extends('layouts.main')

@section('content')
    <div class="min-h-screen bg-gray-50/50 py-10 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">

            {{-- =========================================================
           1. HEADER DASHBOARD PEMILIK
        ========================================================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="h-28 bg-[#2D4A53] relative overflow-hidden">
                    <div
                        class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]">
                    </div>
                </div>

                <div class="px-8 pb-6 flex flex-col md:flex-row items-start md:items-end -mt-10 gap-6">

                    {{-- Avatar --}}
                    <div class="relative flex-shrink-0">
                        <img src="{{ Auth::user()->avatar
                            ? asset('storage/' . Auth::user()->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=2D4A53&color=fff&bold=true' }}"
                            class="w-24 h-24 rounded-full border-[5px] border-white shadow-md object-cover bg-white">
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 w-full">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">
                                    Halo, {{ explode(' ', Auth::user()->name)[0] }} 👋
                                </h1>
                                <p class="text-sm text-gray-500">
                                    Kelola seluruh kost yang Anda miliki dari satu dashboard.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- =========================================================
           2. STATISTIK RINGKAS
        ========================================================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">

                <div class="bg-white p-5 rounded-2xl border shadow-sm">
                    <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Total Kost</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $kosts->count() }}</p>
                </div>

                <div class="bg-white p-5 rounded-2xl border shadow-sm">
                    <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Kost Aktif</p>
                    <p class="text-2xl font-bold text-emerald-600">
                        {{ $kosts->where('status', 'aktif')->count() }}
                    </p>
                </div>

                <div class="bg-white p-5 rounded-2xl border shadow-sm">
                    <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-orange-500">
                        {{ $kosts->where('status', 'pending')->count() }}
                    </p>
                </div>
            </div>

            {{-- =========================================================
           3. GRID LIST KOST
        ========================================================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($kosts as $kost)
                    @php

                        $foto = is_array($kost->foto) ? $kost->foto : json_decode($kost->foto, true);

                        $image = $foto[0] ?? 'kost/default.jpg'; // default di folder storage/app/public/kost/default.jpg
                    @endphp


                    <div
                        class="bg-white rounded-2xl border shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">

                        {{-- Image --}}
                        <div class="relative h-36">
                            <img src="{{ asset($image) }}" class="w-full h-full object-cover">

                            <span
                                class="absolute top-2 left-2 px-3 py-0.5 text-[10px] font-bold rounded-full
                @if ($kost->status === 'aktif') bg-emerald-600
                @elseif($kost->status === 'pending') bg-orange-500
                @else bg-red-500 @endif text-white">
                                {{ strtoupper($kost->status) }}
                            </span>
                        </div>

                        {{-- Body --}}
                        <div class="p-4 flex flex-col flex-1 justify-between">

                            <div>
                                <h3 class="text-sm font-bold text-gray-900 truncate">{{ $kost->nama }}</h3>
                                <p class="text-xs text-gray-500 mt-1">{{ $kost->alamat }}</p>
                            </div>

                            <div class="mt-4 pt-3 border-t flex items-center justify-between">
                                <span class="text-sm font-bold text-orange-600">
                                    Rp {{ number_format($kost->harga, 0, ',', '.') }}
                                </span>

                                <div class="flex gap-2">
                                    <a href="{{ route('pemilik.kost.edit', $kost->id) }}"
                                        class="px-3 py-1.5 text-[11px] font-bold text-orange-600 border border-orange-200 rounded-lg hover:bg-orange-50">
                                        Edit
                                    </a>

                                    <form action="{{ route('pemilik.kost.destroy', $kost->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus kost ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-3 py-1.5 text-[11px] font-bold text-red-600 border border-red-200 rounded-lg hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 text-gray-400">
                        Belum ada kost yang terdaftar.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection

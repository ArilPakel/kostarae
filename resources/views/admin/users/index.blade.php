@extends('admin.layouts')

@section('content')
<div class="space-y-6">

    {{-- HEADER & PENCARIAN --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                👤 Data Pengguna
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Total Pengguna: <span class="font-bold text-indigo-600">{{ $users->total() }}</span>
            </p>
        </div>

        {{-- Search Bar (Updated Design) --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="relative w-full md:w-72">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau no wa..." 
                   class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm transition">
            <div class="absolute left-3 top-2.5 text-gray-400">🔍</div>
        </form>
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
        
        {{-- Filter Cepat (Visual Helper) --}}
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex gap-2 overflow-x-auto">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-indigo-600 transition">
                Semua
            </a>
            {{-- Anda bisa mengaktifkan filter ini jika controller mendukung --}}
            <a href="{{ route('admin.users.index', ['role' => 'pemilik']) }}" class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white border-gray-200 text-purple-600 hover:border-purple-300 hover:bg-purple-50 transition">
                👑 Pemilik Kost
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'pencari']) }}" class="px-4 py-1.5 rounded-full text-xs font-bold border bg-white border-gray-200 text-blue-600 hover:border-blue-300 hover:bg-blue-50 transition">
                🔍 Pencari Kos
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-semibold uppercase tracking-wider text-xs">
                    <tr>
                        <th class="px-6 py-4">Profil Pengguna</th>
                        <th class="px-6 py-4">Kontak WhatsApp</th>
                        <th class="px-6 py-4 text-center">Role</th>
                        <th class="px-6 py-4">Bergabung</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                    <tr class="hover:bg-indigo-50/30 transition group">
                        
                        {{-- PROFIL --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                {{-- Avatar Inisial --}}
                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm shadow-sm border border-indigo-50">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- KONTAK (Style Hijau Emerald) --}}
                        <td class="px-6 py-4">
                            @if(!empty($user->phone))
                                @php 
                                    $phone = $user->phone;
                                    // Bersihkan dan format ke WA (Logic lama dipertahankan)
                                    $waPhone = preg_replace('/[^0-9]/', '', $phone);
                                    if(substr($waPhone, 0, 1) == '0') $waPhone = '62' . substr($waPhone, 1);
                                @endphp
                                <a href="https://wa.me/{{ $waPhone }}" target="_blank" 
                                   class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold px-3 py-1 rounded-full border border-emerald-100 hover:bg-emerald-100 transition shadow-sm">
                                    📞 {{ $user->phone }}
                                </a>
                            @else
                                <span class="text-gray-400 text-xs italic bg-gray-50 px-2 py-1 rounded-md">- Kosong -</span>
                            @endif
                        </td>

                        {{-- ROLE BADGE --}}
                        <td class="px-6 py-4 text-center">
                            @php
                                $roleClass = match(strtolower($user->role)) {
                                    'admin' => 'bg-red-50 text-red-700 border-red-100',
                                    'pemilik', 'owner' => 'bg-purple-50 text-purple-700 border-purple-100',
                                    default => 'bg-blue-50 text-blue-700 border-blue-100' // Pencari
                                };
                                $roleIcon = match(strtolower($user->role)) {
                                    'admin' => '🛡️',
                                    'pemilik', 'owner' => '👑',
                                    default => '🔍'
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-bold border {{ $roleClass }}">
                                {{ $roleIcon }} {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        {{-- TANGGAL JOIN --}}
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-xs">
                            {{ $user->created_at->format('d M Y') }}
                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                
                                {{-- Edit (Menggunakan route yang ada di kode lama) --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   title="Edit Data"
                                   class="w-9 h-9 flex items-center justify-center rounded-full bg-amber-50 text-amber-600 hover:bg-amber-100 hover:scale-105 transition shadow-sm border border-amber-100">
                                    ✏️
                                </a>

                                {{-- Hapus User (Trigger Modal) --}}
                                @if(auth()->id() !== $user->id) 
                                <button type="button"
                                        @click="$dispatch('open-delete-modal', { 
                                            nama: '{{ $user->name }}', 
                                            pemilik: 'Role: {{ $user->role }}',
                                            route: '{{ route('admin.users.destroy', $user->id) }}' 
                                        })"
                                        title="Hapus Pengguna"
                                        class="w-9 h-9 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:scale-105 transition shadow-sm border border-red-100">
                                    🗑️
                                </button>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl grayscale opacity-50">👤</div>
                            <p class="font-medium text-sm">Data pengguna tidak ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- PAGINATION --}}
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
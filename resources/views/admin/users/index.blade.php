@extends('admin.layouts')
@section('title', 'Manajemen Data Pengguna')

@section('content')
<div class="space-y-8">

    {{-- HEADER & PENCARIAN --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                {{-- ICON: User Group (Ganti 👤) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-indigo-600">
                    <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd" />
                    <path d="M5.082 14.254a6.741 6.741 0 00-4.562 3.243.75.75 0 00.372.568A12.696 12.696 0 006 19.5c.34 0 .675-.013 1.007-.037a8.256 8.256 0 01-.925-5.21zM18.918 14.254a6.741 6.741 0 014.562 3.243.75.75 0 01-.372.568A12.696 12.696 0 0118 19.5c-.34 0-.675-.013-1.007-.037a8.256 8.256 0 00.925-5.21z" />
                </svg>
                Data Pengguna
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Total Pengguna Terdaftar: <span class="font-bold text-indigo-600">{{ $users->total() }}</span>
            </p>
        </div>

        {{-- Search Bar --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="relative w-full md:w-72">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau no wa..." 
                   class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm transition">
            <div class="absolute left-3 top-2.5 text-gray-400">
                {{-- ICON: Magnifying Glass --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </div>
        </form>
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
        
        {{-- Filter Cepat (SVG Icons) --}}
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-wrap gap-2">
            <a href="{{ route('admin.users.index') }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1.5 {{ !request('role') ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                Semua
            </a>
            
            <a href="{{ route('admin.users.index', ['role' => 'pemilik']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1.5 {{ request('role') == 'pemilik' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                {{-- ICON: Crown (Ganti 👑) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                </svg>
                Pemilik Kost
            </a>

            <a href="{{ route('admin.users.index', ['role' => 'pencari']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition flex items-center gap-1.5 {{ request('role') == 'pencari' ? 'bg-blue-500 text-white border-blue-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                {{-- ICON: Search/User (Ganti 🔍) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
                Pencari Kos
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
                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm shadow-sm border border-indigo-50">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- KONTAK (SVG Phone) --}}
                        <td class="px-6 py-4">
                            @if(!empty($user->phone))
                                @php 
                                    $phone = $user->phone;
                                    $waPhone = preg_replace('/[^0-9]/', '', $phone);
                                    if(substr($waPhone, 0, 1) == '0') $waPhone = '62' . substr($waPhone, 1);
                                @endphp
                                <a href="https://wa.me/{{ $waPhone }}" target="_blank" 
                                   class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold px-3 py-1 rounded-full border border-emerald-100 hover:bg-emerald-100 transition shadow-sm">
                                    {{-- ICON: Phone (Ganti 📞) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $user->phone }}
                                </a>
                            @else
                                <span class="text-gray-400 text-xs italic bg-gray-50 px-2 py-1 rounded-md">- Kosong -</span>
                            @endif
                        </td>

                        {{-- ROLE BADGE (SVG Icons) --}}
                        <td class="px-6 py-4 text-center">
                            @if(strtolower($user->role) == 'pemilik' || strtolower($user->role) == 'owner')
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-bold border bg-purple-50 text-purple-700 border-purple-100">
                                    {{-- ICON: Crown (Ganti 👑) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                    Pemilik
                                </span>
                            @elseif(strtolower($user->role) == 'admin')
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-bold border bg-red-50 text-red-700 border-red-100">
                                    {{-- ICON: Shield (Admin) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                        <path fill-rule="evenodd" d="M10.362 1.093a.75.75 0 00-.724 0L2.523 5.018 10 9.143l7.477-4.125-7.115-3.925zM18 9.143V15.75A2.25 2.25 0 0115.75 18H4.25A2.25 2.25 0 012 15.75V9.143l7.662 4.255a.75.75 0 00.676 0L18 9.143z" clip-rule="evenodd" />
                                    </svg>
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-bold border bg-blue-50 text-blue-700 border-blue-100">
                                    {{-- ICON: Search/User (Ganti 🔍) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                    </svg>
                                    Pencari
                                </span>
                            @endif
                        </td>

                        {{-- TANGGAL JOIN --}}
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-xs">
                            {{ $user->created_at->format('d M Y') }}
                        </td>

                        {{-- AKSI (SVG Icons) --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                
                                {{-- Edit --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   title="Edit Data"
                                   class="w-9 h-9 flex items-center justify-center rounded-full bg-amber-50 text-amber-600 hover:bg-amber-100 hover:scale-105 transition shadow-sm border border-amber-100">
                                    {{-- ICON: Pencil (Ganti ✏️) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                        <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                    </svg>
                                </a>

                                {{-- Hapus --}}
                                @if(auth()->id() !== $user->id) 
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="w-9 h-9 flex items-center justify-center rounded-full bg-rose-50 text-rose-600 hover:bg-rose-100 hover:scale-105 transition shadow-sm border border-rose-100" 
                                        title="Hapus User">
                                        {{-- ICON: Trash (Ganti 🗑️) --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            {{-- ICON: User (Empty State) --}}
                            <div class="flex justify-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 opacity-30">
                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                                </svg>
                            </div>
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
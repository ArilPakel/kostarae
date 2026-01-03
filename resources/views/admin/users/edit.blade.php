@extends('admin.layouts')

@section('content')
<div class="max-w-6xl mx-auto pb-12">

    {{-- 1. NAVIGASI KEMBALI --}}
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 font-bold px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100 hover:shadow-md hover:text-indigo-600 transition">
            <span>⬅️</span> Kembali ke Data Pengguna
        </a>
    </div>

    {{-- HEADER JUDUL --}}
    <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-2xl shadow-sm">
            ✏️
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Pengguna</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil dan hak akses pengguna.</p>
        </div>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- KOLOM KIRI: RINGKASAN PROFIL VISUAL --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center sticky top-8">
                    {{-- Avatar Besar --}}
                    <div class="w-28 h-28 rounded-3xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-4xl mx-auto mb-4 shadow-inner border border-indigo-100">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 break-words">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
                    
                    {{-- Role Badge Saat Ini --}}
                    <div class="mt-4 mb-4">
                        @php
                            $roleClass = match(strtolower($user->role)) {
                                'admin' => 'bg-red-50 text-red-700 border-red-100',
                                'pemilik', 'owner' => 'bg-purple-50 text-purple-700 border-purple-100',
                                default => 'bg-blue-50 text-blue-700 border-blue-100'
                            };
                            $roleIcon = match(strtolower($user->role)) {
                                'admin' => '🛡️',
                                'pemilik', 'owner' => '👑',
                                default => '🔍'
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-sm font-bold border {{ $roleClass }}">
                            {{ $roleIcon }} {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    
                    <div class="text-xs text-gray-400 bg-gray-50 p-3 rounded-xl border border-gray-100 mt-4">
                        Bergabung sejak:<br>
                        <span class="font-medium text-gray-600">{{ $user->created_at->format('d F Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: FORM EDIT --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- KARTU 1: INFORMASI DASAR --}}
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                        📋 Informasi Dasar
                    </h3>
                    
                    <div class="space-y-5">
                        {{-- Nama Lengkap --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                👤 Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50/50 transition @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                📧 Alamat Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50/50 transition @error('email') border-red-500 @enderror">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- KARTU 2: KONTAK & ROLE --}}
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                        💼 Kontak & Hak Akses
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Nomor WhatsApp --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                📞 Nomor WhatsApp
                            </label>
                            <input type="number" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890"
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50/50 transition @error('phone') border-red-500 @enderror">
                            <p class="text-xs text-gray-400 mt-1 ml-1">Gunakan format angka saja (08xx).</p>
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Role Select --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                👑 Role Pengguna <span class="text-red-500">*</span>
                            </label>
                            
                            @php $isSelf = auth()->id() == $user->id; @endphp
                            
                            <select name="role" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50/50 cursor-pointer transition {{ $isSelf ? 'opacity-60 cursor-not-allowed bg-gray-100' : '' }}" {{ $isSelf ? 'disabled' : '' }}>
                                <option value="pencari" {{ (old('role', $user->role) == 'pencari' || $user->role == 'user') ? 'selected' : '' }}>🔍 Pencari Kos (User)</option>
                                <option value="pemilik" {{ (old('role', $user->role) == 'pemilik') ? 'selected' : '' }}>👑 Pemilik Kost (Owner)</option>
                                <option value="admin" {{ (old('role', $user->role) == 'admin') ? 'selected' : '' }}>🛡️ Administrator</option>
                            </select>
                            
                            {{-- Pesan Pengaman jika mengedit diri sendiri --}}
                            @if($isSelf)
                                <p class="text-xs text-amber-600 mt-2 font-medium flex items-center gap-1">
                                    ⚠️ Demi keamanan, Anda tidak dapat mengubah role Anda sendiri.
                                </p>
                                <input type="hidden" name="role" value="{{ $user->role }}">
                            @else
                                <p class="text-xs text-gray-400 mt-1 ml-1">Hati-hati dalam memberikan akses Admin.</p>
                            @endif
                            
                            @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-3 rounded-xl bg-gray-100 text-gray-600 font-bold text-sm hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold text-sm hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition flex items-center gap-2 transform hover:-translate-y-1">
                        💾 Simpan Perubahan
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
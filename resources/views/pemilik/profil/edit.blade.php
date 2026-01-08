@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 pt-24 pb-12">
    <div class="container mx-auto px-4 max-w-4xl">
        
        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Profil Pemilik</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola informasi pribadi dan akun Anda.</p>
            </div>
            <a href="{{ route('pemilik.kost.index') }}" class="text-sm font-medium text-[#2D4A53] hover:text-orange-600 transition">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KARTU KIRI: FOTO PROFIL --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit text-center">
                <div class="w-32 h-32 mx-auto rounded-full bg-gray-100 overflow-hidden mb-4 border-4 border-white shadow-md relative group">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2D4A53&color=fff" class="w-full h-full object-cover">
                    @endif
                    
                    {{-- Overlay Edit --}}
                    <label for="avatarInput" class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer text-white text-xs font-bold">
                        Ubah Foto
                    </label>
                </div>
                
                <h3 class="font-bold text-gray-900 text-lg">{{ auth()->user()->name }}</h3>
                <p class="text-gray-500 text-sm mb-4">{{ auth()->user()->email }}</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                    Akun Pemilik Kost
                </span>
            </div>

            {{-- KARTU KANAN: FORM EDIT --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                
                @if(session('success'))
                    <div class="mb-6 bg-green-50 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2 border border-green-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('pemilik.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="file" name="avatar" id="avatarInput" class="hidden">

                    <div class="space-y-5">
                        
                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                                   class="w-full rounded-xl border-gray-300 focus:border-[#2D4A53] focus:ring focus:ring-[#2D4A53]/20 transition">
                        </div>

                        {{-- Email --}}
                       <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                            {{-- Pastikan tagnya <input>, name="email", dan TIDAK ADA 'disabled' atau 'readonly' --}}
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                class="w-full rounded-xl border-gray-300 focus:border-[#2D4A53] focus:ring focus:ring-[#2D4A53]/20 transition" required>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            
                            {{-- Info kecil --}}
                            <p class="text-xs text-gray-400 mt-2">
                                <span class="text-orange-500 font-bold">Perhatian:</span> Mengubah email akan mengubah status verifikasi akun Anda.
                            </p>
                        </div>

                        {{-- No HP --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp / Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" 
                                   placeholder="Contoh: 08123456789"
                                   class="w-full rounded-xl border-gray-300 focus:border-[#2D4A53] focus:ring focus:ring-[#2D4A53]/20 transition">
                        </div>

                        

                        <div class="pt-4 border-t border-gray-100 flex justify-end">
                            <button type="submit" class="bg-[#E07B3C] hover:bg-[#d66a2e] text-white px-6 py-3 rounded-xl font-bold shadow-md transition transform hover:-translate-y-0.5">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
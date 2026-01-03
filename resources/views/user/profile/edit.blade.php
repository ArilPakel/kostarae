@extends('layouts.main')
@section('title', 'Edit Profil - Kostarae')

@section('content')
<div class="min-h-screen bg-gray-50/50 pt-28 pb-20">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        
        {{-- Header & Back Button --}}
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('user.profile') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-orange-600 transition group">
                <div class="p-2 bg-white rounded-lg border border-gray-200 group-hover:border-orange-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </div>
                <span>Kembali ke Profil</span>
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-lg p-6 md:p-8">
            <div class="mb-8 border-b border-gray-100 pb-4">
                <h1 class="text-2xl font-bold text-gray-900">Edit Profil</h1>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi akun Anda dengan benar.</p>
            </div>

            {{-- FORM START --}}
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- 1. Upload Avatar (Preview Realtime) --}}
                <div class="flex flex-col items-center gap-4 mb-8">
                    <div class="relative group cursor-pointer" onclick="document.getElementById('avatarInput').click()">
                        {{-- Preview Image Logic --}}
                        <img id="avatarPreview" 
                             src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=random&color=fff' }}" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-gray-50 shadow-md group-hover:border-orange-100 group-hover:opacity-90 transition duration-300">
                        
                        {{-- Overlay Icon --}}
                        <div class="absolute bottom-0 right-0 bg-white p-2 rounded-full border border-gray-200 shadow-sm text-gray-500 group-hover:text-orange-600 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                    </div>
                    
                    {{-- Hidden Input --}}
                    <input type="file" name="avatar" id="avatarInput" class="hidden" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)">
                    
                    <div class="text-center">
                        <p class="text-xs font-bold text-gray-700">Foto Profil</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">JPG, PNG (Max 2MB)</p>
                        @error('avatar') <p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- 2. Input Nama --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                           class="w-full rounded-xl border-gray-200 text-sm font-bold text-gray-900 focus:border-orange-500 focus:ring-orange-500 py-3 transition bg-gray-50 focus:bg-white @error('name') border-red-500 bg-red-50 @enderror"
                           placeholder="Nama Lengkap Anda">
                    @error('name') <p class="text-xs text-red-500 mt-1 ml-1 font-bold flex items-center gap-1">⚠️ {{ $message }}</p> @enderror
                </div>

                {{-- 3. Input Email (Peringatan Perubahan) --}}
                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase">Email</label>
                        @if(Auth::user()->email_verified_at)
                            <span class="text-[10px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100 font-bold">Terverifikasi</span>
                        @endif
                    </div>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                           class="w-full rounded-xl border-gray-200 text-sm font-medium text-gray-800 focus:border-orange-500 focus:ring-orange-500 py-3 transition bg-gray-50 focus:bg-white @error('email') border-red-500 bg-red-50 @enderror">
                    
                    @error('email') 
                        <p class="text-xs text-red-500 mt-1 ml-1 font-bold flex items-center gap-1">⚠️ {{ $message }}</p> 
                    @else
                        <p class="text-[10px] text-gray-400 mt-1 ml-1 italic">*Mengubah email akan menghapus status verifikasi.</p>
                    @enderror
                </div>

                {{-- 4. Input No HP --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2 ml-1">Nomor WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" 
                           class="w-full rounded-xl border-gray-200 text-sm font-medium text-gray-800 focus:border-orange-500 focus:ring-orange-500 py-3 transition bg-gray-50 focus:bg-white @error('phone') border-red-500 bg-red-50 @enderror"
                           placeholder="Contoh: 08123456789 atau 62812...">
                    @error('phone') <p class="text-xs text-red-500 mt-1 ml-1 font-bold flex items-center gap-1">⚠️ {{ $message }}</p> @enderror
                </div>


                {{-- Field Alamat / Domisili (BARU) --}}
                <div class="mb-6">
                    <label for="address" class="block text-xs font-bold text-gray-500 uppercase mb-2">Alamat / Domisili Lengkap</label>
                    <textarea name="address" id="address" rows="3" 
                            placeholder="Jl. Contoh No. 123, Kel. Sumpang Minangae, Kec. Bacukiki Barat, Kota Parepare"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition outline-none resize-none">{{ old('address', Auth::user()->address) }}</textarea>
                    
                    {{-- Hint / Keterangan --}}
                    <p class="text-[10px] text-gray-400 mt-1.5 flex justify-between">
                        <span>Sertakan nama jalan, kelurahan, dan kecamatan.</span>
                        <span id="charCount">0/500</span>
                    </p>
                    @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="pt-6 flex flex-col-reverse sm:flex-row gap-3 border-t border-gray-100 mt-4">
                    <a href="{{ route('user.profile') }}" class="flex-1 text-center py-3.5 rounded-xl border border-gray-200 text-gray-600 font-bold text-sm hover:bg-gray-50 hover:text-gray-900 transition">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 bg-orange-500 text-white font-bold py-3.5 rounded-xl hover:bg-orange-600 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                        <span>💾 Simpan Perubahan</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Script Preview Gambar --}}
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            // Validasi ukuran client-side (opsional tapi bagus untuk UX)
            if(file.size > 2 * 1024 * 1024) {
                alert("Ukuran file terlalu besar! Maksimal 2MB.");
                event.target.value = ""; // Reset input
                return;
            }
            document.getElementById('avatarPreview').src = URL.createObjectURL(file);
        }
    }
</script>
@endsection
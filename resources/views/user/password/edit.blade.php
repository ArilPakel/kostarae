@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 py-20 font-sans flex items-center justify-center">
    <div class="w-full max-w-lg px-4">

        {{-- Header Sederhana --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Keamanan Akun</h1>
            <p class="text-gray-500 text-sm">Lindungi akun Anda dengan kata sandi yang kuat.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Form Header --}}
            <div class="bg-[#2D4A53] px-8 py-4 border-b border-gray-100">
                <h2 class="text-white font-bold text-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Ubah Kata Sandi
                </h2>
            </div>
            
            <div class="p-8">
                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    {{-- 1. Password Saat Ini --}}
                    <div>
                        <label for="current_password" class="block text-xs font-bold text-gray-500 uppercase mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" required autofocus
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition outline-none">
                        @if($errors->updatePassword->has('current_password'))
                            <p class="text-red-500 text-xs mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
                        @endif
                    </div>

                    {{-- 2. Password Baru --}}
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-500 uppercase mb-2">Password Baru</label>
                        <input type="password" name="password" id="password" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition outline-none">
                        @if($errors->updatePassword->has('password'))
                            <p class="text-red-500 text-xs mt-1">{{ $errors->updatePassword->first('password') }}</p>
                        @endif
                    </div>

                    {{-- 3. Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition outline-none">
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-xl transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Simpan Password Baru
                        </button>
                    </div>
                </form>

                {{-- Tombol Batal / Kembali --}}
                <div class="mt-6 text-center">
                    <a href="{{ Auth::user()->role === 'pemilik' ? route('pemilik.profile') : route('user.profile') }}" class="text-sm text-gray-400 hover:text-gray-600 font-medium">
                        &larr; Kembali ke Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
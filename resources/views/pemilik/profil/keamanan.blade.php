@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 pt-24 pb-12 font-sans">
    <div class="container mx-auto px-4 max-w-2xl">
        
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Keamanan Akun</h1>
                <p class="text-gray-500 text-sm mt-1">Perbarui kata sandi Anda untuk menjaga keamanan.</p>
            </div>
            <a href="{{ route('pemilik.profile') }}" class="text-sm font-medium text-[#2D4A53] hover:text-orange-600 transition">
                &larr; Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 text-green-700 px-4 py-3 rounded-lg text-sm border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('pemilik.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Password Lama --}}
                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" required
                           class="w-full rounded-xl border-gray-300 focus:border-[#2D4A53] focus:ring focus:ring-[#2D4A53]/20 transition">
                    @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password Baru --}}
                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Baru</label>
                    <input type="password" name="password" required
                           class="w-full rounded-xl border-gray-300 focus:border-[#2D4A53] focus:ring focus:ring-[#2D4A53]/20 transition">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full rounded-xl border-gray-300 focus:border-[#2D4A53] focus:ring focus:ring-[#2D4A53]/20 transition">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-[#E07B3C] hover:bg-[#d66a2e] text-white px-6 py-3 rounded-xl font-bold shadow-md transition transform hover:-translate-y-0.5">
                        Update Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
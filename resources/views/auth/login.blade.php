@extends('layouts.main')

@section('content')

{{-- BACKGROUND WRAPPER --}}
<div class="min-h-screen flex items-center justify-center bg-gray-50 relative overflow-hidden py-12 px-4 sm:px-6 lg:px-8 font-sans">
    
    {{-- Dekorasi Background (Visual Consistency) --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -right-[10%] w-[500px] h-[500px] bg-[#2D4A53]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[10%] left-[10%] w-[400px] h-[400px] bg-orange-500/5 rounded-full blur-3xl"></div>
    </div>

    {{-- LOGIN CARD --}}
    <div class="max-w-md w-full bg-white p-8 md:p-10 rounded-3xl shadow-xl border border-gray-100 relative z-10">
        
        {{-- 1. HEADER: LOGO & JUDUL --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 group mb-4">
                {{-- Logo Kostarae --}}
                <img src="{{ asset('images/logokost.png') }}" alt="Logo Kostarae" class="h-10 w-auto object-contain">
                <span class="text-[#2D4A53] font-extrabold text-2xl tracking-wide">Kostaraé</span>
            </a>
            
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Selamat Datang Kembali</h2>
            <p class="mt-2 text-sm text-gray-500">
                Masuk untuk mengelola kost atau mencari kost impian Anda.
            </p>
        </div>

        {{-- Flash Message (Error / Success) --}}
        @if(session('success'))
            <div class="mb-5 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-emerald-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-rose-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- 2. FORM LOGIN --}}
        <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Input Phone --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Nomor Telepon</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#2D4A53]/20 focus:border-[#2D4A53] transition duration-150 sm:text-sm" 
                        placeholder="Contoh: 08123456789">
                </div>
                @error('phone') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Input Password --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <input type="password" name="password" required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#2D4A53]/20 focus:border-[#2D4A53] transition duration-150 sm:text-sm" 
                        placeholder="••••••••">
                </div>
                @error('password') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- 3. TOMBOL MASUK (Primary Action - Orange Kostarae) --}}
            <button type="submit" 
                class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-orange-500/20 text-sm font-bold text-white bg-[#ff7a00] hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ff7a00] transition-all transform hover:-translate-y-0.5">
                Masuk Sekarang
            </button>
        </form>

        {{-- DIVIDER --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-3 bg-white text-gray-400 font-medium">Atau masuk dengan</span>
            </div>
        </div>

        {{-- 4. LOGIN GOOGLE (Secondary Action) --}}
        <a href="{{ route('google.login') }}" 
           class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-gray-200 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all">
            <svg class="h-5 w-5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
            Google
        </a>

        {{-- 5. FOOTER LINKS --}}
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500 mb-4">Belum memiliki akun Kostaraé?</p>
            
            <div class="flex flex-col sm:flex-row gap-3 justify-center mb-6">
                {{-- Daftar Pencari --}}
                <a href="{{ route('register.user') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-200 shadow-sm text-xs font-bold rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:text-[#2D4A53] transition">
                    Register User
                </a>
                {{-- Daftar Pemilik --}}
                <a href="{{ route('register.owner') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-200 shadow-sm text-xs font-bold rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:text-[#ff7a00] transition">
                    Register Pemilik
                </a>
            </div>

            <div class="pt-6 border-t border-dashed border-gray-100">
                <a href="{{ route('home') }}" class="text-xs font-medium text-gray-400 hover:text-[#2D4A53] transition flex items-center justify-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
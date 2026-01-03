@extends('layouts.auth')

@section('content')

    <div class="min-h-screen w-full flex items-center justify-center p-4 md:p-8 bg-gray-50">

        <div class="relative w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row">

            <a href="{{ route('home') }}"
                class="absolute top-4 left-4 z-50 bg-white/90 backdrop-blur-sm text-gray-700 px-4 py-2 rounded-lg text-sm font-medium shadow hover:bg-gray-100 transition border border-gray-200">
                ← Kembali
            </a>

            <div class="hidden md:block md:w-1/2 bg-cover bg-center relative" 
                 style="background-image: url('{{ asset('images/hero.png') }}'); min-h-[600px];">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                
                <div class="absolute bottom-10 left-10 text-white pr-10">
                    <h3 class="text-3xl font-bold mb-2">Bergabung Bersama Kami</h3>
                    <p class="text-gray-200 text-sm">Kelola bisnis kost Anda dengan lebih mudah, efisien, dan jangkau lebih banyak penyewa.</p>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-8 md:p-12 overflow-y-auto max-h-[90vh] md:max-h-[700px]">

                <div class="mt-8 md:mt-0">
                    <h2 class="text-2xl md:text-3xl font-bold mb-2 text-gray-800">Daftar Pemilik Kost</h2>
                    <p class="text-sm text-gray-500 mb-8">Isi data diri Anda untuk mulai mengelola kost.</p>
                </div>

                <form action="{{ route('register.owner.submit') }}" method="POST">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="text-sm font-semibold text-gray-700 mb-1.5 block">Nama Lengkap</label>
                        <input name="name" type="text" placeholder="Masukkan nama lengkap" 
                               value="{{ old('name') }}" required
                            class="w-full px-5 py-3 bg-gray-5 border @error('name') border-red-500 @else border-gray-200 @enderror rounded-xl text-sm text-gray-800 outline-none transition focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                        
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="text-sm font-semibold text-gray-700 mb-1.5 block">No Telepon</label>
                        <input name="phone" type="text" placeholder="Contoh: 08123456789" 
                               value="{{ old('phone') }}" required
                            class="w-full px-5 py-3 bg-gray-5 border @error('phone') border-red-500 @else border-gray-200 @enderror rounded-xl text-sm text-gray-800 outline-none transition focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                        
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="text-sm font-semibold text-gray-700 mb-1.5 block">Kata Sandi</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" placeholder="Minimal 6 karakter" required
                                class="w-full px-5 py-3 bg-gray-5 border @error('password') border-red-500 @else border-gray-200 @enderror rounded-xl text-sm text-gray-800 outline-none transition focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 pr-12" />

                            <button type="button" onclick="togglePassword('password','eyeOpen1','eyeClose1')"
                                class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-gray-600 transition">
                                <svg id="eyeOpen1" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeClose1" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19.5c-5.5 0-10-6-10-6a19.977 19.977 0 015.063-4.5M15 12a3 3 0 00-3-3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label class="text-sm font-semibold text-gray-700 mb-1.5 block">Ulangi Kata Sandi</label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password" 
                                placeholder="Masukkan ulang kata sandi" required
                                class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none transition focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 pr-12" />

                            <button type="button" onclick="togglePassword('password_confirmation','eyeOpen2','eyeClose2')"
                                class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-gray-600 transition">
                                <svg id="eyeOpen2" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeClose2" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19.5c-5.5 0-10-6-10-6a19.977 19.977 0 015.063-4.5M15 12a3 3 0 00-3-3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3.5 rounded-xl font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                        Daftar Sekarang
                    </button>

                    <div class="flex items-center my-6">
                        <div class="h-px bg-gray-300 flex-1"></div>
                        <span class="px-4 text-sm text-gray-500">atau daftar dengan</span>
                        <div class="h-px bg-gray-300 flex-1"></div>
                    </div>

                    <a href="{{ route('google.redirect', ['role' => 'pemilik']) }}" 
                       class="flex items-center justify-center w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-white hover:bg-gray-50 transition-all group">
                        
                        <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        
                        <span class="font-medium text-gray-700 group-hover:text-black">
                            Daftar Google sebagai Pemilik
                        </span>
                    </a>
                    <p class="text-center text-sm mt-6 text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline ml-1">Masuk</a>
                    </p>

                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, openId, closeId) {
            const input = document.getElementById(inputId);
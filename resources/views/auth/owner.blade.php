@extends('layouts.auth')

@section('content')

    {{-- NOTIFIKASI BERHASIL --}}
    @if (session('success'))
        <div id="successAlert"
            class="fixed top-6 right-6 z-[9999] bg-green-500 text-white px-6 py-4 rounded-xl shadow-xl flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <span class="font-semibold text-sm">
                {{ session('success') }}
            </span>
        </div>
    @endif


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
                    <p class="text-gray-200 text-sm">Kelola bisnis kost Anda dengan lebih mudah, efisien, dan jangkau lebih
                        banyak penyewa.</p>
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
                        <input name="name" type="text" placeholder="Masukkan nama lengkap" value="{{ old('name') }}"
                            required
                            class="w-full px-5 py-3 bg-gray-5 border @error('name') border-red-500 @else border-gray-200 @enderror rounded-xl text-sm text-gray-800 outline-none transition focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600">

                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="text-sm font-semibold text-gray-700 mb-1.5 block">No Telepon</label>
                        <input name="phone" type="text" placeholder="Contoh: 08123456789" value="{{ old('phone') }}"
                            required
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
                                <svg id="eyeOpen1" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeClose1" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19.5c-5.5 0-10-6-10-6a19.977 19.977 0 015.063-4.5M15 12a3 3 0 00-3-3" />
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
                                <svg id="eyeOpen2" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeClose2" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19.5c-5.5 0-10-6-10-6a19.977 19.977 0 015.063-4.5M15 12a3 3 0 00-3-3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3.5 rounded-xl font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                        Daftar Sekarang
                    </button>

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
            const eyeOpen = document.getElementById(openId);
            const eyeClose = document.getElementById(closeId);

            if (input.type === "password") {
                input.type = "text";
                eyeOpen.classList.add("hidden");
                eyeClose.classList.remove("hidden");
            } else {
                input.type = "password";
                eyeOpen.classList.remove("hidden");
                eyeClose.classList.add("hidden");
            }
        }
    </script>

    <script>
        setTimeout(() => {
            const alert = document.getElementById('successAlert');
            if (alert) {
                alert.classList.add('opacity-0', 'translate-x-10');
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);
    </script>


    <style>
        #successAlert {
            transition: all 0.5s ease;
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(40px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

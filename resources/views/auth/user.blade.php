@extends('layouts.auth')

@section('content')

    <div class="w-full flex justify-center mt-24 mb-12">

        <div class=" relative w-[1000px] h-[600px] bg-white rounded-2xl overflow-hidden shadow-xl flex"> 
            <a href="{{ route('home') }}"
                class="absolute top-4 left-4 z-50 bg-white text-gray-700 px-4 py-1.5 rounded-lg text-sm font-medium shadow hover:bg-gray-100 transition">
                ← Kembali</a>


            <div class="w-[45%] bg-cover bg-center relative" style="background-image: url('{{ asset('images/hero.png') }}');">
                <div class="absolute inset-0 bg-black/30"></div>
            </div>

            <div class="w-1/2 p-10 overflow-y-auto">

                <h2 class="text-1xl font-semibold mb-1"> Daftar Pencari kost </h2>
                <p class="text-sm text-gray-600 mb-5"> Temukan kost sesuai kebutuhan anda </p>

                <form action="{{ route('register.user') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="text-sm font-semibold"> Nama Lengkap </label>
                        <input name="name" type="text" placeholder=" Masukan nama lengkap "
                            class=" w-full px-4 py-3 bg-white border border-gray-300 rounded-xl 
                                text-sm text-gray-800 outline-none
                                transition focus:border-blue-500">
                    </div>
                    <div class="mb-4">
                        <label class="text-sm font-semibold"> No telepon </label>
                        <input name="phone" type="text" placeholder=" Masukan nomor telepon "
                            class=" w-full px-4 py-3 bg-white border border-gray-300 rounded-xl 
                                text-sm text-gray-800 outline-none
                                transition focus:border-blue-500">
                    </div>
                    <div class="mb-4">
                        <label class="text-sm font-semibold"> Kata sandi </label>
                        <div class="relative">
                            <input id="password1" name="password" type="password" placeholder="Masukkan kata sandi"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl 
                               text-sm text-gray-800 outline-none transition focus:border-blue-500" />

                            <button type="button" onclick="togglePassword('password1','eyeOpen1','eyeClose1')"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-700">

                                <svg id="eyeOpen1" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M1.5 12s4.5-6 10.5-6 10.5 6 10.5 6-4.5 6-10.5 6S1.5 12 1.5 12z" />
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>

                                <svg id="eyeClose1" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19.5c-5.5 0-10-6-10-6
                             a19.977 19.977 0 015.063-4.5M15 12a3 3 0 00-3-3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-semibold"> Ulangi Kata sandi </label>
                        <div class="relative">
                            <input id="password2" name="password_confirmation" type="password"
                                placeholder="Masukkan ulang kata sandi"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl 
                               text-sm text-gray-800 outline-none transition focus:border-blue-500" />

                            <button type="button" onclick="togglePassword('password2','eyeOpen2','eyeClose2')"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-700">

                                <svg id="eyeOpen2" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M1.5 12s4.5-6 10.5-6 10.5 6 10.5 6-4.5 6-10.5 6S1.5 12 1.5 12z" />
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>

                                <svg id="eyeClose2" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19.5c-5.5 0-10-6-10-6
                             a19.977 19.977 0 015.063-4.5M15 12a3 3 0 00-3-3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 rounded-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 hover:-translate-y-0.5 hover:shadow-lg transistion">
                        Daftar
                    </button>

                    <div class="flex items-center my-5">
                        <div class="h-px bg-gray-200 flex-1"></div>
                        <span class="px-3 text-xs text-gray-400">atau daftar dengan</span>
                        <div class="h-px bg-gray-200 flex-1"></div>
                    </div>

                    <a href="{{ route('google.redirect', ['role' => 'pencari']) }}" 
                       class="flex items-center justify-center w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm bg-white hover:bg-gray-50 transition-all group">
                        
                        <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        
                        <span class="font-medium text-sm text-gray-600 group-hover:text-black">
                            Daftar Google sebagai Pencari
                        </span>
                    </a>
                    <p class="text-center text-sm mt-5">
                        Sudah Punya akun?
                        <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline"> Masuk </a>
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
@endsection
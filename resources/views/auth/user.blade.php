@extends('layouts.auth')

@section('content')

    <div class="w-full flex justify-center mt-24 mb-12">

        <div class=" relative w-[1000px] h-[560px] bg-white rounded-2xl overflow-hidden shadow-xl flex">

            <!-- Back Button -->
            <a href="{{ route('home') }}"
                class="absolute top-4 left-4 z-50 bg-white text-gray-700 px-4 py-1.5 rounded-lg text-sm font-medium shadow hover:bg-gray-100 transition">
                ← Kembali</a>


            <!-- Left Image -->
            <div class="w-[45%] bg-cover bg-center relative" style="background-image: url('{{ asset('images/hero.png') }}');">
                <div class="absolute inset-0 bg-black/30"></div>
            </div>

            <!-- Right Form -->
            <div class="w-1/2 p-10 oveflow-y-auto">

                <h2 class="text-1xl font-semibold mb-1"> Daftar Pencari kost </h2>
                <p class="text-sm text-gray-600 mb-5"> Temukan kost sesaui kebutuhan anda </p>

                <form action="{{ route('register.user') }}" method="POST">
                    @csrf
                    <!-- Nama -->
                    <div class="mb-4">
                        <label class="text-sm font-semibold"> Nama Lenkap </label>
                        <input name="name" type="text" placeholder=" Masukan username "
                            class=" w-full px-4 py-3 bg-white border border-gray-300 rounded-xl 
                                text-sm text-gray-800 outline-none
                                transition focus:border-blue-500">
                    </div>
                    <!-- No Telp -->
                    <div class="mb-4">
                        <label class="text-sm font-semibold"> No telepon </label>
                        <input name="phone" type="text" placeholder=" Masukan nomor telepon "
                            class=" w-full px-4 py-3 bg-white border border-gray-300 rounded-xl 
                                text-sm text-gray-800 outline-none
                                transition focus:border-blue-500">
                    </div>
                    <!-- Password -->
                    <div class="mb-4">
                        <label class="text-sm font-semibold"> Kata sandi </label>
                        <div class="relative">
                            <input id="password1" name="password" type="password" placeholder="Masukkan kata sandi"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl 
                   text-sm text-gray-800 outline-none transition focus:border-blue-500" />

                            <button type="button" onclick="togglePassword('password1','eyeOpen1','eyeClose1')"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-700">

                                <!-- Eye Open -->
                                <svg id="eyeOpen1" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M1.5 12s4.5-6 10.5-6 10.5 6 10.5 6-4.5 6-10.5 6S1.5 12 1.5 12z" />
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>

                                <!-- Eye Close -->
                                <svg id="eyeClose1" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19.5c-5.5 0-10-6-10-6
                             a19.977 19.977 0 015.063-4.5M15 12a3 3 0 00-3-3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Ulangi Password -->
                    <div class="mb-4">
                        <label class="text-sm font-semibold"> Ulangi Kata sandi </label>
                        <div class="relative">
                            <input id="password2" name="password_confirmation" type="password"
                                placeholder="Masukkan ulang kata sandi"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl 
                   text-sm text-gray-800 outline-none transition focus:border-blue-500" />

                            <button type="button" onclick="togglePassword('password2','eyeOpen2','eyeClose2')"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-700">

                                <!-- Eye Open -->
                                <svg id="eyeOpen2" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M1.5 12s4.5-6 10.5-6 10.5 6 10.5 6-4.5 6-10.5 6S1.5 12 1.5 12z" />
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>

                                <!-- Eye Close -->
                                <svg id="eyeClose2" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19.5c-5.5 0-10-6-10-6
                             a19.977 19.977 0 015.063-4.5M15 12a3 3 0 00-3-3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>





                    <!-- Btn -->
                    <button
                        class="w-full py-3 rounded-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 hover:-translate-y-0.5 hover:shadow-lg transistion">
                        Daftar
                    </button>

                    <p class="text-center text-sm mt-4">
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

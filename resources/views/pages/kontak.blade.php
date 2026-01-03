@extends('layouts.main')

@section('content')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div x-data="contactForm()">

    <div x-show="showModal" 
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center transform transition-all">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Laporan Diterima!</h3>
            <p class="text-gray-500 text-sm mb-6">Terima kasih, tim Kost'Ta akan segera memproses pesan Anda.</p>
            <button @click="showModal = false" class="w-full bg-[#E07B3C] text-white font-bold py-3 rounded-xl hover:bg-[#cf6f32] transition shadow-lg">
                Tutup
            </button>
        </div>
    </div>

    <div class="relative bg-[#2D4A53] pt-32 pb-24 border-b border-[#1F3A43] overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-10 left-10 w-64 h-64 bg-white rounded-full mix-blend-overlay blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-[#E07B3C] rounded-full mix-blend-overlay blur-3xl"></div>
        </div>
        <div class="relative container mx-auto px-4 text-center z-10">
            <span class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-gray-200 text-xs font-semibold mb-4 backdrop-blur-sm">Layanan Pengguna</span>
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">Hubungi Kami</h1>
            <p class="text-gray-200 text-lg max-w-2xl mx-auto leading-relaxed">Ada kendala teknis? Isi formulir di bawah ini.</p>
        </div>
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none rotate-180">
            <svg class="relative block w-[calc(100%+1.3px)] h-[50px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-gray-50"></path>
            </svg>
        </div>
    </div>

    <div class="bg-gray-50 min-h-screen pb-20">
        <div class="container mx-auto px-4 -mt-10 relative z-20">
            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col lg:flex-row">
                
                <div class="lg:w-2/5 bg-[#2D4A53] p-10 text-white flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-[#E07B3C] rounded-full opacity-20 blur-3xl"></div>
                    <div>
                        <h3 class="text-2xl font-bold mb-6">Informasi Kontak</h3>
                        <p class="text-gray-300 mb-8 leading-relaxed">Tim support Kost'Ta siap membantu Anda pada jam kerja (24/7).</p>
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-[#E07B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div><h4 class="font-bold text-white">Alamat Kantor</h4><p class="text-gray-300 text-sm">Kota Parepare, Sulawesi Selatan</p></div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-[#E07B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div><h4 class="font-bold text-white">Email</h4><p class="text-gray-300 text-sm">kostta.support@gmail.com</p></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-3/5 p-10 bg-white">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Kirim Pesan / Laporan</h2>
                    <p class="text-gray-500 mb-8 text-sm">Validasi otomatis aktif untuk memastikan data Anda benar.</p>

                    <form action="{{ route('kontak.store') }}" method="POST" @submit="submitForm">
                        @csrf
                        
                        <div class="grid md:grid-cols-2 gap-6 mb-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" x-model="form.name" @input="validateForm"
                                       class="w-full px-4 py-3 rounded-lg border bg-gray-50 focus:bg-white transition outline-none focus:ring-2 focus:ring-[#2D4A53]"
                                       :class="errors.name ? 'border-red-500' : 'border-gray-300'" placeholder="Nama Anda">
                                <p x-show="errors.name" class="text-red-500 text-xs mt-1" x-text="errors.name"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2"> No WhatsApp </label>
                                <input type="tel" name="phone" x-model="form.phone" @input="validatePhone"
                                       class="w-full px-4 py-3 rounded-lg border bg-gray-50 focus:bg-white transition outline-none focus:ring-2 focus:ring-[#2D4A53]"
                                       :class="errors.phone ? 'border-red-500' : 'border-gray-300'" placeholder="08/62">
                                <p x-show="errors.phone" class="text-red-500 text-xs mt-1" x-text="errors.phone"></p>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" x-model="form.email" @input="validateEmail"
                                   class="w-full px-4 py-3 rounded-lg border bg-gray-50 focus:bg-white transition outline-none focus:ring-2 focus:ring-[#2D4A53]"
                                   :class="errors.email ? 'border-red-500' : 'border-gray-300'" placeholder="email@contoh.com">
                            <p x-show="errors.email" class="text-red-500 text-xs mt-1" x-text="errors.email"></p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan / Laporan</label>
                            <textarea name="message" x-model="form.message" @input="validateForm" rows="4"
                                      class="w-full px-4 py-3 rounded-lg border bg-gray-50 focus:bg-white transition outline-none focus:ring-2 focus:ring-[#2D4A53] resize-none"
                                      :class="errors.message ? 'border-red-500' : 'border-gray-300'" placeholder="Min. 10 karakter..."></textarea>
                            <p x-show="errors.message" class="text-red-500 text-xs mt-1" x-text="errors.message"></p>
                        </div>

                        <button type="submit" 
                                :disabled="!isValid"
                                class="w-full px-8 py-3 rounded-lg font-bold transition shadow-lg flex justify-center items-center gap-2"
                                :class="isValid ? 'bg-[#E07B3C] text-white hover:bg-[#cf6f32] cursor-pointer' : 'bg-gray-200 text-gray-400 cursor-not-allowed'">
                            <span>Kirim Sekarang</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-12 rounded-2xl overflow-hidden shadow-sm border border-gray-200 h-80 relative bg-gray-200 group">
                <iframe src="https://maps.google.com/maps?q=Parepare&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>

        </div>
    </div>
</div>

<script>
    function contactForm() {
        return {
            showModal: {{ session('success') ? 'true' : 'false' }},
            form: {
                name: '{{ old('name') }}',
                phone: '{{ old('phone') }}',
                email: '{{ old('email') }}',
                message: '{{ old('message') }}'
            },
            errors: {},
            isValid: false,

            validatePhone() {
                const phone = this.form.phone;
                const indoPhoneRegex = /^(\+62|62|0)8[1-9][0-9]{6,11}$/;
                if (!phone) this.errors.phone = "Wajib diisi";
                else if (/[^0-9+]/.test(phone)) this.errors.phone = "Hanya angka";
                else if (!indoPhoneRegex.test(phone)) this.errors.phone = "Format salah (08.. atau +62..)";
                else delete this.errors.phone;
                this.validateForm();
            },
            validateEmail() {
                const email = this.form.email;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email) this.errors.email = "Wajib diisi";
                else if (!emailRegex.test(email)) this.errors.email = "Format email salah";
                else delete this.errors.email;
                this.validateForm();
            },
            validateForm() {
                if (!this.form.name) this.errors.name = "Wajib diisi"; else delete this.errors.name;
                if (!this.form.message) this.errors.message = "Wajib diisi"; 
                else if(this.form.message.length < 10) this.errors.message = "Min. 10 karakter"; 
                else delete this.errors.message;
                
                // Cek apakah semua valid
                this.isValid = Object.keys(this.errors).length === 0 && 
                               this.form.name && this.form.phone && 
                               this.form.email && this.form.message;
            }
        }
    }
</script>
@endsection
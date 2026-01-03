@extends('admin.layouts')

@section('content')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
    
    <div x-data="contactForm()" class="max-w-4xl mx-auto relative">

        <div x-show="showModal" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            
            <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-800 mb-2">Laporan Berhasil!</h3>
                <p class="text-gray-500 text-sm mb-6">
                    Terima kasih, pesan Anda telah kami terima dan akan segera diproses.
                </p>
                
                <button @click="showModal = false" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition focus:outline-none shadow-lg">
                    Tutup / OK
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden md:flex">
            
            <div class="bg-blue-600 p-8 text-white md:w-1/3 flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Hubungi Kami</h2>
                    <p class="text-blue-100 text-sm mb-6">Ada kendala teknis? Isi formulir dan tim kami akan segera membantu.</p>
                    
                    <div class="space-y-4 text-sm">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-1 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>admin@mail.com</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-1 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>+62 812-1234-5678</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-1 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Kost Bahagia No. 10, Jakarta</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 md:w-2/3">
                <form action="{{ route('kontak.store') }}" method="POST" @submit="submitForm">
                    @csrf
        
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" x-model="form.name" @input="validateForm"
                               class="w-full px-4 py-3 rounded-lg border bg-gray-50 focus:bg-white transition outline-none focus:ring-2 focus:ring-blue-500"
                               :class="errors.name ? 'border-red-500 focus:ring-red-200' : 'border-gray-200'"
                               placeholder="Nama Anda">
                        <p x-show="errors.name" class="text-red-500 text-xs mt-1" x-text="errors.name"></p>
                    </div>
        
                    <div class="grid md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon (WA)</label>
                            <input type="tel" name="phone" x-model="form.phone" @input="validatePhone"
                                   class="w-full px-4 py-3 rounded-lg border bg-gray-50 focus:bg-white transition outline-none focus:ring-2 focus:ring-blue-500"
                                   :class="errors.phone ? 'border-red-500 focus:ring-red-200' : 'border-gray-200'"
                                   placeholder="0812...">
                            <p x-show="errors.phone" class="text-red-500 text-xs mt-1" x-text="errors.phone"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" x-model="form.email" @input="validateEmail"
                                   class="w-full px-4 py-3 rounded-lg border bg-gray-50 focus:bg-white transition outline-none focus:ring-2 focus:ring-blue-500"
                                   :class="errors.email ? 'border-red-500 focus:ring-red-200' : 'border-gray-200'"
                                   placeholder="nama@email.com">
                            <p x-show="errors.email" class="text-red-500 text-xs mt-1" x-text="errors.email"></p>
                        </div>
                    </div>
        
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan</label>
                        <textarea name="message" x-model="form.message" @input="validateForm" rows="4"
                                  class="w-full px-4 py-3 rounded-lg border bg-gray-50 focus:bg-white transition outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                                  :class="errors.message ? 'border-red-500 focus:ring-red-200' : 'border-gray-200'"
                                  placeholder="Tulis pesan Anda..."></textarea>
                        <p x-show="errors.message" class="text-red-500 text-xs mt-1" x-text="errors.message"></p>
                    </div>
        
                    <button type="submit" 
                            :disabled="!isValid"
                            class="w-full py-3 rounded-lg font-bold transition shadow-lg flex justify-center items-center gap-2"
                            :class="isValid ? 'bg-blue-600 text-white hover:bg-blue-700 cursor-pointer shadow-blue-200' : 'bg-gray-200 text-gray-400 cursor-not-allowed'">
                        <span>Kirim Pesan</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
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
                else if (!indoPhoneRegex.test(phone)) this.errors.phone = "Format salah (harus 08.. atau +62..)";
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
                if (!this.form.message) this.errors.message = "Wajib diisi"; else if(this.form.message.length < 10) this.errors.message = "Min. 10 karakter"; else delete this.errors.message;
                
                this.isValid = Object.keys(this.errors).length === 0 && this.form.name && this.form.phone && this.form.email && this.form.message;
            }
        }
    }
</script>
@endsection
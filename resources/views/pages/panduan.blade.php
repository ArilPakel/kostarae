@extends('layouts.main')

@section('content')
    <script src="//unpkg.com/alpinejs" defer></script>

    <div class="relative bg-[#2D4A53] pt-32 pb-24 border-b border-[#1F3A43] overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-10 left-10 w-64 h-64 bg-white rounded-full mix-blend-overlay blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-[#E07B3C] rounded-full mix-blend-overlay blur-3xl"></div>
        </div>

        <div class="relative container mx-auto px-4 text-center z-10">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">
                Pusat Bantuan & Panduan
            </h1>
            <p class="text-gray-200 text-lg max-w-2xl mx-auto leading-relaxed">
                Bingung mulai dari mana? Ikuti langkah mudah berikut untuk menemukan kost impian atau mengelola properti Anda di Kost'Ta.
            </p>
        </div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none rotate-180">
            <svg class="relative block w-[calc(100%+1.3px)] h-[50px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-gray-50"></path>
            </svg>
        </div>
    </div>

    <div class="bg-gray-50 min-h-screen pb-20" x-data="{ tab: 'pencari' }">
        <div class="container mx-auto px-4 -mt-10 relative z-20">
            
            <div class="flex justify-center mb-12">
                <div class="bg-white p-1.5 rounded-full shadow-lg border border-gray-100 inline-flex">
                    <button @click="tab = 'pencari'"
                        :class="tab === 'pencari' ? 'bg-[#2D4A53] text-white shadow-md' : 'text-gray-500 hover:text-[#2D4A53]'"
                        class="px-8 py-3 rounded-full font-semibold transition-all duration-300 flex items-center gap-2 text-sm md:text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Pencari Kost
                    </button>
                    
                    <button @click="tab = 'pemilik'"
                        :class="tab === 'pemilik' ? 'bg-[#E07B3C] text-white shadow-md' : 'text-gray-500 hover:text-[#E07B3C]'"
                        class="px-8 py-3 rounded-full font-semibold transition-all duration-300 flex items-center gap-2 text-sm md:text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Pemilik Kost
                    </button>
                </div>
            </div>

            <div x-show="tab === 'pencari'" x-transition.opacity.duration.500ms>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                        <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#2D4A53] transition duration-300">
                            <span class="text-2xl font-bold text-[#2D4A53] group-hover:text-white">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Cari Lokasi</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Gunakan fitur pencarian untuk menemukan kost di sekitar kampus atau lokasi strategis di Parepare. Filter berdasarkan harga dan fasilitas.
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                        <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#2D4A53] transition duration-300">
                            <span class="text-2xl font-bold text-[#2D4A53] group-hover:text-white">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Lihat Detail & Survei</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Cek foto, fasilitas, dan peraturan kost. Hubungi pemilik kost melalui kontak yang tersedia untuk melakukan survei lokasi langsung.
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                        <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#2D4A53] transition duration-300">
                            <span class="text-2xl font-bold text-[#2D4A53] group-hover:text-white">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Deal & Bayar</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Sepakati harga dan tanggal masuk dengan pemilik. Lakukan pembayaran sesuai metode yang disepakati (Cash/Transfer) langsung ke pemilik.
                        </p>
                    </div>
                </div>
                
                <div class="mt-12 text-center bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold text-[#2D4A53] mb-4">Siap mencari tempat tinggal baru?</h3>
                    <a href="{{ route('home') }}" class="inline-block bg-[#E07B3C] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#cf6f32] transition shadow-lg shadow-orange-200">
                        Cari Kost Sekarang
                    </a>
                </div>
            </div>

            <div x-show="tab === 'pemilik'" x-transition.opacity.duration.500ms style="display: none;">
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                        <div class="w-14 h-14 bg-orange-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#E07B3C] transition duration-300">
                            <span class="text-2xl font-bold text-[#E07B3C] group-hover:text-white">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Daftar Akun Pemilik</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Buat akun khusus pemilik. Lengkapi data diri dan nomor telepon yang bisa dihubungi oleh calon penyewa.
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                        <div class="w-14 h-14 bg-orange-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#E07B3C] transition duration-300">
                            <span class="text-2xl font-bold text-[#E07B3C] group-hover:text-white">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Tambah Data Kost</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Upload foto kamar yang jelas, isi deskripsi fasilitas, harga sewa, dan lokasi akurat agar mudah ditemukan.
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                        <div class="w-14 h-14 bg-orange-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#E07B3C] transition duration-300">
                            <span class="text-2xl font-bold text-[#E07B3C] group-hover:text-white">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Kelola & Promosi</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Kost Anda akan tayang setelah verifikasi admin. Pantau ketersediaan kamar dan tunggu calon penyewa menghubungi Anda.
                        </p>
                    </div>
                </div>

                <div class="mt-12 text-center bg-[#2D4A53] p-10 rounded-2xl shadow-lg relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold text-white mb-4">Punya Kost Kosong?</h3>
                        <p class="text-gray-200 mb-6 max-w-xl mx-auto">Bergabunglah dengan Kost'Ta dan jangkau ribuan mahasiswa dan pekerja di Parepare.</p>
                        <a href="{{ route('register.owner') }}" class="inline-block bg-white text-[#2D4A53] px-8 py-3 rounded-xl font-bold hover:bg-gray-100 transition">
                            Daftar Sebagai Pemilik
                        </a>
                    </div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-16 -mt-16"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-[#E07B3C] opacity-20 rounded-full -ml-10 -mb-10"></div>
                </div>
            </div>

        </div>

        <div class="container mx-auto px-4 mt-20">
            <h2 class="text-2xl font-bold text-center text-[#2D4A53] mb-10">Pertanyaan Sering Diajukan (FAQ)</h2>
            <div class="max-w-3xl mx-auto space-y-4">
                
                <div x-data="{ open: false }" class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <button @click="open = !open" class="flex justify-between items-center w-full p-5 text-left font-semibold text-gray-700 hover:bg-gray-50 transition">
                        <span>Apakah aplikasi ini gratis?</span>
                        <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 transition-transform duration-300 text-[#E07B3C]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" class="p-5 border-t border-gray-100 text-gray-600 bg-gray-50 text-sm leading-relaxed">
                        Ya, Kost'Ta 100% gratis digunakan untuk pencari kost. Untuk pemilik kost, saat ini juga masih gratis tanpa biaya komisi.
                    </div>
                </div>

                <div x-data="{ open: false }" class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <button @click="open = !open" class="flex justify-between items-center w-full p-5 text-left font-semibold text-gray-700 hover:bg-gray-50 transition">
                        <span>Bagaimana cara menghubungi pemilik kost?</span>
                        <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 transition-transform duration-300 text-[#E07B3C]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" class="p-5 border-t border-gray-100 text-gray-600 bg-gray-50 text-sm leading-relaxed">
                        Klik pada kost yang Anda minati. Di halaman detail kost, akan terdapat tombol WhatsApp atau nomor telepon pemilik yang bisa Anda hubungi langsung.
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
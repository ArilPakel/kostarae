@extends('layouts.main') {{-- Pastikan ini sesuai dengan nama layout Anda --}}

@section('content')
    <style>
        html { scroll-behavior: smooth; }
        section { scroll-margin-top: 120px; }
    </style>

    <div class="relative bg-[#2D4A53] pt-32 pb-24 border-b border-[#1F3A43] overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-10 left-10 w-64 h-64 bg-white rounded-full mix-blend-overlay blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-[#E07B3C] rounded-full mix-blend-overlay blur-3xl"></div>
        </div>

        <div class="relative container mx-auto px-4 text-center z-10">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 tracking-tight">
                Syarat & Ketentuan
            </h1>
            <p class="text-gray-200 text-lg max-w-2xl mx-auto leading-relaxed">
                Harap membaca syarat dan ketentuan ini dengan saksama sebelum menggunakan platform Kostarae.
            </p>
            
            <div class="mt-6 inline-block px-4 py-1 rounded-full bg-white/10 border border-white/20 text-sm text-gray-200 backdrop-blur-sm">
                Terakhir diperbarui: {{ date('d F Y') }}
            </div>
        </div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none rotate-180">
            <svg class="relative block w-[calc(100%+1.3px)] h-[50px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-gray-50"></path>
            </svg>
        </div>
    </div>

    <div class="bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 py-12">
            <div class="flex flex-col lg:flex-row gap-10 relative">

                <aside class="w-full lg:w-1/4">
                    <div class="lg:sticky lg:top-28 space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 px-3">Daftar Isi</p>
                        
                        <a href="#pendahuluan" class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-white hover:text-[#2D4A53] hover:shadow-sm transition">
                            1. Pendahuluan
                        </a>
                        <a href="#akun" class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-white hover:text-[#2D4A53] hover:shadow-sm transition">
                            2. Akun & Keamanan
                        </a>
                        <a href="#pencari" class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-white hover:text-[#2D4A53] hover:shadow-sm transition">
                            3. Ketentuan Pencari
                        </a>
                        <a href="#pemilik" class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-white hover:text-[#2D4A53] hover:shadow-sm transition">
                            4. Ketentuan Pemilik
                        </a>
                        <a href="#transaksi" class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-white hover:text-[#2D4A53] hover:shadow-sm transition">
                            5. Transaksi
                        </a>
                        <a href="#larangan" class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-white hover:text-[#2D4A53] hover:shadow-sm transition">
                            6. Larangan
                        </a>
                        <a href="#disclaimer" class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-white hover:text-[#2D4A53] hover:shadow-sm transition">
                            7. Disclaimer
                        </a>
                    </div>
                </aside>

                <main class="w-full lg:w-3/4 bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12 space-y-10">
                    
                    <section id="pendahuluan">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#2D4A53]/10 text-[#2D4A53] font-bold text-sm">1</span>
                            <h2 class="text-xl font-bold text-gray-800">Pendahuluan</h2>
                        </div>
                        <p class="text-gray-600 text-sm md:text-base leading-relaxed text-justify">
                            Selamat datang di <strong>Kostarae</strong> (selanjutnya disebut "Platform"). Platform ini dikelola untuk memfasilitasi pertemuan informasi antara Penyewa (Pencari Kost) dan Pemilik Properti (Pemilik Kost). Dengan menggunakan layanan ini, Anda dianggap menyetujui seluruh aturan yang berlaku.
                        </p>
                    </section>

                    <hr class="border-gray-50">

                    <section id="akun">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#2D4A53]/10 text-[#2D4A53] font-bold text-sm">2</span>
                            <h2 class="text-xl font-bold text-gray-800">Akun & Keamanan</h2>
                        </div>
                        <ul class="space-y-2 text-gray-600 text-sm md:text-base list-disc pl-5">
                            <li>Pengguna wajib memberikan data identitas yang valid dan akurat.</li>
                            <li>Kerahasiaan kata sandi (password) adalah tanggung jawab penuh pengguna.</li>
                            <li>Kostarae berhak membekukan akun yang terindikasi melakukan pelanggaran.</li>
                        </ul>
                    </section>

                    <hr class="border-gray-50">

                    <section id="pencari">
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                                    <span class="text-[#2D4A53]">#</span> Pencari Kost
                                </h3>
                                <p class="text-sm text-gray-600 text-justify">
                                    Gunakan informasi hanya untuk tujuan penyewaan yang sah. Selalu lakukan survei lokasi sebelum bertransaksi.
                                </p>
                            </div>
                            <div id="pemilik">
                                <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                                    <span class="text-[#2D4A53]">#</span> Pemilik Kost
                                </h3>
                                <p class="text-sm text-gray-600 text-justify">
                                    Wajib memberikan informasi jujur. Dilarang mencantumkan biaya tersembunyi yang merugikan.
                                </p>
                            </div>
                        </div>
                    </section>

                    <hr class="border-gray-50">

                    <section id="transaksi">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#2D4A53]/10 text-[#2D4A53] font-bold text-sm">5</span>
                            <h2 class="text-xl font-bold text-gray-800">Transaksi & Pembayaran</h2>
                        </div>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <p class="text-sm text-yellow-800 font-medium">
                                ⚠️ Marketplace Only: Kostarae adalah perantara informasi.
                            </p>
                        </div>
                        <p class="text-gray-600 text-sm md:text-base text-justify">
                            Transaksi pembayaran dilakukan berdasarkan kesepakatan kedua belah pihak. Kami tidak bertanggung jawab atas transaksi di luar sistem yang telah ditentukan.
                        </p>
                    </section>

                    <hr class="border-gray-50">

                    <section id="larangan">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#2D4A53]/10 text-[#2D4A53] font-bold text-sm">6</span>
                            <h2 class="text-xl font-bold text-gray-800">Larangan</h2>
                        </div>
                        <p class="text-gray-600 text-sm md:text-base">Dilarang keras:</p>
                        <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-600 text-sm md:text-base">
                            <li>Mengunggah konten SARA atau Pornografi.</li>
                            <li>Menggunakan properti untuk kegiatan ilegal (Narkoba/Perjudian).</li>
                        </ul>
                    </section>

                    <hr class="border-gray-50">

                    <section id="disclaimer" class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-200 text-gray-600 font-bold text-sm">7</span>
                            <h2 class="text-xl font-bold text-gray-800">Batasan Tanggung Jawab</h2>
                        </div>
                        <p class="text-gray-600 text-sm md:text-base text-justify leading-relaxed">
                            Kami berupaya memverifikasi data, namun tidak menjamin 100% keakuratan informasi. Segala kerugian akibat kelalaian pengguna adalah tanggung jawab pribadi masing-masing pihak.
                        </p>
                    </section>

                </main>
            </div>
        </div>
    </div>
@endsection
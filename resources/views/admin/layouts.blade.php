<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Kostarae</title>
    
    {{-- 1. TAILWIND CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- 2. SWEETALERT2 (Wajib untuk Pop-up) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    {{-- 3. FONT INTER --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <div class="flex h-screen overflow-hidden">
        
        {{-- ================= SIDEBAR (KIRI) ================= --}}
        {{-- 'hidden md:flex' artinya sembunyi di HP, muncul di Laptop --}}
        <aside class="w-64 bg-[#1E1F24] text-gray-400 flex-col hidden md:flex transition-all duration-300">
            
            {{-- Logo --}}
            <div class="p-6 flex items-center gap-3 border-b border-gray-700">
                {{-- Pastikan path logo benar --}}
                <img src="{{ asset('images/logokost.png') }}" alt="Logo" class="h-8 w-8 object-contain">
                <span class="text-xl font-bold text-white tracking-wide">Kostarae</span>
            </div>

            {{-- Menu Navigasi --}}
            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                
                {{-- Helper function untuk class active --}}
                @php
                    $activeClass = 'bg-gray-700 text-white shadow-md';
                    $inactiveClass = 'hover:bg-gray-800 hover:text-white';
                @endphp

                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2.5 rounded-lg flex items-center gap-3 transition {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}">
                    <span>Dashboard</span>
                </a>

                <div class="pt-4 pb-1 pl-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Master Data</div>

                <a href="{{ route('admin.kost.index') }}" class="px-3 py-2.5 rounded-lg flex items-center gap-3 transition {{ request()->routeIs('admin.kost.*') ? $activeClass : $inactiveClass }}">
                    <span>Data Kost</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="px-3 py-2.5 rounded-lg flex items-center gap-3 transition {{ request()->routeIs('admin.users.*') ? $activeClass : $inactiveClass }}">
                    <span>Pengguna</span>
                </a>

                <a href="{{ route('admin.owners.index') }}" class="px-3 py-2.5 rounded-lg flex items-center gap-3 transition {{ request()->routeIs('admin.owners.*') ? $activeClass : $inactiveClass }}">
                    <span>Pemilik Kost</span>
                </a>

                <div class="pt-4 pb-1 pl-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Moderasi</div>

                <a href="{{ route('admin.reviews.index') }}" class="px-3 py-2.5 rounded-lg flex items-center gap-3 transition {{ request()->routeIs('admin.reviews.*') ? $activeClass : $inactiveClass }}">
                    <span>Ulasan</span>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="px-3 py-2.5 rounded-lg flex items-center gap-3 transition {{ request()->routeIs('admin.reports.*') ? $activeClass : $inactiveClass }}">
                    <span>Laporan</span>
                </a>

                <a href="{{ route('admin.activity.index') }}" class="px-3 py-2.5 rounded-lg flex items-center gap-3 transition {{ request()->routeIs('admin.activity.*') ? $activeClass : $inactiveClass }}">
                    <span>Aktivitas</span>
                </a>

                <div class="pt-4 pb-1 pl-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Halaman Info</div>

                <a href="{{ route('admin.pages.terms') }}" class="px-3 py-2.5 rounded-lg flex items-center gap-3 transition {{ request()->routeIs('admin.pages.terms') ? $activeClass : $inactiveClass }}">
                    <span>Syarat & Ketentuan</span>
                </a>
                <a href="{{ route('admin.pages.contact') }}" class="px-3 py-2.5 rounded-lg flex items-center gap-3 transition {{ request()->routeIs('admin.pages.contact') ? $activeClass : $inactiveClass }}">
                    <span>Kontak</span>
                </a>
                <a href="{{ route('admin.pages.guide') }}" class="px-3 py-2.5 rounded-lg flex items-center gap-3 transition {{ request()->routeIs('admin.pages.guide') ? $activeClass : $inactiveClass }}">
                    <span>Panduan</span>
                </a>

            </nav>

            {{-- Logout --}}
            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2.5 rounded-lg transition font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- ================= KONTEN UTAMA (KANAN) ================= --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">
            
            {{-- Header Mobile (Hanya muncul di HP) --}}
            <header class="md:hidden bg-white border-b h-16 flex items-center justify-between px-4 z-20">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logokost.png') }}" alt="Logo" class="h-8 w-8">
                    <span class="font-bold text-lg">Kostarae</span>
                </div>
                {{-- Tombol Hamburger belum difungsikan dengan JS di versi simple ini, 
                     tapi struktur layout sudah siap --}}
                <button class="text-gray-600">☰</button> 
            </header>

            {{-- Area Konten Scrollable --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8">
                
                {{-- Flash Message Otomatis via SweetAlert --}}
                @if(session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: "{{ session('success') }}",
                                timer: 3000,
                                showConfirmButton: false
                            });
                        });
                    </script>
                @endif

                @if(session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: "{{ session('error') }}",
                            });
                        });
                    </script>
                @endif

                {{-- ISI KONTEN --}}
                @yield('content')
                
            </main>
        </div>
    </div>

    {{-- Script SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
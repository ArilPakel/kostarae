<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kostarae</title>
    
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Alpine.js (Untuk interaksi UI) --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    {{-- Style Tambahan --}}
    <style>
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased">

    {{-- 1. LOGIC NAVBAR OTOMATIS --}}
    @auth
        @include('partials.navbar-user')
    @else
        {{-- Pastikan nama file ini sesuai dengan yang kamu edit tadi (misal: navbar-guest) --}}
        @include('partials.navbar-guest') 
    @endauth

    {{-- 2. TOAST NOTIFIKASI GLOBAL --}}
    @if (session('status'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             x-init="setTimeout(() => show = false, 4000)" 
             class="fixed top-24 right-4 z-[9999] bg-emerald-500 text-white px-6 py-4 rounded-xl shadow-xl flex items-center gap-4 max-w-sm"
             style="display: none;">
            
            <div class="bg-white/20 p-2 rounded-full">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <div>
                <h4 class="font-bold text-sm">Berhasil!</h4>
                <p class="text-xs opacity-90">
                    @if(session('status') === 'password-updated')
                        Kata sandi Anda telah berhasil diperbarui.
                    @elseif(session('status') === 'profile-updated')
                        Profil Anda berhasil diperbarui.
                    @else
                        {{ session('status') }}
                    @endif
                </p>
            </div>

            <button @click="show = false" class="text-white/70 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    {{-- 3. KONTEN HALAMAN --}}
    <main class="page-content min-h-screen">
        @yield('content')
    </main>

    {{-- 4. MODAL TAMBAHAN --}}
    @include('partials.register-modal')

    {{-- 5. SCRIPT SCROLL NAVBAR (BARU DITAMBAHKAN) --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navbar = document.getElementById('navbar');

            // Cek apakah element navbar ada (untuk menghindari error di halaman tanpa navbar)
            if (navbar) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 10) {
                        // Saat Scroll: Warna Hijau Kostarae + Shadow
                        navbar.classList.add('bg-[#2D4A53]', 'shadow-md');
                        navbar.classList.remove('bg-transparent');
                    } else {
                        // Saat di Pucuk Atas: Transparan
                        navbar.classList.add('bg-transparent');
                        navbar.classList.remove('bg-[#2D4A53]', 'shadow-md');
                    }
                });
            }
        });
    </script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kost Marketplace</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">

    <div class="min-h-screen flex flex-col justify-center">
        
        {{-- Container --}}
        <div class="mx-auto w-full max-w-md bg-white shadow-lg rounded-xl p-8">

            {{-- Brand --}}
            <div class="flex items-center gap-2 justify-center mb-6">
                <svg width="32" height="32" class="text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 10L12 3l9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V10z"/>
                </svg>
                <h1 class="text-xl font-semibold text-gray-800 tracking-wide">
                    Kost Marketplace
                </h1>
            </div>

            {{-- Flash message --}}
            @if(session('success'))
                <div class="text-green-600 text-sm mb-4 bg-green-100 px-3 py-2 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="text-red-600 text-sm mb-4 bg-red-100 px-3 py-2 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            {{-- FORM LOGIN MANUAL --}}
            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Phone / Username --}}
                <div>
                    <label class="block text-gray-600 text-sm font-medium mb-1">
                        Nomor Telepon
                    </label>
                    <input 
                        type="text" 
                        name="phone" 
                        value="{{ old('phone') }}"
                        class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-blue-400 focus:border-blue-600 outline-none"
                        placeholder="Masukkan nomor telepon"
                        required
                    />
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-gray-600 text-sm font-medium mb-1">
                        Password
                    </label>
                    <input 
                        type="password" 
                        name="password"
                        class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-blue-400 focus:border-blue-600 outline-none"
                        placeholder="********"
                        required
                    />
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                    Masuk
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center my-5">
                <div class="h-px bg-gray-300 flex-1"></div>
                <p class="text-xs text-gray-500 px-3">atau masuk dengan</p>
                <div class="h-px bg-gray-300 flex-1"></div>
            </div>

            {{-- ========================================== --}}
            {{-- TOMBOL GOOGLE (Login Socialite) --}}
            {{-- ========================================== --}}
            <div class="mb-6">
                <a href="{{ route('google.login') }}" 
                   class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Masuk dengan Google
                </a>
            </div>

            {{-- Link register --}}
            <div class="text-center text-sm pt-2">
                <p class="text-gray-500">Belum punya akun?</p>
                <div class="flex justify-center gap-3 mt-2">
                    <a class="text-blue-600 hover:underline font-medium" href="{{ route('register.user') }}">
                        Register User
                    </a>
                    |
                    <a class="text-blue-600 hover:underline font-medium" href="{{ route('register.owner') }}">
                        Register Pemilik
                    </a>
                </div>
            </div>

            {{-- Back to Home --}}
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 text-sm flex items-center justify-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 19l-7-7 7-7v4h8v6h-8v4z"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

</body>
</html>
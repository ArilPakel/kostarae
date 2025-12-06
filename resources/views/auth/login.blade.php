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

            {{-- FORM LOGIN --}}
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

                {{-- Submit --}}
                <button 
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                    Masuk
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center my-5">
                <div class="h-px bg-gray-300 flex-1"></div>
                <p class="text-xs text-gray-500 px-3">atau</p>
                <div class="h-px bg-gray-300 flex-1"></div>
            </div>

            {{-- Link register --}}
            <div class="text-center text-sm">
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

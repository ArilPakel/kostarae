<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>admin login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-xl w-full max-w-md p-8">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800"> 
            Admin login
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 text-sm px-3 py-2 rounded-md mb-4 text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

             {{-- Email --}}
             <div class="mb-4">
                <label class="block font-semibold"></label>
                <input 
                type="email"
                name="email"
                class="w-full px-4 py-2 border rounded-md outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="admin@example.com"
                required
                value="{{ old('email') }}">

            {{-- Password --}}
            <div class="mb-6">
                <label class="block font-semibold mb-1">Password</label>
                <input 
                type="password"
                name="password"
                class="w-full px-4 py-2 border rounded-md outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Masukkan Password"
                required>
            </div>

            <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounde-md transition-all">
                Login
            </button>
                    
        </form>

             </div>
    </div>
</body>
</html>
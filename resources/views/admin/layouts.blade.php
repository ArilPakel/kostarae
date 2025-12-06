<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 flex">

    {{-- Sidebar --}}
    <aside class="w-64 h-screen bg-[#1E1F24] text-gray-200 flex flex-col p-5 sticky top-0">
        <div class="flex items-center gap-3 mb-8">
            <img src="{{ asset('images/logokost.png') }}" alt="Logo Kostarae" class="h-10 w-10 object-contain">
            <span class="text-2xl font-bold tracking-wide">Kostarae</span>
        </div>

        <nav class="flex flex-col space-y-3 text-sm ">
            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg hover:bg-gray-700">
                Dashboard
            </a>
            <a href="{{ route('admin.kost.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-700">
                Data Kost
            </a>
            <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-700">
                Pengguna
            </a>
            <a href="{{ route('admin.owners.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-700">
                Pemilik Kost
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-700">
                Ulasan
            </a>
            <a href="{{ route('admin.reports.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-700">
                Laporan
            </a>
            <a href="{{ route('admin.activity.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-700">
                Aktivitas
            </a>

            <hr class="border-gray-500 my-3">

            {{-- Halaman Informasi --}}
            <a href="{{ route('admin.pages.terms') }}" class="px-3 py-2 rounded-lg hover:bg-gray-700 "> Syarat dan
                ketentuan </a>
            <a href="{{ route('admin.pages.contact') }}" class="px-3 py-2 rounded-lg hover:bg-gray-700 "> Kontak </a>
            <a href="{{ route('admin.pages.guide') }}" class="px-3 py-2 rounded-lg hover:bg-gray-700 "> Panduan </a>

        </nav>

        <div class="mt-auto">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="w-full mt-6 bg-orange-500 hover:bg-red-600 py-2 rounded-lg">
                    Logout
                </button>
            </form>

        </div>

    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-6">
        @yield('content')
    </main>

</body>

</html>

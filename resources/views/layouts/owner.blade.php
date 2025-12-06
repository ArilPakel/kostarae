<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik Kost</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<script src="//unpkg.com/alpinejs" defer></script>

<body class="bg-gray-100">
    @auth
        @include('partials.navbar-user')
    @endauth

    <div class="max-w-7xl mx-auto p-6">
        @yield('content')
    </div>

</body>

</html>

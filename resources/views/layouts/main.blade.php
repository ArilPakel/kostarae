<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kostarae`</title>
    @vite('resources/css/app.css')
</head>


<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@include('partials.register-modal')

<body>

    @include('partials.navbar')

    <div class=page-content>
        @yield('content')
    </div>

</body>

</html>

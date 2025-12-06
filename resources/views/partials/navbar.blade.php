{{-- Jika belum login --}}
@guest
    @include('partials.navbar-guest')
@endguest

{{-- Jika sudah login --}}
@auth
    @include('partials.navbar-user')
@endauth

@extends('layouts.main')

@section('content')

    {{-- 1. MODAL (Hidden) --}}
    @include('partials.register-modal')

    {{-- 2. HERO SECTION (Pencarian & Banner) - WAJIB DI ATAS --}}
    @include('partials.hero')

    {{-- 3. DAFTAR KOST (Promo & Rekomendasi) --}}
    {{-- PENTING: Panggil include ini CUKUP SEKALI. --}}
    {{-- File ini sudah cerdas memisahkan Promo dan Rekomendasi di dalamnya --}}
    @include('kost.public', [
        'iklanKost' => $iklanKost ?? collect([]),
        'rekomendasiKost' => $rekomendasiKost ?? $kosts ?? collect([])
    ])

    {{-- 4. FOOTER --}}
    @include('partials.footer')

@endsection
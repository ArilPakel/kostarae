@extends('admin.layouts')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Kontak Admin</h1>

    <p class="mb-4 text-gray-700">
        Jika ada kendala dalam sistem, hubungi kami melalui:
    </p>

    <div class="space-y-3 text-gray-700">
        <p><strong>Email:</strong> admin@mail.com</p>
        <p><strong>Telepon:</strong> +62 812-1234-5678</p>
        <p><strong>Alamat:</strong> Jl. Kost Bahagia No. 10, Jakarta</p>
    </div>

    <hr class="my-6"/>

    <h2 class="text-xl font-semibold mb-2">Form Kontak</h2>

    <form class="space-y-4">
        <input type="text" class="w-full border rounded-lg p-2" placeholder="Nama Anda">
        <input type="email" class="w-full border rounded-lg p-2" placeholder="Email Anda">
        <textarea class="w-full border rounded-lg p-2" placeholder="Pesan"></textarea>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Kirim
        </button>
    </form>
</div>
@endsection

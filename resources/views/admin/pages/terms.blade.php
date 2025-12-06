@extends('admin.layouts')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Syarat & Ketentuan</h1>

    <p class="text-gray-700 leading-relaxed mb-4">
        Selamat datang di sistem Admin Kost. Dengan menggunakan layanan ini, Anda menyetujui ketentuan berikut:
    </p>

    <ul class="list-disc pl-6 space-y-2 text-gray-700">
        <li>Admin wajib menjaga kerahasiaan akun.</li>
        <li>Pengguna tidak boleh mengupload konten ilegal atau merugikan.</li>
        <li>Data kost harus valid dan sesuai fakta.</li>
        <li>Segala pelanggaran bisa menyebabkan akun diblokir.</li>
    </ul>

    <p class="mt-6 text-gray-600">
        Dengan melanjutkan, Anda menyetujui semua syarat ini.
    </p>
</div>
@endsection

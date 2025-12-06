@extends('admin.layouts')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Panduan Penggunaan Admin</h1>

    <p class="text-gray-700 mb-4">Berikut adalah langkah-langkah dasar penggunaan sistem ini:</p>

    <ol class="list-decimal pl-6 space-y-3 text-gray-700">
        <li>
            Masuk ke Dashboard melalui menu Admin.
        </li>
        <li>
            Kelola data Kost melalui menu <strong>Data Kost</strong> (tambah/edit/hapus).
        </li>
        <li>
            Kelola Pengguna melalui menu <strong>Manajemen Users</strong>.
        </li>
        <li>
            Kelola pemilik kost melalui menu <strong>Pemilik Kost</strong>.
        </li>
        <li>
            Cek ulasan pengguna melalui menu <strong>Ulasan</strong>.
        </li>
        <li>
            Cek laporan dan aktivitas admin melalui menu <strong>Laporan</strong> & <strong>Aktivitas</strong>.
        </li>
    </ol>

    <div class="mt-6 text-gray-600">
        Jika butuh bantuan lebih lanjut, hubungi Admin melalui halaman kontak.
    </div>
</div>
@endsection

@extends('admin.layouts')

@section('title', 'Panduan Admin')

@section('content')
<div class="max-w-6xl mx-auto pb-12 font-sans text-gray-800">

    {{-- ================================================================
       1. HEADER HALAMAN
    ================================================================ --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight flex items-center gap-3">
                📘 Panduan Penggunaan Admin
            </h1>
            <p class="text-sm text-gray-500 mt-2 max-w-3xl leading-relaxed">
                Panduan resmi operasional Administrator Kostarae dalam mengelola data kost, pengguna, verifikasi, ulasan, laporan, 
                dan sistem rekomendasi secara aman, objektif, dan profesional.
            </p>
        </div>
        <div class="flex flex-col gap-2 items-end">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-900 text-white shadow-sm">
                <svg class="w-3 h-3 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                Admin Only
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                📌 Versi Sistem Aktif
            </span>
        </div>
    </div>

    {{-- ================================================================
       2. RINGKASAN PERAN ADMIN
    ================================================================ --}}
    <div class="bg-gradient-to-r from-blue-50 to-white border-l-4 border-blue-600 rounded-r-xl p-6 mb-10 shadow-sm">
        <div class="flex items-start gap-4">
            <div class="p-3 bg-blue-100 rounded-lg text-blue-600 shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Peran & Tanggung Jawab Utama</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                        Admin bertugas sebagai <strong>pengelola data, moderator konten, dan pengawas sistem</strong>.
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                        Setiap tindakan (create, update, delete, verify) <strong>tercatat otomatis</strong> dalam Log Aktivitas (Audit Trail).
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                        Admin wajib bertindak <strong>objektif, netral</strong>, dan sesuai dengan Syarat & Ketentuan yang berlaku.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ================================================================
       3. PANDUAN BERDASARKAN MENU (GRID LAYOUT)
    ================================================================ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        {{-- A. DASHBOARD --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-4 border-b border-gray-100 pb-3">
                <span class="text-2xl">🧭</span>
                <h3 class="font-bold text-gray-900 text-lg">Dashboard Overview</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4">Pusat pemantauan kondisi sistem secara real-time.</p>
            <ul class="space-y-3 text-sm text-gray-600">
                <li><strong>Statistik Utama:</strong> Pantau angka Total Kost, Kost Pending (Perlu Review), Kost Aktif, dan Ditolak.</li>
                <li><strong>Status Sistem:</strong> Perhatikan notifikasi atau alert pada dashboard untuk tindakan cepat.</li>
                <li><strong>Prioritas:</strong> Admin harus segera bertindak jika angka pada kartu "Perlu Review" > 0.</li>
            </ul>
        </div>

        {{-- B. DATA KOST --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-4 border-b border-gray-100 pb-3">
                <span class="text-2xl">🏠</span>
                <h3 class="font-bold text-gray-900 text-lg">Manajemen Data Kost</h3>
            </div>
            <ul class="space-y-3 text-sm text-gray-600">
                <li><strong>Daftar Kost:</strong> Gunakan filter status untuk melihat kost Pending/Aktif.</li>
                <li><strong>Verifikasi (Terima):</strong> Pastikan foto jelas, harga wajar, dan alamat valid sebelum mengubah status ke <span class="text-emerald-600 font-bold">Aktif</span>.</li>
                <li><strong>Verifikasi (Tolak):</strong> Wajib menyertakan alasan penolakan yang jelas agar pemilik dapat memperbaiki data.</li>
                <li><strong>Edit/Hapus:</strong> Admin memiliki hak akses penuh, namun perubahan data harus didasari alasan kuat.</li>
            </ul>
        </div>

        {{-- C. PENGGUNA --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-4 border-b border-gray-100 pb-3">
                <span class="text-2xl">👤</span>
                <h3 class="font-bold text-gray-900 text-lg">Manajemen Pengguna</h3>
            </div>
            <ul class="space-y-3 text-sm text-gray-600">
                <li><strong>Tipe User:</strong> Sistem membedakan antara Pencari Kost, Pemilik Kost, dan Admin.</li>
                <li><strong>Monitoring:</strong> Cek daftar pengguna baru secara berkala.</li>
                <li><strong>Batasan:</strong> Admin dilarang mengubah data sensitif (password/email) pengguna tanpa permintaan resmi atau prosedur reset yang sah.</li>
            </ul>
        </div>

        {{-- D. PEMILIK KOST --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-4 border-b border-gray-100 pb-3">
                <span class="text-2xl">🏡</span>
                <h3 class="font-bold text-gray-900 text-lg">Manajemen Pemilik Kost</h3>
            </div>
            <ul class="space-y-3 text-sm text-gray-600">
                <li><strong>Validasi:</strong> Pastikan pemilik adalah entitas nyata (bukan bot).</li>
                <li><strong>Relasi Data:</strong> Setiap pemilik terhubung dengan satu atau banyak data kost.</li>
                <li><strong>Suspend/Blokir:</strong> Jika pemilik diblokir karena pelanggaran, seluruh kost miliknya akan otomatis tidak tampil (non-aktif) di website.</li>
            </ul>
        </div>

        {{-- E. ULASAN --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-4 border-b border-gray-100 pb-3">
                <span class="text-2xl">⭐</span>
                <h3 class="font-bold text-gray-900 text-lg">Moderasi Ulasan</h3>
            </div>
            <ul class="space-y-3 text-sm text-gray-600">
                <li><strong>Monitoring:</strong> Pantau ulasan masuk untuk mencegah spam atau konten tidak pantas.</li>
                <li><strong>Kebijakan Hapus:</strong> Dilarang menghapus ulasan negatif yang valid/konstruktif. Ulasan hanya boleh dihapus jika mengandung SARA, Kebencian, atau Spam.</li>
                <li><strong>Dampak:</strong> Ingat, ulasan mempengaruhi skor dalam Sistem Rekomendasi.</li>
            </ul>
        </div>

        {{-- F. LAPORAN & AKTIVITAS --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-4 border-b border-gray-100 pb-3">
                <span class="text-2xl">📊</span>
                <h3 class="font-bold text-gray-900 text-lg">Laporan & Audit</h3>
            </div>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <h4 class="text-xs font-bold uppercase text-gray-400 mb-1">Laporan Sistem</h4>
                    <p class="text-sm text-gray-600">Gunakan fitur ini untuk melihat rekap data per periode. Laporan dapat diekspor ke PDF untuk arsip.</p>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase text-gray-400 mb-1">Log Aktivitas (Audit Trail)</h4>
                    <p class="text-sm text-gray-600">Semua aksi admin (Login, Edit, Hapus) tercatat disini dan <strong>tidak dapat dihapus manual</strong> demi keamanan data.</p>
                </div>
            </div>
        </div>

    </div>

    {{-- ================================================================
       SECTION KHUSUS: SISTEM REKOMENDASI (FULL WIDTH)
    ================================================================ --}}
    <div class="bg-white rounded-xl border border-indigo-100 shadow-sm overflow-hidden mb-10">
        <div class="px-6 py-5 bg-indigo-50 border-b border-indigo-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white rounded-lg text-indigo-600 border border-indigo-200">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <div>
                    <h3 class="font-bold text-indigo-900 text-lg">Sistem Rekomendasi Kost</h3>
                    <p class="text-xs text-indigo-700">Mekanisme Algoritma Otomatis & Peran Admin</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-white text-indigo-700 text-xs font-bold rounded border border-indigo-200 shadow-sm">
                System Generated
            </span>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Kiri: Penjelasan --}}
            <div>
                <h4 class="font-bold text-gray-800 mb-2">Bagaimana cara kerjanya?</h4>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">
                    Sistem rekomendasi Kostarae bekerja secara <strong>otomatis</strong> berdasarkan algoritma penilaian kualitas. 
                    <br><br>
                    <span class="text-red-600 font-bold">PENTING:</span> Admin <strong>TIDAK BISA</strong> memilih kost secara manual untuk masuk ke dalam daftar rekomendasi. Hal ini menjaga objektivitas platform.
                </p>
                <div class="bg-gray-50 p-3 rounded border border-gray-200">
                    <h5 class="text-xs font-bold text-gray-700 uppercase mb-1">Peran Admin:</h5>
                    <p class="text-xs text-gray-600">Hanya melakukan monitoring. Jika ditemukan kost rekomendasi yang melanggar aturan, Admin berhak menindak (menonaktifkan), yang otomatis akan menghapusnya dari rekomendasi.</p>
                </div>
            </div>

            {{-- Kanan: Syarat --}}
            <div class="bg-indigo-50/50 p-5 rounded-xl border border-indigo-100">
                <h4 class="font-bold text-indigo-900 mb-3 text-sm uppercase tracking-wide">Syarat Masuk Rekomendasi (Otomatis):</h4>
                <ul class="space-y-2.5">
                    <li class="flex items-start gap-2 text-sm text-gray-700">
                        <span class="text-green-500 font-bold text-lg leading-none">✓</span>
                        <span>Status kost wajib <strong>Aktif & Terverifikasi</strong>.</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-700">
                        <span class="text-green-500 font-bold text-lg leading-none">✓</span>
                        <span>Memiliki <strong>Rating Minimal 4.0</strong> Bintang.</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-700">
                        <span class="text-green-500 font-bold text-lg leading-none">✓</span>
                        <span>Memiliki jumlah ulasan yang cukup (misal: ≥ 2 ulasan).</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-700">
                        <span class="text-green-500 font-bold text-lg leading-none">✓</span>
                        <span><strong>Data Lengkap</strong> (Foto sampul, detail fasilitas, peta lokasi).</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-700">
                        <span class="text-green-500 font-bold text-lg leading-none">✓</span>
                        <span>Tidak memiliki riwayat pelanggaran berat dalam sistem.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ================================================================
       4. ATURAN PENTING (WARNING CARD)
    ================================================================ --}}
    <div class="bg-red-50 border border-red-100 rounded-xl p-6 mb-12">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-red-100 rounded-lg text-red-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <h3 class="font-bold text-red-800 text-lg">Larangan & Kode Etik Admin</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-red-900/80">
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Dilarang</strong> memanipulasi data kost untuk keuntungan pribadi.</li>
                <li><strong>Dilarang</strong> menerima imbalan dalam proses verifikasi.</li>
                <li><strong>Dilarang</strong> menghapus data pengguna tanpa prosedur valid.</li>
            </ul>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Dilarang</strong> menyebarkan data pribadi (No HP/Email) pengguna.</li>
                <li><strong>Dilarang</strong> meminjamkan akun admin kepada orang lain.</li>
                <li>Pelanggaran terhadap aturan ini akan dikenakan sanksi tegas hingga pemblokiran akun dan jalur hukum.</li>
            </ul>
        </div>
    </div>

    {{-- ================================================================
       5. PENUTUP
    ================================================================ --}}
    <div class="text-center border-t border-gray-200 pt-8">
        <p class="text-sm text-gray-500 mb-2">
            Dengan menggunakan Dashboard Admin Kostarae, Admin dianggap telah membaca, memahami, dan menyetujui seluruh panduan operasional di atas.
        </p>
        <div class="text-xs text-gray-400 font-mono">
            &copy; {{ date('Y') }} Kostarae System | Panduan Admin – Versi Aktif
        </div>
    </div>

</div>
@endsection
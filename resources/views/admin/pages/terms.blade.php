@extends('admin.layouts')

@section('title', 'Kebijakan Administrator')

@section('content')
<div class="max-w-6xl mx-auto pb-12 font-sans text-gray-800">

    {{-- 1. HEADER HALAMAN --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Kebijakan & Ketentuan Administrator</h1>
            <p class="text-sm text-gray-500 mt-1">
                Pedoman standar operasional, protokol keamanan, dan batasan wewenang dalam pengelolaan sistem Kostarae.
            </p>
        </div>
        <div>
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                Internal Policy v1.0
            </span>
        </div>
    </div>

    {{-- 2. ALERT AUDIT TRAIL (Highlight Sistem) --}}
    <div class="bg-blue-50 border-l-4 border-blue-600 p-5 rounded-r-xl mb-8 shadow-sm flex items-start gap-4">
        <div class="p-2 bg-blue-100 rounded-lg text-blue-600 shrink-0">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
        </div>
        <div>
            <h3 class="font-bold text-blue-900 text-sm uppercase tracking-wide mb-1">Pemberitahuan Sistem: Audit Trail Aktif</h3>
            <p class="text-sm text-blue-800 leading-relaxed">
                Seluruh aktivitas Admin (Login, Verifikasi, Edit, Hapus) dicatat secara otomatis oleh sistem dalam <strong>Log Aktivitas</strong> yang bersifat permanen (immutable). Log ini digunakan untuk keperluan monitoring, audit keamanan, dan bukti digital jika terjadi sengketa data.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- 3. CARD: HAK AKSES & KEAMANAN --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 h-full">
            <div class="flex items-center gap-3 mb-4 border-b border-gray-100 pb-4">
                <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <h2 class="font-bold text-gray-900">Hak Akses & Keamanan Akun</h2>
            </div>
            <ul class="space-y-3 text-sm text-gray-600">
                <li class="flex gap-2">
                    <span class="text-indigo-500 font-bold">•</span>
                    <span>Admin wajib menjaga kerahasiaan kredensial (Email & Password).</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-indigo-500 font-bold">•</span>
                    <span><strong>Dilarang keras</strong> meminjamkan akun kepada pihak lain. Setiap akun merepresentasikan satu individu penanggung jawab.</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-indigo-500 font-bold">•</span>
                    <span>Admin bertanggung jawab penuh atas segala perubahan data yang terjadi di bawah sesi login akunnya.</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-indigo-500 font-bold">•</span>
                    <span>Wajib melakukan Logout saat meninggalkan perangkat kerja.</span>
                </li>
            </ul>
        </div>

        {{-- 4. CARD: MANAJEMEN DATA KOST --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 h-full">
            <div class="flex items-center gap-3 mb-4 border-b border-gray-100 pb-4">
                <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <h2 class="font-bold text-gray-900">Validasi & Verifikasi Data</h2>
            </div>
            <ul class="space-y-3 text-sm text-gray-600">
                <li class="flex gap-2">
                    <span class="text-green-500 font-bold">✓</span>
                    <span>Verifikasi harus dilakukan secara <strong>objektif</strong> berdasarkan kelengkapan dan kevalidan data, bukan hubungan personal.</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-green-500 font-bold">✓</span>
                    <span>Admin berhak menolak ajuan kost jika: Foto tidak layak/buram, Alamat fiktif, atau Harga tidak wajar (indikasi penipuan).</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-green-500 font-bold">✓</span>
                    <span>Perubahan status kost (Pending ke Aktif/Ditolak) harus disertai alasan yang jelas jika ditolak.</span>
                </li>
            </ul>
        </div>

        {{-- 5. CARD: SISTEM REKOMENDASI (HIGHLIGHT / WAJIB DETAIL) --}}
        <div class="md:col-span-2 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 flex items-center gap-3">
                <div class="p-2 bg-white rounded-lg border border-gray-200 text-yellow-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                </div>
                <div>
                    <h2 class="font-bold text-gray-900">Ketentuan Sistem Rekomendasi Kost</h2>
                    <p class="text-xs text-gray-500">Mekanisme algoritma dan batasan intervensi admin.</p>
                </div>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Kiri: Prinsip --}}
                <div>
                    <h3 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wide">Prinsip Dasar</h3>
                    <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                        Fitur "Rekomendasi Kost" di Kostarae bekerja menggunakan <strong>algoritma otomatis</strong>. Admin hanya bertugas memantau hasil keluaran sistem dan memastikan tidak ada anomali.
                    </p>
                    <div class="bg-red-50 p-3 rounded-lg border border-red-100">
                        <p class="text-xs text-red-700 font-medium flex gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            <strong>Larangan Keras:</strong> Admin dilarang memanipulasi database atau menerima imbalan untuk memasukkan kost tertentu ke dalam list rekomendasi secara manual (bypass sistem).
                        </p>
                    </div>
                </div>

                {{-- Kanan: Syarat Teknis --}}
                <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wide">Kriteria Kelayakan Sistem</h3>
                    <ul class="space-y-2.5">
                        <li class="flex items-start gap-2 text-xs text-gray-700">
                            <span class="text-emerald-500 font-bold bg-emerald-50 rounded px-1">SYARAT 1</span>
                            Status kost wajib <strong>Aktif (Terverifikasi)</strong>.
                        </li>
                        <li class="flex items-start gap-2 text-xs text-gray-700">
                            <span class="text-emerald-500 font-bold bg-emerald-50 rounded px-1">SYARAT 2</span>
                            Memiliki <strong>Rating Rata-rata ≥ 4.0</strong>.
                        </li>
                        <li class="flex items-start gap-2 text-xs text-gray-700">
                            <span class="text-emerald-500 font-bold bg-emerald-50 rounded px-1">SYARAT 3</span>
                            Telah diulas oleh minimal <strong>2 pengguna berbeda</strong> (untuk validitas).
                        </li>
                        <li class="flex items-start gap-2 text-xs text-gray-700">
                            <span class="text-emerald-500 font-bold bg-emerald-50 rounded px-1">SYARAT 4</span>
                            Data Profil Kost (Foto, Fasilitas, Peta) terisi <strong>100% Lengkap</strong>.
                        </li>
                        <li class="flex items-start gap-2 text-xs text-gray-700">
                            <span class="text-emerald-500 font-bold bg-emerald-50 rounded px-1">SYARAT 5</span>
                            Tidak memiliki catatan pelanggaran berat dalam 30 hari terakhir.
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- 6. CARD: MODERASI & LAPORAN --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 h-full">
            <div class="flex items-center gap-3 mb-4 border-b border-gray-100 pb-4">
                <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>
                </div>
                <h2 class="font-bold text-gray-900">Moderasi Konten & Laporan</h2>
            </div>
            <p class="text-sm text-gray-600 mb-3">
                Admin bertindak sebagai <strong>mediator netral</strong>. Tindakan moderasi hanya boleh dilakukan jika ada bukti pelanggaran:
            </p>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex gap-2">
                    <span class="text-red-500 font-bold">•</span>
                    <span><strong>Penghapusan Ulasan:</strong> Hanya diperbolehkan jika mengandung unsur SARA, pornografi, spam, atau terbukti palsu. Ulasan negatif yang konstruktif DILARANG dihapus.</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-red-500 font-bold">•</span>
                    <span><strong>Penanganan Laporan:</strong> Wajib merespon laporan user maksimal 2x24 jam kerja.</span>
                </li>
            </ul>
        </div>

        {{-- 7. CARD: SANKSI ADMIN --}}
        <div class="bg-white rounded-xl border border-red-100 shadow-sm p-6 h-full">
            <div class="flex items-center gap-3 mb-4 border-b border-red-100 pb-4">
                <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center text-red-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <h2 class="font-bold text-red-800">Pelanggaran & Sanksi</h2>
            </div>
            <p class="text-sm text-gray-600 mb-4">
                Penyalahgunaan wewenang (kebocoran data, manipulasi verifikasi, korupsi rekomendasi) akan dikenakan sanksi bertingkat:
            </p>
            <div class="space-y-3">
                <div class="flex items-center gap-3 bg-gray-50 p-2 rounded border border-gray-100">
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded">Tahap 1</span>
                    <span class="text-xs text-gray-700 font-medium">Peringatan Tertulis (SP1)</span>
                </div>
                <div class="flex items-center gap-3 bg-gray-50 p-2 rounded border border-gray-100">
                    <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded">Tahap 2</span>
                    <span class="text-xs text-gray-700 font-medium">Suspensi Akun Sementara</span>
                </div>
                <div class="flex items-center gap-3 bg-red-50 p-2 rounded border border-red-100">
                    <span class="px-2 py-1 bg-red-600 text-white text-xs font-bold rounded">Tahap 3</span>
                    <span class="text-xs text-red-700 font-bold">Pemblokiran Permanen & Jalur Hukum</span>
                </div>
            </div>
        </div>

    </div>

    {{-- 8. FOOTER PERSETUJUAN --}}
    <div class="mt-10 pt-6 border-t border-gray-200 text-center">
        <p class="text-sm text-gray-500 mb-2">
            Dengan mengakses Dashboard Admin, Anda menyatakan telah membaca, memahami, dan menyetujui seluruh ketentuan di atas.
        </p>
        <div class="text-xs text-gray-400 font-mono">
            Dokumen Internal Kostarae • Diperbarui: {{ date('Y') }}
        </div>
    </div>

</div>
@endsection
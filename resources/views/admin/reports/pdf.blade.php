<!DOCTYPE html>
<html>
<head>
    <title>Laporan Ekosistem Kostarae</title>
    <style>
        /* RESET & BASIC STYLE */
        body { font-family: sans-serif; font-size: 10pt; color: #333; }
        .page-break { page-break-after: always; }
        
        /* HEADER */
        .header { width: 100%; border-bottom: 2px solid #2D4A53; padding-bottom: 10px; margin-bottom: 20px; }
        .header-logo { font-size: 20pt; font-weight: bold; color: #2D4A53; text-transform: uppercase; }
        .header-meta { text-align: right; font-size: 9pt; line-height: 1.4; }

        /* SECTION TITLE */
        .section-title { font-size: 12pt; font-weight: bold; margin-bottom: 10px; color: #000; text-transform: uppercase; border-left: 4px solid #2D4A53; padding-left: 8px; }

        /* STATS GRID (Menggunakan Tabel untuk Layout) */
        .stats-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .stats-table td { width: 25%; padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd; text-align: center; }
        .stat-label { font-size: 8pt; text-transform: uppercase; color: #666; display: block; margin-bottom: 5px; }
        .stat-value { font-size: 16pt; font-weight: bold; color: #2D4A53; }

        /* DATA TABLE */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th { background-color: #2D4A53; color: white; padding: 8px; font-size: 9pt; text-align: left; }
        .data-table td { border-bottom: 1px solid #eee; padding: 8px; font-size: 9pt; }
        .data-table tr:nth-child(even) { background-color: #f9f9f9; }

        /* FOOTER */
        .footer { position: fixed; bottom: 0; left: 0; right: 0; height: 30px; border-top: 1px solid #ddd; padding-top: 10px; font-size: 8pt; color: #999; text-align: center; }
    </style>
</head>
<body>

    {{-- HEADER RESMI --}}
    <table class="header">
        <tr>
            <td width="50%">
                <div class="header-logo">KOSTARAE</div>
                <div style="font-size: 10pt;">Sistem Manajemen Kost</div>
            </td>
            <td width="50%" class="header-meta">
                <strong>LAPORAN EKOSISTEM SISTEM</strong><br>
                Tanggal Cetak: {{ $date }} Pukul {{ $time }}<br>
                Dicetak Oleh: {{ $admin }} (Administrator)
            </td>
        </tr>
    </table>

    {{-- RINGKASAN STATISTIK --}}
    <div class="section-title">Ringkasan Statistik Ekosistem</div>
    <table class="stats-table">
        <tr>
            <td>
                <span class="stat-label">Total Pencari</span>
                <span class="stat-value">{{ $stats['total_user'] }}</span>
            </td>
            <td>
                <span class="stat-label">Total Unit Kost</span>
                <span class="stat-value">{{ $stats['total_kost'] }}</span>
            </td>
            <td>
                <span class="stat-label">Menunggu Review</span>
                <span class="stat-value" style="color: #d97706;">{{ $stats['pending_kost'] }}</span>
            </td>
            <td>
                <span class="stat-label">Kualitas (Rating)</span>
                <span class="stat-value">⭐ {{ number_format($stats['avg_rating'], 1) }}</span>
            </td>
        </tr>
    </table>

    {{-- DATA UTAMA (Top Kost) --}}
    <div class="section-title">Data Unit Kost Terpopuler (Top 10)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Kost</th>
                <th width="25%">Pemilik</th>
                <th width="15%">Rating</th>
                <th width="10%">Ulasan</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topKosts as $index => $kost)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $kost->nama }}</strong><br>
                    <span style="font-size:8pt; color:#666;">{{ Str::limit($kost->alamat, 40) }}</span>
                </td>
                <td>{{ $kost->pemilik->name ?? 'User Terhapus' }}</td>
                <td>{{ number_format($kost->reviews_avg_rating, 1) }} / 5.0</td>
                <td>{{ $kost->reviews_count }}</td>
                <td>
                    <span style="font-weight:bold; color: #059669;">Aktif</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- INFO TAMBAHAN --}}
    <div style="margin-top: 20px; font-size: 9pt; color: #555;">
        <strong>Catatan:</strong><br>
        Laporan ini mencakup data real-time hingga {{ $date }}. 
        Gunakan data ini sebagai acuan evaluasi kualitas mitra kost dan pertumbuhan pengguna.
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        Dokumen ini dihasilkan otomatis oleh sistem Kostarae. Dilarang mengubah isi dokumen tanpa izin otoritas sistem.
    </div>

</body>
</html>
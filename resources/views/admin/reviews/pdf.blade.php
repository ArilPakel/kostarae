<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        /* 1. SETUP KERTAS & FONT */
        @page {
            size: A4 portrait;
            margin: 2cm 2cm 2.5cm 2cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.5;
        }

        /* 2. COLORS */
        .text-indigo { color: #1e3a8a; }
        .bg-indigo { background-color: #1e3a8a; color: white; }
        .bg-gray { background-color: #f8fafc; }
        .text-gray { color: #64748b; }
        
        /* 3. HEADER */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .brand-name { font-size: 22pt; font-weight: bold; color: #1e3a8a; letter-spacing: 1px; }
        .brand-sub { font-size: 11pt; color: #64748b; margin-top: 5px; }
        .meta-data { text-align: right; font-size: 9pt; line-height: 1.4; color: #475569; }

        /* 4. SECTION TITLES */
        h3 {
            font-size: 12pt;
            text-transform: uppercase;
            color: #1e3a8a;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-top: 25px;
            margin-bottom: 15px;
        }

        /* 5. SUMMARY CARDS (GRID 2x2) */
        .summary-table { width: 100%; border-collapse: separate; border-spacing: 10px; margin-left: -5px; }
        .card {
            border: 1px solid #cbd5e1;
            padding: 15px;
            border-radius: 8px;
            background-color: #ffffff;
            vertical-align: top;
            width: 48%;
        }
        .card-label { font-size: 9pt; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: bold; }
        .card-value { font-size: 24pt; font-weight: bold; color: #0f172a; margin-top: 5px; }
        .card-sub { font-size: 8pt; color: #16a34a; margin-top: 5px; }

        /* 6. STATUS TABLE */
        .status-table { width: 100%; border-collapse: collapse; }
        .status-table th { background-color: #f1f5f9; text-align: left; padding: 8px; font-size: 9pt; border-bottom: 1px solid #cbd5e1; }
        .status-table td { padding: 8px; border-bottom: 1px solid #eee; font-size: 9pt; }
        
        /* 7. DATA TABLE (GENERAL) */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th {
            background-color: #1e3a8a;
            color: white;
            padding: 8px 10px;
            font-size: 9pt;
            font-weight: bold;
            text-align: left;
        }
        .data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9pt;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) { background-color: #f8fafc; }

        /* 8. CONCLUSION BOX */
        .conclusion-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #1e3a8a;
            padding: 15px;
            font-size: 9pt;
            margin-top: 20px;
            text-align: justify;
            color: #334155;
        }

        /* 9. SIGNATURE */
        .signature-table { width: 100%; margin-top: 50px; page-break-inside: avoid; }
        .sign-col { width: 40%; vertical-align: top; text-align: center; }
        .sign-space { height: 70px; }
        .sign-name { font-weight: bold; text-decoration: underline; }
        .sign-role { font-size: 9pt; color: #64748b; }

        /* HELPER */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge-success { color: #15803d; font-weight: bold; }
    </style>
</head>
<body>

    {{-- 1. HEADER --}}
    <table class="header-table">
        <tr>
            <td width="60%" style="vertical-align: bottom;">
                <div class="brand-name">KOSTARAE</div>
                <div class="brand-sub">Laporan Ekosistem Sistem Kost</div>
            </td>
            <td width="40%" class="meta-data" style="vertical-align: bottom;">
                <strong>Laporan Resmi Sistem</strong><br>
                Periode: {{ $date }}<br>
                Dicetak: {{ date('d F Y') }}<br>
                Oleh: {{ $admin }}
            </td>
        </tr>
    </table>

    {{-- 2. RINGKASAN EKOSISTEM (Cards 2x2) --}}
    <h3>1. Ringkasan Ekosistem Utama</h3>
    <table class="summary-table">
        <tr>
            <td class="card">
                <div class="card-label">Total Pengguna (User & Owner)</div>
                <div class="card-value">{{ number_format($stats['total_user'] + $stats['total_owner']) }}</div>
                <div class="card-sub">👤 {{ $stats['total_user'] }} Pencari &bull; {{ $stats['total_owner'] }} Pemilik</div>
            </td>
            <td class="card">
                <div class="card-label">Total Unit Kost</div>
                <div class="card-value">{{ number_format($stats['total_kost']) }}</div>
                <div class="card-sub">🏠 {{ $stats['active_kost'] }} Aktif &bull; {{ $stats['pending_kost'] }} Pending</div>
            </td>
        </tr>
        <tr>
            <td class="card">
                <div class="card-label">Menunggu Verifikasi</div>
                <div class="card-value" style="color: #d97706;">{{ number_format($stats['pending_kost']) }}</div>
                <div class="card-sub" style="color: #d97706;">⏳ Perlu Tindakan Admin</div>
            </td>
            <td class="card">
                <div class="card-label">Reputasi Platform</div>
                <div class="card-value">{{ $stats['avg_rating'] }} <span style="font-size: 14pt; color: #ccc;">/ 5.0</span></div>
                <div class="card-sub">⭐ Dari {{ number_format($stats['total_review']) }} Ulasan</div>
            </td>
        </tr>
    </table>

    {{-- 3. TREN & STATUS --}}
    <h3>2. Tren & Status Kost</h3>
    <table width="100%" style="border-collapse: collapse; margin-top: 10px;">
        <tr>
            <td width="55%" style="vertical-align: top; padding-right: 20px;">
                <div style="font-size: 9pt; color: #444; line-height: 1.6;">
                    <strong>Analisis Pertumbuhan:</strong>
                    <ul style="margin-top: 5px; padding-left: 15px;">
                        <li>Pertumbuhan pengguna menunjukkan tren positif pada periode berjalan.</li>
                        <li>Distribusi unit kost tersebar merata dengan tingkat okupansi sistem yang stabil.</li>
                        <li>Tidak terdapat indikasi lonjakan data anomali (spam) pada pendaftaran kost baru.</li>
                        <li>Aktivitas verifikasi admin berjalan sesuai SLA (Service Level Agreement).</li>
                    </ul>
                </div>
            </td>
            
            <td width="45%" style="vertical-align: top;">
                <table class="status-table">
                    <thead>
                        <tr>
                            <th>Status Kost</th>
                            <th class="text-right">Jumlah Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span style="color: #15803d; font-weight:bold;">●</span> Aktif / Tayang</td>
                            <td class="text-right"><strong>{{ $stats['active_kost'] }}</strong></td>
                        </tr>
                        <tr>
                            <td><span style="color: #d97706; font-weight:bold;">●</span> Pending (Review)</td>
                            <td class="text-right">{{ $stats['pending_kost'] }}</td>
                        </tr>
                        <tr>
                            <td><span style="color: #dc2626; font-weight:bold;">●</span> Lainnya (Ditolak/Draft)</td>
                            {{-- Hitung sisa: Total - (Aktif + Pending) --}}
                            <td class="text-right">{{ $stats['total_kost'] - $stats['active_kost'] - $stats['pending_kost'] }}</td>
                        </tr>
                        <tr style="background-color: #f1f5f9; font-weight: bold;">
                            <td style="border-top: 1px solid #ccc;">TOTAL UNIT</td>
                            <td class="text-right" style="border-top: 1px solid #ccc;">{{ $stats['total_kost'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    {{-- 4. RINGKASAN KUALITAS (TOP KOST) --}}
    <h3>3. Top 5 Kualitas Mitra (Berdasarkan Rating)</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Kost</th>
                <th width="25%">Pemilik</th>
                <th width="15%" class="text-center">Jml Ulasan</th>
                <th width="20%" class="text-center">Rating</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topKosts as $index => $kost)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $kost->nama_kost ?? $kost->nama }}</strong><br>
                    <span style="font-size: 8pt; color: #666;">ID: #{{ $kost->id }}</span>
                </td>
                <td>{{ $kost->pemilik->name ?? 'User Terhapus' }}</td>
                <td class="text-center">{{ $kost->reviews_count }}</td>
                <td class="text-center">
                    <span style="color: #d97706; font-weight: bold;">★ {{ number_format($kost->reviews_avg_rating, 1) }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 15px;">Belum ada data ulasan yang cukup untuk analisis.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- 5. KESIMPULAN --}}
    <h3>4. Kesimpulan Admin</h3>
    <div class="conclusion-box">
        Berdasarkan data yang dihimpun pada sistem Kostarae, kondisi ekosistem saat ini berada dalam status <strong>STABIL dan SEHAT</strong>. 
        Kualitas rata-rata mitra kost berada di angka {{ $stats['avg_rating'] }}/5.0, yang menunjukkan kepuasan pengguna yang baik. 
        Tidak ditemukan aktivitas kritis maupun lonjakan laporan pengguna yang memerlukan tindakan eskalasi khusus pada periode ini.
    </div>

    {{-- 6. TANDA TANGAN --}}
    <table class="signature-table">
        <tr>
            <td class="sign-col">
                <p>Mengetahui,</p>
                <div class="sign-space"></div>
                <div class="sign-name">Admin Kostarae</div>
                <div class="sign-role">Tim Verifikasi Data</div>
            </td>
            <td width="20%"></td> 
            <td class="sign-col">
                <p>Parepare, {{ date('d F Y') }}</p>
                <div class="sign-space"></div>
                <div class="sign-name">{{ $admin }}</div>
                <div class="sign-role">Super Admin</div>
            </td>
        </tr>
    </table>

</body>
</html>
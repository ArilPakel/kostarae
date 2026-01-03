@extends('admin.layouts')
@section('title', 'Laporan & Analitik')

@section('content')
<div class="space-y-8 pb-20">

    {{-- HEADER & TOOLS --}}
    <div class="flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                📊 Laporan Ekosistem
            </h1>
            <p class="text-sm text-gray-500 mt-1">Pantau pertumbuhan pengguna dan kualitas kost secara real-time.</p>
        </div>
        
        <div class="flex gap-2 relative z-50">
        <div class="bg-white border border-gray-100 rounded-xl px-4 py-2.5 flex items-center gap-2 shadow-sm">
            <span class="text-lg">📅</span>
            <span class="text-sm text-gray-600 font-bold">{{ date('F Y') }}</span>
        </div>

        {{-- TOMBOL EXPORT PDF YANG SUDAH DIPERBAIKI --}}
        <a href="{{ route('admin.reviews.export') }}" 
        target="_blank" 
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5 cursor-pointer relative z-50">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Export Ulasan PDF
        </a>
    </div>
    </div>

    {{-- 1. SUMMARY CARDS (TETAP) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card: Total Pencari --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pencari Kost</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_user'] }}</h3>
                    <div class="mt-2 inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">
                        <span>📈 + Pengguna Baru</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">👥</div>
            </div>
        </div>

        {{-- Card: Total Unit Kost --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Unit Kost Aktif</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_kost'] }}</h3>
                    <p class="text-[10px] text-gray-400 mt-2 font-medium">Dari {{ $stats['total_owner'] }} Mitra Pemilik</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl">🏠</div>
            </div>
        </div>

        {{-- Card: Menunggu Verifikasi --}}
        <a href="{{ route('admin.kost.index', ['status' => 'pending']) }}" class="bg-white p-6 rounded-3xl border border-amber-100 shadow-sm relative overflow-hidden group hover:shadow-md transition cursor-pointer">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Perlu Review</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_kost'] }}</h3>
                    <p class="text-[10px] text-gray-400 mt-2 font-medium">Klik untuk verifikasi</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl animate-pulse">⏳</div>
            </div>
        </a>

        {{-- Card: Rating Rata-rata --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kualitas Ekosistem</p>
                    <div class="flex items-center gap-2 mt-2">
                        <h3 class="text-3xl font-bold text-gray-900">{{ number_format($stats['avg_rating'], 1) }}</h3>
                        <span class="text-sm text-gray-400 font-medium">/ 5.0</span>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-2 font-medium">Dari {{ $stats['total_review'] }} Ulasan</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-500 flex items-center justify-center text-2xl">⭐</div>
            </div>
        </div>
    </div>

    {{-- 2. CHARTS SECTION (DIOPTIMALKAN) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Chart: Pertumbuhan (Line) --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    📈 Tren Pertumbuhan
                </h3>
                <span class="text-xs font-medium text-gray-400 bg-gray-50 px-3 py-1 rounded-full border border-gray-100">6 Bulan Terakhir</span>
            </div>
            <div class="flex-1 min-h-[300px] relative">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        {{-- Chart: Distribusi (Doughnut) --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col">
            <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                📊 Status Kost
            </h3>
            <div class="flex-1 flex flex-col items-center justify-center relative min-h-[250px]">
                <div class="w-56 h-56 relative">
                    <canvas id="statusChart"></canvas>
                    {{-- Center Text --}}
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-4xl font-extrabold text-gray-800 tracking-tight">{{ $stats['total_kost'] + $stats['pending_kost'] }}</span>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Total Unit</span>
                    </div>
                </div>
            </div>
            {{-- Custom Legend --}}
            <div class="mt-4 grid grid-cols-2 gap-3">
                <a href="{{ route('admin.kost.index', ['status' => 'aktif']) }}" class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50 hover:bg-emerald-50 border border-transparent hover:border-emerald-100 transition group cursor-pointer">
                    <span class="flex items-center gap-2 text-xs font-bold text-gray-600 group-hover:text-emerald-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Aktif
                    </span>
                    <span class="text-xs font-extrabold text-gray-800">{{ $stats['total_kost'] }}</span>
                </a>
                <a href="{{ route('admin.kost.index', ['status' => 'pending']) }}" class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50 hover:bg-amber-50 border border-transparent hover:border-amber-100 transition group cursor-pointer">
                    <span class="flex items-center gap-2 text-xs font-bold text-gray-600 group-hover:text-amber-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                    </span>
                    <span class="text-xs font-extrabold text-gray-800">{{ $stats['pending_kost'] }}</span>
                </a>
            </div>
        </div>
    </div>

    {{-- 3. TABEL TOP PERFORMING (TETAP) --}}
    <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">🏆 Top 5 Kost Paling Diminati</h3>
            <a href="{{ route('admin.kost.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-3 py-1.5 rounded-lg transition">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nama Kost</th>
                        <th class="px-6 py-4">Pemilik</th>
                        <th class="px-6 py-4 text-center">Rating</th>
                        <th class="px-6 py-4 text-center">Total Ulasan</th>
                        <th class="px-6 py-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($topKosts as $item)
                    <tr class="hover:bg-indigo-50/30 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-xl overflow-hidden border border-gray-200">
                                    @php $foto = is_array($item->foto) ? ($item->foto[0]['path'] ?? $item->foto[0]) : $item->foto; @endphp
                                    @if($foto) <img src="{{ asset('storage/'.$foto) }}" class="w-full h-full object-cover">
                                    @else <div class="w-full h-full flex items-center justify-center text-lg">🏠</div> @endif
                                </div>
                                <div class="font-bold text-gray-900 text-sm">{{ $item->nama }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->pemilik->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-yellow-50 text-yellow-700 text-xs font-bold border border-yellow-100">⭐ {{ number_format($item->reviews_avg_rating, 1) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm font-bold text-gray-800">{{ $item->reviews_count }}</td>
                        <td class="px-6 py-4 text-right">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">Aktif</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Belum ada data review.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- SCRIPT CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Konfigurasi Warna & Font Global
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#94a3b8'; // gray-400
    Chart.defaults.borderColor = 'rgba(0,0,0,0.03)';

    const usersData = @json($chartData['users']);
    const kostsData = @json($chartData['kosts']);
    const labels = @json($chartData['labels']);

    // 1. GROWTH CHART (Clean Line Chart)
    const ctxGrowth = document.getElementById('growthChart').getContext('2d');
    
    // Gradient untuk User
    const gradientUser = ctxGrowth.createLinearGradient(0, 0, 0, 300);
    gradientUser.addColorStop(0, 'rgba(99, 102, 241, 0.2)'); // Indigo
    gradientUser.addColorStop(1, 'rgba(99, 102, 241, 0)');

    // Gradient untuk Kost
    const gradientKost = ctxGrowth.createLinearGradient(0, 0, 0, 300);
    gradientKost.addColorStop(0, 'rgba(34, 197, 94, 0.2)'); // Emerald
    gradientKost.addColorStop(1, 'rgba(34, 197, 94, 0)');

    new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'User Baru',
                data: usersData,
                borderColor: '#6366F1', // Indigo 500
                backgroundColor: gradientUser,
                borderWidth: 2,
                pointRadius: 0, // Sembunyikan dot default
                pointHoverRadius: 6, // Muncul saat hover
                pointBackgroundColor: '#6366F1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                fill: true,
                tension: 0.3
            }, {
                label: 'Kost Baru',
                data: kostsData,
                borderColor: '#22C55E', // Emerald 500
                backgroundColor: gradientKost,
                borderWidth: 2,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointBackgroundColor: '#22C55E',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        padding: 20,
                        font: { size: 11, weight: 'bold' }
                    }
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 13 },
                    bodyFont: { size: 12 },
                    displayColors: true,
                    cornerRadius: 8,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [4, 4], drawBorder: false },
                    ticks: { padding: 10, font: { size: 11 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { padding: 10, font: { size: 11 } }
                }
            }
        }
    });

    // 2. STATUS CHART (Interactive Doughnut)
    const ctxStatus = document.getElementById('statusChart');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Pending', 'Ditolak'],
            datasets: [{
                data: [{{ $stats['total_kost'] }}, {{ $stats['pending_kost'] }}, 0], // Ganti 0 dgn rejected jika ada
                backgroundColor: [
                    '#22C55E', // Active (Emerald)
                    '#F59E0B', // Pending (Amber)
                    '#EF4444'  // Rejected (Red)
                ],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '80%', // Lebih tipis dan modern
            plugins: {
                legend: { display: false }, // Kita pakai custom legend di HTML
                tooltip: {
                    backgroundColor: '#1e293b',
                    bodyFont: { size: 12 },
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.label + ': ' + context.raw + ' Unit';
                        }
                    }
                }
            },
            onClick: (evt, elements) => {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    // Mapping index ke status untuk filter
                    const statusMap = ['aktif', 'pending', 'ditolak'];
                    const selectedStatus = statusMap[index];
                    
                    // Redirect ke halaman Kost dengan filter
                    window.location.href = `{{ route('admin.kost.index') }}?status=${selectedStatus}`;
                }
            },
            onHover: (event, chartElement) => {
                event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
            }
        }
    });
</script>
@endsection  . itu kodingan  review   silhkan sesuikan dnegna kodoe terbaru
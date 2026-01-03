@extends('admin.layouts')
@section('title', 'Manajemen Data Kost')

@section('content')
<div class="space-y-8">

    {{-- 1. STATISTIK UTAMA (Updated Design) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Kost --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Kost</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalKost ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                🏠
            </div>
        </div>

        {{-- Menunggu --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Perlu Review</p>
                <h3 class="text-3xl font-bold text-amber-600 mt-1">{{ $totalPending ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                🕒
            </div>
        </div>

        {{-- Diterima --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Aktif</p>
                <h3 class="text-3xl font-bold text-emerald-600 mt-1">{{ $totalApproved ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                ✅
            </div>
        </div>

        {{-- Ditolak --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ditolak</p>
                <h3 class="text-3xl font-bold text-rose-600 mt-1">{{ $totalRejected ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                ❌
            </div>
        </div>
    </div>

    {{-- 2. HEADER & FILTER --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                🏠 Data Kost
            </h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data kost, verifikasi status, dan atur promosi.</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Search Bar --}}
            <form method="GET" action="{{ route('admin.kost.index') }}" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kost..." 
                       class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-64 shadow-sm">
                <div class="absolute left-3 top-2.5 text-gray-400">🔍</div>
            </form>

            {{-- Tombol Tambah --}}
            <a href="{{ route('admin.kost.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                <span>➕ Tambah Data</span>
            </a>
        </div>
    </div>

    {{-- 3. TABEL DATA --}}
    <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
        
        {{-- Filter Status Pills --}}
        <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap gap-2 bg-gray-50/50">
            @php $currentStatus = request('status'); @endphp
            <a href="{{ route('admin.kost.index') }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition {{ !$currentStatus ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                Semua
            </a>
            <a href="{{ route('admin.kost.index', ['status' => 'pending']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition {{ $currentStatus == 'pending' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                🕒 Menunggu
            </a>
            <a href="{{ route('admin.kost.index', ['status' => 'diterima']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition {{ $currentStatus == 'diterima' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                ✅ Aktif
            </a>
            <a href="{{ route('admin.kost.index', ['status' => 'ditolak']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition {{ $currentStatus == 'ditolak' ? 'bg-rose-500 text-white border-rose-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                ❌ Ditolak
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-semibold uppercase tracking-wider text-xs">
                    <tr>
                        <th class="px-6 py-4">Info Kost</th>
                        <th class="px-6 py-4">Pemilik</th>
                        <th class="px-6 py-4 text-center">Verifikasi</th>
                        <th class="px-6 py-4 text-center">Status Iklan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($kosts as $kost)
                    <tr class="hover:bg-indigo-50/30 transition group">
                        
                        {{-- INFO KOST --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                {{-- Logic Gambar Lama Anda (Dipertahankan) --}}
                                <div class="w-14 h-14 rounded-2xl bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0 flex items-center justify-center text-xl shadow-sm">
                                    @php
                                        $foto = is_array($kost->foto) ? ($kost->foto[0] ?? null) : $kost->foto;
                                        if(is_array($foto)) $foto = $foto['path'] ?? null;
                                        $imgSrc = $foto ? asset('storage/'.$foto) : null;
                                    @endphp
                                    
                                    @if($imgSrc)
                                        <img src="{{ $imgSrc }}" class="w-full h-full object-cover" alt="Foto Kost">
                                    @else
                                        🏠
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition">{{ $kost->nama }}</div>
                                    <div class="text-xs text-gray-500 truncate w-40 mt-0.5">{{ $kost->alamat }}</div>
                                    <div class="text-xs font-bold text-indigo-600 mt-1">
                                        Rp {{ number_format($kost->harga, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- PEMILIK --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                    {{ substr($kost->pemilik->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800 text-xs">{{ $kost->pemilik->name ?? 'Unknown' }}</div>
                                    
                                    {{-- Logic WA Lama Anda (Dipertahankan) --}}
                                    @if($kost->pemilik && $kost->pemilik->phone)
                                        @php $waPhone = preg_replace('/^0/', '62', $kost->pemilik->phone); @endphp
                                        <a href="https://wa.me/{{ $waPhone }}" target="_blank" class="text-[10px] text-green-600 flex items-center gap-1 hover:underline font-medium bg-green-50 px-2 py-0.5 rounded-full w-fit mt-1">
                                            📞 Chat WA
                                        </a>
                                    @else
                                        <span class="text-[10px] text-gray-400">No WA -</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- STATUS VERIFIKASI (DROPDOWN AJAX) --}}
                        <td class="px-6 py-4 text-center">
                            {{-- Saya styling select box ini agar terlihat seperti Badge --}}
                            <div class="relative inline-block">
                                <select onchange="updateStatusVerifikasi({{ $kost->id }}, this.value)" 
                                    class="appearance-none cursor-pointer text-xs font-bold rounded-full pl-3 pr-8 py-1.5 border-0 ring-1 ring-inset outline-none transition hover:ring-2 focus:ring-2
                                    {{ $kost->status == 'diterima' ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : '' }}
                                    {{ $kost->status == 'pending' ? 'bg-amber-50 text-amber-700 ring-amber-200' : '' }}
                                    {{ $kost->status == 'ditolak' ? 'bg-rose-50 text-rose-700 ring-rose-200' : '' }}">
                                    
                                    <option value="diterima" {{ $kost->status == 'diterima' ? 'selected' : '' }}>✅ Aktif</option>
                                    <option value="pending" {{ $kost->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="ditolak" {{ $kost->status == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                                </select>
                                {{-- Icon panah kecil custom untuk select --}}
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </td>

                        {{-- STATUS IKLAN --}}
                        <td class="px-6 py-4 text-center">
                            @php
                                $isActivePromo = $kost->is_promoted && now()->between($kost->promoted_start_date, $kost->promoted_end_date);
                            @endphp
                            
                            @if($isActivePromo)
                                <div class="inline-flex flex-col items-center">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-1 text-[10px] font-bold text-amber-700">
                                        🔥 Iklan Aktif
                                    </span>
                                    <span class="text-[10px] text-gray-400 mt-1">
                                        s/d {{ \Carbon\Carbon::parse($kost->promoted_end_date)->format('d M') }}
                                    </span>
                                </div>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-[10px] font-bold text-gray-400 border border-gray-100">
                                    Off
                                </span>
                            @endif
                        </td>

                        {{-- AKSI (PASTEL EMOJI) --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                
                                {{-- 1. Promosi (📣) --}}
                                <button onclick="openPromoModal({{ $kost->id }}, {{ $kost->is_promoted ? 1 : 0 }}, '{{ $kost->promoted_start_date }}', '{{ $kost->promoted_end_date }}')" 
                                    class="w-9 h-9 flex items-center justify-center rounded-full bg-amber-50 text-amber-600 hover:bg-amber-100 hover:scale-105 transition shadow-sm border border-amber-100" 
                                    title="Atur Promosi">
                                    📣
                                </button>

                                {{-- 2. Detail (👁️) --}}
                                <a href="{{ route('admin.kost.show', $kost->id) }}" 
                                   class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 hover:scale-105 transition shadow-sm border border-blue-100" 
                                   title="Lihat Detail">
                                    👁️
                                </a>

                                {{-- 3. Hapus (🗑️) --}}
                                <form action="{{ route('admin.kost.destroy', $kost->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kost ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="w-9 h-9 flex items-center justify-center rounded-full bg-rose-50 text-rose-600 hover:bg-rose-100 hover:scale-105 transition shadow-sm border border-rose-100" 
                                        title="Hapus Kost">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            <div class="text-4xl opacity-30 mb-2">🏠</div>
                            <p class="text-sm">Data kost tidak ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($kosts->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $kosts->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

{{-- MODAL PROMOSI (Redesigned) --}}
<div id="promoModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 flex items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 transform transition-all scale-100 border border-gray-100">
        
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-amber-50 rounded-full flex items-center justify-center text-xl">📣</div>
            <h3 class="text-xl font-bold text-gray-900">Promosi Kost</h3>
        </div>
        
        <form id="promoForm">
            <input type="hidden" id="kostId">
            
            <div class="flex items-center justify-between mb-6 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                <div>
                    <span class="text-gray-800 font-bold text-sm block">Status Iklan</span>
                    <span class="text-xs text-gray-500">Tampilkan di halaman utama</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="promoSwitch" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                </label>
            </div>

            <div id="dateInputs" class="space-y-4 transition-all duration-300">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Mulai Promosi</label>
                    <input type="datetime-local" id="startDate" class="block w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-500 focus:ring-amber-500 p-2.5">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Berakhir Promosi</label>
                    <input type="datetime-local" id="endDate" class="block w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-amber-500 focus:ring-amber-500 p-2.5">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit" id="btnSave" class="px-5 py-2.5 text-sm font-bold text-white bg-amber-500 rounded-xl hover:bg-amber-600 shadow-lg shadow-amber-200 transition flex items-center gap-2">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT (LOGIC DIPERTAHANKAN 100%) --}}
<script>
    // --- 1. SCRIPT UPDATE STATUS AJAX (TETAP) ---
    async function updateStatusVerifikasi(id, newStatus) {
        document.body.style.cursor = 'wait';
        try {
            const response = await fetch(`/admin/kost/${id}/update-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            });
            const result = await response.json();
            if (result.success) {
                // Tambahkan notifikasi toast sederhana jika mau, atau reload
                location.reload(); 
            } else {
                alert('Gagal mengubah status.');
            }
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan sistem.');
        } finally {
            document.body.style.cursor = 'default';
        }
    }

    // --- 2. SCRIPT MODAL PROMO (TETAP) ---
    function openPromoModal(id, isPromoted, start, end) {
        document.getElementById('kostId').value = id;
        document.getElementById('promoSwitch').checked = isPromoted == 1;
        if(start) document.getElementById('startDate').value = start.replace(' ', 'T');
        if(end) document.getElementById('endDate').value = end.replace(' ', 'T');
        toggleInputs();
        document.getElementById('promoModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('promoModal').classList.add('hidden');
    }

    document.getElementById('promoSwitch').addEventListener('change', toggleInputs);

    function toggleInputs() {
        const isChecked = document.getElementById('promoSwitch').checked;
        const inputs = document.getElementById('dateInputs');
        if(isChecked) {
            inputs.classList.remove('opacity-50', 'pointer-events-none');
        } else {
            inputs.classList.add('opacity-50', 'pointer-events-none');
        }
    }

    document.getElementById('promoForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('kostId').value;
        const btn = document.getElementById('btnSave');
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Menyimpan...';
        btn.disabled = true;

        try {
            const response = await fetch(`/admin/kost/promotion/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    is_promoted: document.getElementById('promoSwitch').checked,
                    promoted_start_date: document.getElementById('startDate').value,
                    promoted_end_date: document.getElementById('endDate').value
                })
            });

            const result = await response.json();
            
            if (response.ok && result.status === 'success') {
                alert(result.message);
                location.reload();
            } else {
                console.log(result);
                alert('Gagal: ' + (result.message || 'Periksa input tanggal Anda.'));
            }
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan sistem.');
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
            closeModal();
        }
    });
</script>
@endsection
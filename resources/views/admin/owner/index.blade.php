@extends('admin.layouts')
@section('title', 'Manajemen Mitra Pemilik')

@section('content')
<div class="space-y-8 pb-20">

    {{-- 1. HEADER & SUMMARY STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Total Mitra --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl z-10">
                💼
            </div>
            <div class="z-10">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Mitra</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $totalOwners ?? 0 }}</h3>
            </div>
        </div>

        {{-- Produktif --}}
        <div class="bg-emerald-50/50 p-6 rounded-3xl border border-emerald-100 shadow-sm flex items-center gap-4 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-100/50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl z-10">
                📈
            </div>
            <div class="z-10">
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Produktif</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $productiveOwners ?? 0 }}</h3>
                <p class="text-[10px] text-emerald-600 font-medium">Memiliki Kost Aktif</p>
            </div>
        </div>

        {{-- Pasif --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gray-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="w-14 h-14 rounded-2xl bg-gray-100 text-gray-500 flex items-center justify-center text-3xl z-10">
                💤
            </div>
            <div class="z-10">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pasif (0 Kost)</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ ($totalOwners ?? 0) - ($productiveOwners ?? 0) }}</h3>
                <p class="text-[10px] text-gray-400 font-medium">Perlu Follow-up</p>
            </div>
        </div>
    </div>

    {{-- 2. TOOLBAR (Search & Filter) --}}
    <div class="flex flex-col lg:flex-row justify-between items-center gap-4 bg-white p-2 rounded-2xl border border-gray-100 shadow-sm">
        {{-- Search --}}
        <div class="relative w-full lg:w-96">
            <form action="{{ route('admin.owners.index') }}" method="GET">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <span class="text-gray-400">🔍</span>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mitra..." 
                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border-transparent rounded-xl text-sm focus:bg-white focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 transition">
            </form>
        </div>

        {{-- Filters --}}
        <div class="flex gap-2 w-full lg:w-auto overflow-x-auto pb-1 lg:pb-0">
            <form id="filterForm" action="{{ route('admin.owners.index') }}" method="GET" class="flex gap-2 w-full">
                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                
                <select name="status" onchange="this.form.submit()" class="flex-1 lg:flex-none px-5 py-3 bg-gray-50 border-transparent rounded-xl text-sm font-bold text-gray-600 focus:bg-white focus:border-indigo-300 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="produktif" {{ request('status') == 'produktif' ? 'selected' : '' }}>✅ Produktif</option>
                    <option value="pasif" {{ request('status') == 'pasif' ? 'selected' : '' }}>💤 Pasif</option>
                </select>

                <select name="sort" onchange="this.form.submit()" class="flex-1 lg:flex-none px-5 py-3 bg-gray-50 border-transparent rounded-xl text-sm font-bold text-gray-600 focus:bg-white focus:border-indigo-300 cursor-pointer">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru Gabung</option>
                    <option value="most_active" {{ request('sort') == 'most_active' ? 'selected' : '' }}>Kost Terbanyak</option>
                </select>
            </form>
        </div>
    </div>

    {{-- 3. GRID CARD MITRA --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($owners as $owner)
            @php 
                $isProductive = $owner->active_kost_count > 0;
                $statusColor = $isProductive ? 'bg-emerald-500' : 'bg-gray-300';
                $cardBorder = $isProductive ? 'border-emerald-100' : 'border-gray-100';
            @endphp
            
            <div class="group bg-white rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full border {{ $cardBorder }} relative overflow-hidden">
                
                {{-- Status Bar Atas --}}
                <div class="h-1.5 w-full {{ $statusColor }}"></div>

                <div class="p-6 flex flex-col h-full">
                    
                    {{-- Header Profil --}}
                    <div class="flex items-start gap-4 mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-gray-50 text-gray-600 flex items-center justify-center font-bold text-xl shadow-inner border border-gray-100 flex-shrink-0">
                            {{ substr($owner->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-gray-900 text-lg truncate" title="{{ $owner->name }}">
                                {{ $owner->name }}
                            </h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded-md bg-gray-50 text-[10px] font-bold text-gray-500 border border-gray-100">
                                    Member sejak {{ $owner->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Admin Note (Jika Ada) --}}
                    @if($owner->admin_notes)
                    <div class="mb-5 bg-amber-50 border border-amber-100 p-3 rounded-xl text-xs text-amber-800 flex items-start gap-2">
                        <span class="text-sm">📝</span>
                        <span class="line-clamp-2 italic">"{{ $owner->admin_notes }}"</span>
                    </div>
                    @endif

                    {{-- Statistik Utama --}}
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="bg-gray-50 rounded-2xl p-3 text-center border border-gray-100">
                            <span class="block text-[10px] font-bold text-gray-400 uppercase">Kost Dimiliki</span>
                            <span class="block text-2xl font-bold {{ $isProductive ? 'text-gray-800' : 'text-gray-400' }} mt-1">
                                {{ $owner->active_kost_count }}
                            </span>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-3 text-center border border-gray-100 flex flex-col justify-center items-center">
                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Status</span>
                            @if($isProductive)
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                                    ✅ Produktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-200 text-gray-500 text-[10px] font-bold">
                                    💤 Pasif
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between gap-2">
                        
                        {{-- WhatsApp (Paling Menonjol) --}}
                        @if($owner->phone)
                            @php $wa = preg_replace('/^0/', '62', $owner->phone); @endphp
                            <a href="https://wa.me/{{ $wa }}" target="_blank" 
                               class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl bg-emerald-50 text-emerald-600 font-bold text-sm hover:bg-emerald-500 hover:text-white transition group/wa border border-emerald-100">
                                <span class="text-lg">📞</span> <span class="hidden sm:inline">WhatsApp</span>
                            </a>
                        @else
                            <button disabled class="flex-1 py-2.5 rounded-xl bg-gray-50 text-gray-300 font-bold text-sm cursor-not-allowed border border-gray-100 flex items-center justify-center gap-2">
                                <span>📞</span> <span class="hidden sm:inline">No WA</span>
                            </button>
                        @endif

                        {{-- Grup Aksi Admin --}}
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.owners.show', $owner->id) }}" 
                               class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition border border-blue-100" title="Detail">
                                👁️
                            </a>
                            <button onclick="openNoteModal({{ $owner->id }}, '{{ addslashes($owner->admin_notes ?? '') }}')" 
                                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-100 transition border border-amber-100" title="Catatan">
                                ✏️
                            </button>
                            <form action="{{ route('admin.owners.destroy', $owner->id) }}" method="POST" onsubmit="return confirm('Hapus mitra ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 transition border border-rose-100" title="Hapus">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-gray-100 border-dashed">
                <div class="text-6xl opacity-20 mb-4 grayscale">💼</div>
                <h3 class="text-xl font-bold text-gray-900">Belum ada mitra ditemukan</h3>
                <p class="text-gray-500 mt-2">Silakan tunggu pendaftaran mitra baru.</p>
            </div>
        @endforelse
    </div>

    {{-- 4. PAGINATION --}}
    @if($owners->hasPages())
        <div class="mt-8 px-4 border-t border-gray-100 pt-6">
            {{ $owners->withQueryString()->links() }}
        </div>
    @endif

</div>

{{-- MODAL NOTE (TETAP SAMA) --}}
<div id="noteModal" class="fixed inset-0 z-50 hidden bg-gray-900/40 flex items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 transform transition-all scale-100 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">📝 Catatan Admin</h3>
            <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-100 transition">✕</button>
        </div>
        
        <form id="noteForm">
            <input type="hidden" id="modalOwnerId">
            <textarea id="modalNoteText" rows="4" 
                      class="w-full rounded-2xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm p-4 bg-gray-50 placeholder-gray-400 resize-none" 
                      placeholder="Contoh: 'Respon cepat', 'Perlu verifikasi ulang data diri'"></textarea>
            
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" id="btnSaveNote" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                    Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT (TETAP SAMA) --}}
<script>
    function openNoteModal(id, note) {
        document.getElementById('modalOwnerId').value = id;
        document.getElementById('modalNoteText').value = note; 
        document.getElementById('noteModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('noteModal').classList.add('hidden');
    }

    window.onclick = function(event) {
        const modal = document.getElementById('noteModal');
        if (event.target === modal) closeModal();
    }

    document.getElementById('noteForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('modalOwnerId').value;
        const note = document.getElementById('modalNoteText').value;
        const btn = document.getElementById('btnSaveNote');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = 'Menyimpan...';
        btn.disabled = true;

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`/admin/owners/${id}/notes`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: JSON.stringify({ notes: note })
            });
            const data = await response.json();

            if (response.ok) {
                closeModal();
                alert("✅ " + data.message); 
                location.reload(); 
            } else {
                throw new Error(data.message || 'Error.');
            }
        } catch (error) {
            alert("❌ Gagal: " + error.message);
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });
</script>
@endsection
@extends('layouts.admin')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <h3 class="text-3xl font-medium text-gray-700">Manajemen Rekomendasi & Iklan</h3>

    <div class="flex flex-col mt-8">
        <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">Info Kost</th>
                            <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">Performa</th>
                            <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">Status Rekomendasi (Auto)</th>
                            <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">Status Iklan (Manual)</th>
                            <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($kosts as $kost)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <div class="text-sm font-medium text-gray-900">{{ $kost->nama }}</div>
                                <div class="text-sm text-gray-500">{{ $kost->tipe }} | Rp {{ number_format($kost->harga) }}</div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <div class="flex items-center text-sm">
                                    <span class="text-yellow-500 mr-1">★</span> {{ number_format($kost->reviews_avg_rating ?? 0, 1) }} 
                                    <span class="text-gray-400 text-xs ml-1">({{ $kost->reviews_count }} ulasan)</span>
                                </div>
                                <div class="mt-1 text-xs">
                                    Data Lengkap: 
                                    <span class="{{ $kost->data_completeness == 100 ? 'text-green-600 font-bold' : 'text-red-500' }}">
                                        {{ $kost->data_completeness }}%
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                @if($kost->is_recommendable)
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                        ✅ Layak Rekomendasi
                                    </span>
                                @else
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-gray-600 bg-gray-100 rounded-full cursor-help group relative">
                                        ⚠️ Belum Layak
                                        <div class="absolute bottom-full left-0 hidden group-hover:block bg-black text-white text-xs rounded p-2 w-48 z-10">
                                            <ul class="list-disc pl-4">
                                                @foreach($kost->recommendation_issues as $issue)
                                                    <li>{{ $issue }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                @php $status = $kost->promotion_status_label; @endphp
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                    {{ $status == 'Aktif' ? 'text-yellow-800 bg-yellow-100' : '' }}
                                    {{ $status == 'Nonaktif' ? 'text-gray-800 bg-gray-100' : '' }}
                                    {{ $status == 'Berakhir' ? 'text-red-800 bg-red-100' : '' }}">
                                    {{ $status }}
                                </span>
                                @if($status == 'Aktif')
                                    <div class="text-xs text-gray-500 mt-1">s/d {{ \Carbon\Carbon::parse($kost->promoted_end_date)->format('d M Y') }}</div>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <button onclick="openPromoModal({{ $kost->id }}, '{{ $kost->is_promoted }}', '{{ $kost->promoted_start_date }}', '{{ $kost->promoted_end_date }}')" 
                                    class="text-indigo-600 hover:text-indigo-900 text-sm font-bold">
                                    Atur Iklan
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $kosts->links() }}
            </div>
        </div>
    </div>
</div>

<div id="promoModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-bold mb-4">Kelola Promosi</h3>
        <form id="promoForm" method="POST" action="">
            @csrf
            @method('POST') <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Status Promosi</label>
                <select name="is_promoted" id="modalIsPromoted" class="mt-1 block w-full rounded border-gray-300 shadow-sm" onchange="toggleDates()">
                    <option value="0">Nonaktifkan</option>
                    <option value="1">Aktifkan Iklan</option>
                </select>
            </div>

            <div id="dateInputs" class="hidden">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Mulai Tanggal</label>
                    <input type="datetime-local" name="promoted_start_date" id="modalStart" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Berakhir Tanggal</label>
                    <input type="datetime-local" name="promoted_end_date" id="modalEnd" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openPromoModal(id, status, start, end) {
        document.getElementById('promoForm').action = '/admin/kost/' + id + '/promote'; // Sesuaikan route
        document.getElementById('modalIsPromoted').value = status;
        
        // Format tanggal untuk input datetime-local (YYYY-MM-DDTHH:MM)
        if(start) document.getElementById('modalStart').value = start.replace(' ', 'T');
        if(end) document.getElementById('modalEnd').value = end.replace(' ', 'T');

        toggleDates();
        document.getElementById('promoModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('promoModal').classList.add('hidden');
    }

    function toggleDates() {
        const status = document.getElementById('modalIsPromoted').value;
        const inputs = document.getElementById('dateInputs');
        if (status == '1') {
            inputs.classList.remove('hidden');
        } else {
            inputs.classList.add('hidden');
        }
    }
</script>
@endsection
@extends('admin.layouts')

@section('content')
    <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Pengajuan Kost</h2>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-800 px-4 py-3 text-sm font-medium border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50 border-b">
                    <tr class="text-gray-700 text-sm font-semibold">
                        <th class="px-6 py-3 text-left">Nama Kost</th>
                        <th class="px-6 py-3 text-left">Pemilik</th>
                        <th class="px-6 py-3 text-left">Alamat</th>
                        <th class="px-6 py-3 text-left">Harga</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($kosts as $kost)
                        <tr class="hover:bg-gray-50 transition">
                            {{-- 1. Nama Kost --}}
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $kost->nama }}</td>

                            {{-- 2. Pemilik --}}
                            <td class="px-6 py-4 text-gray-700">
                                {{ $kost->pemilik->name ?? 'Tanpa Nama' }}
                            </td>

                            {{-- 3. Alamat --}}
                            <td class="px-6 py-4 text-gray-700">{{ Str::limit($kost->alamat, 20) }}</td>

                            {{-- 4. Harga --}}
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                Rp {{ number_format($kost->harga, 0, ',', '.') }}
                            </td>

                            {{-- 5. Status --}}
                            <td class="px-6 py-4">
                                @if ($kost->status == 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">Pending</span>
                                @elseif ($kost->status == 'diterima')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Diterima</span>
                                @elseif ($kost->status == 'ditolak')
                                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Ditolak</span>
                                @endif
                            </td>

                            {{-- 6. Tombol Aksi --}}
                            <td class="px-6 py-4 text-center">
                                @if ($kost->status == 'pending')
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- TOMBOL TERIMA --}}
                                        <form action="{{ route('admin.kost.approve', $kost->id) }}" method="POST" class="m-0 p-0">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="flex items-center justify-center gap-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                                                <span>✓ Terima</span>
                                            </button>
                                        </form>

                                        {{-- TOMBOL TOLAK --}}
                                        <button onclick="openRejectModal({{ $kost->id }})" class="flex items-center justify-center gap-1 bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                                            <span>✕ Tolak</span>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                <p>Belum ada data pengajuan kost.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL PENOLAKAN --}}
    <div id="modal-reject" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 items-center justify-center">
        <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-xl border animate-fadeIn m-4">
            <h3 class="text-lg font-bold text-gray-800 mb-1">Tolak Pengajuan Kost</h3>
            <p class="text-sm text-gray-500 mb-4">Berikan alasan penolakan.</p>

            <form id="form-reject" method="POST">
                @csrf @method('PATCH')
                <textarea name="alasan_penolakan" rows="3" required class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 outline-none text-sm" placeholder="Alasan..."></textarea>
                <div class="flex justify-end gap-3 mt-5">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium shadow">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(id) {
            const modal = document.getElementById('modal-reject');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.getElementById('form-reject').action = "/admin/kost/" + id + "/reject";
        }
        function closeRejectModal() {
            const modal = document.getElementById('modal-reject');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fadeIn { animation: fadeIn 0.2s ease-out; }
    </style>
@endsection
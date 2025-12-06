@extends('admin.layouts')

@section('content')
    <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Kost</h2>

        {{-- Notifikasi --}}
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
                    @foreach ($kosts as $kost)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $kost->nama }}</td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $kost->pemilik->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-gray-700">{{ $kost->alamat }}</td>

                            <td class="px-6 py-4 font-semibold text-gray-800">
                                Rp {{ number_format($kost->harga, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($kost->status == 'pending')
                                    <span class="badge-yellow">Pending</span>
                                @elseif ($kost->status == 'diterima')
                                    <span class="badge-green">Diterima</span>
                                @elseif ($kost->status == 'ditolak')
                                    <span class="badge-red">Ditolak</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">

                                @if ($kost->status == 'pending')
                                    <div class="flex items-center justify-center gap-4">

                                        {{-- TERIMA --}}
                                        <form action="{{ route('admin.kost.approve', $kost) }}" method="POST"
                                            class="m-0 p-0">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 
                    text-white font-medium w-[130px] h-[45px] rounded-xl shadow-md transition">

                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>

                                                <span>Terima</span>
                                            </button>
                                        </form>

                                        {{-- TOLAK --}}
                                        <button onclick="openRejectModal({{ $kost->id }})"
                                            class="flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 
                text-white font-medium w-[130px] h-[45px] rounded-xl shadow-md transition">

                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>

                                            <span>Tolak</span>
                                        </button>

                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm italic">Tidak ada aksi</span>
                                @endif

                            </td>



                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>


    {{-- MODAL PENOLAKAN --}}
    <div id="modal-reject" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 items-center justify-center">

        <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-xl border animate-fadeIn">

            <h3 class="text-xl font-bold text-gray-800 mb-1">Tolak Pengajuan Kost</h3>
            <p class="text-sm text-gray-500 mb-4">Harap tuliskan alasan penolakan untuk pemilik.</p>

            <form id="form-reject" method="POST">
                @csrf
                @method('PATCH')

                <label class="text-sm font-medium text-gray-700">Alasan Penolakan</label>
                <textarea name="alasan_penolakan" rows="3"
                    class="w-full mt-1 p-3 border rounded-xl focus:ring-red-500 focus:border-red-500 outline-none"
                    placeholder="Tuliskan alasan penolakan..." required></textarea>

                <div class="flex justify-end gap-3 mt-5">
                    <button type="button" onclick="closeRejectModal()" class="btn-gray">
                        Batal
                    </button>

                    <button type="submit" class="btn-red">
                        Kirim Penolakan
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection


{{-- SCRIPT --}}
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


{{-- STYLE --}}
<style>
    /* BADGE */
    .badge-yellow {
        @apply px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full;
    }

    .badge-green {
        @apply px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full;
    }

    .badge-red {
        @apply px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full;
    }


    /* BUTTON MODAL */
    .btn-green {
        @apply px-4 py-2 rounded-xl bg-green-600 hover:bg-green-700 text-white text-sm font-medium shadow transition;
    }

    .btn-red {
        @apply px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-medium shadow transition;
    }

    .btn-gray {
        @apply px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition;
    }


    /* ANIMATION */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px) scale(0.97);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.25s ease-out;
    }


    /* --- TOMBOL AKSI — SEMPURNA SIMETRIS --- */
    .action-btn-green,
    .action-btn-red {
        @apply inline-flex items-center justify-center gap-2 w-[130px] h-[45px] rounded-xl font-medium text-white shadow transition;
    }

    .action-btn-green {
        @apply bg-green-600 hover:bg-green-700;
    }

    .action-btn-red {
        @apply bg-red-600 hover:bg-red-700;
    }

    .action-btn-green svg,
    .action-btn-red svg {
        @apply w-5 h-5 shrink-0;
    }
</style>

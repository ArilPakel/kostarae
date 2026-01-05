@extends('layouts.owner')

@section('content')
<div class="max-w-4xl mx-auto p-6 py-20 bg-white shadow-md rounded-lg">

    <h2 class="text-2xl font-bold mb-6">Edit Kost</h2>

    <form action="{{ route('pemilik.kost.update', $kost->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Nama Kost</label>
            <input type="text" name="nama" value="{{ $kost->nama }}" class="w-full border rounded-lg p-2" required>
        </div>

        {{-- Alamat --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Alamat</label>
            <textarea name="alamat" class="w-full border rounded-lg p-2" rows="3" required>{{ $kost->alamat }}</textarea>
        </div>

        {{-- Harga --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Harga</label>
            <input type="number" name="harga" value="{{ $kost->harga }}" class="w-full border rounded-lg p-2" required>
        </div>

        {{-- Tipe --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Tipe Kost</label>
            <select name="tipe" class="w-full border p-2 rounded-lg" required>
                <option value="putra" {{ $kost->tipe=='putra'?'selected':'' }}>Putra</option>
                <option value="putri" {{ $kost->tipe=='putri'?'selected':'' }}>Putri</option>
                <option value="campur" {{ $kost->tipe=='campur'?'selected':'' }}>Campur</option>
            </select>
        </div>

        {{-- Fasilitas --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Fasilitas</label>

            <div class="grid grid-cols-2 gap-2">
                @php
                    $facilities = ['AC','Kamar Mandi Dalam','WiFi','Parkir','Kasur','Lemari','Meja Belajar'];
                @endphp

                @foreach($facilities as $item)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="fasilitas[]" value="{{ $item }}"
                        {{ in_array($item, $kost->fasilitas ?? []) ? 'checked' : '' }}>
                        <span>{{ $item }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Foto lama --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Foto Saat Ini</label>

            <div class="grid grid-cols-3 gap-3">
                @foreach($kost->foto ?? [] as $foto)
                    <div class="relative group">

                        <img src="{{ asset($foto) }}"
                             class="w-full h-32 object-cover rounded-lg shadow">

                        <button type="button"
                            class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded opacity-80 group-hover:opacity-100 deletePhotoBtn"
                            data-id="{{ $kost->id }}"
                            data-foto="{{ $foto }}">
                            Hapus
                        </button>

                    </div>
                @endforeach
            </div>
        </div>

        {{-- Upload baru --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Tambah Foto Baru</label>
            <input type="file" name="foto[]" multiple class="w-full">
        </div>

        <button type="submit"
            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
            Update Kost
        </button>
    </form>

</div>

{{-- AJAX DELETE --}}
<script>
document.querySelectorAll('.deletePhotoBtn').forEach(btn => {
    btn.addEventListener('click', function () {

        const kostId = this.dataset.id;
        const foto = this.dataset.foto;
        const card = this.closest('div');

        fetch(`/pemilik/kost/${kostId}/delete-photo`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ foto })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                card.classList.add("opacity-0", "scale-75", "transition", "duration-300");
                setTimeout(() => card.remove(), 300);
            }
        });

    });
});
</script>

@endsection

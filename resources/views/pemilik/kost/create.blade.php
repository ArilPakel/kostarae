@extends('layouts.owner')

@section('content')
    <div class="max-w-4xl mx-auto p-6 py-20  bg-white shadow-md rounded-lg">

        <h2 class="text-2xl font-bold mb-6">Tambah Kost Baru</h2>

        <form action="{{ route('pemilik.kost.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Nama Kost</label>
                <input type="text" name="nama" class="w-full border rounded-lg p-2" required>
            </div>

            {{-- Alamat --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Alamat</label>
                <textarea name="alamat" class="w-full border rounded-lg p-2" rows="3" required></textarea>
            </div>

            {{-- Harga --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Harga</label>
                <input type="number" name="harga" class="w-full border rounded-lg p-2" required>
            </div>

            {{-- Tipe Kost --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Tipe Kost</label>
                <select name="tipe" class="w-full border p-2 rounded-lg" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="putra">Putra</option>
                    <option value="putri">Putri</option>
                    <option value="campur">Campur</option>
                </select>
            </div>

            {{-- Fasilitas --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Fasilitas</label>

                <div class="grid grid-cols-2 gap-2">

                    @php
                        $facilities = ['AC', 'Kamar Mandi Dalam', 'WiFi', 'Parkir', 'Kasur', 'Lemari', 'Meja Belajar'];
                    @endphp

                    @foreach ($facilities as $item)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="fasilitas[]" value="{{ $item }}">
                            <span>{{ $item }}</span>
                        </label>
                    @endforeach

                </div>
            </div>

            {{-- Upload Foto --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2">Upload Foto</label>
                <input type="file" name="foto[]" multiple class="w-full">
            </div>

            {{-- Tombol submit --}}
            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                Simpan Kost
            </button>
        </form>

    </div>
@endsection

@extends('admin.layouts')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Pesan Masuk</h1>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-800 border-b">
                <tr>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Nama Pengirim</th>
                    <th class="px-6 py-4">Kontak</th>
                    <th class="px-6 py-4">Isi Pesan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($reports as $rpt)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">{{ $rpt->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 font-bold">{{ $rpt->name }}</td>
                    <td class="px-6 py-4">
                        {{ $rpt->email }} <br>
                        <span class="text-xs text-gray-500">{{ $rpt->phone }}</span>
                    </td>
                    <td class="px-6 py-4">{{ $rpt->message }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada pesan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
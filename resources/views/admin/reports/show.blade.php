@extends('admin.layouts')
@section('title', 'Detail Laporan #' . $report->id)

@section('content')
<div class="max-w-4xl mx-auto pb-20">

    <div class="mb-6">
        <a href="{{ route('admin.reports.index') }}" class="text-sm font-bold text-gray-500 hover:text-indigo-600 flex items-center gap-1">
            ⬅️ Kembali ke Laporan
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        
        {{-- Header Detail --}}
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-800">Rincian Aktivitas</h2>
            <span class="text-xs font-mono text-gray-400">ID: {{ $report->id }}</span>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            
            {{-- Info Dasar --}}
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b pb-2">Informasi Umum</h3>
                
                <div>
                    <span class="block text-xs text-gray-500">Waktu Kejadian</span>
                    <span class="block text-sm font-medium text-gray-900">{{ $report->created_at->format('d F Y, H:i:s') }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-500">Pelaku (User)</span>
                    <span class="block text-sm font-bold text-gray-900">{{ $report->causer->name ?? 'System' }}</span>
                    <span class="block text-xs text-gray-400">{{ $report->causer->email ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-500">Deskripsi</span>
                    <p class="text-sm text-gray-700 bg-gray-50 p-2 rounded border border-gray-100 mt-1">
                        {{ $report->description }}
                    </p>
                </div>
            </div>

            {{-- Info Teknis & Perubahan --}}
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b pb-2">Data Teknis</h3>

                @php
                    $props = $report->properties;
                    // Ambil IP/Agent jika ada
                    $ip = $props['ip'] ?? '-';
                    $agent = $props['agent'] ?? '-';
                @endphp

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-xs text-gray-500">IP Address</span>
                        <span class="block text-sm font-mono text-gray-800">{{ $ip }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Browser</span>
                        <span class="block text-sm font-mono text-gray-800 truncate" title="{{ $agent }}">
                            {{ Str::limit($agent, 20) }}
                        </span>
                    </div>
                </div>

                {{-- Tampilkan Perubahan Data (Jika ada) --}}
                @if(isset($props['attributes']))
                <div class="mt-4">
                    <span class="block text-xs text-gray-500 mb-2">Perubahan Data (JSON)</span>
                    <pre class="bg-slate-800 text-green-400 p-3 rounded-lg text-xs font-mono overflow-x-auto">{{ json_encode($props['attributes'], JSON_PRETTY_PRINT) }}</pre>
                </div>
                @endif
                
                @if(isset($props['old']))
                <div class="mt-2">
                    <span class="block text-xs text-gray-500 mb-2">Data Lama (JSON)</span>
                    <pre class="bg-slate-800 text-red-400 p-3 rounded-lg text-xs font-mono overflow-x-auto">{{ json_encode($props['old'], JSON_PRETTY_PRINT) }}</pre>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
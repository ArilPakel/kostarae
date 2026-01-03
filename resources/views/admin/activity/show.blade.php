@extends('admin.layouts')
@section('title', 'Detail Log Aktivitas #' . $log->id)

@section('content')
<div class="max-w-5xl mx-auto pb-20">

    {{-- 1. NAVIGASI KEMBALI --}}
    <div class="mb-8">
        <a href="{{ route('admin.activity.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-indigo-600 bg-white px-4 py-2.5 rounded-full shadow-sm border border-gray-100 transition">
            <span>⬅️</span> Kembali ke Jejak Aktivitas
        </a>
    </div>

    {{-- LOGIC: Tentukan Warna Tema Berdasarkan Aksi --}}
    @php
        $desc = strtolower($log->description);
        $theme = 'indigo'; // Default
        $icon = '🧭';
        $bgHeader = 'bg-indigo-50';
        $textHeader = 'text-indigo-700';

        if (Str::contains($desc, ['hapus', 'delete', 'destroy'])) {
            $theme = 'rose';
            $icon = '🗑️';
            $bgHeader = 'bg-rose-50';
            $textHeader = 'text-rose-700';
        } elseif (Str::contains($desc, ['update', 'edit', 'ubah'])) {
            $theme = 'amber';
            $icon = '✏️';
            $bgHeader = 'bg-amber-50';
            $textHeader = 'text-amber-700';
        } elseif (Str::contains($desc, ['login', 'masuk', 'created', 'tambah'])) {
            $theme = 'emerald';
            $icon = '✅';
            $bgHeader = 'bg-emerald-50';
            $textHeader = 'text-emerald-700';
        }

        // Parsing Properties Aman
        $rawProps = $log->properties;
        // Cek apakah sudah array atau masih string
        $props = is_array($rawProps) ? $rawProps : json_decode($rawProps, true);
        if(!$props) $props = [];
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- KOLOM KIRI: INFO UTAMA (PELAKU & KONTEKS) --}}
        <div class="lg:col-span-1 space-y-6">
            
            {{-- Card Pelaku --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 {{ $bgHeader }} rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Pelaku Aktivitas</h3>
                
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl {{ $bgHeader }} {{ $textHeader }} flex items-center justify-center text-3xl shadow-inner">
                        {{ substr($log->causer->name ?? 'S', 0, 1) }}
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-900 text-lg leading-tight">{{ $log->causer->name ?? 'System / Guest' }}</h2>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded-md bg-gray-100 text-gray-500 text-xs font-bold uppercase tracking-wide border border-gray-200">
                            {{ $log->causer->role ?? 'System' }}
                        </span>
                    </div>
                </div>

                @if(isset($log->causer->email))
                <div class="mt-4 pt-4 border-t border-gray-50">
                    <p class="text-xs text-gray-400 mb-1">Email</p>
                    <p class="text-sm font-medium text-gray-700">{{ $log->causer->email }}</p>
                </div>
                @endif
            </div>

            {{-- Card Metadata Teknis --}}
            <div class="bg-slate-900 rounded-3xl border border-slate-700 shadow-sm p-6 text-slate-300">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    💻 Metadata Teknis
                </h3>
                
                <div class="space-y-4 text-xs font-mono">
                    <div>
                        <span class="block text-slate-500 mb-1">Waktu Kejadian</span>
                        <span class="text-white bg-slate-800 px-2 py-1 rounded">
                            {{ $log->created_at->format('d M Y, H:i:s') }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-slate-500 mb-1">IP Address</span>
                        <span class="text-emerald-400">{{ $props['ip'] ?? 'Tidak tercatat' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 mb-1">Log ID</span>
                        <span class="text-slate-400">#{{ $log->id }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 mb-1">Browser / Agent</span>
                        <div class="bg-slate-800 p-2 rounded text-[10px] leading-relaxed break-all border border-slate-700">
                            {{ $props['agent'] ?? 'Tidak tersedia' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: DETAIL PERUBAHAN (DIFF VIEW) --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden min-h-full">
                
                {{-- Header Content --}}
                <div class="p-6 border-b border-gray-100 {{ $bgHeader }}">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">{{ $icon }}</span>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">{{ $log->description }}</h2>
                            <p class="text-xs {{ $textHeader }} font-medium mt-0.5">
                                Subject: {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if(isset($props['attributes']) || isset($props['old']))
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            📝 Rincian Perubahan Data
                        </h3>

                        <div class="space-y-3">
                            {{-- Loop Attributes --}}
                            @php 
                                $attributes = $props['attributes'] ?? [];
                                $old = $props['old'] ?? [];
                                // Gabungkan key dari keduanya untuk memastikan semua field tampil
                                $allKeys = array_unique(array_merge(array_keys($attributes), array_keys($old)));
                            @endphp

                            @foreach($allKeys as $key)
                                @php
                                    if(in_array($key, ['updated_at', 'created_at', 'id', 'email_verified_at', 'remember_token'])) continue;
                                    
                                    $valNew = $attributes[$key] ?? null;
                                    $valOld = $old[$key] ?? null;

                                    // Jika tidak ada perubahan, skip (opsional, tergantung kebutuhan)
                                    if($valNew == $valOld && !is_null($valNew)) continue; 
                                @endphp

                                <div class="group bg-gray-50 hover:bg-white border border-gray-100 hover:border-indigo-100 rounded-xl p-4 transition-all">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                        {{ str_replace('_', ' ', $key) }}
                                    </p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        {{-- SEBELUM --}}
                                        <div class="relative">
                                            <span class="absolute -top-2 left-0 text-[8px] font-bold bg-red-100 text-red-600 px-1.5 rounded uppercase">Sebelum</span>
                                            <div class="mt-2 text-sm text-gray-600 break-words font-mono bg-red-50/50 p-2 rounded border border-red-50 min-h-[40px] flex items-center">
                                                @if(is_array($valOld))
                                                    <pre class="text-[10px]">{{ json_encode($valOld, JSON_PRETTY_PRINT) }}</pre>
                                                @elseif(is_bool($valOld))
                                                    {{ $valOld ? 'True' : 'False' }}
                                                @else
                                                    {{ $valOld ?? '-' }}
                                                @endif
                                            </div>
                                        </div>

                                        {{-- SESUDAH --}}
                                        <div class="relative">
                                            <span class="absolute -top-2 left-0 text-[8px] font-bold bg-emerald-100 text-emerald-600 px-1.5 rounded uppercase">Sesudah</span>
                                            <div class="mt-2 text-sm text-gray-800 break-words font-mono bg-emerald-50/50 p-2 rounded border border-emerald-50 min-h-[40px] flex items-center font-medium">
                                                @if(is_array($valNew))
                                                    <pre class="text-[10px]">{{ json_encode($valNew, JSON_PRETTY_PRINT) }}</pre>
                                                @elseif(is_bool($valNew))
                                                    {{ $valNew ? 'True' : 'False' }}
                                                @else
                                                    {{ $valNew ?? '-' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if(empty($allKeys))
                            <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <span class="text-2xl block mb-2">ℹ️</span>
                                <p class="text-gray-500 text-sm">Tidak ada perubahan data spesifik yang tercatat.</p>
                            </div>
                        @endif

                    @else
                        {{-- Tampilan Jika Tidak Ada Data Perubahan (Misal: Login/Logout) --}}
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-3xl mb-4 grayscale opacity-50">
                                {{ $icon }}
                            </div>
                            <h3 class="text-gray-900 font-bold">Aktivitas Sistem Standar</h3>
                            <p class="text-gray-500 text-sm mt-1 max-w-md">
                                Ini adalah log aktivitas umum (seperti Login, Logout, atau Melihat Halaman) yang tidak melibatkan perubahan data pada database.
                            </p>
                        </div>
                    @endif
                </div>
                
                {{-- Footer JSON Mentah (Untuk Developer) --}}
                <div class="bg-gray-50 p-4 border-t border-gray-100">
                    <details class="group">
                        <summary class="flex items-center gap-2 text-xs font-bold text-gray-400 cursor-pointer hover:text-indigo-600 transition select-none">
                            <span>🛠️ Lihat Raw JSON Data (Developer Only)</span>
                            <span class="group-open:rotate-180 transition-transform">▼</span>
                        </summary>
                        <div class="mt-3">
                            <pre class="bg-slate-800 text-green-400 p-4 rounded-xl text-[10px] font-mono overflow-x-auto shadow-inner border border-slate-700">{{ json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </details>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
@extends('admin.layouts')
@section('title', 'Edit Data Kost')

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Data Kost</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi kost {{ $kost->nama }}.</p>
        </div>
        <a href="{{ route('admin.kost.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 hover:text-blue-600 transition text-sm font-medium shadow-sm">
            &larr; Kembali
        </a>
    </div>

    {{-- Notifikasi Error --}}
    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.kost.update', $kost->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        
        {{-- SECTION 1: INFO DASAR --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold">1</span>
                Informasi Dasar
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                {{-- Pemilik --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Pemilik Kost</label>
                    <div class="relative">
                        <select name="pemilik_id" id="pemilik_select" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 pl-4 pr-10 appearance-none bg-gray-50" onchange="checkOwnerPhone(this)" required>
                            <option value="" data-phone="">-- Pilih Pemilik --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" data-phone="{{ $user->phone }}" {{ $kost->pemilik_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} {{ empty($user->phone) ? '(❌ Tanpa WA)' : '(✅ '. $user->phone .')' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    <p id="wa-warning" class="hidden text-xs text-red-500 mt-2 font-medium flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        User ini belum mengisi No WA. Mohon update profilnya dulu.
                    </p>
                </div>

                {{-- Nama Kost --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kost</label>
                    <input type="text" name="nama" value="{{ old('nama', $kost->nama) }}" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 px-4" 
                           placeholder="Contoh: Kost Syafira Indah" required>
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Per Bulan</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold group-focus-within:text-blue-600">Rp</span>
                        <input type="text" name="harga" value="{{ old('harga', number_format($kost->harga, 0, ',', '.')) }}" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-12 py-3 text-lg font-medium tracking-wide" 
                               placeholder="0" onkeyup="formatRupiah(this)" required>
                    </div>
                    <p class="text-[11px] text-gray-500 mt-1.5 leading-snug">
                        * Jika harga bervariasi (misal: <strong>500.000 – 750.000</strong>), masukkan harga terendah di sini, lalu jelaskan detailnya di deskripsi.
                    </p>
                </div>

                {{-- Tipe --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Kost</label>
                    <div class="relative">
                        <select name="tipe" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 pl-4 pr-10 appearance-none bg-white cursor-pointer">
                            <option value="campur" {{ $kost->tipe == 'campur' ? 'selected' : '' }}>🧑‍🤝‍🧑 Campur (Pria/Wanita)</option>
                            <option value="putra" {{ $kost->tipe == 'putra' ? 'selected' : '' }}>👨 Khusus Putra</option>
                            <option value="putri" {{ $kost->tipe == 'putri' ? 'selected' : '' }}>👩 Khusus Putri</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: LOKASI --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold">2</span>
                Lokasi Kost
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                {{-- Kota --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kota / Kab</label>
                    <select name="kota" id="select-kota" class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 py-2.5 bg-gray-50">
                        <option value="">{{ $lokasiData['kota'] ?? 'Pilih Kota...' }}</option>
                        {{-- Data Kota Lain akan dimuat via JS --}}
                    </select>
                </div>
                {{-- Kecamatan --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kecamatan</label>
                    <select name="kecamatan" id="select-kecamatan" class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 py-2.5 bg-gray-50" disabled>
                        <option value="">{{ $lokasiData['kec'] ?? 'Pilih Kota Dulu...' }}</option>
                    </select>
                </div>
                {{-- Kelurahan (Pre-filled Manual Input) --}}
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kelurahan</label>
                        {{-- Toggle Button --}}
                        <button type="button" id="toggle-kelurahan" class="text-[10px] text-blue-600 font-bold hover:underline cursor-pointer">
                            Gunakan Otomatis?
                        </button>
                    </div>
                    
                    {{-- Mode Select (Hidden by Default in Edit) --}}
                    <select name="kelurahan" id="select-kelurahan" class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 py-2.5 bg-gray-50 hidden" disabled>
                        <option value="">Pilih Kec Dulu...</option>
                    </select>

                    {{-- Mode Input Manual (Active by Default in Edit) --}}
                    <input type="text" name="kelurahan" id="input-kelurahan" 
                           value="{{ $lokasiData['kel'] ?? '' }}"
                           class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 py-2.5 bg-white" 
                           placeholder="Nama Lingkungan/Desa...">
                </div>
            </div>

            {{-- Detail Alamat --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                <textarea name="alamat_detail" rows="2" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-3" 
                          placeholder="Nama Jalan, Nomor Rumah, RT/RW, Patokan..." required>{{ $lokasiData['detail'] ?? $kost->alamat }}</textarea>
            </div>
        </div>

        {{-- SECTION 3: FASILITAS & FOTO --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold">3</span>
                Fasilitas & Foto
            </h3>
            
            {{-- Logika memisahkan fasilitas Checkbox dan Input --}}
            @php
                $dbFasilitas = $kost->fasilitas ?? [];
                $listFasilitas = ['Kasur', 'Lemari', 'Meja Belajar', 'WiFi', 'AC', 'Kamar Mandi Dalam', 'Dapur', 'Parkir', 'CCTV', 'Laundry'];
                $fasilitasTambahan = array_diff($dbFasilitas, $listFasilitas);
            @endphp

            {{-- Fasilitas Checkbox --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Fasilitas Tersedia</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($listFasilitas as $item)
                    <label class="group flex items-center p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                        <input type="checkbox" name="fasilitas[]" value="{{ $item }}" 
                               class="rounded text-blue-600 focus:ring-blue-500 h-4 w-4 mr-3 transition group-hover:scale-110"
                               {{ in_array($item, $dbFasilitas) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-700 font-medium">{{ $item }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            
            {{-- Fasilitas Manual --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Fasilitas Lainnya</label>
                <input type="text" name="fasilitas_tambahan" 
                       value="{{ implode(', ', $fasilitasTambahan) }}"
                       class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-3" 
                       placeholder="Contoh: Kulkas, TV, Dispenser (Pisahkan dengan koma)">
                <p class="text-xs text-gray-400 mt-1.5 ml-1">* Wajib gunakan tanda koma ( , ) sebagai pemisah antar fasilitas.</p>
            </div>

            {{-- Foto yang Sudah Ada --}}
            @if(!empty($kost->foto))
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Saat Ini</label>
                <div class="grid grid-cols-4 md:grid-cols-6 gap-3">
                    @foreach($kost->foto as $foto)
                        <div class="relative group h-24 w-full rounded-lg overflow-hidden border border-gray-200">
                            @php $fotoPath = str_replace('public/', '', $foto); @endphp
                            <img src="{{ asset('storage/' . $fotoPath) }}" class="w-full h-full object-cover">
                            {{-- Optional: Tombol Hapus per Foto bisa ditambahkan nanti --}}
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Upload Foto Baru --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tambah Foto Baru</label>
                <div class="relative border-2 border-dashed border-blue-200 bg-blue-50/50 rounded-2xl p-8 text-center hover:bg-blue-50 transition cursor-pointer group" id="drop-zone">
                    <input type="file" name="foto[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" onchange="handleFileSelect(this)">
                    
                    <div class="space-y-3 pointer-events-none group-hover:scale-105 transition duration-300" id="upload-placeholder">
                        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-700">Klik untuk upload foto tambahan</p>
                            <p class="text-xs text-gray-500 mt-1">Foto lama tidak akan terhapus</p>
                        </div>
                    </div>
                    <div id="preview-container" class="hidden grid-cols-2 md:grid-cols-4 gap-4 mt-4 relative z-10"></div>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Tambahan</label>
                <textarea name="deskripsi" rows="4" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-3" 
                          placeholder="Jelaskan detail peraturan kost..." oninput="autoCapitalize(this)">{{ old('deskripsi', $kost->deskripsi) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Huruf awal kalimat otomatis dikapitalisasi.</p>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex justify-end gap-4 pt-4 pb-8">
            <a href="{{ route('admin.kost.index') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition shadow-sm">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition transform active:scale-95">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

{{-- JAVASCRIPT LOGIC --}}
<script>
    // 1. CEK WA PEMILIK
    function checkOwnerPhone(select) {
        const phone = select.options[select.selectedIndex].getAttribute('data-phone');
        const warning = document.getElementById('wa-warning');
        if (!phone || phone === '') {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }
    }

    // 2. AUTO CAPITALIZE
    function autoCapitalize(el) {
        el.value = el.value.replace(/(?:^|[\.\!\?]\s+)([a-z])/g, function(match) { 
            return match.toUpperCase(); 
        });
    }

    // 3. FORMAT RUPIAH
    function formatRupiah(input) {
        let value = input.value.replace(/\D/g, ''); 
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }

    // 4. UPLOAD PREVIEW
    function handleFileSelect(input) {
        const previewContainer = document.getElementById('preview-container');
        const placeholder = document.getElementById('upload-placeholder');
        const dropZone = document.getElementById('drop-zone');

        previewContainer.innerHTML = ''; 

        if (input.files && input.files.length > 0) {
            placeholder.classList.add('hidden');
            previewContainer.classList.remove('hidden');
            previewContainer.classList.add('grid');
            dropZone.classList.remove('p-8');
            dropZone.classList.add('p-4');

            Array.from(input.files).forEach((file, index) => {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let div = document.createElement('div');
                    div.className = 'relative group bg-white p-2 rounded-xl shadow-sm border border-gray-200';
                    div.innerHTML = `
                        <div class="h-24 w-full overflow-hidden rounded-lg bg-gray-100 mb-2">
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                        </div>
                        <input type="text" placeholder="Label foto..." class="w-full text-[10px] border-gray-200 rounded px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                    `;
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        } else {
            placeholder.classList.remove('hidden');
            previewContainer.classList.add('hidden');
            previewContainer.classList.remove('grid');
            dropZone.classList.add('p-8');
            dropZone.classList.remove('p-4');
        }
    }

    // 5. LOCATION (CACHED + EDIT MODE)
    document.addEventListener('DOMContentLoaded', function() {
        const kotaSelect = document.getElementById('select-kota');
        const kecSelect = document.getElementById('select-kecamatan');
        const kelSelect = document.getElementById('select-kelurahan');
        const kelInput = document.getElementById('input-kelurahan');
        const toggleBtn = document.getElementById('toggle-kelurahan');

        // Toggle Manual/Auto (Disesuaikan untuk Edit)
        toggleBtn.addEventListener('click', function() {
            if (kelSelect.classList.contains('hidden')) {
                // Switch ke Select (Auto)
                kelSelect.classList.remove('hidden');
                kelSelect.disabled = false;
                kelInput.classList.add('hidden');
                kelInput.disabled = true;
                this.innerText = "Input Manual?";
            } else {
                // Switch ke Input (Manual)
                kelSelect.classList.add('hidden');
                kelSelect.disabled = true;
                kelInput.classList.remove('hidden');
                kelInput.disabled = false;
                this.innerText = "Gunakan Otomatis?";
            }
        });

        // Caching Fetcher
        async function fetchCached(url, key) {
            const cached = localStorage.getItem(key);
            if (cached) return JSON.parse(cached);
            try {
                const res = await fetch(url);
                const data = await res.json();
                localStorage.setItem(key, JSON.stringify(data));
                return data;
            } catch (e) { console.error(e); return []; }
        }

        // Init Kota (Supaya user bisa ganti kota jika mau)
        fetchCached('https://www.emsifa.com/api-wilayah-indonesia/api/regencies/73.json', 'kota_73')
            .then(data => {
                // Jangan hapus option pertama (selected current value)
                data.forEach(kota => {
                    let option = new Option(kota.name, kota.name);
                    option.dataset.id = kota.id;
                    kotaSelect.add(option);
                });
            });

        // Event Listeners (Sama seperti Create)
        kotaSelect.addEventListener('change', function() {
            let kotaId = this.options[this.selectedIndex].dataset.id;
            if(!kotaId) return; // Jika pilih data lama, tidak ada ID, jadi stop

            kecSelect.innerHTML = '<option value="">Memuat...</option>';
            kecSelect.disabled = true;
            kelSelect.innerHTML = '<option value="">Pilih Kec Dulu...</option>';
            
            fetchCached(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kotaId}.json`, `kec_${kotaId}`)
                .then(data => {
                    kecSelect.innerHTML = '<option value="">Pilih Kecamatan...</option>';
                    kecSelect.disabled = false;
                    data.forEach(kec => {
                        let option = new Option(kec.name, kec.name);
                        option.dataset.id = kec.id;
                        kecSelect.add(option);
                    });
                });
        });

        kecSelect.addEventListener('change', function() {
            let kecId = this.options[this.selectedIndex].dataset.id;
            if(!kecId) return;

            kelSelect.innerHTML = '<option value="">Memuat...</option>';
            
            fetchCached(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`, `kel_${kecId}`)
                .then(data => {
                    kelSelect.innerHTML = '<option value="">Pilih Kelurahan...</option>';
                    data.forEach(kel => kelSelect.add(new Option(kel.name, kel.name)));
                });
        });
    });
</script>
@endsection
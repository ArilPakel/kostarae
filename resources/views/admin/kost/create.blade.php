@extends('admin.layouts')
@section('title', 'Tambah Data Kost')

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Tambah Kost Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Lengkapi formulir di bawah untuk mendaftarkan properti baru.</p>
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

    <form action="{{ route('admin.kost.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
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
                            <option value="" data-phone="ok">-- Cari Nama Pemilik --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" data-phone="{{ $user->phone }}">
                                    {{ $user->name }} {{ empty($user->phone) ? '(⚠️ Data Belum Lengkap)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    {{-- Dynamic Input: No HP (Hanya muncul jika user belum punya) --}}
                    <div id="phone-input-wrapper" class="hidden mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-xl transition-all duration-300">
                        <label class="block text-xs font-bold text-yellow-700 mb-1">
                            ⚠️ User ini belum memiliki No. WhatsApp. Mohon lengkapi:
                        </label>
                        <input type="number" name="owner_phone_update" id="owner_phone_input" 
                               class="w-full border-yellow-300 rounded-lg py-2 px-3 text-sm focus:ring-yellow-500 focus:border-yellow-500" 
                               placeholder="Contoh: 081234567890">
                    </div>
                </div>

                {{-- Nama Kost --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kost</label>
                    <input type="text" name="nama" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 px-4" 
                           placeholder="Contoh: Kost Syafira Indah" required>
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Per Bulan</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold group-focus-within:text-blue-600">Rp</span>
                        <input type="text" name="harga" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-12 py-3 text-lg font-medium tracking-wide" 
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
                            <option value="campur">🧑‍🤝‍🧑 Campur (Pria/Wanita)</option>
                            <option value="putra">👨 Khusus Putra</option>
                            <option value="putri">👩 Khusus Putri</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: LOKASI (OPTIMIZED & HYBRID) --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold">2</span>
                Lokasi Kost
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                {{-- Kota --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kota / Kab</label>
                    <select name="kota" id="select-kota" class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 py-2.5 bg-gray-50" required>
                        <option value="">Memuat data...</option>
                    </select>
                </div>
                {{-- Kecamatan --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kecamatan</label>
                    <select name="kecamatan" id="select-kecamatan" class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 py-2.5 bg-gray-50" disabled required>
                        <option value="">Pilih Kota Dulu...</option>
                    </select>
                </div>
                {{-- Kelurahan (Hybrid Input) --}}
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kelurahan</label>
                        {{-- Toggle Button --}}
                        <button type="button" id="toggle-kelurahan" class="text-[10px] text-blue-600 font-bold hover:underline cursor-pointer bg-blue-50 px-2 py-0.5 rounded border border-blue-100 transition hover:bg-blue-100">
                            Input Manual?
                        </button>
                    </div>
                    
                    {{-- Input 1: Dropdown API --}}
                    <select name="kelurahan" id="select-kelurahan" class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 py-2.5 bg-gray-50" disabled>
                        <option value="">Pilih Kec Dulu...</option>
                    </select>

                    {{-- Input 2: Manual Text --}}
                    <input type="text" name="kelurahan_manual" id="input-kelurahan" class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 py-2.5 bg-white hidden" placeholder="Contoh: Matras, Pantai Bibir..." disabled>
                </div>
            </div>

            {{-- Detail Alamat --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                <textarea name="alamat_detail" rows="2" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-3" 
                          placeholder="Nama Jalan, Nomor Rumah, RT/RW, Patokan..." required></textarea>
            </div>
        </div>

        {{-- SECTION 3: FASILITAS & FOTO --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold">3</span>
                Fasilitas & Foto
            </h3>
            
            {{-- Fasilitas Checkbox --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Fasilitas Tersedia</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @php $listFasilitas = ['Kasur', 'Lemari', 'Meja Belajar', 'WiFi', 'AC', 'Kamar Mandi Dalam', 'Dapur', 'Parkir', 'CCTV', 'Laundry']; @endphp
                    @foreach($listFasilitas as $item)
                    <label class="group flex items-center p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                        <input type="checkbox" name="fasilitas[]" value="{{ $item }}" class="rounded text-blue-600 focus:ring-blue-500 h-4 w-4 mr-3 transition group-hover:scale-110">
                        <span class="text-sm text-gray-700 font-medium">{{ $item }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            
            {{-- Fasilitas Manual --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Fasilitas Lainnya</label>
                <input type="text" name="fasilitas_tambahan" class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-3" 
                       placeholder="Contoh: Kulkas, TV, Dispenser (Pisahkan dengan koma)">
                <p class="text-xs text-gray-400 mt-1.5 ml-1">* Wajib gunakan tanda koma ( , ) sebagai pemisah antar fasilitas.</p>
            </div>

            {{-- Upload Foto (Multiple & Label) --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Kost (Bisa Banyak)</label>
                
                <div class="relative border-2 border-dashed border-blue-200 bg-blue-50/50 rounded-2xl p-8 text-center hover:bg-blue-50 transition cursor-pointer group" id="drop-zone">
                    <input type="file" name="foto[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" onchange="handleFileSelect(this)">
                    
                    <div class="space-y-3 pointer-events-none group-hover:scale-105 transition duration-300" id="upload-placeholder">
                        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-700">Klik untuk upload atau drag & drop</p>
                            <p class="text-xs text-gray-500 mt-1">Bisa pilih banyak foto sekaligus (Maks 2MB)</p>
                        </div>
                    </div>

                    {{-- Preview Container --}}
                    <div id="preview-container" class="hidden grid-cols-2 md:grid-cols-4 gap-4 mt-4 relative z-10"></div>
                </div>
            </div>

            {{-- Deskripsi (Auto Capitalize) --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Tambahan</label>
                <textarea name="deskripsi" rows="4" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-3" 
                          placeholder="Jelaskan detail peraturan kost, lingkungan sekitar, akses jalan, dll..." oninput="autoCapitalize(this)"></textarea>
                <p class="text-xs text-gray-400 mt-1">Huruf awal kalimat otomatis dikapitalisasi.</p>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex justify-end gap-4 pt-4 pb-8">
            <a href="{{ route('admin.kost.index') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition shadow-sm">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition transform active:scale-95">
                Simpan Data Kost
            </button>
        </div>
    </form>
</div>

{{-- JAVASCRIPT LOGIC --}}
<script>
    // 1. CEK WA PEMILIK (GOOGLE LOGIN HANDLER)
    function checkOwnerPhone(select) {
        const phone = select.options[select.selectedIndex].getAttribute('data-phone');
        const phoneInputWrapper = document.getElementById('phone-input-wrapper');
        const phoneInput = document.getElementById('owner_phone_input');

        if (!phone || phone === '') {
            // Tampilkan input pelengkap no HP
            phoneInputWrapper.classList.remove('hidden');
            phoneInput.required = true;
        } else {
            // Sembunyikan jika sudah ada
            phoneInputWrapper.classList.add('hidden');
            phoneInput.required = false;
            phoneInput.value = '';
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

    // 4. LOGIKA UPLOAD FOTO & PREVIEW
    function handleFileSelect(input) {
        const previewContainer = document.getElementById('preview-container');
        const placeholder = document.getElementById('upload-placeholder');
        const dropZone = document.getElementById('drop-zone');

        previewContainer.innerHTML = ''; // Reset

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
                        <div class="h-24 w-full overflow-hidden rounded-lg bg-gray-100 mb-2 relative group">
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition rounded-lg"></div>
                        </div>
                        <label class="block text-[10px] font-bold text-gray-500 mb-1 uppercase tracking-wide">Label Foto:</label>
                        <input type="text" name="foto_labels[]" placeholder="Cth: Kamar / Depan" 
                               class="w-full text-[11px] border-gray-200 rounded px-2 py-1.5 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 transition focus:bg-white">
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

    // 5. API WILAYAH & TOGGLE MANUAL
    document.addEventListener('DOMContentLoaded', function() {
        const kotaSelect = document.getElementById('select-kota');
        const kecSelect = document.getElementById('select-kecamatan');
        const kelSelect = document.getElementById('select-kelurahan');
        const kelInput = document.getElementById('input-kelurahan');
        const toggleBtn = document.getElementById('toggle-kelurahan');

        // Toggle Logic
        toggleBtn.addEventListener('click', function() {
            if (kelSelect.classList.contains('hidden')) {
                kelSelect.classList.remove('hidden');
                kelSelect.disabled = false;
                kelInput.classList.add('hidden');
                kelInput.disabled = true;
                this.innerText = "Input Manual?";
            } else {
                kelSelect.classList.add('hidden');
                kelSelect.disabled = true;
                kelInput.classList.remove('hidden');
                kelInput.disabled = false;
                this.innerText = "Gunakan Otomatis?";
                kelInput.focus();
            }
        });

        // Helper Cache
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

        // Init Kota (73 = Sulsel)
        fetchCached('https://www.emsifa.com/api-wilayah-indonesia/api/regencies/73.json', 'kota_73')
            .then(data => {
                kotaSelect.innerHTML = '<option value="">Pilih Kota/Kab...</option>';
                data.forEach(kota => {
                    let option = new Option(kota.name, kota.name);
                    option.dataset.id = kota.id;
                    kotaSelect.add(option);
                });
            });

        // Load Kecamatan
        kotaSelect.addEventListener('change', function() {
            let kotaId = this.options[this.selectedIndex].dataset.id;
            kecSelect.innerHTML = '<option value="">Memuat...</option>';
            kecSelect.disabled = true;
            kelSelect.innerHTML = '<option value="">Pilih Kec Dulu...</option>';
            
            if (kotaId) {
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
            }
        });

        // Load Kelurahan
        kecSelect.addEventListener('change', function() {
            let kecId = this.options[this.selectedIndex].dataset.id;
            kelSelect.innerHTML = '<option value="">Memuat...</option>';
            
            if (kecId) {
                fetchCached(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`, `kel_${kecId}`)
                    .then(data => {
                        kelSelect.innerHTML = '<option value="">Pilih Kelurahan...</option>';
                        data.forEach(kel => kelSelect.add(new Option(kel.name, kel.name)));
                    });
            }
        });
    });
</script>
@endsection
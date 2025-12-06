<div id="registerModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm items-center justify-center">
    <div class="bg-[#1F2A32] text-white rounded-3xl w-full max-w-md shadow-xl overflow-hidden">

        <!-- HEADER -->
        <div class="flex justify-between items-center px-6 py-4">
            <h5 class="font-semibold text-lg">Daftar ke Kostaraé</h5>
            <button onclick="closeModal()" class="text-white hover:text-gray-300 text-xl">
                ✕
            </button>
        </div>

        <!-- BODY -->
        <div class="px-6 pb-6 text-center">
            <p class="mb-6 text-white/60">Saya ingin mendaftar sebagai</p>

            <!-- PENCARI KOST -->
            <div onclick="window.location.href='{{ route('register.user') }}'"
                class="flex justify-between items-center bg-[#2D3A42] hover:bg-[#36454E] transition cursor-pointer p-4 rounded-xl mb-3">
                <div class="text-start">
                    <h6 class="font-semibold text-white mb-0">Pencari Kost</h6>
                    <small class="text-white/60">Temukan kost ideal sesuai kebutuhanmu</small>
                </div>
                <span class="text-white text-lg">›</span>
            </div>

            <!-- PEMILIK KOST -->
            <div onclick="window.location.href='{{ route('register.owner') }}'"
                class="flex justify-between items-center bg-[#2D3A42] hover:bg-[#36454E] transition cursor-pointer p-4 rounded-xl mb-3">
                <div class="text-start">
                    <h6 class="font-semibold text-white mb-0">Pemilik Kost</h6>
                    <small class="text-white/60">Kelola dan promosikan properti kost kamu</small>
                </div>
                <span class="text-white text-lg">›</span>
            </div>



            <div onclick="window.location.href='{{ route('login') }}'"
                class="relative bg-[#2D3A42] hover:bg-[#36454E] 
           transition cursor-pointer p-4 rounded-xl mb-3">

                <h6 class="font-semibold text-white text-center">
                    Masuk
                </h6>
                <small class="text-white/60">Masuk jika sudah punya akun</small>

                <span class="text-white text-lg absolute right-4 top-1/2 -translate-y-1/2">›</span>
            </div>

        </div>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('registerModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('registerModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

<div x-data="{ 
        isOpen: false, 
        confirmed: false, 
        isProcessing: false,
        item: { nama: '', pemilik: '', route: '', harga: '', status: '' } 
     }" 
     @open-delete-modal.window="item = $event.detail; isOpen = true; confirmed = false; isProcessing = false;"
     x-show="isOpen" 
     class="fixed inset-0 z-[99] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     x-cloak>
    
    <div @click.away="!isProcessing && (isOpen = false)" 
         x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-1 bg-red-600"></div>

        <div class="text-center mt-2">
            <div class="bg-red-50 text-red-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm border border-red-100">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Konfirmasi Hapus Kost</h3>
            <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                Tindakan ini akan menghapus unit <span class="font-bold text-gray-800" x-text="item.nama"></span> secara permanen.
            </p>
        </div>

        <div class="mt-5 bg-gray-50 p-4 rounded-xl border border-gray-200 text-[13px] space-y-2.5 shadow-inner">
            <div class="flex justify-between items-center">
                <span class="text-gray-500 font-medium">Mitra Pemilik:</span> 
                <span class="font-bold text-gray-800" x-text="item.pemilik"></span>
            </div>
            <div class="flex justify-between items-center border-t border-gray-200 pt-2">
                <span class="text-gray-500 font-medium">Harga Unit:</span> 
                <span class="text-emerald-700 font-bold" x-text="item.harga"></span>
            </div>
            <div class="flex justify-between items-center border-t border-gray-200 pt-2">
                <span class="text-gray-500 font-medium">Status Unit:</span> 
                <span class="px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-700 text-[10px] font-extrabold uppercase tracking-wider border border-indigo-100" x-text="item.status"></span>
            </div>
        </div>

        <label class="flex items-center mt-6 p-3 bg-red-50/50 rounded-lg border border-red-100 cursor-pointer group hover:bg-red-50 transition-colors">
            <input type="checkbox" x-model="confirmed" class="w-4 h-4 rounded border-gray-300 text-red-600 focus:ring-red-500 transition cursor-pointer">
            <span class="ml-3 text-[12px] text-red-800 font-medium select-none">
                Saya mengerti bahwa data, foto, dan ulasan akan hilang.
            </span>
        </label>

        <div class="mt-7 flex flex-col-reverse sm:flex-row gap-3">
            <button @click="isOpen = false" 
                    :disabled="isProcessing" 
                    class="flex-1 py-3 rounded-xl border border-gray-300 text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-800 transition-all disabled:opacity-50">
                Batalkan
            </button>
            
            <form :action="item.route" method="POST" class="flex-1" @submit="isProcessing = true">
                @csrf 
                @method('DELETE')
                <button type="submit" 
                        :disabled="!confirmed || isProcessing"
                        class="w-full py-3 rounded-xl bg-red-600 text-white text-sm font-bold hover:bg-red-700 hover:shadow-lg hover:shadow-red-200 disabled:bg-gray-300 disabled:shadow-none transition-all duration-200 flex items-center justify-center gap-2">
                    <template x-if="isProcessing">
                        <i class="fas fa-circle-notch animate-spin"></i>
                    </template>
                    <span x-text="isProcessing ? 'Menghapus...' : 'Ya, Hapus Data'"></span>
                </button>
            </form>
        </div>
    </div>
</div>
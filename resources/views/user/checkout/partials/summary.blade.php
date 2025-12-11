<div class="glass-panel p-6 rounded-2xl sticky top-24">
    <h3 class="text-xl font-bold text-white mb-4">Ringkasan Pesanan</h3>

    <!-- Loop Item Cart (Read-Only) -->
    <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
        <template x-for="item in cart" :key="item.id">
            <div class="flex gap-3">
                <div class="w-12 h-12 rounded bg-gray-800 overflow-hidden shrink-0">
                    <img :src="item.img" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <div class="flex justify-between text-sm">
                        <span class="text-white font-medium" x-text="item.qty + 'x ' + item.name"></span>
                        <span class="text-gray-300" x-text="formatRupiah(item.total)"></span>
                    </div>
                    <div class="text-xs text-gray-500 mt-1" x-show="item.addons.length > 0">
                        + <span x-text="item.addons.map(a => a.name).join(', ')"></span>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <hr class="border-gray-700 mb-4">

    <div class="space-y-2 text-sm">
        <div class="flex justify-between text-gray-400">
            <span>Subtotal</span>
            <span x-text="'Rp ' + formatRupiah(subtotal)"></span>
        </div>
        <div class="flex justify-between text-gray-400">
            <span>Ongkos Kirim (Estimasi)</span>
            <span x-text="'Rp ' + formatRupiah(deliveryFee)" class="text-white font-bold"></span>
        </div>
        <div class="flex justify-between text-gray-400">
            <span>Pajak & Layanan (11%)</span>
            <span x-text="'Rp ' + formatRupiah(tax)"></span>
        </div>
        <div class="flex justify-between text-white font-bold text-lg pt-2 border-t border-gray-700 mt-2">
            <span>Total Bayar</span>
            <span class="text-brand-green" x-text="'Rp ' + formatRupiah(grandTotal)"></span>
        </div>
    </div>

    <!-- Tombol Submit -->
    <button type="button" @click="submitOrder()" class="w-full bg-brand-green hover:bg-green-400 text-black font-bold py-4 rounded-xl shadow-lg mt-6 transition transform hover:-translate-y-1 flex justify-center items-center gap-2" :disabled="loading">
        <span x-show="!loading">Bayar Sekarang</span>
        <div x-show="loading" class="animate-spin rounded-full h-5 w-5 border-b-2 border-black"></div>
    </button>

    <p class="text-xs text-gray-500 text-center mt-4 flex items-center justify-center gap-1">
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
        Pembayaran Aman & Terenkripsi
    </p>
</div>
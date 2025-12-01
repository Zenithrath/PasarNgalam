<!-- ============================================ -->
<!-- VIEW 3: CART DETAIL & CHECKOUT -->
<!-- ============================================ -->
<div x-show="modalView === 'cart_detail'" class="flex flex-col h-full w-full" style="display: none;">
    
    <!-- Header Cart -->
    <div class="px-6 py-5 border-b border-gray-700 bg-[#0F172A] flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button @click="backToMerchant()" class="bg-gray-700 p-2 rounded-full hover:text-white text-gray-400 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <h3 class="text-xl font-bold text-white">Keranjang Saya</h3>
        </div>
        <button @click="showModal = false" class="text-gray-400 hover:text-white bg-gray-800 p-2 rounded-full">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Cart Items List -->
    <div class="flex-1 overflow-y-auto no-scrollbar p-6 bg-[#0F172A] space-y-4">
        <!-- Jika Keranjang Kosong -->
        <template x-if="cart.length === 0">
            <div class="flex flex-col items-center justify-center h-full text-gray-500">
                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <p>Keranjang kosong</p>
                <button @click="backToMerchant()" class="mt-4 text-brand-green text-sm hover:underline">Tambah Menu</button>
            </div>
        </template>

        <!-- Loop Item Cart -->
        <template x-for="item in cart" :key="item.id">
            <div class="flex gap-4 p-4 rounded-xl bg-gray-800/30 border border-gray-700 items-start">
                <div class="w-16 h-16 rounded-lg bg-gray-900 overflow-hidden flex-shrink-0">
                    <img :src="item.img" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <h5 class="font-bold text-white text-sm" x-text="item.name"></h5>
                        <span class="text-brand-green font-bold text-sm" x-text="'Rp ' + formatRupiah(item.total)"></span>
                    </div>
                    <p class="text-gray-400 text-xs mt-1" x-text="item.qty + 'x ' + (item.note ? ' • Catatan: ' + item.note : '')"></p>
                    <div class="flex flex-wrap gap-1 mt-2">
                        <template x-for="addon in item.addons">
                            <span class="text-[10px] bg-gray-700 text-gray-300 px-1.5 py-0.5 rounded border border-gray-600" x-text="'+ ' + addon.name"></span>
                        </template>
                    </div>
                </div>
                <button @click="removeFromCart(item.id)" class="text-red-500 hover:text-red-400 p-2 bg-red-500/10 rounded-lg hover:bg-red-500/20 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </template>
    </div>

    <!-- Footer Checkout -->
    <div class="p-6 border-t border-gray-700 bg-[#0F172A] flex-shrink-0 shadow-[0_-5px_15px_rgba(0,0,0,0.3)] space-y-4">
        <div class="flex justify-between items-center text-sm text-gray-400">
            <span>Total Pembayaran</span>
            <span class="text-2xl font-bold text-white" x-text="'Rp ' + formatRupiah(grandTotal)"></span>
        </div>
        
        <!-- TOMBOL CHECKOUT (Redirect ke Web Checkout) -->
        <button @click="processCheckout()" class="w-full bg-brand-green hover:bg-green-400 text-black font-bold py-4 rounded-xl shadow-[0_0_20px_rgba(0,224,115,0.3)] hover:shadow-[0_0_30px_rgba(0,224,115,0.5)] transition transform hover:-translate-y-1 flex justify-center items-center gap-2">
            <span>Checkout</span>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </div>
</div>
<div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <!-- Backdrop -->
    <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-black/80 backdrop-blur-sm"></div>

    <!-- Modal Container -->
    <div class="flex items-center justify-center min-h-screen p-0 md:p-4">
        <div x-show="showModal" 
             @click.away="showModal = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-20 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             class="relative bg-[#0F172A] md:rounded-[2rem] w-full max-w-lg shadow-2xl flex flex-col h-screen md:h-[85vh] overflow-hidden">

            <!-- ============================================ -->
            <!-- VIEW 1: DETAIL TOKO & LIST MENU (Tampilan Awal) -->
            <!-- ============================================ -->
            <div x-show="modalView === 'merchant_detail'" class="flex flex-col h-full relative w-full">
                
                <!-- HEADER (Fixed) -->
                <div class="relative h-40 w-full flex-shrink-0 z-10">
                    <img :src="selectedMerchant.img" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A] via-black/40 to-transparent"></div>
                    <button @click="showModal = false" class="absolute top-4 right-4 bg-black/50 backdrop-blur-md text-white p-2 rounded-full hover:bg-black/70 transition border border-white/10 z-20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="absolute bottom-4 left-6 right-6">
                        <h3 class="text-2xl font-bold text-white leading-tight" x-text="selectedMerchant.name"></h3>
                        <p class="text-brand-green font-medium text-sm" x-text="selectedMerchant.category"></p>
                    </div>
                </div>

                <!-- BODY (Scrollable) -->
                <div class="flex-1 overflow-y-auto no-scrollbar p-6 bg-[#0F172A] pb-24">
                    <h4 class="font-bold text-white mb-4 flex items-center gap-2">
                        <div class="w-1 h-5 bg-brand-green rounded-full"></div>
                        Daftar Menu
                    </h4>
                    
                    <div class="space-y-4">
                        <template x-for="menu in selectedMerchant.menus" :key="menu.name">
                            <div @click="openMenuCustomization(menu)" class="flex gap-4 p-3 rounded-xl bg-gray-800/40 border border-gray-700 hover:border-brand-green/50 hover:bg-gray-800/80 transition cursor-pointer group active:scale-95">
                                <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-900 flex-shrink-0">
                                    <img :src="menu.img" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <h5 class="font-bold text-white text-base leading-tight" x-text="menu.name"></h5>
                                        <p class="text-gray-400 text-xs mt-1 line-clamp-1" x-text="menu.desc"></p>
                                    </div>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-brand-green font-bold text-sm" x-text="'Rp ' + formatRupiah(menu.price)"></span>
                                        <button class="bg-gray-700 text-white text-[10px] font-bold px-3 py-1 rounded-full group-hover:bg-brand-green group-hover:text-black transition">
                                            Tambah +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- FOOTER: FLOATING CART BAR (Muncul jika ada isi keranjang) -->
                <div x-show="cartCount > 0" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="translate-y-full opacity-0"
                     x-transition:enter-end="translate-y-0 opacity-100"
                     class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-[#0F172A] via-[#0F172A] to-transparent z-20">
                    <button @click="openCart()" class="w-full bg-brand-green text-black font-bold py-4 px-6 rounded-2xl shadow-xl flex justify-between items-center hover:bg-green-400 transition transform active:scale-95">
                        <div class="flex items-center gap-3">
                            <div class="bg-black/20 text-black px-3 py-1 rounded-lg text-sm font-mono font-bold" x-text="cartCount + ' item'"></div>
                            <span class="text-sm font-bold">Lihat Keranjang & Checkout</span>
                        </div>
                        <span class="font-bold text-lg" x-text="'Rp ' + formatRupiah(grandTotal)"></span>
                    </button>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- VIEW 2: MENU CUSTOMIZATION (Detail Menu & Addon) -->
            <!-- ============================================ -->
            <div x-show="modalView === 'menu_customization'" class="flex flex-col h-full w-full" style="display: none;">
                
                <!-- HEADER (Fixed) -->
                <div class="relative px-6 py-4 border-b border-gray-700 bg-[#0F172A] flex items-center gap-4 z-10 flex-shrink-0">
                    <button @click="backToMerchant()" class="bg-gray-800 text-white p-2 rounded-full hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <h3 class="text-lg font-bold text-white truncate" x-text="selectedMenu.name"></h3>
                </div>

                <!-- BODY (Scrollable) -->
                <div class="flex-1 overflow-y-auto no-scrollbar bg-[#0F172A]">
                    <!-- Gambar Menu -->
                    <div class="h-56 w-full">
                        <img :src="selectedMenu.img" class="w-full h-full object-cover">
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Info Dasar -->
                        <div class="flex justify-between items-start">
                            <h2 class="text-2xl font-bold text-white" x-text="selectedMenu.name"></h2>
                            <p class="text-brand-green font-bold text-xl" x-text="'Rp ' + formatRupiah(selectedMenu.price)"></p>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed" x-text="selectedMenu.desc"></p>

                        <hr class="border-gray-700">

                        <!-- Add-ons Selection -->
                        <div>
                            <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider text-gray-400">Tambahan (Opsional)</h4>
                            <div class="space-y-3">
                                <template x-for="(addon, index) in selectedMenu.addons_available" :key="index">
                                    <label class="flex items-center justify-between p-4 rounded-xl border border-gray-700 bg-gray-800/40 hover:border-brand-green/50 transition cursor-pointer group select-none">
                                        <div class="flex items-center gap-3">
                                            <div class="relative flex items-center">
                                                <input type="checkbox" class="peer h-5 w-5 cursor-pointer appearance-none rounded border border-gray-500 transition-all checked:border-brand-green checked:bg-brand-green" @change="toggleAddon(addon)">
                                                <svg class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-3.5 h-3.5 text-black opacity-0 peer-checked:opacity-100 transition" viewBox="0 0 14 10" fill="none"><path d="M1 5L4.5 8.5L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </div>
                                            <span class="text-gray-200 group-hover:text-white font-medium" x-text="addon.name"></span>
                                        </div>
                                        <span class="text-sm font-bold" :class="addon.price > 0 ? 'text-gray-400' : 'text-brand-green'" x-text="addon.price > 0 ? '+Rp ' + formatRupiah(addon.price) : 'Gratis'"></span>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <!-- Note -->
                        <div>
                            <h4 class="font-bold text-white mb-2 text-sm uppercase tracking-wider text-gray-400">Catatan</h4>
                            <textarea x-model="note" rows="2" placeholder="Contoh: Jangan terlalu pedas..." class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- FOOTER (Fixed Bottom - Tombol Keranjang) -->
                <div class="p-5 border-t border-gray-700 bg-[#0F172A] z-10 flex-shrink-0 shadow-[0_-5px_15px_rgba(0,0,0,0.3)]">
                    <div class="flex items-center justify-between gap-4">
                        <!-- Qty -->
                        <div class="flex items-center gap-4 bg-gray-800 rounded-xl p-1.5 border border-gray-700">
                            <button @click="if(qty > 1) qty--" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition font-bold text-xl">−</button>
                            <span class="w-6 text-center font-bold text-white text-lg" x-text="qty"></span>
                            <button @click="qty++" class="w-10 h-10 flex items-center justify-center text-brand-green hover:bg-brand-green hover:text-black rounded-lg transition font-bold text-xl">+</button>
                        </div>

                        <!-- Add Button -->
                        <button @click="addToCart()" class="flex-1 bg-brand-green hover:bg-green-400 text-black font-bold py-4 px-6 rounded-xl shadow-lg transition transform active:scale-95 flex justify-between items-center group">
                            <span>Tambah Pesanan</span>
                            <span class="bg-black/20 px-2 py-1 rounded-lg text-xs font-mono" x-text="'Rp ' + formatRupiah(currentItemTotal)"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- VIEW 3: CART & CHECKOUT -->
            <!-- ============================================ -->
            <div x-show="modalView === 'cart_detail'" class="flex flex-col h-full w-full" style="display: none;">
                
                <!-- HEADER (Fixed) -->
                <div class="px-6 py-4 border-b border-gray-700 bg-[#0F172A] flex items-center justify-between flex-shrink-0 z-10">
                    <div class="flex items-center gap-3">
                        <button @click="backToMerchant()" class="bg-gray-800 p-2 rounded-full hover:text-white text-gray-400 transition"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                        <h3 class="text-xl font-bold text-white">Keranjang Saya</h3>
                    </div>
                    <button @click="showModal = false" class="text-gray-400 hover:text-white bg-gray-800 p-2 rounded-full"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>

                <!-- BODY (Scrollable List Item) -->
                <div class="flex-1 overflow-y-auto no-scrollbar p-6 bg-[#0F172A] space-y-4">
                    <template x-if="cart.length === 0">
                        <div class="flex flex-col items-center justify-center h-full text-gray-500">
                            <svg class="w-16 h-16 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <p>Keranjang kosong</p>
                        </div>
                    </template>

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
                            <button @click="removeFromCart(item.id)" class="text-red-500 hover:text-red-400 p-2 bg-red-500/10 rounded-lg hover:bg-red-500/20 transition"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </div>
                    </template>
                </div>

                <!-- FOOTER (Fixed Bottom - Checkout Button) -->
                <div class="p-6 border-t border-gray-700 bg-[#0F172A] flex-shrink-0 shadow-[0_-5px_15px_rgba(0,0,0,0.3)] space-y-4">
                    <div class="flex justify-between items-center text-sm text-gray-400">
                        <span>Total Pembayaran</span>
                        <span class="text-2xl font-bold text-white" x-text="'Rp ' + formatRupiah(grandTotal)"></span>
                    </div>
                    <button @click="processCheckout()" class="w-full bg-brand-green hover:bg-green-400 text-black font-bold py-4 rounded-xl shadow-lg transition transform active:scale-95 flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        Pesan via WhatsApp
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
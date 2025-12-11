<div x-show="showModal" class="fixed inset-0 z-[60] overflow-y-auto" x-cloak>
    <div x-show="showModal" x-transition.opacity @click="showModal = false"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm"></div>

    <div x-show="showModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         class="flex items-center justify-center min-h-screen p-4">

        <div class="bg-[#1E293B] border border-gray-700 w-full max-w-lg rounded-3xl shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]">

            <!-- HEADER -->
            <div class="p-6 border-b border-gray-700 flex justify-between items-center bg-[#0F172A]">
                <h3 class="text-xl font-bold text-white">
                    <span x-show="modalView === 'merchant_detail'" x-text="selectedMerchant.name"></span>
                    <span x-show="modalView === 'menu_customization'">Pesan Menu</span>
                    <span x-show="modalView === 'cart_detail'">Keranjang Saya</span>
                    <span x-show="modalView === 'merchant_reviews'">Ulasan Pelanggan</span>
                </h3>
                <button @click="showModal = false"
                        class="text-gray-400 hover:text-white bg-gray-800 p-2 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- BODY -->
            <div class="overflow-y-auto p-6 flex-1 no-scrollbar">

                <!-- VIEW: MERCHANT DETAIL -->
                <div x-show="modalView === 'merchant_detail'">

                    <!-- IMAGE -->
                    <img :src="selectedMerchant.img"
                         class="w-full h-48 object-cover rounded-2xl mb-6 border border-gray-600 bg-gray-800">

                    <!-- RATING SECTION -->
                    <div class="mb-4 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="text-yellow-400 font-bold text-lg">★</span>
                            <span class="text-white font-bold text-lg" x-text="selectedMerchant.rating"></span>
                            <span class="text-gray-400 text-xs" x-text="'(' + selectedMerchant.reviews.length + ' ulasan)'"></span>
                        </div>

                        <button @click="modalView = 'merchant_reviews'"
                                class="text-brand-green text-sm underline hover:text-green-400">
                            Lihat Ulasan
                        </button>
                    </div>

                    <h4 class="text-gray-400 text-sm font-bold uppercase tracking-wider mb-4">Daftar Menu</h4>

                    <div class="space-y-4">
                        <template x-for="menu in selectedMerchant.menus" :key="menu.id">
                            <div class="flex gap-4 p-4 rounded-xl border border-gray-700 bg-gray-800/50 
                                        hover:border-brand-green/50 cursor-pointer transition"
                                 @click="openMenuCustomization(menu)">
                                <img :src="menu.img" class="w-20 h-20 rounded-lg object-cover bg-gray-700">

                                <div class="flex-1">
                                    <h4 class="font-bold text-white text-lg" x-text="menu.name"></h4>
                                    <p class="text-gray-400 text-xs line-clamp-2"
                                       x-text="menu.desc || 'Tidak ada deskripsi'"></p>

                                    <div class="mt-2 flex justify-between items-center">
                                        <span class="text-brand-green font-bold"
                                              x-text="'Rp ' + formatRupiah(menu.price)">
                                        </span>
                                        <button class="bg-gray-700 hover:bg-brand-green hover:text-black 
                                                       text-white px-3 py-1 rounded-lg text-xs font-bold transition">
                                            + Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- VIEW: MENU CUSTOMIZATION -->
                <div x-show="modalView === 'menu_customization'">
                    <button @click="backToMerchant()"
                            class="text-gray-400 text-sm hover:text-white mb-4 flex items-center gap-1">
                        &larr; Kembali
                    </button>

                    <div class="flex gap-4 mb-6">
                        <img :src="selectedMenu.img" class="w-24 h-24 rounded-xl object-cover border border-gray-600 bg-gray-800">
                        <div>
                            <h2 class="text-2xl font-bold text-white" x-text="selectedMenu.name"></h2>
                            <p class="text-brand-green font-bold text-lg" x-text="'Rp ' + formatRupiah(selectedMenu.price)"></p>
                        </div>
                    </div>

                    <!-- Addons -->
                    <template x-if="selectedMenu.addons_available && selectedMenu.addons_available.length > 0">
                        <div class="mb-6">
                            <h4 class="font-bold text-white mb-3">Tambahan (Opsional)</h4>

                            <div class="space-y-2">
                                <template x-for="addon in selectedMenu.addons_available">
                                    <label class="flex items-center justify-between p-3 rounded-lg border border-gray-700 cursor-pointer hover:bg-gray-800 transition">
                                        <div class="flex items-center gap-3">
                                            <input type="checkbox" @change="toggleAddon(addon)"
                                                class="w-5 h-5 rounded border-gray-600 bg-gray-700 text-brand-green">
                                            <span class="text-gray-300 text-sm" x-text="addon.name"></span>
                                        </div>

                                        <span class="text-gray-400 text-xs"
                                              x-text="addon.price > 0 ? '+Rp ' + formatRupiah(addon.price) : 'Gratis'"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Notes -->
                    <div class="mb-6">
                        <h4 class="font-bold text-white mb-2">Catatan Pesanan</h4>
                        <textarea x-model="note"
                                  class="w-full bg-gray-900 border border-gray-700 rounded-xl p-3 text-white"
                                  placeholder="Contoh: Jangan pedas..."
                                  ></textarea>
                    </div>

                    <!-- Quantity -->
                    <div class="flex items-center justify-between bg-gray-900 p-4 rounded-xl border border-gray-700">
                        <span class="font-bold text-white">Jumlah</span>

                        <div class="flex items-center gap-4">
                            <button @click="qty > 1 ? qty-- : null"
                                class="w-8 h-8 rounded-full bg-gray-700 text-white flex items-center justify-center hover:bg-gray-600">−</button>

                            <span class="font-bold text-xl text-white w-8 text-center" x-text="qty"></span>

                            <button @click="qty++"
                                class="w-8 h-8 rounded-full bg-brand-green text-black flex items-center justify-center hover:bg-green-500">+</button>
                        </div>
                    </div>
                </div>

                <!-- VIEW 3: CART DETAIL -->
                <div x-show="modalView === 'cart_detail'">
                    <template x-if="cart.length === 0">
                        <div class="text-center py-10">
                            <div class="text-5xl mb-3">🛒</div>
                            <p class="text-gray-400 font-bold">Keranjang Kosong</p>
                            <button @click="showModal = false"
                                class="text-brand-green border border-brand-green px-4 py-2 rounded-lg hover:bg-brand-green hover:text-black">
                                Tutup
                            </button>
                        </div>
                    </template>

                    <div class="space-y-4">
                        <template x-for="item in cart" :key="item.id">
                            <div class="bg-gray-800/50 border border-gray-700 p-4 rounded-xl flex gap-4">
                                <img :src="item.img" class="w-16 h-16 rounded-lg object-cover bg-gray-700">

                                <div class="flex-1">
                                    <h4 class="font-bold text-white" x-text="item.name"></h4>
                                    <p class="text-gray-400 text-xs" x-text="item.qty + 'x @ Rp ' + formatRupiah(item.price)"></p>

                                    <template x-if="item.addons && item.addons.length > 0">
                                        <div class="mt-1 flex flex-wrap gap-1">
                                            <template x-for="ad in item.addons">
                                                <span class="text-[10px] bg-gray-700 px-2 py-0.5 rounded text-gray-300"
                                                      x-text="ad.name + ' (+' + formatRupiah(ad.price) + ')'"></span>
                                            </template>
                                        </div>
                                    </template>

                                    <p x-show="item.note" class="text-xs text-yellow-500 italic mt-1"
                                       x-text="'Note: ' + item.note"></p>
                                </div>

                                <div class="flex flex-col items-end justify-between">
                                    <span class="font-bold text-brand-green" x-text="'Rp ' + formatRupiah(item.total)"></span>
                                    <button @click="removeFromCart(item.id)" class="text-red-400 text-xs hover:underline">Hapus</button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- VIEW 4: MERCHANT REVIEWS -->
                <div x-show="modalView === 'merchant_reviews'">

                    <button @click="modalView = 'merchant_detail'"
                        class="text-gray-400 text-sm hover:text-white mb-4 flex items-center gap-1">
                        &larr; Kembali ke Detail Warung
                    </button>

                    <h2 class="text-xl font-bold text-white mb-4">Ulasan Pelanggan</h2>

                    <!-- Jika Tidak Ada Review -->
                    <template x-if="selectedMerchant.reviews.length === 0">
                        <div class="text-center py-10 text-gray-500">
                            <div class="text-5xl mb-3">💬</div>
                            Belum ada ulasan untuk warung ini.
                        </div>
                    </template>

                    <!-- LIST REVIEW -->
                    <div class="space-y-4" x-show="selectedMerchant.reviews.length > 0">
                        <template x-for="rev in selectedMerchant.reviews" :key="rev.id">
                            <div class="bg-gray-800/50 border border-gray-700 p-4 rounded-xl">

                                <div class="flex justify-between items-center mb-2">
                                    <div class="font-bold text-white text-sm" x-text="rev.reviewer_name"></div>
                                    <div class="text-yellow-400 text-xs font-bold">
                                        <span x-text="'★'.repeat(rev.rating)"></span>
                                        <span class="text-gray-500" x-text="'★'.repeat(5 - rev.rating)"></span>
                                    </div>
                                </div>

                                <div class="text-gray-500 text-xs mb-2"
                                    x-text="new Date(rev.created_at).toLocaleDateString('id-ID')"></div>

                                <p class="text-gray-300 text-sm whitespace-pre-line" x-text="rev.comment"></p>

                            </div>
                        </template>
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="p-6 border-t border-gray-700 bg-[#0F172A]" 
                 x-show="modalView !== 'merchant_detail'">

                <button x-show="modalView === 'menu_customization'"
                        @click="addToCart()"
                        class="w-full bg-brand-green hover:bg-green-500 text-black font-bold py-4 rounded-xl flex justify-between px-6">
                    <span>Tambah Pesanan</span>
                    <span x-text="'Rp ' + formatRupiah(currentItemTotal)"></span>
                </button>

                <button x-show="modalView === 'cart_detail' && cart.length > 0"
                        @click="processCheckout()"
                        class="w-full bg-brand-green hover:bg-green-500 text-black font-bold py-4 rounded-xl flex justify-between px-6">
                    <span>Checkout Sekarang</span>
                    <span x-text="'Total: Rp ' + formatRupiah(grandTotal)"></span>
                </button>

            </div>

        </div>
    </div>
</div>

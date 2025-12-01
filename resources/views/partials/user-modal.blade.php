<!-- ===== MODAL PEMBELIAN (PARTIAL) ===== -->
<div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <!-- Backdrop -->
    <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-black/80 backdrop-blur-sm"></div>

    <!-- Modal Container -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div x-show="showModal" 
             @click.away="showModal = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-20 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-20 scale-95"
             class="relative bg-[#0F172A] border border-gray-700 rounded-[2rem] w-full max-w-lg shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">
            
            <!-- 1. Header: Image -->
            <div class="relative h-64 w-full flex-shrink-0">
                <img :src="selectedFood.img" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A] via-transparent to-transparent"></div>
                
                <!-- Close Button -->
                <button @click="showModal = false" class="absolute top-4 right-4 bg-black/50 backdrop-blur-md text-white p-2 rounded-full hover:bg-black/70 transition border border-white/10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <!-- Title Overlay -->
                <div class="absolute bottom-4 left-6 right-6">
                    <div class="flex justify-between items-end">
                        <div>
                            <h3 class="text-3xl font-bold text-white leading-tight" x-text="selectedFood.name"></h3>
                            <p class="text-brand-green font-medium text-lg mt-1" x-text="'Rp ' + formatRupiah(selectedFood.price)"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Body: Scrollable -->
            <div class="p-6 overflow-y-auto no-scrollbar space-y-6 flex-1">
                
                <!-- Description -->
                <div class="bg-gray-800/30 p-4 rounded-xl border border-white/5">
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Nikmati hidangan spesial <span x-text="selectedFood.category"></span> dengan bumbu racikan khas yang menggugah selera. Cocok untuk makan siang maupun malam.
                    </p>
                </div>

                <!-- Add-ons Selection -->
                <div>
                    <h4 class="font-bold text-white mb-3 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-brand-green rounded-full"></span>
                        Tambahan (Opsional)
                    </h4>
                    <div class="space-y-3">
                        <template x-for="(addon, index) in selectedFood.addons" :key="index">
                            <label class="flex items-center justify-between p-4 rounded-xl border border-gray-700 bg-gray-800/40 hover:border-brand-green/50 hover:bg-gray-800/60 transition cursor-pointer group">
                                <div class="flex items-center gap-3">
                                    <!-- Custom Checkbox -->
                                    <div class="relative flex items-center">
                                        <input type="checkbox" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-gray-500 transition-all checked:border-brand-green checked:bg-brand-green"
                                               @change="toggleAddon(addon)">
                                        <svg class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-3.5 h-3.5 text-black opacity-0 peer-checked:opacity-100 transition" viewBox="0 0 14 10" fill="none">
                                            <path d="M1 5L4.5 8.5L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <span class="text-gray-200 group-hover:text-white font-medium" x-text="addon.name"></span>
                                </div>
                                <span class="text-sm font-bold" 
                                      :class="addon.price > 0 ? 'text-gray-400' : 'text-brand-green'"
                                      x-text="addon.price > 0 ? '+Rp ' + formatRupiah(addon.price) : 'Gratis'"></span>
                            </label>
                        </template>
                    </div>
                </div>

                <!-- Note -->
                <div>
                    <h4 class="font-bold text-white mb-3">Catatan Pesanan</h4>
                    <textarea x-model="note" rows="2" placeholder="Contoh: Jangan terlalu pedas, kuah dipisah..." class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition resize-none"></textarea>
                </div>
            </div>

            <!-- 3. Footer: Action -->
            <div class="p-6 border-t border-gray-700 bg-gray-800/50 backdrop-blur-md">
                <div class="flex items-center justify-between gap-4">
                    <!-- Qty Selector -->
                    <div class="flex items-center gap-4 bg-gray-900 rounded-xl p-1 border border-gray-700">
                        <button @click="if(qty > 1) qty--" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition font-bold text-lg">−</button>
                        <span class="w-8 text-center font-bold text-white text-lg" x-text="qty"></span>
                        <button @click="qty++" class="w-10 h-10 flex items-center justify-center text-brand-green hover:bg-brand-green hover:text-black rounded-lg transition font-bold text-lg">+</button>
                    </div>

                    <!-- Add to Cart Button -->
                    <button class="flex-1 bg-brand-green hover:bg-green-400 text-black font-bold py-4 px-6 rounded-xl shadow-[0_0_20px_rgba(0,224,115,0.3)] hover:shadow-[0_0_30px_rgba(0,224,115,0.5)] transition transform hover:-translate-y-1 flex justify-between items-center group">
                        <span>Pesan Sekarang</span>
                        <span class="bg-black/20 px-3 py-1 rounded-lg text-sm group-hover:bg-black/30 transition" x-text="'Rp ' + formatRupiah(totalPrice)"></span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
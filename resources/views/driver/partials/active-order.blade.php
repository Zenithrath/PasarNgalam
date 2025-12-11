<div class="glass-panel border-2 border-brand-green/50 rounded-3xl p-0 shadow-[0_0_50px_rgba(0,224,115,0.15)] relative overflow-hidden animate-pulse-glow">
    
    <!-- Header Status Order -->
    <div class="bg-gradient-to-r from-brand-green to-emerald-500 p-4 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagonal-stripes.png')] opacity-10"></div>
        <h2 class="text-xl font-black text-black uppercase tracking-wide flex items-center justify-center gap-2">
            <span class="animate-bounce">🔔</span> Orderan Masuk!
        </h2>
        <p class="text-black/80 text-xs font-bold mt-1">Status: {{ strtoupper($activeOrder->status) }}</p>
    </div>

    <div class="p-6 relative">
        <!-- Route Timeline -->
        <div class="relative pl-4 border-l-2 border-dashed border-gray-700 ml-2 space-y-8">
            <!-- Merchant (Titik Jemput) -->
            <div class="relative">
                <div class="absolute -left-[23px] top-1 w-6 h-6 bg-brand-card border-2 border-blue-500 rounded-full flex items-center justify-center text-[10px] z-10 shadow-lg shadow-blue-500/50">🏪</div>
                <div>
                    <p class="text-[10px] text-blue-400 font-bold uppercase mb-1">Lokasi Jemput</p>
                    <h4 class="font-bold text-white text-lg leading-tight">{{ $activeOrder->merchant->store_name ?? 'Merchant' }}</h4>
                    <p class="text-gray-400 text-sm mt-1 bg-gray-800/50 p-2 rounded-lg inline-block border border-gray-700">
                        📦 Total Belanja: <span class="text-white font-bold">Rp {{ number_format($activeOrder->total_price, 0, ',', '.') }}</span>
                    </p>
                </div>
            </div>

            <!-- Customer (Titik Antar) -->
            <div class="relative">
                <div class="absolute -left-[23px] top-1 w-6 h-6 bg-brand-green border-2 border-brand-green rounded-full flex items-center justify-center text-black font-bold text-[10px] z-10 shadow-lg shadow-brand-green/50">📍</div>
                <div>
                    <p class="text-[10px] text-brand-green font-bold uppercase mb-1">Lokasi Antar</p>
                    <h4 class="font-bold text-white text-lg leading-tight">{{ $activeOrder->delivery_address }}</h4>
                    
                    <!-- Informasi Ongkir -->
                    <div class="mt-2 flex items-center gap-2 bg-brand-green/10 p-2 rounded-lg border border-brand-green/20">
                        <span class="text-xl">💰</span>
                        <div>
                            <p class="text-[10px] text-gray-400">Ongkir Tunai (Terima dari Customer)</p>
                            <p class="text-brand-green font-bold text-base">Rp {{ number_format($activeOrder->delivery_fee, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi (Google Maps & Selesaikan) -->
        <div class="mt-8 grid gap-3">
            <!-- Google Maps Link -->
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $activeOrder->dest_latitude }},{{ $activeOrder->dest_longitude }}" target="_blank" 
               class="w-full bg-gray-800 hover:bg-gray-700 text-white py-3.5 rounded-xl border border-gray-600 transition font-bold flex items-center justify-center gap-2 group">
                <span class="group-hover:scale-110 transition">🗺️</span> Buka Google Maps
            </a>
            
            <!-- Logic Tombol Berdasarkan Status -->
            @if($activeOrder->status == 'ready')
                <!-- Jika status READY (Makanan Siap), Driver klik Ambil -->
                <form action="{{ route('driver.order.accept', $activeOrder->id) }}" method="POST" onsubmit="return confirm('Konfirmasi Ambil Pesanan?')">
                    @csrf
                    <button type="submit" class="w-full bg-gradient-to-r from-brand-green to-emerald-500 hover:to-emerald-400 text-black font-black uppercase tracking-wider py-4 rounded-xl shadow-[0_10px_20px_rgba(0,224,115,0.2)] transition transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
                        <span>🚀</span> Ambil Pesanan
                    </button>
                </form>
            
            @elseif($activeOrder->status == 'delivery')
                <!-- Jika status DELIVERY (Sedang Diantar), Driver klik Selesai -->
                <form action="{{ route('driver.order.complete', $activeOrder->id) }}" method="POST" onsubmit="return confirm('Selesaikan Pengantaran? Pastikan uang sudah diterima.')">
                    @csrf
                    <button type="submit" class="w-full bg-gradient-to-r from-brand-green to-emerald-500 hover:to-emerald-400 text-black font-black uppercase tracking-wider py-4 rounded-xl shadow-[0_10px_20px_rgba(0,224,115,0.2)] transition transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
                        <span>✅</span> Selesaikan Order
                    </button>
                </form>
            
            @else
                <!-- Jika status Pending/Cooking -->
                <button disabled class="w-full bg-gray-700 text-gray-400 font-bold py-4 rounded-xl cursor-not-allowed">
                    Menunggu Merchant Menyiapkan...
                </button>
            @endif
        </div>
    </div>
</div>
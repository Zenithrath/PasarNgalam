<!-- VIEW: ONLINE (RADAR ANIMATION) -->
<div x-show="isOnline" x-transition.opacity.duration.500ms class="text-center py-16 relative">
    
    <!-- Radar Animation -->
    <div class="relative w-48 h-48 mx-auto mb-10 flex items-center justify-center">
        <!-- Ripples -->
        <div class="absolute inset-0 bg-brand-green/20 rounded-full animate-ping-slow"></div>
        <div class="absolute inset-10 bg-brand-green/10 rounded-full animate-ping-slow" style="animation-delay: 0.8s"></div>
        <div class="absolute inset-20 bg-brand-green/5 rounded-full animate-ping-slow" style="animation-delay: 1.5s"></div>
        
        <!-- Static Rings -->
        <div class="absolute inset-0 border border-brand-green/20 rounded-full"></div>
        <div class="absolute inset-12 border border-brand-green/10 rounded-full"></div>

        <!-- Center Icon -->
        <div class="relative z-10 bg-[#0B1120] p-6 rounded-full border-2 border-brand-green shadow-[0_0_30px_rgba(0,224,115,0.4)]">
            <span class="text-5xl animate-pulse">📡</span>
        </div>
    </div>

    <h2 class="text-2xl font-bold text-white mb-2">Mencari Orderan...</h2>
    <div class="flex items-center justify-center gap-2 text-brand-green bg-brand-green/10 px-4 py-2 rounded-full inline-block border border-brand-green/20">
        <span class="w-2 h-2 bg-brand-green rounded-full animate-pulse"></span>
        <span class="text-xs font-bold tracking-wide">GPS AKTIF & MEMANTAU</span>
    </div>
    <p class="text-gray-500 text-sm mt-6 max-w-xs mx-auto leading-relaxed">
        Sistem sedang mencarikan pelanggan terdekat dari lokasi Anda saat ini.
    </p>
</div>

<!-- VIEW: OFFLINE -->
<div x-show="!isOnline" x-transition.opacity.duration.500ms class="text-center py-20">
    <div class="w-32 h-32 bg-gray-800/50 rounded-full flex items-center justify-center mx-auto mb-6 border border-gray-700">
        <span class="text-5xl grayscale opacity-50">😴</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-400 mb-2">Kamu Sedang Offline</h2>
    <p class="text-gray-500 text-sm max-w-xs mx-auto mb-8">Istirahatlah sejenak. Jika sudah siap, geser tombol di atas untuk mulai bekerja kembali.</p>
    
    <button @click="toggleStatus()" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-xl border border-gray-600 transition hover:border-brand-green hover:text-brand-green">
        Mulai Bekerja
    </button>
</div>
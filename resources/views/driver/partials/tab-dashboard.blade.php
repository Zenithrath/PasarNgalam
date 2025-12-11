<!-- 1. STATISTIK UTAMA (Saldo & Order Hari Ini) -->
@include('driver.partials.stats')

<!-- 2. ORDER AKTIF / STANDBY -->
<div class="mt-6 transition-all duration-300">
    @if($activeOrder)
        @include('driver.partials.active-order')
    @else
        @include('driver.partials.standby')
    @endif
</div>

<!-- 3. PERFORMA & MISI (Dinamis dari Database) -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
    
    <!-- Kartu Performa Dinamis -->
    <div class="glass-panel p-5 rounded-2xl relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="font-bold text-white">Performa Kamu</h3>
                <p class="text-xs text-gray-400">Update terakhir: Realtime</p>
            </div>
            <!-- RATING DINAMIS -->
            <div class="bg-gray-800 p-2 rounded-lg text-yellow-400 font-bold flex items-center gap-1 shadow-inner">
                <span>⭐</span> {{ $driverRating ?? '5.0' }}
            </div>
        </div>
        <div class="flex gap-4 text-center">
            <!-- PERSENTASE PENERIMAAN -->
            <div class="flex-1 bg-gray-800/50 p-3 rounded-xl border border-gray-700">
                <p class="text-brand-green font-bold text-xl">{{ $completionRate ?? 100 }}%</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-wide">Penerimaan</p>
            </div>
            <!-- PERSENTASE PEMBATALAN -->
            <div class="flex-1 bg-gray-800/50 p-3 rounded-xl border border-gray-700">
                <!-- Jika pembatalan tinggi (>10%), warna jadi merah -->
                <p class="{{ ($cancellationRate ?? 0) > 10 ? 'text-red-500' : 'text-white' }} font-bold text-xl">
                    {{ $cancellationRate ?? 0 }}%
                </p>
                <p class="text-[10px] text-gray-400 uppercase tracking-wide">Pembatalan</p>
            </div>
        </div>
    </div>

    <!-- Kartu Misi Harian (Target 10 Order) -->
    <div class="glass-panel p-5 rounded-2xl relative overflow-hidden">
        <!-- Hiasan Background -->
        <div class="absolute -right-4 -top-4 w-20 h-20 bg-brand-green/20 rounded-full blur-xl"></div>
        
        <h3 class="font-bold text-white mb-1 flex items-center gap-2 relative z-10">
            <span>🎯</span> Misi Harian
        </h3>
        <p class="text-xs text-gray-400 mb-4 relative z-10">Selesaikan order untuk bonus tambahan!</p>
        
        <!-- Progress Bar Misi -->
        <div class="relative pt-1 z-10">
            <div class="flex mb-2 items-center justify-between">
                <span class="text-xs font-semibold inline-block text-brand-green">
                    {{ $todayOrders ?? 0 }}/10 Order
                </span>
                <span class="text-xs font-semibold inline-block text-white">Bonus 50rb</span>
            </div>
            
            <div class="overflow-hidden h-2.5 mb-2 text-xs flex rounded bg-gray-700">
                @php 
                    $target = 10;
                    $current = $todayOrders ?? 0;
                    $percentage = min(($current / $target) * 100, 100); 
                @endphp
                <div style="width:{{ $percentage }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-brand-green to-emerald-500 transition-all duration-1000 ease-out"></div>
            </div>
            
            <p class="text-[10px] text-gray-400 italic">
                {{ ($target - $current) > 0 ? 'Kurang ' . ($target - $current) . ' order lagi semangat!' : '🎉 Misi Selesai! Selamat!' }}
            </p>
        </div>
    </div>
</div>

<!-- 4. BERITA & INFO (Carousel - Tetap Static karena belum ada tabel Berita) -->
<div class="mt-8 mb-8">
    <div class="flex items-center justify-between mb-3 px-1">
        <h3 class="font-bold text-white">Kabar PasarNgalam</h3>
        <span class="text-[10px] text-gray-400">Geser untuk info &rarr;</span>
    </div>

    <div class="flex overflow-x-auto gap-4 hide-scrollbar pb-2 snap-x">
        <!-- News Card 1 -->
        <div class="min-w-[260px] glass-panel p-0 rounded-2xl overflow-hidden cursor-pointer hover:border-brand-green/50 transition snap-center group">
            <div class="relative h-32 w-full overflow-hidden">
                <img src="https://images.unsplash.com/photo-1556740758-90de374c12ad?q=80&w=400" class="h-full w-full object-cover opacity-80 group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
            </div>
            <div class="p-4 relative -mt-8">
                <span class="bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded mb-2 inline-block shadow-lg">Tips</span>
                <h4 class="font-bold text-sm text-white leading-tight line-clamp-2">Cara mendapatkan orderan gacor di jam sibuk</h4>
            </div>
        </div>

        <!-- News Card 2 -->
        <div class="min-w-[260px] glass-panel p-0 rounded-2xl overflow-hidden cursor-pointer hover:border-brand-green/50 transition snap-center group">
            <div class="relative h-32 w-full overflow-hidden">
                <img src="https://images.unsplash.com/photo-1607203699026-b8252277d3f8?q=80&w=400" class="h-full w-full object-cover opacity-80 group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
            </div>
            <div class="p-4 relative -mt-8">
                <span class="bg-brand-green text-black text-[10px] font-bold px-2 py-0.5 rounded mb-2 inline-block shadow-lg">Promo</span>
                <h4 class="font-bold text-sm text-white leading-tight line-clamp-2">Area Sawojajar sedang ramai orderan!</h4>
            </div>
        </div>

        <!-- News Card 3 -->
        <div class="min-w-[260px] glass-panel p-0 rounded-2xl overflow-hidden cursor-pointer hover:border-brand-green/50 transition snap-center group">
            <div class="h-32 w-full bg-gray-800 flex items-center justify-center text-4xl relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                ⚠️
            </div>
            <div class="p-4 relative -mt-8">
                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded mb-2 inline-block shadow-lg">Penting</span>
                <h4 class="font-bold text-sm text-white leading-tight line-clamp-2">Hindari area macet di Jl. Soekarno Hatta sore ini</h4>
            </div>
        </div>
    </div>
</div>
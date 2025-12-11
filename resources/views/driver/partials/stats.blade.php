<div class="grid grid-cols-2 gap-4">
    <!-- Card Saldo -->
    <div class="glass-panel p-5 rounded-2xl relative overflow-hidden group hover:border-brand-green/30 transition duration-300">
        <div class="absolute right-[-10px] bottom-[-10px] text-gray-700/20 group-hover:text-brand-green/10 transition-colors transform rotate-12">
            <svg class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2 flex items-center gap-2">
            <span class="w-2 h-2 bg-brand-green rounded-full"></span> Dompet Tunai
        </p>
        <p class="text-2xl font-extrabold text-white flex items-baseline gap-1">
            <span class="text-sm font-normal text-gray-400">Rp</span>
            {{ number_format($totalEarnings, 0, ',', '.') }}
        </p>
    </div>

    <!-- Card Orderan -->
    <div class="glass-panel p-5 rounded-2xl relative overflow-hidden group hover:border-blue-400/30 transition duration-300">
        <div class="absolute right-[-10px] bottom-[-10px] text-gray-700/20 group-hover:text-blue-400/10 transition-colors transform rotate-12">
            <svg class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        </div>
        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2 flex items-center gap-2">
            <span class="w-2 h-2 bg-blue-400 rounded-full"></span> Order Hari Ini
        </p>
        <p class="text-2xl font-extrabold text-white flex items-baseline gap-1">
            {{ $todayOrders }} <span class="text-sm font-normal text-gray-400">Selesai</span>
        </p>
    </div>
</div>
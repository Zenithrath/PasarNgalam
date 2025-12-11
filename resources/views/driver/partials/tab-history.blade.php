<div class="space-y-4">
    <h2 class="text-xl font-bold text-white mb-4">Riwayat Orderan</h2>

    <!-- LIST RIWAYAT DINAMIS -->
    <div class="space-y-3">
        @forelse($historyOrders as $history)
            <div class="glass-panel p-4 rounded-2xl flex items-center gap-4 transition hover:bg-gray-800/50 
                {{ $history->status == 'cancelled' ? 'opacity-70 grayscale' : '' }}">
                
                <!-- Icon Berdasarkan Nama Toko (Inisial) -->
                <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold
                    {{ $history->status == 'cancelled' ? 'bg-red-900/50 text-red-400' : 'bg-gray-800 text-white' }}">
                    {{ substr($history->merchant->store_name ?? 'M', 0, 1) }}
                </div>

                <div class="flex-1">
                    <div class="flex justify-between">
                        <h4 class="font-bold text-white text-sm">{{ $history->merchant->store_name ?? 'Merchant' }}</h4>
                        
                        <!-- Format Harga Ongkir -->
                        @if($history->status == 'cancelled')
                            <span class="text-red-400 font-bold text-sm line-through">Rp {{ number_format($history->delivery_fee, 0, ',', '.') }}</span>
                        @else
                            <span class="text-brand-green font-bold text-sm">Rp {{ number_format($history->delivery_fee, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    
                    <p class="text-xs text-gray-400">
                        {{ \Carbon\Carbon::parse($history->created_at)->isoFormat('D MMM, HH:mm') }} • Tunai
                    </p>
                    
                    <div class="flex items-center gap-1 mt-1">
                        @if($history->status == 'completed')
                            <span class="text-[10px] bg-green-500/20 text-green-400 px-1.5 py-0.5 rounded">Selesai</span>
                            <span class="text-[10px] text-gray-500">⭐ 5.0</span>
                        @else
                            <span class="text-[10px] bg-red-500/20 text-red-400 px-1.5 py-0.5 rounded">Dibatalkan</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <!-- Tampilan Jika Belum Ada History -->
            <div class="text-center py-16 bg-gray-800/30 rounded-2xl border border-gray-700 border-dashed">
                <p class="text-gray-400 text-sm mb-2">Belum ada riwayat orderan.</p>
                <p class="text-xs text-gray-600">Ayo mulai cari orderan!</p>
            </div>
        @endforelse
    </div>
</div>
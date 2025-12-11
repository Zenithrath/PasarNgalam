<div class="glass-panel p-6 rounded-2xl">
    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
        <span class="bg-brand-green text-black w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">2</span>
        Pilih Pembayaran
    </h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- QRIS -->
        <label class="cursor-pointer relative">
            <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" class="peer sr-only">
            <div class="p-4 rounded-xl border border-gray-600 bg-gray-800/50 hover:bg-gray-800 peer-checked:border-brand-green peer-checked:bg-brand-green/10 transition flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded flex items-center justify-center p-1"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/1200px-Logo_QRIS.svg.png" class="max-w-full max-h-full"></div>
                <div><div class="font-bold text-white">QRIS</div><div class="text-xs text-gray-400">Scan & Bayar Instan</div></div>
                <div class="ml-auto w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-brand-green peer-checked:bg-brand-green"></div>
            </div>
        </label>
        
        <!-- GOPAY -->
        <label class="cursor-pointer relative">
            <input type="radio" name="payment_method" value="gopay" x-model="paymentMethod" class="peer sr-only">
            <div class="p-4 rounded-xl border border-gray-600 bg-gray-800/50 hover:bg-gray-800 peer-checked:border-brand-green peer-checked:bg-brand-green/10 transition flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded flex items-center justify-center p-1"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/2560px-Gopay_logo.svg.png" class="max-w-full max-h-full"></div>
                <div><div class="font-bold text-white">GoPay</div><div class="text-xs text-gray-400">Sambungkan Akun</div></div>
                <div class="ml-auto w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-brand-green peer-checked:bg-brand-green"></div>
            </div>
        </label>
        
        <!-- BANK TRANSFER -->
        <label class="cursor-pointer relative">
            <input type="radio" name="payment_method" value="bank" x-model="paymentMethod" class="peer sr-only">
            <div class="p-4 rounded-xl border border-gray-600 bg-gray-800/50 hover:bg-gray-800 peer-checked:border-brand-green peer-checked:bg-brand-green/10 transition flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded flex items-center justify-center p-1"><svg class="w-6 h-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg></div>
                <div><div class="font-bold text-white">Transfer Bank</div><div class="text-xs text-gray-400">BCA, Mandiri, BRI</div></div>
                <div class="ml-auto w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-brand-green peer-checked:bg-brand-green"></div>
            </div>
        </label>
        
        <!-- COD -->
        <label class="cursor-pointer relative">
            <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="peer sr-only">
            <div class="p-4 rounded-xl border border-gray-600 bg-gray-800/50 hover:bg-gray-800 peer-checked:border-brand-green peer-checked:bg-brand-green/10 transition flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded flex items-center justify-center p-1"><svg class="w-6 h-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg></div>
                <div><div class="font-bold text-white">Tunai / COD</div><div class="text-xs text-gray-400">Bayar ke kurir</div></div>
                <div class="ml-auto w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-brand-green peer-checked:bg-brand-green"></div>
            </div>
        </label>
    </div>
</div>
<div class="glass-panel p-6 rounded-2xl">
    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
        <span class="bg-brand-green text-black w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">1</span>
        Alamat Pengiriman
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nama Penerima</label>
            <input type="text" name="customer_name" class="form-input" placeholder="Contoh: Budi Santoso" required>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nomor WhatsApp</label>
            <input type="tel" name="customer_phone" class="form-input" placeholder="0812..." required>
        </div>
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Alamat Lengkap</label>
        <textarea name="delivery_address" rows="2" class="form-input" placeholder="Nama jalan, nomor rumah, patokan..." required></textarea>
    </div>
    
    <!-- PETA LOKASI PENGIRIMAN -->
    <div class="mt-4">
        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Lokasi Pengiriman (Geser Pin)</label>
        <div id="map-register" style="height: 250px; width: 100%; border-radius: 0.75rem; z-index: 0; margin-top: 10px; border: 1px solid #475569;"></div>
        <p class="text-[10px] text-gray-500 mt-1">*Geser pin ke lokasi rumah Anda. Ongkir dihitung otomatis.</p>
    </div>
</div>
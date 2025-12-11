<div x-show="activeTab === 'menu'" x-transition.opacity.duration.300ms class="space-y-8">
    
    <!-- HERO BANNER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-green to-teal-500 text-black shadow-2xl shadow-brand-green/20">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
        <div class="relative z-10 p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left">
                <h1 class="text-3xl font-extrabold mb-2 text-white drop-shadow-md">
                    Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋
                </h1>
                <p class="text-white/90 text-lg font-medium max-w-lg">
                    Siap melayani pelanggan hari ini? Jangan lupa update stok menu.
                </p>
            </div>
            <button @click="openModal('create')" class="bg-white text-brand-green font-bold py-3.5 px-8 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition transform flex items-center gap-2 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="current/svg" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Menu Baru
            </button>
        </div>
    </div>

    <!-- LIST MENU -->
    <div class="space-y-4">
        <div class="flex items-center justify-between px-2">
            <h2 class="text-xl font-bold text-white">Daftar Menu Aktif</h2>
            <span class="text-sm text-gray-400">Total {{ isset($products) ? count($products) : 0 }} Menu</span>
        </div>

        <!-- GRID RESPONSIVE (HP = 2 kolom, Desktop = 1 kolom) -->
        <div class="grid grid-cols-2 md:grid-cols-1 gap-4">

        @if(isset($products) && count($products) > 0)
            @foreach($products as $product)

            <div class="glass-panel p-4 rounded-2xl flex flex-col md:flex-row gap-5 items-center 
                        group hover:border-brand-green/30 transition duration-300 bg-[#151F32] 
                        border border-white/5 h-full">

                <!-- Image -->
                <div class="w-full md:w-28 h-28 rounded-xl overflow-hidden relative flex-shrink-0 
                            border border-white/10 bg-black">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x400?text=No+Image' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                
                <!-- Content -->
                <div class="flex-1 text-center md:text-left w-full">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start">
                        <div>
                            <h3 class="font-bold text-white text-lg">{{ $product->name }}</h3>
                            <p class="text-gray-400 text-sm mt-1 line-clamp-1">{{ $product->description }}</p>
                            <span class="inline-block mt-2 text-[10px] px-2 py-0.5 rounded bg-gray-700 text-gray-300 border border-gray-600">
                                {{ $product->category ?? 'Makanan' }}
                            </span>
                        </div>
                        <div class="mt-2 md:mt-0">
                            <span class="text-brand-green font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-center md:justify-between mt-3 pt-3 border-t border-white/5">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full {{ $product->is_available ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]' : 'bg-red-500' }}"></span>
                            <span class="text-xs text-gray-300">{{ $product->is_available ? 'Tersedia' : 'Habis' }}</span>
                        </div>
                        <div class="flex gap-2">
                            <!-- Edit -->
                            <button @click="openModal('edit', {{ json_encode($product) }})" 
                                    class="flex items-center gap-1 bg-gray-700/50 hover:bg-blue-500/20 hover:text-blue-400 
                                           text-gray-300 px-3 py-1.5 rounded-lg text-xs font-medium transition 
                                           border border-transparent hover:border-blue-500/30">
                                Edit
                            </button>
                            
                            <!-- Hapus -->
                            <form action="{{ route('merchant.product.delete', $product->id) }}" 
                                  method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" 
                                    class="flex items-center gap-1 bg-gray-700/50 hover:bg-red-500/20 hover:text-red-400 
                                           text-gray-300 px-3 py-1.5 rounded-lg text-xs font-medium transition 
                                           border border-transparent hover:border-red-500/30">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach

        @else
            <!-- State Kosong -->
            <div class="col-span-2 md:col-span-1 text-center py-12 bg-[#151F32] rounded-2xl border border-dashed border-gray-700">
                <div class="text-5xl mb-4 opacity-50 grayscale">🍲</div>
                <h3 class="text-gray-300 font-bold mb-1">Belum ada menu</h3>
                <p class="text-gray-500 text-sm mb-4">Tambahkan menu pertamamu sekarang!</p>
                <button @click="openModal('create')" class="text-brand-green text-sm hover:underline">
                    + Tambah Menu
                </button>
            </div>
        @endif

        </div> <!-- end grid -->
    </div>

</div>

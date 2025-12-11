<div x-show="showProfileModal" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak>
    <!-- Backdrop Blur -->
    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" 
         x-show="showProfileModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="showProfileModal = false"></div>

    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="glass-panel w-full max-w-2xl rounded-3xl shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]"
             x-show="showProfileModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-10"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-10">
            
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b border-gray-700 bg-black/20">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <span>👤</span> Profil Driver
                </h3>
                <button @click="showProfileModal = false" class="text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 p-2 rounded-full transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <!-- Scrollable Body -->
            <div class="p-8 overflow-y-auto custom-scrollbar">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf @method('PUT')

                    <!-- Foto Profil Center -->
                    <div class="text-center">
                        <div class="relative w-32 h-32 mx-auto rounded-full overflow-hidden group cursor-pointer border-4 border-gray-700 hover:border-brand-green transition-all shadow-xl bg-[#0B1120]">
                            <input type="file" name="profile_picture" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewDriverProfile(this)">
                            
                            <!-- Overlay Hover -->
                            <div class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition z-10">
                                <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-xs font-bold uppercase">Ganti Foto</span>
                            </div>

                            <img id="driver-profile-pic-preview" 
                                 src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=00E073&color=000&size=200' }}" 
                                 class="absolute inset-0 w-full h-full object-cover transition transform group-hover:scale-110">
                        </div>
                        <p class="text-gray-500 text-xs mt-3">Klik foto untuk mengganti</p>
                    </div>
                    
                    <!-- Form Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1">
                            <label class="text-gray-400 text-xs font-bold uppercase ml-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full bg-black/30 border border-gray-600 rounded-xl p-3 text-white focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition">
                        </div>
                        <div class="space-y-1">
                            <label class="text-gray-400 text-xs font-bold uppercase ml-1">No. WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                                class="w-full bg-black/30 border border-gray-600 rounded-xl p-3 text-white focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition">
                        </div>
                        <div class="space-y-1">
                            <label class="text-brand-green text-xs font-bold uppercase ml-1">Plat Nomor Kendaraan</label>
                            <input type="text" name="vehicle_plate" value="{{ old('vehicle_plate', $user->vehicle_plate) }}" required
                                class="w-full bg-black/30 border border-brand-green/50 rounded-xl p-3 text-white focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition font-mono tracking-wider">
                        </div>
                        <div class="space-y-1">
                            <label class="text-gray-400 text-xs font-bold uppercase ml-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full bg-black/30 border border-gray-600 rounded-xl p-3 text-white focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-gray-400 text-xs font-bold uppercase ml-1">Alamat Domisili</label>
                        <textarea name="address" rows="2" 
                            class="w-full bg-black/30 border border-gray-600 rounded-xl p-3 text-white focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition resize-none">{{ old('address', $user->address) }}</textarea>
                    </div>
                    
                    <div class="p-4 bg-yellow-500/10 rounded-xl border border-yellow-500/20">
                        <label class="text-yellow-500 text-xs font-bold uppercase mb-2 block">Ganti Password (Opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti" 
                            class="w-full bg-black/30 border border-gray-600 rounded-xl p-3 text-white focus:outline-none focus:border-yellow-500 transition text-sm">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-brand-green hover:bg-green-400 text-black font-bold py-4 rounded-xl shadow-lg transition transform hover:scale-[1.01] active:scale-95">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

                <form action="{{ route('logout') }}" method="POST" class="mt-6 pt-6 border-t border-gray-700 text-center">
                    @csrf
                    <button type="submit" class="text-red-400 hover:text-white text-sm font-bold hover:bg-red-500/20 px-6 py-2 rounded-lg transition">
                        Keluar Aplikasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
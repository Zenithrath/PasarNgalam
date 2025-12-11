<nav class="glass-panel sticky top-0 z-40 border-b-0 border-b-white/5 backdrop-blur-xl">
    <div class="max-w-3xl mx-auto px-4 py-4 flex justify-between items-center">
        
        <!-- Kiri: Hamburger & Profil -->
        <div class="flex items-center gap-3">
            <!-- Hamburger Button -->
            <button @click="sidebarOpen = true" class="bg-gray-800/80 p-2.5 rounded-xl text-gray-400 hover:text-brand-green hover:bg-gray-700 transition border border-gray-700">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
            </button>

            <!-- Profil Singkat -->
            <div @click="showProfileModal = true" class="cursor-pointer group flex items-center gap-3">
                <!-- Avatar Kecil -->
                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=00E073&color=000&size=100' }}" 
                     class="w-9 h-9 rounded-full object-cover border border-gray-600 group-hover:border-brand-green transition">
                
                <div class="hidden sm:block">
                    <h1 class="text-sm font-bold text-white leading-tight group-hover:text-brand-green transition">
                        Halo, {{ explode(' ', $user->name)[0] }}
                    </h1>
                    <div class="flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full" :class="isOnline ? 'bg-brand-green animate-pulse' : 'bg-red-500'"></span>
                        <p class="text-[10px] text-gray-400 font-medium">{{ $user->vehicle_plate ?? 'Tanpa Plat' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Kanan: Switch Online -->
        <div class="flex items-center gap-3 bg-black/20 p-1.5 pr-2 rounded-full border border-white/5">
            <button @click="toggleStatus()" 
                class="w-12 h-7 rounded-full p-1 transition-colors duration-300 focus:outline-none relative"
                :class="isOnline ? 'bg-brand-green shadow-[0_0_10px_rgba(0,224,115,0.4)]' : 'bg-gray-700'">
                <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-300 flex items-center justify-center"
                     :class="isOnline ? 'translate-x-5' : 'translate-x-0'">
                     <svg x-show="isOnline" class="w-3 h-3 text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
            </button>
            <span class="text-xs font-bold w-8 text-center" :class="isOnline ? 'text-brand-green' : 'text-gray-500'" x-text="isOnline ? 'ON' : 'OFF'"></span>
        </div>
    </div>
</nav>
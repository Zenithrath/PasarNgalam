<!-- Backdrop -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity 
     class="fixed inset-0 bg-black/80 z-[60] backdrop-blur-sm"></div>

<!-- Sidebar Panel -->
<aside class="fixed top-0 left-0 h-full w-72 bg-[#0B1120] border-r border-gray-800 z-[70] transform transition-transform duration-300 ease-in-out shadow-2xl"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    
    <!-- Header Sidebar -->
    <div class="p-6 border-b border-gray-800 flex items-center justify-between">
        <h2 class="text-xl font-bold text-brand-green flex items-center gap-2">
            <span class="text-2xl">⚡</span> PasarNgalam
        </h2>
        <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Menu Items -->
    <div class="p-4 space-y-2">
        <button @click="currentTab = 'dashboard'; sidebarOpen = false" 
                class="w-full flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200"
                :class="currentTab === 'dashboard' ? 'bg-brand-green text-black font-bold shadow-[0_0_15px_rgba(0,224,115,0.3)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white'">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            Dashboard
        </button>

        <button @click="currentTab = 'history'; sidebarOpen = false" 
                class="w-full flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200"
                :class="currentTab === 'history' ? 'bg-brand-green text-black font-bold shadow-[0_0_15px_rgba(0,224,115,0.3)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white'">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Riwayat Order
        </button>

        <button @click="currentTab = 'earnings'; sidebarOpen = false" 
                class="w-full flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200"
                :class="currentTab === 'earnings' ? 'bg-brand-green text-black font-bold shadow-[0_0_15px_rgba(0,224,115,0.3)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white'">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Pendapatan
        </button>
    </div>

    <!-- Footer Sidebar -->
    <div class="absolute bottom-0 w-full p-4 border-t border-gray-800">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>
<nav class="glass-panel fixed w-full z-50 top-0 transition-all border-b-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- BAGIAN KIRI: LOGO -->
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="bg-white p-1 rounded-full shadow-[0_0_15px_rgba(0,224,115,0.4)] h-10 w-10 md:h-12 md:w-12 flex items-center justify-center border-2 border-brand-green/50 overflow-hidden">
                        <img src="{{ asset('logo.jpg') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">PasarNgalam</span>
                </a>
            </div>

            <!-- BAGIAN TENGAH: Menu Desktop -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="#" class="text-white hover:text-brand-green font-medium transition">Beranda</a>
                <a href="#" class="text-gray-300 hover:text-brand-green font-medium transition">Promo</a>
            </div>

            <!-- BAGIAN KANAN: Cart & User Actions -->
            <div class="flex items-center gap-4">
                
                <!-- CART BUTTON -->
                <button @click="openCart()" class="relative bg-gray-800 p-2.5 rounded-xl hover:bg-gray-700 transition border border-gray-600 group">
                    <svg class="w-6 h-6 text-gray-300 group-hover:text-brand-green transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <div x-show="cartCount > 0" x-transition.scale class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-[#0F172A] cart-badge" x-text="cartCount"></div>
                </button>

                <!-- DESKTOP ONLY: User Profile -->
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        @if(Auth::user()->role == 'merchant')
                        <a href="{{ route('merchant.dashboard') }}" class="text-brand-green font-bold border border-brand-green/30 px-4 py-1.5 rounded-full hover:bg-brand-green hover:text-black transition">Dashboard Warung</a>
                        @elseif(Auth::user()->role == 'driver')
                        <a href="{{ route('driver.dashboard') }}" class="text-brand-green font-bold border border-brand-green/30 px-4 py-1.5 rounded-full hover:bg-brand-green hover:text-black transition">Panel Driver</a>
                        @endif

                        @php
                        $activeOrder = \App\Models\Order::where('customer_id', Auth::id())
                        ->where('status', '!=', 'completed')
                        ->latest()->first();
                        @endphp

                        @if($activeOrder)
                        <a href="{{ route('order.track', $activeOrder->id) }}" class="bg-blue-600/20 text-blue-400 hover:text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 border border-blue-600/30 animate-pulse">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Lacak
                        </a>
                        @endif

                        <div class="text-right">
                            <p class="text-xs text-gray-400">Halo,</p>
                            <p class="text-sm font-bold text-white">{{ Auth::user()->name }}</p>
                        </div>
                        
                        <a href="{{ route('profile.show') }}" class="bg-gray-700 hover:bg-gray-600 text-white p-2.5 rounded-xl transition border border-gray-600" title="Profil">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-500/20 hover:bg-red-600 text-red-400 hover:text-white p-2.5 rounded-xl transition">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-brand-green font-bold border border-brand-green/30 px-4 py-1.5 rounded-full hover:bg-brand-green hover:text-black transition shadow-[0_0_10px_rgba(0,224,115,0.2)]">Gabung Mitra</a>
                        <a href="{{ route('login') }}" class="bg-brand-card hover:bg-gray-700 text-white border border-gray-600 px-5 py-2.5 rounded-xl font-bold text-sm transition">Masuk</a>
                    @endauth
                </div>

                <!-- MOBILE HAMBURGER BUTTON -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden bg-gray-800 p-2.5 rounded-xl hover:bg-gray-700 transition border border-gray-600 text-gray-300">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE MENU DROPDOWN -->
    <div x-show="mobileMenuOpen" x-collapse x-cloak class="md:hidden bg-[#0F172A] border-t border-gray-800 absolute w-full left-0 z-40 shadow-2xl">
        <div class="px-4 py-6 space-y-4">
            <a href="#" class="block text-white hover:text-brand-green font-medium py-2 border-b border-gray-800">Beranda</a>
            <a href="#" class="block text-gray-300 hover:text-brand-green font-medium py-2 border-b border-gray-800">Promo</a>

            <div class="pt-2">
                @auth
                    <div class="flex items-center gap-3 mb-4 bg-gray-800/50 p-3 rounded-xl border border-gray-700">
                        <div class="bg-gray-700 p-2 rounded-full">
                            <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Login sebagai,</p>
                            <p class="text-sm font-bold text-white">{{ Auth::user()->name }}</p>
                        </div>
                    </div>

                    @if(Auth::user()->role == 'merchant')
                    <a href="{{ route('merchant.dashboard') }}" class="block text-center w-full mb-3 bg-gray-800 text-brand-green font-bold border border-brand-green/30 px-4 py-2 rounded-xl">Dashboard Warung</a>
                    @elseif(Auth::user()->role == 'driver')
                    <a href="{{ route('driver.dashboard') }}" class="block text-center w-full mb-3 bg-gray-800 text-brand-green font-bold border border-brand-green/30 px-4 py-2 rounded-xl">Panel Driver</a>
                    @endif
                    
                    @php
                    $activeOrderMobile = \App\Models\Order::where('customer_id', Auth::id())
                    ->where('status', '!=', 'completed')
                    ->latest()->first();
                    @endphp
                    @if($activeOrderMobile)
                    <a href="{{ route('order.track', $activeOrderMobile->id) }}" class="flex items-center justify-center gap-2 w-full mb-3 bg-blue-600/20 text-blue-400 border border-blue-600/30 px-4 py-2 rounded-xl font-bold animate-pulse">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Lacak Pesanan
                    </a>
                    @endif

                    <a href="{{ route('profile.show') }}" class="block text-gray-300 hover:text-white py-2">Edit Profil</a>
                    
                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-400 hover:text-red-300 font-medium py-2">Keluar Aplikasi</button>
                    </form>
                @else
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <a href="{{ route('login') }}" class="text-center text-brand-green font-bold border border-brand-green/30 px-4 py-2.5 rounded-xl hover:bg-brand-green/10 transition">Gabung Mitra</a>
                        <a href="{{ route('login') }}" class="text-center bg-brand-green text-black font-bold px-4 py-2.5 rounded-xl hover:bg-green-400 transition shadow-[0_0_15px_rgba(0,224,115,0.3)]">Masuk</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
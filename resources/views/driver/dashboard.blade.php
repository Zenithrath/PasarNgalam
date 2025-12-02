<!-- File: resources/views/driver/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Panel - PasarNgalam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#2ECC71'
                        , 'brand-dark': '#1F2937'
                        , 'brand-bg': '#111827'
                    , }
                    , fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

    </style>
</head>
<!-- 
    Logic AlpineJS: 
    Jika ada activeOrder (sedang mengantar), tab otomatis pindah ke 'active'.
    Jika tidak, default ke 'jobs'.
-->
<body class="bg-brand-bg text-gray-100 min-h-screen pb-24" x-data="{ activeTab: '{{ $activeOrder ? 'active' : 'jobs' }}', showProfileModal: false }">

    <!-- NOTIFIKASI SUKSES (Flash Message) -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 right-4 z-50 bg-brand-green text-brand-bg px-6 py-3 rounded-lg font-bold shadow-lg transform transition-all duration-500">
        ✅ {{ session('success') }}
    </div>
    @endif

    <!-- NAVBAR DRIVER -->
    <nav class="bg-brand-dark border-b border-gray-700 sticky top-0 z-40 shadow-md">
        <div class="max-w-3xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <!-- Tombol Balik ke Home (BARU) -->
                <a href="{{ url('/') }}" class="bg-gray-800 p-2 rounded-lg text-gray-400 hover:text-white hover:bg-gray-700 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>

                <div class="bg-brand-green/20 p-2 rounded-lg">
                    <svg class="h-6 w-6 text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div @click="showProfileModal = true" class="cursor-pointer hover:opacity-80">
                    <h1 class="text-lg font-bold text-white leading-tight">Halo, {{ explode(' ', $user->name)[0] }}!</h1>
                    <span class="flex items-center gap-1 text-xs text-brand-green font-medium">
                        <span class="w-2 h-2 bg-brand-green rounded-full animate-pulse"></span> Online
                    </span>
                </div>
            </div>
            
            <!-- Foto Profil -->
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2ECC71&color=fff" class="h-10 w-10 rounded-full border-2 border-brand-dark ring-2 ring-brand-green/50">
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 mt-6">

        <!-- STATISTIK (DUMMY - Nanti bisa diupdate pakai query sum) -->
        <div class="grid grid-cols-2 gap-3 mb-6">
            <div class="bg-brand-dark border border-gray-700 p-4 rounded-xl shadow-lg">
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Dompet</p>
                <p class="text-xl font-bold text-brand-green">Rp 0</p>
            </div>
            <div class="bg-brand-dark border border-gray-700 p-4 rounded-xl shadow-lg">
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Total Order</p>
                <p class="text-xl font-bold text-white">0</p>
            </div>
        </div>

        <!-- TAB SWITCHER -->
        <div class="bg-gray-800 p-1 rounded-xl flex mb-6 border border-gray-700 sticky top-20 z-30 shadow-xl">
            <button @click="activeTab = 'jobs'" :class="activeTab === 'jobs' ? 'bg-brand-green text-white shadow-md' : 'text-gray-400 hover:text-white'" class="flex-1 py-2.5 rounded-lg text-sm font-bold transition-all duration-200">
                Order Masuk ({{ $availableOrders->count() }})
            </button>
            <button @click="activeTab = 'active'" :class="activeTab === 'active' ? 'bg-brand-green text-white shadow-md' : 'text-gray-400 hover:text-white'" class="flex-1 py-2.5 rounded-lg text-sm font-bold transition-all duration-200">
                Sedang Jalan
            </button>
        </div>

        <!-- KONTEN: TAB ORDER MASUK -->
        <div x-show="activeTab === 'jobs'" x-transition.opacity.duration.300ms class="space-y-4">

            @forelse($availableOrders as $order)
            <div class="bg-brand-dark border border-gray-700 rounded-2xl p-5 relative overflow-hidden shadow-lg group hover:border-brand-green/50 transition-colors">
                <!-- Ongkir Badge -->
                <div class="absolute top-0 right-0 bg-brand-green text-brand-bg text-xs font-bold px-3 py-1.5 rounded-bl-xl shadow-sm">
                    Ongkir Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}
                </div>

                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center shrink-0 border border-gray-600">
                        <span class="text-2xl">🍜</span>
                    </div>
                    <div class="flex-1">
                        <!-- Nama Warung -->
                        <h3 class="font-bold text-lg text-white group-hover:text-brand-green transition-colors">
                            {{ $order->merchant->store_name ?? 'Warung UMKM' }}
                        </h3>

                        <!-- Alamat Tujuan -->
                        <div class="flex items-start gap-2 mt-2 mb-4">
                            <svg class="w-4 h-4 text-gray-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <p class="text-gray-400 text-sm leading-tight">{{ $order->delivery_address }}</p>
                        </div>

                        <!-- Form Ambil Order -->
                        <form action="{{ route('driver.order.take', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-brand-green hover:bg-green-600 text-brand-bg font-bold py-3 rounded-xl transition-transform active:scale-95 shadow-lg shadow-brand-green/20">
                                Ambil Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <div class="bg-gray-800/50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">😴</span>
                </div>
                <h3 class="text-lg font-bold text-gray-300">Belum ada orderan</h3>
                <p class="text-gray-500 text-sm">Istirahat dulu sambil nunggu notifikasi.</p>
            </div>
            @endforelse

        </div>

        <!-- KONTEN: TAB SEDANG JALAN -->
        <div x-show="activeTab === 'active'" x-transition.opacity.duration.300ms class="space-y-6">

            @if($activeOrder)
            <div class="bg-brand-dark border border-brand-green/40 rounded-2xl p-6 shadow-[0_0_20px_rgba(46,204,113,0.1)]">

                <!-- Header Card -->
                <div class="flex justify-between items-start mb-6 border-b border-gray-700 pb-4">
                    <div>
                        <span class="text-xs text-brand-green font-bold tracking-wide uppercase bg-brand-green/10 px-2 py-1 rounded">Dalam Proses</span>
                        <h2 class="text-xl font-bold text-white mt-2">{{ $activeOrder->merchant->store_name }}</h2>
                    </div>
                    <!-- Tombol WA Merchant -->
                    <div class="text-right">
                        <a href="https://wa.me/{{ $activeOrder->merchant->phone ?? '' }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg inline-flex items-center justify-center transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" /></svg>
                        </a>
                    </div>
                </div>

                <!-- Timeline Driver -->
                <div class="relative pl-6 border-l-2 border-gray-600 space-y-8 ml-2">

                    <!-- STEP 1: PICKUP -->
                    <div class="relative">
                        <div class="absolute -left-[31px] bg-brand-dark p-1">
                            <div class="w-6 h-6 rounded-full bg-gray-700 text-gray-400 border border-gray-500 flex items-center justify-center font-bold text-xs">1</div>
                        </div>
                        <div>
                            <h4 class="text-white font-bold">Ambil Pesanan</h4>
                            <p class="text-sm text-gray-400">Warung: {{ $activeOrder->merchant->store_name }}</p>
                            <p class="text-xs text-gray-500">Total Harga Barang: Rp {{ number_format($activeOrder->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- STEP 2: DELIVERY -->
                    <div class="relative">
                        <div class="absolute -left-[31px] bg-brand-dark p-1">
                            <!-- Icon Aktif -->
                            <div class="w-6 h-6 rounded-full bg-brand-green text-brand-bg flex items-center justify-center font-bold text-xs animate-bounce">2</div>
                        </div>
                        <div>
                            <h4 class="text-white font-bold">Antar ke Pelanggan</h4>
                            <p class="text-sm text-gray-300">{{ $activeOrder->delivery_address }}</p>

                            <!-- Buka Maps -->
                            <div class="mt-4">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($activeOrder->delivery_address) }}" target="_blank" class="block text-center w-full mb-3 text-brand-green border border-brand-green/30 hover:bg-brand-green/10 py-2 rounded-lg text-sm font-medium transition">
                                    Buka Google Maps 🗺️
                                </a>

                                <!-- Tombol Selesai -->
                                <form action="{{ route('driver.order.complete', $activeOrder->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Yakin pesanan sudah sampai?')" class="w-full bg-brand-green hover:bg-green-600 text-brand-bg font-bold py-3 rounded-xl shadow-lg shadow-brand-green/20">
                                        Selesaikan Pesanan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @else
            <!-- Tampilan jika tidak ada order aktif -->
            <div class="text-center py-12">
                <div class="bg-gray-800/50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">🛵</span>
                </div>
                <h3 class="text-lg font-bold text-gray-300">Siap Mengantar?</h3>
                <p class="text-gray-500 text-sm">Pindah ke tab "Order Masuk" untuk mengambil pekerjaan.</p>
                <button @click="activeTab = 'jobs'" class="mt-4 text-brand-green font-bold text-sm hover:underline">Cari Orderan &rarr;</button>
            </div>
            @endif

        </div>

    </div>

    <!-- MOBILE BOTTOM NAV -->
    <!-- MOBILE BOTTOM NAV -->
    <div class="fixed bottom-0 w-full bg-brand-dark border-t border-gray-700 py-3 px-8 flex justify-between md:hidden z-50">

        <button @click="activeTab = 'jobs'" :class="activeTab === 'jobs' ? 'text-brand-green' : 'text-gray-500'" class="flex flex-col items-center gap-1 transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            <span class="text-[10px] font-medium">Order</span>
        </button>

        <button @click="activeTab = 'active'" :class="activeTab === 'active' ? 'text-brand-green' : 'text-gray-500'" class="flex flex-col items-center gap-1 relative transition-colors">
            @if($activeOrder)
            <span class="absolute top-0 right-2 w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
            <span class="absolute top-0 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
            @endif
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            <span class="text-[10px] font-medium">Jalan</span>
        </button>

        <!-- TOMBOL LOGOUT (ICON PINTU) -->
        <form action="{{ route('logout') }}" method="POST" class="flex flex-col items-center">
            @csrf
            <button type="submit" class="flex flex-col items-center gap-1 text-gray-500 hover:text-red-500 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="text-[10px] font-medium">Keluar</span>
            </button>
        </form>

    </div>

    <!-- MODAL EDIT PROFIL DRIVER -->
<div x-show="showProfileModal" class="fixed inset-0 z-[60] overflow-y-auto" x-cloak>
    <div class="fixed inset-0 bg-black/90 backdrop-blur-sm" @click="showProfileModal = false"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-brand-dark border border-gray-700 rounded-3xl w-full max-w-md p-8 shadow-2xl">
            <h3 class="text-2xl font-bold text-white mb-6">Edit Profil Driver</h3>
            
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                
                <div>
                    <label class="block text-gray-400 text-xs font-bold mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:border-brand-green">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-brand-green text-xs font-bold mb-1">Plat Nomor</label>
                        <input type="text" name="vehicle_plate" value="{{ $user->vehicle_plate }}" class="w-full bg-gray-800 border border-brand-green/50 rounded-lg p-3 text-white focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-400 text-xs font-bold mb-1">No. HP</label>
                        <input type="text" name="phone" value="{{ $user->phone }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none">
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-400 text-xs font-bold mb-1">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none">
                </div>

                <div class="pt-2 border-t border-gray-700">
                     <label class="block text-gray-400 text-xs font-bold mb-1">Password Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Isi untuk ganti" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none">
                </div>

                <button type="submit" class="w-full bg-brand-green hover:bg-green-600 text-black font-bold py-3 rounded-xl shadow-lg mt-2">Simpan Profil</button>
                <button type="button" @click="showProfileModal = false" class="w-full text-gray-500 py-2 text-sm hover:text-white">Batal</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PasarNgalam - Kuliner Terbaik Malang</title>
    
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#00E073',
                        'brand-dark': '#0F172A',
                        'brand-card': '#1E293B',
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-panel {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-brand-dark text-white min-h-screen relative selection:bg-brand-green selection:text-black"
      x-data="{
          showModal: false,
          
          // Data Makanan yang sedang dipilih
          selectedFood: {
              name: '',
              category: '',
              price: 0,
              img: '',
              addons: []
          },

          // State Pembelian
          qty: 1,
          selectedAddons: [],
          note: '',

          // Helper Format Rupiah
          formatRupiah(number) {
              return new Intl.NumberFormat('id-ID').format(number);
          },

          // Hitung Total Harga
          get totalPrice() {
              let addonTotal = this.selectedAddons.reduce((sum, item) => sum + item.price, 0);
              return (this.selectedFood.price + addonTotal) * this.qty;
          },

          // Fungsi Buka Modal
          openModal(food) {
              this.selectedFood = {
                  name: food.name,
                  category: food.category,
                  price: food.price_int,
                  img: food.img,
                  // Simulasi Add-ons (Hardcode sementara)
                  addons: [
                      { name: 'Extra Sambal', price: 3000 },
                      { name: 'Nasi Tambah', price: 5000 },
                      { name: 'Kerupuk', price: 2000 },
                      { name: 'Level Pedas: Neraka', price: 0 }
                  ]
              };
              this.qty = 1;
              this.selectedAddons = [];
              this.note = '';
              this.showModal = true;
          },

          // Logic Checkbox Addon
          toggleAddon(addon) {
              const index = this.selectedAddons.findIndex(a => a.name === addon.name);
              if (index === -1) {
                  this.selectedAddons.push(addon);
              } else {
                  this.selectedAddons.splice(index, 1);
              }
          }
      }">

    <!-- BACKGROUND DECORATION -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-brand-green/5 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-[120px]"></div>
    </div>

    {{-- DATA DUMMY PHP --}}
    @php
        $foods = [
            ['name' => 'Warung Bu Kris', 'category' => 'Masakan Jawa, Penyet', 'rating' => '4.8', 'time' => '25-35 min', 'dist' => '1.2 km', 'promo' => 'Diskon 20%', 'price_int' => 35000, 'img' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&fit=crop'],
            ['name' => 'Bakso President', 'category' => 'Bakso, Mie Ayam', 'rating' => '4.9', 'time' => '20-30 min', 'dist' => '0.8 km', 'promo' => 'Gratis Ongkir', 'price_int' => 20000, 'img' => 'https://images.unsplash.com/photo-1617384750865-c323f4f722a9?w=600&fit=crop'],
            ['name' => 'Sate Kelinci Pak Sadi', 'category' => 'Sate, Bakaran', 'rating' => '4.7', 'time' => '30-40 min', 'dist' => '2.1 km', 'promo' => null, 'price_int' => 25000, 'img' => 'https://images.unsplash.com/photo-1529563021427-d8f8bad9d71c?w=600&fit=crop'],
            ['name' => 'Kopi Tuku Ijen', 'category' => 'Minuman, Kopi', 'rating' => '4.5', 'time' => '10-20 min', 'dist' => '0.5 km', 'promo' => 'Beli 2 Gratis 1', 'price_int' => 18000, 'img' => 'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=600&fit=crop'],
            ['name' => 'Depot Kare Nona', 'category' => 'Kare, Masakan Padang', 'rating' => '4.6', 'time' => '25-45 min', 'dist' => '3.2 km', 'promo' => 'Diskon 50%', 'price_int' => 40000, 'img' => 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=600&fit=crop'],
            ['name' => 'Mie Gacoan', 'category' => 'Mie Pedas, Dimsum', 'rating' => '4.8', 'time' => '40-50 min', 'dist' => '1.5 km', 'promo' => 'Diskon 10%', 'price_int' => 12000, 'img' => 'https://images.unsplash.com/photo-1552611052-33e04de081de?w=600&fit=crop'],
        ];
    @endphp

    <!-- NAVBAR -->
    <nav class="glass-panel fixed w-full z-50 top-0 transition-all border-b-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="bg-brand-green p-2 rounded-xl shadow-[0_0_15px_rgba(0,224,115,0.4)]">
                        <svg class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">PasarNgalam</span>
                </div>
                <!-- Menu Desktop -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#" class="text-white hover:text-brand-green font-medium transition">Beranda</a>
                    <a href="#" class="text-gray-300 hover:text-brand-green font-medium transition">Promo</a>
                    <a href="{{ url('/mitra-login') }}" class="text-brand-green font-bold border border-brand-green/30 px-4 py-1.5 rounded-full hover:bg-brand-green hover:text-black transition shadow-[0_0_10px_rgba(0,224,115,0.2)]">
                        Buka Warung
                    </a>
                </div>
                <!-- Tombol Masuk -->
                <a href="{{ route('login') }}" class="bg-brand-card hover:bg-gray-700 text-white border border-gray-600 px-6 py-2.5 rounded-xl font-bold text-sm transition">
    Masuk</a>
</div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <div class="relative h-[550px] w-full flex items-center justify-center mt-20">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=1920&fit=crop" alt="Malang Night Market" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-brand-dark/80 to-brand-dark/40"></div>
        </div>
        <div class="relative z-10 text-center px-4 w-full max-w-4xl">
            <h1 class="text-5xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-brand-green to-teal-400 mb-6 drop-shadow-2xl">
                Kuliner Ngalam
            </h1>
            <p class="text-xl text-gray-200 mb-10 font-light max-w-2xl mx-auto">
                Temukan cita rasa legendaris dan dukung UMKM lokal langsung dari smartphone Anda.
            </p>
            <div class="relative max-w-xl mx-auto group">
                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                    <svg class="h-6 w-6 text-gray-400 group-focus-within:text-brand-green transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" class="block w-full pl-14 pr-24 py-5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-green focus:border-transparent shadow-2xl transition" placeholder="Mau makan apa ker?">
                <button class="absolute right-2 top-2 bottom-2 bg-brand-green hover:bg-green-400 text-black px-8 rounded-full font-bold transition shadow-[0_0_15px_rgba(0,224,115,0.4)]">Cari</button>
            </div>
        </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-20">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-1.5 h-8 bg-brand-green rounded-full"></div>
            <h2 class="text-3xl font-bold text-white">Rekomendasi Pilihan</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($foods as $food)
            <div @click="openModal({{ json_encode($food) }})" class="glass-panel rounded-3xl overflow-hidden hover:border-brand-green/50 transition duration-300 group cursor-pointer relative">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ $food['img'] }}" alt="{{ $food['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-card to-transparent opacity-60"></div>
                    
                    @if($food['promo'])
                        <div class="absolute top-4 right-4 bg-brand-green text-black text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                            {{ $food['promo'] }}
                        </div>
                    @endif
                    
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-black/50 backdrop-blur-md text-white text-xs px-2 py-1 rounded-lg border border-white/10">
                            {{ $food['time'] }} • {{ $food['dist'] }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-white truncate group-hover:text-brand-green transition">{{ $food['name'] }}</h3>
                        <div class="flex items-center gap-1 bg-yellow-500/10 px-2 py-1 rounded-lg border border-yellow-500/20">
                            <svg class="w-4 h-4 text-yellow-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="font-bold text-yellow-500 text-sm">{{ $food['rating'] }}</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mb-4 truncate">{{ $food['category'] }}</p>
                    <div class="flex items-center justify-between pt-4 border-t border-white/5">
                        <span class="text-gray-300 text-sm">Mulai dari</span>
                        <span class="text-brand-green font-bold text-lg">Rp {{ number_format($food['price_int'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- SECTION: AJAKAN GABUNG MITRA -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 mt-20">
        <div class="relative rounded-[2.5rem] overflow-hidden bg-gradient-to-br from-brand-card to-gray-900 border border-white/5 shadow-2xl">
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-green/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between p-10 md:p-16 gap-10">
                <div class="max-w-2xl">
                    <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6 leading-tight">
                        Punya Usaha Kuliner? <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-green to-teal-400">Gabung PasarNgalam!</span>
                    </h2>
                    <p class="text-gray-300 text-lg mb-8">Jangkau ribuan pelanggan baru dan kelola warungmu dengan dashboard canggih. Tanpa biaya pendaftaran.</p>
                    <div class="flex flex-wrap gap-6">
                        <div class="flex items-center gap-3 text-gray-300 bg-white/5 px-4 py-2 rounded-full border border-white/10">
                            <div class="bg-brand-green/20 p-1 rounded-full"><svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                            <span>Gratis Daftar</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-300 bg-white/5 px-4 py-2 rounded-full border border-white/10">
                            <div class="bg-brand-green/20 p-1 rounded-full"><svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                            <span>Pencairan Harian</span>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ url('/mitra-login') }}" class="group relative inline-flex items-center justify-center px-10 py-5 font-bold text-black transition-all duration-200 bg-brand-green font-pj rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-green hover:scale-105 shadow-[0_0_30px_rgba(0,224,115,0.3)]">
                        Buka Warung Sekarang
                        <svg class="w-5 h-5 ml-2 -mr-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- INCLUDE MODAL (FILE TERPISAH) -->
    @include('partials.user-modal')

</body>
</html>
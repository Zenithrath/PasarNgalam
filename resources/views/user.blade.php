<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PasarNgalam - Kuliner Terbaik Malang</title>
    
    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
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
        .cart-badge { animation: bounce 0.5s; }
        @keyframes bounce { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.2); } }
    </style>
</head>
<body class="bg-brand-dark text-white min-h-screen relative selection:bg-brand-green selection:text-black"
      x-data="{
          showModal: false,
          modalView: 'merchant_detail', // 'merchant_detail', 'menu_customization', 'cart_detail'
          
          selectedMerchant: {}, 
          selectedMenu: {},

          // CART STATE (KERANJANG)
          cart: [],
          
          // Form State
          qty: 1,
          selectedAddons: [],
          note: '',

          // Format Rupiah
          formatRupiah(number) {
              return new Intl.NumberFormat('id-ID').format(number);
          },

          // Hitung Harga Item saat Kustomisasi
          get currentItemTotal() {
              if(!this.selectedMenu.price) return 0;
              let addonTotal = this.selectedAddons.reduce((sum, item) => sum + item.price, 0);
              return (this.selectedMenu.price + addonTotal) * this.qty;
          },

          // Hitung Total Semua Keranjang
          get grandTotal() {
              return this.cart.reduce((sum, item) => sum + item.total, 0);
          },

          // Hitung Jumlah Item di Keranjang
          get cartCount() {
              return this.cart.reduce((sum, item) => sum + item.qty, 0);
          },

          // Aksi 1: Buka Toko
          openMerchantModal(merchant) {
              this.selectedMerchant = merchant;
              this.modalView = 'merchant_detail';
              this.showModal = true;
          },

          // Aksi 2: Pilih Menu
          openMenuCustomization(menu) {
              this.selectedMenu = {
                  ...menu,
                  addons_available: [
                      { name: 'Extra Sambal', price: 3000 },
                      { name: 'Nasi Tambah', price: 5000 },
                      { name: 'Kerupuk', price: 2000 },
                      { name: 'Level Pedas: Neraka', price: 0 }
                  ]
              };
              this.qty = 1;
              this.selectedAddons = [];
              this.note = '';
              this.modalView = 'menu_customization';
          },

          // Aksi 3: Masukkan ke Keranjang
          addToCart() {
              const item = {
                  id: Date.now(), // ID Unik
                  name: this.selectedMenu.name,
                  img: this.selectedMenu.img,
                  price: this.selectedMenu.price,
                  qty: this.qty,
                  addons: this.selectedAddons,
                  note: this.note,
                  total: this.currentItemTotal
              };
              this.cart.push(item);
              this.modalView = 'merchant_detail'; // Balik ke list menu
          },

          // Aksi 4: Buka Keranjang (Checkout)
          openCart() {
              if (this.cart.length === 0) {
                  alert('Keranjang masih kosong!');
                  return;
              }
              this.modalView = 'cart_detail';
              this.showModal = true;
          },

          // Aksi 5: Hapus Item
          removeFromCart(id) {
              this.cart = this.cart.filter(item => item.id !== id);
              if (this.cart.length === 0) {
                  this.modalView = 'merchant_detail';
              }
          },

          // Aksi 6: Proses Checkout (Simulasi WA)
          processCheckout() {
              let message = 'Halo, saya mau pesan via PasarNgalam:%0A';
              this.cart.forEach(item => {
                  message += `- ${item.name} (${item.qty}x)`;
                  if(item.addons.length) message += ` + Addons`;
                  message += `%0A`;
              });
              message += `%0ATotal: Rp ${this.formatRupiah(this.grandTotal)}`;
              
              // Redirect ke WA (Simulasi)
              window.open(`https://wa.me/?text=${message}`, '_blank');
              
              // Reset
              this.cart = [];
              this.showModal = false;
              alert('Pesanan diteruskan ke WhatsApp Penjual!');
          },

          backToMerchant() { this.modalView = 'merchant_detail'; },
          toggleAddon(addon) {
              const index = this.selectedAddons.findIndex(a => a.name === addon.name);
              if (index === -1) this.selectedAddons.push(addon);
              else this.selectedAddons.splice(index, 1);
          }
      }">

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
                    <span class="text-xl font-bold text-white tracking-tight hidden md:block">PasarNgalam</span>
                </div>
                
                <!-- Menu Desktop -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#" class="text-white hover:text-brand-green font-medium transition">Beranda</a>
                    <a href="#" class="text-gray-300 hover:text-brand-green font-medium transition">Promo</a>
                    <a href="{{ url('/mitra-login') }}" class="text-brand-green font-bold border border-brand-green/30 px-4 py-1.5 rounded-full hover:bg-brand-green hover:text-black transition shadow-[0_0_10px_rgba(0,224,115,0.2)]">
                        Buka Warung
                    </a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    
                    <!-- TOMBOL KERANJANG (NAVBAR) -->
                    <button @click="openCart()" class="relative bg-gray-800 p-2.5 rounded-xl hover:bg-gray-700 transition border border-gray-600 group">
                        <svg class="w-6 h-6 text-gray-300 group-hover:text-brand-green transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <!-- Badge Counter -->
                        <div x-show="cartCount > 0" x-transition.scale class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-[#0F172A] cart-badge" x-text="cartCount"></div>
                    </button>

                    <!-- Tombol Masuk -->
                    <a href="{{ route('login') }}" class="bg-brand-card hover:bg-gray-700 text-white border border-gray-600 px-5 py-2.5 rounded-xl font-bold text-sm transition hidden sm:block">Masuk</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT DATA DUMMY -->
    @php
        $merchants = [
            [
                'name' => 'Warung Bu Kris',
                'category' => 'Masakan Jawa, Penyet',
                'rating' => '4.8',
                'time' => '25-35 min',
                'dist' => '1.2 km',
                'promo' => 'Diskon 20%',
                'img' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&fit=crop',
                'menus' => [
                    ['name' => 'Nasi Penyet Ayam', 'price' => 25000, 'desc' => 'Ayam goreng penyet sambal bawang + lalapan', 'img' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=400'],
                    ['name' => 'Empal Suwir', 'price' => 30000, 'desc' => 'Daging empal suwir manis gurih', 'img' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400'],
                    ['name' => 'Es Jeruk', 'price' => 8000, 'desc' => 'Jeruk peras murni', 'img' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?w=400'],
                ]
            ],
            [
                'name' => 'Bakso President',
                'category' => 'Bakso, Mie Ayam',
                'rating' => '4.9',
                'time' => '20-30 min',
                'dist' => '0.8 km',
                'promo' => 'Gratis Ongkir',
                'img' => 'https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba?w=600&fit=crop',
                'menus' => [
                    ['name' => 'Bakso Campur', 'price' => 20000, 'desc' => 'Pentol halus, kasar, goreng, tahu, siomay', 'img' => 'https://images.unsplash.com/photo-1617384750865-c323f4f722a9?w=400'],
                    ['name' => 'Mie Ayam Bakso', 'price' => 18000, 'desc' => 'Mie ayam jamur + 2 pentol kecil', 'img' => 'https://images.unsplash.com/photo-1585032226651-759b368d7246?w=400'],
                ]
            ],
            [
                'name' => 'Kopi Tuku Ijen',
                'category' => 'Minuman, Kopi',
                'rating' => '4.5',
                'time' => '10-20 min',
                'dist' => '0.5 km',
                'promo' => 'Beli 2 Gratis 1',
                'img' => 'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=600&fit=crop',
                'menus' => [
                    ['name' => 'Es Kopi Susu Tetangga', 'price' => 18000, 'desc' => 'Kopi susu gula aren signature', 'img' => 'https://images.unsplash.com/photo-1541167760496-1628856ab772?w=400'],
                    ['name' => 'Tahu Walik', 'price' => 12000, 'desc' => 'Cemilan tahu isi aci ayam', 'img' => 'https://images.unsplash.com/photo-1625488109605-728469e77995?w=400'],
                ]
            ],
        ];
    @endphp

    <!-- HERO SECTION -->
    <div class="relative h-[500px] w-full flex items-center justify-center mt-20">
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
            <div class="relative max-w-xl mx-auto">
                <input type="text" class="block w-full pl-8 pr-24 py-5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-green shadow-2xl transition" placeholder="Cari Toko atau Warung...">
                <button class="absolute right-2 top-2 bottom-2 bg-brand-green hover:bg-green-400 text-black px-8 rounded-full font-bold transition">Cari</button>
            </div>
        </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-20 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($merchants as $merchant)
            <div @click="openMerchantModal({{ json_encode($merchant) }})" class="glass-panel rounded-3xl overflow-hidden hover:border-brand-green/50 transition duration-300 group cursor-pointer relative">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $merchant['img'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition"></div>
                    @if($merchant['promo'])
                        <div class="absolute top-4 right-4 bg-brand-green text-black text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">{{ $merchant['promo'] }}</div>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-white truncate group-hover:text-brand-green transition">{{ $merchant['name'] }}</h3>
                        <div class="flex items-center gap-1 bg-yellow-500/10 px-2 py-1 rounded-lg border border-yellow-500/20">
                            <span class="font-bold text-yellow-500 text-sm">★ {{ $merchant['rating'] }}</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mb-4 truncate">{{ $merchant['category'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- INCLUDE MODAL -->
    @include('partials.user-modal')

</body>
</html>
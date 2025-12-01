<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - PasarNgalam</title>
    
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
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .form-input { 
            background-color: rgba(15, 23, 42, 0.6); 
            border: 1px solid rgba(71, 85, 105, 0.8); 
            color: white; 
            padding: 0.75rem; 
            border-radius: 0.75rem; 
            width: 100%; 
            transition: all 0.2s;
        }
        .form-input:focus { 
            outline: none; 
            border-color: #00E073; 
            box-shadow: 0 0 0 2px rgba(0, 224, 115, 0.2);
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-brand-dark text-white min-h-screen"
      x-data="{
          cart: [],
          paymentMethod: 'qris', // Default
          loading: false,
          showSuccess: false,

          // Load data dari LocalStorage saat halaman dibuka
          init() {
              const savedCart = localStorage.getItem('pasarNgalamCart');
              if (savedCart) {
                  this.cart = JSON.parse(savedCart);
              } else {
                  // Jika kosong, kembalikan ke home
                  window.location.href = '/';
              }
          },

          formatRupiah(number) {
              return new Intl.NumberFormat('id-ID').format(number);
          },

          get subtotal() {
              return this.cart.reduce((sum, item) => sum + item.total, 0);
          },
          
          get tax() {
              return this.subtotal * 0.11; // PPN 11%
          },

          get grandTotal() {
              return this.subtotal + this.tax + 5000; // + Ongkir Flat 5rb
          },

          processPayment() {
              this.loading = true;
              
              // Simulasi Loading Pembayaran
              setTimeout(() => {
                  this.loading = false;
                  this.showSuccess = true;
                  localStorage.removeItem('pasarNgalamCart'); // Bersihkan keranjang
              }, 2000);
          }
      }">

    <!-- NAVBAR -->
    <nav class="border-b border-gray-800 bg-[#0F172A] sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center gap-4">
            <a href="{{ url('/') }}" class="text-gray-400 hover:text-white flex items-center gap-2 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
            <div class="h-6 w-px bg-gray-700"></div>
            <span class="font-bold text-lg">Checkout Pesanan</span>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- LEFT COLUMN: FORM & PAYMENT -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- 1. Alamat Pengiriman -->
                <div class="glass-panel p-6 rounded-2xl">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <span class="bg-brand-green text-black w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">1</span>
                        Alamat Pengiriman
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nama Penerima</label>
                            <input type="text" class="form-input" placeholder="Contoh: Budi Santoso">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nomor WhatsApp</label>
                            <input type="tel" class="form-input" placeholder="0812...">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Alamat Lengkap</label>
                        <textarea rows="2" class="form-input" placeholder="Nama jalan, nomor rumah, patokan..."></textarea>
                    </div>
                </div>

                <!-- 2. Metode Pembayaran -->
                <div class="glass-panel p-6 rounded-2xl">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <span class="bg-brand-green text-black w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">2</span>
                        Pilih Pembayaran
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- QRIS -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="payment" value="qris" x-model="paymentMethod" class="peer sr-only">
                            <div class="p-4 rounded-xl border border-gray-600 bg-gray-800/50 hover:bg-gray-800 peer-checked:border-brand-green peer-checked:bg-brand-green/10 transition flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded flex items-center justify-center p-1">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/1200px-Logo_QRIS.svg.png" class="max-w-full max-h-full">
                                </div>
                                <div>
                                    <div class="font-bold text-white">QRIS</div>
                                    <div class="text-xs text-gray-400">Scan & Bayar Instan</div>
                                </div>
                                <div class="ml-auto w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-brand-green peer-checked:bg-brand-green"></div>
                            </div>
                        </label>

                        <!-- GOPAY -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="payment" value="gopay" x-model="paymentMethod" class="peer sr-only">
                            <div class="p-4 rounded-xl border border-gray-600 bg-gray-800/50 hover:bg-gray-800 peer-checked:border-brand-green peer-checked:bg-brand-green/10 transition flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded flex items-center justify-center p-1">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/2560px-Gopay_logo.svg.png" class="max-w-full max-h-full">
                                </div>
                                <div>
                                    <div class="font-bold text-white">GoPay</div>
                                    <div class="text-xs text-gray-400">Sambungkan Akun</div>
                                </div>
                                <div class="ml-auto w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-brand-green peer-checked:bg-brand-green"></div>
                            </div>
                        </label>

                        <!-- TRANSFER BANK -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="payment" value="bank" x-model="paymentMethod" class="peer sr-only">
                            <div class="p-4 rounded-xl border border-gray-600 bg-gray-800/50 hover:bg-gray-800 peer-checked:border-brand-green peer-checked:bg-brand-green/10 transition flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded flex items-center justify-center p-1">
                                    <svg class="w-6 h-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-white">Transfer Bank</div>
                                    <div class="text-xs text-gray-400">BCA, Mandiri, BRI</div>
                                </div>
                                <div class="ml-auto w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-brand-green peer-checked:bg-brand-green"></div>
                            </div>
                        </label>

                        <!-- COD -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="payment" value="cod" x-model="paymentMethod" class="peer sr-only">
                            <div class="p-4 rounded-xl border border-gray-600 bg-gray-800/50 hover:bg-gray-800 peer-checked:border-brand-green peer-checked:bg-brand-green/10 transition flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded flex items-center justify-center p-1">
                                    <svg class="w-6 h-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-white">Tunai / COD</div>
                                    <div class="text-xs text-gray-400">Bayar ke kurir</div>
                                </div>
                                <div class="ml-auto w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-brand-green peer-checked:bg-brand-green"></div>
                            </div>
                        </label>

                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: ORDER SUMMARY -->
            <div class="lg:col-span-1">
                <div class="glass-panel p-6 rounded-2xl sticky top-24">
                    <h3 class="text-xl font-bold text-white mb-4">Ringkasan Pesanan</h3>
                    
                    <!-- Loop Item Cart -->
                    <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2">
                        <template x-for="item in cart" :key="item.id">
                            <div class="flex gap-3">
                                <div class="w-12 h-12 rounded bg-gray-800 overflow-hidden flex-shrink-0">
                                    <img :src="item.img" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-white font-medium" x-text="item.qty + 'x ' + item.name"></span>
                                        <span class="text-gray-300" x-text="formatRupiah(item.total)"></span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1" x-show="item.addons.length > 0">
                                        + <span x-text="item.addons.map(a => a.name).join(', ')"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <hr class="border-gray-700 mb-4">

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between text-gray-400">
                            <span>Subtotal</span>
                            <span x-text="'Rp ' + formatRupiah(subtotal)"></span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>Ongkos Kirim</span>
                            <span>Rp 5.000</span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>Pajak & Layanan (11%)</span>
                            <span x-text="'Rp ' + formatRupiah(tax)"></span>
                        </div>
                        <div class="flex justify-between text-white font-bold text-lg pt-2 border-t border-gray-700 mt-2">
                            <span>Total Bayar</span>
                            <span class="text-brand-green" x-text="'Rp ' + formatRupiah(grandTotal)"></span>
                        </div>
                    </div>

                    <button @click="processPayment()" 
                        class="w-full bg-brand-green hover:bg-green-400 text-black font-bold py-4 rounded-xl shadow-lg mt-6 transition transform hover:-translate-y-1 flex justify-center items-center gap-2"
                        :disabled="loading">
                        
                        <span x-show="!loading">Bayar Sekarang</span>
                        
                        <!-- Loading Spinner -->
                        <div x-show="loading" class="animate-spin rounded-full h-5 w-5 border-b-2 border-black"></div>
                    </button>
                    
                    <p class="text-xs text-gray-500 text-center mt-4 flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Pembayaran Aman & Terenkripsi
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- SUCCESS MODAL (Pop-up after payment) -->
    <div x-show="showSuccess" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md" x-cloak>
        <div class="bg-[#0F172A] border border-gray-700 p-8 rounded-[2rem] max-w-sm w-full text-center shadow-2xl relative overflow-hidden">
            <div class="absolute top-[-20%] left-[-20%] w-32 h-32 bg-brand-green/20 rounded-full blur-2xl"></div>
            
            <div class="w-20 h-20 bg-brand-green rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_0_30px_rgba(0,224,115,0.4)]">
                <svg class="w-10 h-10 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            </div>
            
            <h2 class="text-2xl font-bold text-white mb-2">Pembayaran Berhasil!</h2>
            <p class="text-gray-400 text-sm mb-8">Pesanan Anda telah diterima oleh merchant dan sedang diproses.</p>
            
            <a href="{{ url('/') }}" class="block w-full bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 rounded-xl transition border border-gray-600">
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PasarNgalam - Kuliner Terbaik Malang</title>

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <!-- Config Warna & Font -->
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
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-brand-dark text-white min-h-screen relative selection:bg-brand-green selection:text-black" 
      x-data="appData()">

    <!-- 1. NAVBAR -->
    @include('user.partials.navbar')

    <!-- 2. HERO SECTION -->
    @include('user.partials.hero')

    <!-- 3. CONTENT GRID (MERCHANTS) -->
    @include('user.partials.merchants')

    <!-- 4. MODALS (Popups) -->
    @include('user.partials.modals')

    <!-- LOGIC ALPINE JS (Dipisah di bawah agar rapi) -->
    <script>
        function appData() {
            return {
                showModal: false,
                modalView: 'merchant_detail', 
                mobileMenuOpen: false,
                selectedMerchant: { menus: [] },
                selectedMenu: {},
                cart: [],
                qty: 1,
                selectedAddons: [], 
                note: '',

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID').format(number);
                },

                get currentItemTotal() {
                    if(!this.selectedMenu.price) return 0;
                    let addonTotal = this.selectedAddons.reduce((sum, item) => sum + parseInt(item.price), 0);
                    return (parseInt(this.selectedMenu.price) + addonTotal) * this.qty;
                },

                get grandTotal() {
                    return this.cart.reduce((sum, item) => sum + item.total, 0);
                },

                get cartCount() {
                    return this.cart.reduce((sum, item) => sum + item.qty, 0);
                },

                openMerchantModal(merchant) {
                    this.selectedMerchant = merchant;
                    this.modalView = 'merchant_detail';
                    this.showModal = true;
                },

                openMenuCustomization(menu) {
                    let dynamicAddons = [];
                    if (menu.addons) {
                        if (Array.isArray(menu.addons)) {
                            dynamicAddons = menu.addons;
                        } else if (typeof menu.addons === 'string') {
                            try { dynamicAddons = JSON.parse(menu.addons); } catch (e) { dynamicAddons = []; }
                        }
                    }

                    this.selectedMenu = {
                        ...menu,
                        addons_available: dynamicAddons
                    };
                    
                    this.qty = 1;
                    this.selectedAddons = []; 
                    this.note = '';
                    this.modalView = 'menu_customization';
                },

                addToCart() {
                    const item = {
                        id: Date.now(),
                        product_id: this.selectedMenu.id,
                        merchant_id: this.selectedMenu.merchant_id,
                        name: this.selectedMenu.name,
                        img: this.selectedMenu.img,
                        price: this.selectedMenu.price,
                        qty: this.qty,
                        addons: JSON.parse(JSON.stringify(this.selectedAddons)), 
                        note: this.note,
                        total: this.currentItemTotal,
                        merchant_lat: this.selectedMerchant.lat, 
                        merchant_lng: this.selectedMerchant.lng
                    };
                    
                    this.cart.push(item);
                    localStorage.setItem('pasarNgalamCart', JSON.stringify(this.cart));
                    this.modalView = 'merchant_detail';
                },

                openCart() {
                    this.modalView = 'cart_detail';
                    this.showModal = true;
                },

                removeFromCart(id) {
                    this.cart = this.cart.filter(item => item.id !== id);
                    localStorage.setItem('pasarNgalamCart', JSON.stringify(this.cart));
                },

                processCheckout() {
                    if (this.cart.length === 0) {
                        alert('Keranjang kosong!');
                        return;
                    }
                    window.location.href = '{{ route('checkout') }}';
                },

                backToMerchant() { this.modalView = 'merchant_detail'; },
                
                toggleAddon(addon) {
                    const index = this.selectedAddons.findIndex(a => a.name === addon.name);
                    if (index === -1) {
                        this.selectedAddons.push(addon); 
                    } else {
                        this.selectedAddons.splice(index, 1); 
                    }
                },
                
                init() {
                    const savedCart = localStorage.getItem('pasarNgalamCart');
                    if (savedCart) {
                        this.cart = JSON.parse(savedCart);
                    }
                }
            }
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - PasarNgalam</title>
    
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
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
        .glass-panel { background: rgba(30, 41, 59, 0.5); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .form-input { background-color: rgba(15, 23, 42, 0.6); border: 1px solid rgba(71, 85, 105, 0.8); color: white; padding: 0.75rem; border-radius: 0.75rem; width: 100%; transition: all 0.2s; }
        .form-input:focus { outline: none; border-color: #00E073; box-shadow: 0 0 0 2px rgba(0, 224, 115, 0.2); }
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>
<body class="bg-brand-dark text-white min-h-screen" x-data="checkoutData()">

    <!-- NAVBAR SIMPLE -->
    <nav class="border-b border-gray-800 bg-[#0F172A] sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center gap-4">
            <a href="{{ url('/') }}" class="text-gray-400 hover:text-white flex items-center gap-2 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
            <div class="h-6 w-px bg-gray-700"></div>
            <span class="font-bold text-lg">Checkout Pesanan</span>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            
            <!-- Hidden Inputs -->
            <input type="hidden" name="cart_data" id="cart_json">
            <input type="hidden" name="total_amount" id="total_amount">
            <input type="hidden" name="payment_method" id="payment_method" x-model="paymentMethod">
            <input type="hidden" name="latitude" id="lat_input">
            <input type="hidden" name="longitude" id="lng_input">

            <!-- KIRI: FORM & PAYMENT -->
            <div class="lg:col-span-2 space-y-6">
                <!-- 1. Alamat Pengiriman -->
                @include('user.checkout.partials.form-address')

                <!-- 2. Metode Pembayaran -->
                @include('user.checkout.partials.form-payment')
            </div>

            <!-- KANAN: ORDER SUMMARY -->
            <div class="lg:col-span-1">
                @include('user.checkout.partials.summary')
            </div>

        </form>
    </div>

    <!-- SCRIPT PETA & ALPINE LOGIC -->
    <script>
        function checkoutData() {
            return {
                cart: [],
                paymentMethod: 'qris', 
                loading: false,
                userLat: -7.9826,
                userLng: 112.6308,

                init() {
                    const savedCart = localStorage.getItem('pasarNgalamCart');
                    if (savedCart) {
                        this.cart = JSON.parse(savedCart);
                    } else {
                        window.location.href = '/';
                    }

                    // Listener Update Lokasi dari Peta
                    window.addEventListener('location-updated', (e) => {
                        this.userLat = e.detail.lat;
                        this.userLng = e.detail.lng;
                    });
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID').format(number);
                },

                calcDistance(lat1, lon1, lat2, lon2) {
                    if(!lat1 || !lon1 || !lat2 || !lon2) return 0;
                    var R = 6371; // Radius bumi km
                    var dLat = (lat2 - lat1) * Math.PI / 180;
                    var dLon = (lon2 - lon1) * Math.PI / 180;
                    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                            Math.sin(dLon/2) * Math.sin(dLon/2);
                    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                    return R * c; 
                },

                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + item.total, 0);
                },
                
                get tax() {
                    return this.subtotal * 0.11; // PPN 11%
                },
                
                get deliveryFee() {
                    let merchLat = this.cart[0]?.merchant_lat;
                    let merchLng = this.cart[0]?.merchant_lng;

                    if(!merchLat || !merchLng) return 7000;

                    let distance = this.calcDistance(merchLat, merchLng, this.userLat, this.userLng);

                    if (distance <= 5) {
                        return 7000;
                    } else {
                        let extraKm = Math.ceil(distance - 5);
                        return 7000 + (extraKm * 1000);
                    }
                },

                get grandTotal() {
                    return this.subtotal + this.tax + this.deliveryFee;
                },

                submitOrder() {
                    var lat = document.getElementById('lat_input').value;
                    var lng = document.getElementById('lng_input').value;

                    if (!lat || !lng) {
                        alert('Mohon tunggu peta memuat lokasi atau geser pin sedikit.');
                        return;
                    }

                    this.loading = true;
                    
                    document.getElementById('cart_json').value = JSON.stringify(this.cart);
                    document.getElementById('total_amount').value = this.grandTotal;
                    
                    document.getElementById('checkoutForm').submit();
                    localStorage.removeItem('pasarNgalamCart');
                }
            }
        }

        // --- MAP SCRIPT ---
        var map = L.map('map-register').setView([-7.9826, 112.6308], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([-7.9826, 112.6308], { draggable: true }).addTo(map);

        function updateInput(lat, lng) {
            document.getElementById('lat_input').value = lat;
            document.getElementById('lng_input').value = lng;
            window.dispatchEvent(new CustomEvent('location-updated', { detail: { lat: lat, lng: lng } }));
        }

        marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            updateInput(position.lat, position.lng);
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    map.setView([lat, lng], 17);
                    marker.setLatLng([lat, lng]);
                    updateInput(lat, lng);
                },
                function(error) { updateInput(-7.9826, 112.6308); }
            );
        } else {
            updateInput(-7.9826, 112.6308);
        }
    </script>
</body>
</html>
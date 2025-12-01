<!-- File: resources/views/user.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PasarNgalam - Kuliner Terbaik Malang</title>
    
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Config Warna & Font -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#2ECC71',
                        'brand-dark': '#1F2937',
                        'brand-bg': '#111827',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
    </style>
</head>
<body class="bg-brand-bg text-white">

    {{-- DATA DUMMY --}}
    @php
        $foods = [
            ['name' => 'Warung Bu Kris', 'category' => 'Masakan Jawa, Penyet', 'rating' => '4.8', 'time' => '25-35 min', 'dist' => '1.2 km', 'promo' => 'Diskon 20%', 'img' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&fit=crop'],
            ['name' => 'Bakso President', 'category' => 'Bakso, Mie Ayam', 'rating' => '4.9', 'time' => '20-30 min', 'dist' => '0.8 km', 'promo' => 'Gratis Ongkir', 'img' => 'https://images.unsplash.com/photo-1617384750865-c323f4f722a9?w=600&fit=crop'],
            ['name' => 'Sate Kelinci Pak Sadi', 'category' => 'Sate, Bakaran', 'rating' => '4.7', 'time' => '30-40 min', 'dist' => '2.1 km', 'promo' => null, 'img' => 'https://images.unsplash.com/photo-1529563021427-d8f8bad9d71c?w=600&fit=crop'],
            ['name' => 'Kopi Tuku Ijen', 'category' => 'Minuman, Kopi', 'rating' => '4.5', 'time' => '10-20 min', 'dist' => '0.5 km', 'promo' => 'Beli 2 Gratis 1', 'img' => 'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=600&fit=crop'],
            ['name' => 'Depot Kare Nona', 'category' => 'Kare, Masakan Padang', 'rating' => '4.6', 'time' => '25-45 min', 'dist' => '3.2 km', 'promo' => 'Diskon 50%', 'img' => 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=600&fit=crop'],
            ['name' => 'Mie Gacoan', 'category' => 'Mie Pedas, Dimsum', 'rating' => '4.8', 'time' => '40-50 min', 'dist' => '1.5 km', 'promo' => 'Diskon 10%', 'img' => 'https://images.unsplash.com/photo-1552611052-33e04de081de?w=600&fit=crop'],
        ];
    @endphp

    <!-- NAVBAR -->
    <nav class="fixed w-full z-50 top-0 bg-brand-bg/90 backdrop-blur-md border-b border-gray-800 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="bg-brand-green/20 p-1.5 rounded-lg">
                        <svg class="h-6 w-6 text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-brand-green">PasarNgalam</span>
                </div>
                <!-- Menu Desktop -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#" class="text-white hover:text-brand-green font-medium transition">Beranda</a>
                    <a href="#" class="text-gray-300 hover:text-brand-green font-medium transition">Promo</a>
                    <!-- LINK KE DASHBOARD MITRA -->
                    <a href="{{ url('/mitra-login') }}" class="text-brand-green font-bold border border-brand-green/30 px-3 py-1 rounded-full hover:bg-brand-green hover:text-white transition">
                        Jadi Mitra
                    </a>
                </div>
                <!-- Tombol Masuk -->
                <a href="#" class="bg-brand-green hover:bg-green-600 text-white px-5 py-2 rounded-full font-medium text-sm transition">Masuk</a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <div class="relative h-[500px] w-full flex items-center justify-center mt-16">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=1920&fit=crop" alt="Malang Night Market" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-bg via-gray-900/80 to-gray-900/60"></div>
        </div>
        <div class="relative z-10 text-center px-4 w-full max-w-3xl">
            <h1 class="text-4xl md:text-6xl font-bold text-brand-green mb-4 drop-shadow-lg">Kuliner Ngalam</h1>
            <p class="text-lg text-gray-200 mb-8">Temukan makanan legendaris dan UMKM terbaik di sekitarmu.</p>
            <div class="relative max-w-xl mx-auto">
                <input type="text" class="block w-full pl-6 pr-24 py-4 bg-gray-800/90 border border-gray-600 rounded-full text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-green" placeholder="Mau makan apa ker?">
                <button class="absolute right-2 top-2 bottom-2 bg-brand-green hover:bg-green-600 text-white px-6 rounded-full font-medium transition">Cari</button>
            </div>
        </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <h2 class="text-2xl font-bold text-white mb-6 pl-1">Rekomendasi Pilihan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($foods as $food)
            <div class="bg-brand-dark rounded-xl overflow-hidden shadow-xl border border-gray-800 hover:border-gray-600 transition group cursor-pointer">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $food['img'] }}" alt="{{ $food['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @if($food['promo'])
                        <div class="absolute top-3 right-3 bg-brand-green text-white text-xs font-bold px-2 py-1 rounded-md shadow-md">{{ $food['promo'] }}</div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-bold text-white truncate">{{ $food['name'] }}</h3>
                    <p class="text-gray-400 text-sm mb-4 truncate">{{ $food['category'] }}</p>
                    <div class="flex items-center justify-between text-sm text-gray-300 border-t border-gray-700 pt-3">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-yellow-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="font-bold text-white">{{ $food['rating'] }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ $food['time'] }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $food['dist'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- SECTION: AJAKAN GABUNG MITRA -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 mt-12">
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-brand-dark to-gray-900 border border-gray-700 shadow-2xl">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-brand-green rounded-full blur-3xl opacity-20"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between p-8 md:p-12">
                <div class="mb-8 md:mb-0 max-w-2xl">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Punya Usaha Kuliner?</h2>
                    <p class="text-gray-300 text-lg mb-6">Gabung PasarNgalam. Jangkau lebih banyak pelanggan dan kelola warungmu lewat dashboard canggih.</p>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center gap-2 text-gray-400">
                            <svg class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Gratis Daftar</span>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ url('/mitra-login') }}" class="block text-center bg-brand-green hover:bg-green-600 text-white text-lg font-bold py-4 px-8 rounded-full shadow-lg shadow-brand-green/30 transition transform hover:scale-105">
                        Buka Warung
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
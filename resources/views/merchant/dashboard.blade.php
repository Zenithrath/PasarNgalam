<!-- File: resources/views/merchant/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra PasarNgalam - Panel Warung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#2ECC71',
                        'brand-dark': '#1F2937',
                        'brand-bg': '#111827',
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .form-input { background-color: #1F2937; border: 1px solid #4B5563; color: white; padding: 0.75rem; border-radius: 0.5rem; width: 100%; }
        .form-input:focus { outline: none; border-color: #2ECC71; ring: 2px solid #2ECC71; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-brand-bg text-gray-100" x-data="{ activeTab: 'menu', showModal: false }">

    <!-- NAVBAR MITRA -->
    <nav class="bg-brand-dark border-b border-gray-700 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="bg-brand-green/20 p-2 rounded-lg hover:bg-brand-green/30 transition">
                        <svg class="h-6 w-6 text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <span class="text-xl font-bold text-brand-green tracking-tight">Mitra Panel</span>
                        <span class="text-xs block text-gray-400">PasarNgalam Seller</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name=Sam+Ker&background=2ECC71&color=fff" class="h-10 w-10 rounded-full border-2 border-brand-green">
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- SIDEBAR -->
            <div class="lg:col-span-1 space-y-4">
                <div class="bg-brand-dark rounded-xl p-4 border border-gray-700 shadow-lg">
                    <nav class="space-y-2">
                        <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'bg-brand-green text-white shadow-lg' : 'text-gray-400 hover:text-white'" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all">
                            Profil Warung
                        </button>
                        <button @click="activeTab = 'menu'" :class="activeTab === 'menu' ? 'bg-brand-green text-white shadow-lg' : 'text-gray-400 hover:text-white'" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all">
                            Daftar Menu
                        </button>
                    </nav>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="lg:col-span-3">
                <!-- TAB PROFIL -->
                <div x-show="activeTab === 'profile'" x-transition class="bg-brand-dark border border-gray-700 rounded-xl p-6 shadow-lg space-y-6">
                    <h2 class="text-2xl font-bold text-white border-b border-gray-700 pb-4">Pengaturan Warung</h2>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label class="block text-gray-400 mb-2">Nama Warung</label><input type="text" class="form-input" value="Warung Ngalam"></div>
                            <div><label class="block text-gray-400 mb-2">Kategori</label><select class="form-input"><option>Masakan Jawa</option></select></div>
                        </div>
                        <div><label class="block text-gray-400 mb-2">Alamat</label><textarea rows="2" class="form-input">Jl. Ijen No. 1</textarea></div>
                        <button class="bg-brand-green hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg">Simpan</button>
                    </form>
                </div>

                <!-- TAB MENU -->
                <div x-show="activeTab === 'menu'" x-transition class="space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-white">Daftar Menu</h2>
                        <button @click="showModal = true" class="bg-brand-green hover:bg-green-600 text-white px-6 py-2 rounded-lg font-medium shadow-lg">+ Tambah Menu</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach([
                            ['name'=>'Nasi Goreng Mawut', 'price'=>'15.000', 'status'=>'Tersedia'],
                            ['name'=>'Es Teh Jumbo', 'price'=>'5.000', 'status'=>'Tersedia']
                        ] as $menu)
                        <div class="bg-brand-dark border border-gray-700 rounded-xl p-4 flex gap-4">
                            <div class="w-20 h-20 bg-gray-800 rounded-lg"></div>
                            <div class="flex-1">
                                <h3 class="font-bold text-white">{{ $menu['name'] }}</h3>
                                <p class="text-brand-green font-semibold">Rp {{ $menu['price'] }}</p>
                                <span class="text-xs text-gray-400 bg-gray-800 px-2 py-1 rounded mt-2 inline-block">{{ $menu['status'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div @click.away="showModal = false" class="relative bg-brand-dark rounded-2xl w-full max-w-lg border border-gray-700 p-6 shadow-2xl">
                <h3 class="text-xl font-bold text-white mb-4">Tambah Menu Baru</h3>
                <form class="space-y-4">
                    <input type="text" placeholder="Nama Menu" class="form-input">
                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" placeholder="Harga" class="form-input">
                        <select class="form-input"><option>Makanan</option><option>Minuman</option></select>
                    </div>
                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="showModal = false" class="w-full py-3 bg-gray-700 text-white rounded-lg">Batal</button>
                        <button type="button" @click="showModal = false" class="w-full py-3 bg-brand-green text-white rounded-lg font-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
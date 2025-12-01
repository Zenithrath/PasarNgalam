<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk / Daftar Mitra - PasarNgalam</title>
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
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-brand-bg text-white h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Background Decoration -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-brand-green/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-4xl bg-brand-dark/80 backdrop-blur-lg border border-gray-700 rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row h-[600px] md:h-[550px]" 
         x-data="{ tab: 'login' }"> <!-- Alpine State -->

        <!-- Left Side: Image & Text (Hidden on Mobile) -->
        <div class="hidden md:flex w-1/2 bg-gray-900 relative items-center justify-center p-8 text-center">
            <img src="https://images.unsplash.com/photo-1556910103-1c02745a30bf?auto=format&fit=crop&w=800&q=80" class="absolute inset-0 w-full h-full object-cover opacity-40">
            <div class="relative z-10">
                <h2 class="text-3xl font-bold text-white mb-2">PasarNgalam Mitra</h2>
                <p class="text-gray-300">Kelola warungmu, pantau pesanan, dan jangkau pelanggan lebih luas.</p>
            </div>
        </div>

        <!-- Right Side: Forms -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            
            <!-- Logo Mobile -->
            <div class="md:hidden text-center mb-6">
                <h1 class="text-2xl font-bold text-brand-green">PasarNgalam</h1>
            </div>

            <!-- Tab Switcher -->
            <div class="flex bg-gray-800 p-1 rounded-lg mb-8">
                <button @click="tab = 'login'" 
                        :class="tab === 'login' ? 'bg-brand-green text-white shadow' : 'text-gray-400 hover:text-white'"
                        class="flex-1 py-2 rounded-md text-sm font-medium transition-all">
                    Masuk
                </button>
                <button @click="tab = 'register'" 
                        :class="tab === 'register' ? 'bg-brand-green text-white shadow' : 'text-gray-400 hover:text-white'"
                        class="flex-1 py-2 rounded-md text-sm font-medium transition-all">
                    Daftar Baru
                </button>
            </div>

            <!-- FORM LOGIN -->
            <div x-show="tab === 'login'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <form action="{{ url('/merchant/dashboard') }}" method="GET" class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Email</label>
                        <input type="email" placeholder="email@warung.com" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green transition">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Password</label>
                        <input type="password" placeholder="••••••••" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green transition">
                    </div>
                    <button type="submit" class="w-full bg-brand-green hover:bg-green-600 text-white font-bold py-3 rounded-lg shadow-lg shadow-brand-green/20 transition transform hover:scale-[1.02]">
                        Masuk Dashboard
                    </button>
                </form>
            </div>

            <!-- FORM REGISTER -->
            <div x-show="tab === 'register'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                <form action="{{ url('/merchant/dashboard') }}" method="GET" class="space-y-3">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Nama Pemilik</label>
                        <input type="text" placeholder="Budi Santoso" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-brand-green focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Nama Usaha</label>
                        <input type="tel" placeholder="Ayam Geprek" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-brand-green focus:outline-none transition">
                    </div>
                     <div>
                        <label class="block text-sm text-gray-400 mb-1">Nomor WhatsApp</label>
                        <input type="tel" placeholder="0812..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-brand-green focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Buat Password</label>
                        <input type="password" placeholder="••••••••" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-brand-green focus:outline-none transition">
                    </div>
                    <button type="submit" class="w-full bg-brand-green hover:bg-green-600 text-white font-bold py-3 rounded-lg shadow-lg shadow-brand-green/20 transition transform hover:scale-[1.02] mt-2">
                        Daftar Sekarang
                    </button>
                </form>
            </div>

        </div>
    </div>
    
    <div class="absolute bottom-4 text-gray-500 text-xs">
        &copy; 2024 PasarNgalam Mitra. <a href="{{ url('/') }}" class="hover:text-brand-green">Kembali ke Beranda</a>
    </div>

</body>
</html>
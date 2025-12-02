<!-- File: resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - PasarNgalam</title>

    <!-- Tailwind CSS & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#00E073'
                        , 'brand-dark': '#0F172A'
                        , 'brand-card': '#1E293B'
                    , }
                    , fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                    , animation: {
                        'float': 'float 6s ease-in-out infinite'
                    , }
                    , keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            }
                            , '50%': {
                                transform: 'translateY(-20px)'
                            }
                        , }
                    }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .form-input {
            background-color: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(71, 85, 105, 0.6);
            color: white;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            width: 100%;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #00E073;
            box-shadow: 0 0 0 4px rgba(0, 224, 115, 0.1);
            background-color: rgba(30, 41, 59, 0.8);
        }

        [x-cloak] {
            display: none !important;
        }

    </style>
</head>
<body class="bg-brand-dark text-white min-h-screen flex items-center justify-center p-4 relative overflow-hidden" x-data="{ tab: 'login', role: 'user' }">
    <!-- Tambah state role -->

    <!-- BACKGROUND BLOBS -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-brand-green/10 rounded-full blur-[100px] animate-float"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-blue-600/10 rounded-full blur-[100px] animate-float" style="animation-delay: 2s"></div>
    </div>

    <!-- MAIN CONTAINER -->
    <div class="relative z-10 w-full max-w-5xl bg-[#1E293B]/60 backdrop-blur-xl border border-white/10 rounded-[2rem] shadow-2xl overflow-hidden flex min-h-[600px]">

        <!-- LEFT SIDE: VISUAL (Desktop Only) -->
        <div class="hidden lg:flex w-1/2 relative bg-gray-900 items-center justify-center p-12 overflow-hidden group">
            <div class="absolute inset-0 bg-brand-green/10 mix-blend-overlay z-10"></div>
            <!-- Gambar Berubah Sesuai Role -->
            <img :src="role === 'merchant' ? 'https://images.unsplash.com/photo-1556910103-1c02745a30bf?auto=format&fit=crop&w=800' : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1000&auto=format&fit=crop'" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition duration-1000">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-brand-dark/40 to-transparent"></div>

            <div class="relative z-20 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-brand-green/20 backdrop-blur-md border border-brand-green/30 mb-6 shadow-[0_0_30px_rgba(0,224,115,0.3)]">
                    <svg class="w-8 h-8 text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">PasarNgalam</h2>
                <p class="text-gray-300 max-w-xs mx-auto" x-text="role === 'merchant' ? 'Kelola warungmu dan jangkau pelanggan lebih luas.' : 'Jelajahi kuliner legendaris Malang langsung dari layar HP-mu.'"></p>
            </div>
        </div>

        <!-- RIGHT SIDE: FORM -->
        <div class="w-full lg:w-1/2 p-8 md:p-12 flex flex-col justify-center relative">

            <!-- Tombol Kembali -->
            <a href="{{ url('/') }}" class="absolute top-6 right-6 text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>

            <!-- Mobile Logo -->
            <div class="lg:hidden flex items-center gap-2 mb-8">
                <div class="w-8 h-8 bg-brand-green/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                </div>
                <span class="font-bold text-xl">PasarNgalam</span>
            </div>

            <!-- Tab Switcher -->
            <div class="flex p-1 bg-gray-800/50 rounded-xl mb-8 border border-white/5">
                <button @click="tab = 'login'" class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all duration-300" :class="tab === 'login' ? 'bg-brand-green text-black shadow-lg' : 'text-gray-400 hover:text-white'">
                    Masuk
                </button>
                <button @click="tab = 'register'" class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all duration-300" :class="tab === 'register' ? 'bg-brand-green text-black shadow-lg' : 'text-gray-400 hover:text-white'">
                    Daftar
                </button>
            </div>

            <!-- ALERT ERROR MESSAGE -->
            @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/50 text-red-200 text-sm p-4 rounded-xl mb-6 backdrop-blur-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- LOGIN FORM -->
            <div x-show="tab === 'login'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-white">Selamat Datang! 👋</h3>
                    <p class="text-gray-400 text-sm mt-1">Masuk untuk mulai memesan makanan favoritmu.</p>
                </div>

                <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-300 text-xs font-bold uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" class="form-input" required>
                    </div>
                    <div>
                        <label class="block text-gray-300 text-xs font-bold uppercase tracking-wider mb-2">Password</label>
                        <input type="password" name="password" placeholder="••••••••" class="form-input" required>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-gray-600 bg-gray-700 text-brand-green focus:ring-brand-green">
                            <span class="text-gray-400">Ingat Saya</span>
                        </label>
                        <a href="#" class="text-brand-green hover:underline font-medium">Lupa Password?</a>
                    </div>
                    <button type="submit" class="w-full bg-brand-green hover:bg-green-400 text-black font-bold py-3.5 rounded-xl shadow-[0_0_20px_rgba(0,224,115,0.3)] hover:shadow-[0_0_30px_rgba(0,224,115,0.5)] transition transform hover:-translate-y-0.5">
                        Masuk Sekarang
                    </button>
                </form>
            </div>

            <!-- REGISTER FORM -->
            <div x-show="tab === 'register'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">

                <!-- Pilihan Role (Penting untuk Backend) -->
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-white mb-3">Daftar Sebagai?</h3>
                    <div class="flex gap-2 bg-gray-800/50 p-1.5 rounded-xl border border-white/5">
                        <button @click="role = 'user'" :class="role === 'user' ? 'bg-gray-700 text-brand-green border border-brand-green/30 shadow-sm' : 'text-gray-400 hover:text-white'" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all">Pembeli</button>
                        <button @click="role = 'merchant'" :class="role === 'merchant' ? 'bg-gray-700 text-brand-green border border-brand-green/30 shadow-sm' : 'text-gray-400 hover:text-white'" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all">Mitra Warung</button>
                        <button @click="role = 'driver'" :class="role === 'driver' ? 'bg-gray-700 text-brand-green border border-brand-green/30 shadow-sm' : 'text-gray-400 hover:text-white'" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all">Mitra Driver</button>
                    </div>
                </div>

                <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- Hidden Input Role -->
                    <input type="hidden" name="role" :value="role">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-300 text-xs font-bold uppercase tracking-wider mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-gray-300 text-xs font-bold uppercase tracking-wider mb-2">No. WhatsApp</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="0812..." class="form-input" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-300 text-xs font-bold uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" class="form-input" required>
                    </div>

                    <!-- Input Khusus Merchant -->
                    <div x-show="role === 'merchant'" x-transition>
                        <label class="block text-brand-green text-xs font-bold uppercase tracking-wider mb-2">Nama Warung</label>
                        <input type="text" name="store_name" placeholder="Warung Makan..." class="form-input border-brand-green/50 bg-brand-green/5">
                    </div>

                    <!-- Input Khusus Driver -->
                    <div x-show="role === 'driver'" x-transition class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-brand-green text-xs font-bold uppercase tracking-wider mb-2">Plat Nomor</label>
                            <input type="text" name="vehicle_plate" placeholder="N 1234 AB" class="form-input border-brand-green/50 bg-brand-green/5">
                        </div>
                        <div>
                            <label class="block text-brand-green text-xs font-bold uppercase tracking-wider mb-2">Jenis</label>
                            <select name="vehicle_type" class="form-input border-brand-green/50 bg-brand-green/5">
                                <option value="motor" class="text-black">Motor</option>
                                <option value="mobil" class="text-black">Mobil</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-300 text-xs font-bold uppercase tracking-wider mb-2">Password</label>
                        <input type="password" name="password" placeholder="••••••••" class="form-input" required>
                    </div>

                    <div class="flex items-start gap-2 text-sm text-gray-400 mt-2">
                        <input type="checkbox" required class="mt-1 rounded border-gray-600 bg-gray-700 text-brand-green focus:ring-brand-green">
                        <span>Saya setuju dengan <a href="#" class="text-brand-green hover:underline">Syarat & Ketentuan</a> PasarNgalam.</span>
                    </div>

                    <button type="submit" class="w-full bg-brand-green hover:bg-green-400 text-black font-bold py-3.5 rounded-xl shadow-[0_0_20px_rgba(0,224,115,0.3)] hover:shadow-[0_0_30px_rgba(0,224,115,0.5)] transition transform hover:-translate-y-0.5">
                        Daftar <span x-text="role === 'user' ? 'Pembeli' : (role === 'merchant' ? 'Mitra Warung' : 'Mitra Driver')"></span>
                    </button>
                </form>
            </div>

            <!-- Social Login (Visual Only) -->
            <div class="mt-8 relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-[#17202e] text-gray-400">Atau masuk dengan</span>
                </div>
            </div>

            <!-- Google Button (Dummy) -->
            <button class="mt-6 w-full bg-white text-gray-900 border border-gray-200 font-bold py-3.5 rounded-xl hover:bg-gray-100 transition flex items-center justify-center gap-3">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
                Google Account
            </button>

        </div>
    </div>

</body>
</html>

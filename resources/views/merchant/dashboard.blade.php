<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mitra - {{ $user->store_name }}</title>
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-bg': '#0B1120',      // Latar belakang sangat gelap
                        'brand-card': '#151F32',    // Warna kartu
                        'brand-green': '#00E073',   // Hijau neon
                        'brand-text': '#94A3B8'     // Teks abu-abu
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .form-input { 
            background-color: #1E293B; border: 1px solid #334155; color: white; 
            padding: 0.75rem; border-radius: 0.5rem; width: 100%; transition: all 0.2s;
        }
        .form-input:focus { outline: none; border-color: #00E073; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-brand-bg text-white min-h-screen"
      x-data="{ 
          activeTab: 'menu', 
          showModal: false,
          modalMode: 'create', // create / edit
          
          // Data Form
          formAction: '{{ route('merchant.product.store') }}',
          formData: { id: null, name: '', description: '', price: '', is_available: true, imagePreview: null },

          // Buka Modal (Create/Edit)
          openModal(mode, data = null) {
              this.modalMode = mode;
              this.showModal = true;
              if (mode === 'edit' && data) {
                  this.formAction = '/merchant/product/' + data.id;
                  this.formData = {
                      id: data.id,
                      name: data.name,
                      description: data.description,
                      price: data.price,
                      is_available: data.is_available == 1,
                      imagePreview: data.image ? '/storage/' + data.image : null
                  };
              } else {
                  this.formAction = '{{ route('merchant.product.store') }}';
                  this.resetForm(false);
              }
          },

          // Handle Upload Preview
          handleFileUpload(event) {
              const file = event.target.files[0];
              if (file) this.formData.imagePreview = URL.createObjectURL(file);
          },

          resetForm(closeModal = true) {
              this.formData = { id: null, name: '', description: '', price: '', is_available: true, imagePreview: null };
              if (closeModal) this.showModal = false;
          }
      }">

    <!-- HEADER ATAS (NAVBAR) -->
    <nav class="border-b border-white/5 bg-brand-bg sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <!-- Kiri: Tombol Back & Judul -->
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="bg-brand-green text-black p-2 rounded-lg hover:opacity-90 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-lg font-bold text-white flex items-center gap-2">
                        Dashboard Mitra <span class="text-[10px] bg-white/10 text-brand-green border border-brand-green rounded px-1.5">PRO</span>
                    </h1>
                    <p class="text-xs text-brand-text">Kelola Warung & Menu</p>
                </div>
            </div>

            <!-- Kanan: Nama Warung & Status -->
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-white">{{ $user->store_name }}</p>
                    <p class="text-[10px] text-brand-green flex items-center justify-end gap-1">
                        <span class="w-1.5 h-1.5 bg-brand-green rounded-full"></span> Buka
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-brand-green flex items-center justify-center text-black font-bold text-sm">
                    {{ substr($user->store_name, 0, 2) }}
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT LAYOUT -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- 1. SIDEBAR (KIRI) -->
            <div class="lg:col-span-3 space-y-4">
                <div class="bg-brand-card rounded-2xl p-4 border border-white/5">
                    <nav class="space-y-1">
                        <!-- Menu Button -->
                        <button @click="activeTab = 'menu'" 
                            :class="activeTab === 'menu' ? 'bg-brand-green text-black' : 'text-brand-text hover:text-white hover:bg-white/5'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            Daftar Menu
                        </button>
                        
                        <!-- Profil Button -->
                        <button @click="activeTab = 'profile'" 
                            :class="activeTab === 'profile' ? 'bg-brand-green text-black' : 'text-brand-text hover:text-white hover:bg-white/5'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Profil & Statistik
                        </button>

                        <div class="my-4 border-t border-white/5"></div>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl font-semibold transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- 2. MAIN CONTENT (KANAN) -->
            <div class="lg:col-span-9 space-y-6">
                
                <!-- VIEW 1: DAFTAR MENU -->
                <div x-show="activeTab === 'menu'" x-transition>
                    
                    <!-- BANNER HIJAU BESAR (Sesuai Screenshot) -->
                    <div class="bg-gradient-to-r from-[#00E073] to-[#00C062] rounded-3xl p-8 mb-8 relative overflow-hidden shadow-lg">
                        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="text-brand-bg">
                                <h2 class="text-3xl font-bold mb-2">Halo, {{ explode(' ', $user->name)[0] }}! 👋</h2>
                                <p class="opacity-90 max-w-lg text-sm leading-relaxed">
                                    Siap melayani pelanggan hari ini? Jangan lupa update stok menu agar tidak mengecewakan pembeli.
                                </p>
                            </div>
                            <button @click="openModal('create')" class="bg-white text-black px-6 py-3 rounded-full font-bold shadow-lg hover:shadow-xl hover:scale-105 transition transform flex items-center gap-2">
                                <span class="text-xl">+</span> Tambah Menu Baru
                            </button>
                        </div>
                        <!-- Dekorasi Banner -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    </div>

                    <!-- KARTU KECIL (PROMO & ULASAN) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="bg-brand-card border border-white/5 p-5 rounded-2xl">
                            <div class="text-brand-green mb-2"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg></div>
                            <h3 class="font-bold text-white">Ikut Promo</h3>
                            <p class="text-xs text-gray-500 mt-1">Tingkatkan orderan (coming soon)</p>
                        </div>
                        <div class="bg-brand-card border border-white/5 p-5 rounded-2xl">
                            <div class="text-purple-400 mb-2"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg></div>
                            <h3 class="font-bold text-white">Ulasan</h3>
                            <p class="text-xs text-gray-500 mt-1">0 Ulasan baru</p>
                        </div>
                    </div>

                    <!-- DAFTAR MENU (LIST VIEW) -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-white">Daftar Menu Aktif</h3>
                        <span class="text-xs text-gray-500">Total {{ count($products) }} Menu</span>
                    </div>

                    <div class="space-y-4">
                        @forelse($products as $product)
                        <!-- ITEM MENU (Horizontal Layout) -->
                        <div class="bg-brand-card border border-white/5 rounded-2xl p-4 flex flex-col sm:flex-row items-center gap-5 hover:border-brand-green/30 transition group">
                            
                            <!-- Foto Produk -->
                            <div class="w-full sm:w-24 h-24 bg-[#0B1120] rounded-xl flex-shrink-0 overflow-hidden relative">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-3xl">🥘</div>
                                @endif
                            </div>

                            <!-- Info Produk -->
                            <div class="flex-1 w-full text-center sm:text-left">
                                <h4 class="text-lg font-bold text-white mb-1">{{ $product->name }}</h4>
                                <p class="text-sm text-gray-400 line-clamp-1 mb-2">{{ $product->description }}</p>
                                
                                <!-- Status -->
                                <div class="flex items-center justify-center sm:justify-start gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $product->is_available ? 'bg-brand-green' : 'bg-red-500' }}"></span>
                                    <span class="text-xs text-gray-300">{{ $product->is_available ? 'Tersedia' : 'Habis' }}</span>
                                </div>
                            </div>

                            <!-- Harga & Aksi -->
                            <div class="flex flex-row sm:flex-col items-center justify-between w-full sm:w-auto gap-4 sm:gap-2">
                                <span class="text-brand-green font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                
                                <div class="flex gap-2">
                                    <button @click="openModal('edit', {{ $product }})" class="bg-[#263345] hover:bg-white hover:text-black text-gray-300 px-4 py-1.5 rounded-lg text-xs font-bold transition">
                                        Edit
                                    </button>
                                    <form action="{{ route('merchant.product.delete', $product->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-[#263345] hover:bg-red-500 hover:text-white text-gray-300 px-4 py-1.5 rounded-lg text-xs font-bold transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <!-- Kosong -->
                        <div class="text-center py-12 bg-brand-card rounded-2xl border border-dashed border-gray-700">
                            <p class="text-gray-500">Belum ada menu. Tambah sekarang!</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- VIEW 2: PROFILE (Form Sederhana) -->
                <div x-show="activeTab === 'profile'" x-transition style="display: none;">
                    <div class="bg-brand-card border border-white/5 rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6 pb-4 border-b border-gray-700">Edit Profil Warung</h2>
                        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div><label class="text-xs text-gray-400 block mb-2">Nama Pemilik</label><input type="text" name="name" value="{{ $user->name }}" class="form-input"></div>
                                <div><label class="text-xs text-gray-400 block mb-2">Email</label><input type="email" name="email" value="{{ $user->email }}" class="form-input"></div>
                                <div><label class="text-xs text-brand-green block mb-2">Nama Warung</label><input type="text" name="store_name" value="{{ $user->store_name }}" class="form-input border-brand-green/30"></div>
                                <div><label class="text-xs text-gray-400 block mb-2">No WhatsApp</label><input type="text" name="phone" value="{{ $user->phone }}" class="form-input"></div>
                            </div>
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-brand-green text-black font-bold py-3 px-8 rounded-xl hover:scale-105 transition">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL (CREATE / EDIT) -->
    <div x-show="showModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" x-cloak>
        <div class="bg-brand-card rounded-2xl w-full max-w-lg border border-white/10 p-8 shadow-2xl relative" @click.away="showModal = false">
            <h3 class="text-2xl font-bold text-white mb-6" x-text="modalMode === 'edit' ? 'Edit Menu' : 'Tambah Menu'"></h3>
            
            <form :action="formAction" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <template x-if="modalMode === 'edit'"><input type="hidden" name="_method" value="PUT"></template>

                <!-- Status Switch -->
                <div x-show="modalMode === 'edit'" class="flex items-center justify-between bg-[#0B1120] p-3 rounded-lg">
                    <span class="text-sm text-gray-300">Status Tersedia</span>
                    <input type="checkbox" name="is_available" class="accent-brand-green w-5 h-5" x-model="formData.is_available">
                </div>

                <!-- Upload -->
                <div class="border-2 border-dashed border-gray-600 rounded-xl h-32 flex flex-col items-center justify-center relative cursor-pointer hover:border-brand-green bg-[#0B1120]">
                    <input type="file" name="image" @change="handleFileUpload" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                    <div x-show="!formData.imagePreview" class="text-center">
                        <span class="text-2xl">📸</span>
                        <p class="text-xs text-gray-400 mt-1">Upload Foto</p>
                    </div>
                    <img x-show="formData.imagePreview" :src="formData.imagePreview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                </div>

                <input type="text" name="name" x-model="formData.name" placeholder="Nama Menu" class="form-input" required>
                <div class="grid grid-cols-2 gap-4">
                    <input type="number" name="price" x-model="formData.price" placeholder="Harga (Rp)" class="form-input" required>
                    <select class="form-input appearance-none"><option>Makanan</option><option>Minuman</option></select>
                </div>
                <textarea name="description" x-model="formData.description" rows="2" placeholder="Deskripsi menu..." class="form-input"></textarea>

                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showModal = false" class="flex-1 py-3 bg-gray-700 text-white rounded-xl font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-3 bg-brand-green text-black rounded-xl font-bold hover:bg-green-400">Simpan</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
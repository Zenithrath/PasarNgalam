<div x-show="activeTab === 'profile'" x-transition.opacity.duration.300ms class="space-y-6">
    
    {{-- NOTIFIKASI SUKSES --}}
    @if(session('success'))
    <div class="bg-[#00E073]/10 border border-[#00E073]/30 text-[#00E073] px-6 py-4 rounded-2xl text-sm font-semibold flex items-center gap-2 animate-pulse">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-[#151F32] border border-white/5 p-6 rounded-2xl relative overflow-hidden group shadow-lg hover:border-[#00E073]/30 transition">
            <div class="absolute right-0 top-0 w-24 h-24 bg-[#00E073]/10 rounded-bl-full -mr-4 -mt-4"></div>
            <p class="text-gray-400 text-sm uppercase font-medium">Total Pendapatan</p>
            <h3 class="text-2xl font-bold text-white mt-1">
                Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
            </h3>
            <p class="text-xs text-[#00E073] mt-2">Data Realtime</p>
        </div>

        <div class="bg-[#151F32] border border-white/5 p-6 rounded-2xl relative overflow-hidden group shadow-lg hover:border-blue-500/30 transition">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-500/10 rounded-bl-full -mr-4 -mt-4"></div>
            <p class="text-gray-400 text-sm uppercase font-medium">Pesanan Bulan Ini</p>
            <h3 class="text-2xl font-bold text-white mt-1">
                {{ $revenueThisMonth > 0 ? 'Aktif' : '0 Pesanan' }}
            </h3>
            <p class="text-xs text-blue-400 mt-2">{{ now()->format('F Y') }}</p>
        </div>

        <div class="bg-[#151F32] border border-white/5 p-6 rounded-2xl relative overflow-hidden group shadow-lg hover:border-purple-500/30 transition">
            <div class="absolute right-0 top-0 w-24 h-24 bg-purple-500/10 rounded-bl-full -mr-4 -mt-4"></div>
            <p class="text-gray-400 text-sm uppercase font-medium">Status Warung</p>
            <h3 class="text-2xl font-bold text-white mt-1">Buka</h3>
            <p class="text-xs text-purple-400 mt-2">Siap menerima order</p>
        </div>
    </div>



    {{-- FORM PROFILE --}}
    <div class="bg-[#151F32] border border-white/5 rounded-2xl p-8 space-y-8 shadow-xl"
        x-data="{
            bannerPreview: '{{ $user->banner ? asset('storage/'.$user->banner) : '' }}',
            avatarPreview: '{{ $user->profile_picture ? asset('storage/'.$user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=00E073&color=000&size=200' }}',

            updatePreview(e, type) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (ev) => {
                    if (type === 'banner') this.bannerPreview = ev.target.result;
                    if (type === 'avatar') this.avatarPreview = ev.target.result;
                };
                reader.readAsDataURL(file);
            }
        }">

        <div class="flex justify-between items-center border-b border-white/5 pb-6">
            <div>
                <h2 class="text-xl font-bold text-white">Edit Profil Warung</h2>
                <p class="text-gray-400 text-sm">Perbarui tampilan warung Anda.</p>
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- BANNER --}}
            <div>
                <label class="block text-gray-400 text-xs uppercase font-bold mb-3">Banner Warung</label>
                <div class="relative h-48 rounded-2xl overflow-hidden border-2 border-dashed border-gray-600 hover:border-[#00E073] bg-[#0B1120] cursor-pointer group">

                    <input type="file" name="store_banner" accept="image/*"
                        class="absolute inset-0 opacity-0 z-20 cursor-pointer"
                        @change="updatePreview($event, 'banner')">

                    <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#00E073]"
                        x-show="!bannerPreview">
                        <svg class="w-12 h-12 opacity-40 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-bold">Klik untuk upload banner</span>
                    </div>

                    <img :src="bannerPreview" x-show="bannerPreview"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition">
                </div>
            </div>


            {{-- PROFILE PICTURE --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div>
                    <label class="block text-gray-400 text-xs uppercase font-bold mb-3">Foto Profil</label>

                    <div class="relative w-full aspect-square rounded-2xl overflow-hidden border-2 border-dashed border-gray-600 hover:border-[#00E073] bg-[#0B1120] group">

                        <input type="file" name="profile_picture" accept="image/*"
                            class="absolute inset-0 opacity-0 z-20 cursor-pointer"
                            @change="updatePreview($event, 'avatar')">

                        <img :src="avatarPreview"
                            class="absolute inset-0 w-full h-full object-cover group-hover:brightness-75 transition" />

                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-bold transition">
                            Ubah Foto
                        </div>
                    </div>
                </div>

                {{-- INPUT --}}
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 content-start">

                    <div>
                        <label class="text-gray-400 text-xs uppercase font-bold mb-2">Nama Pemilik</label>
                        <input type="text" name="name" value="{{ $user->name }}" required
                            class="bg-[#0B1120] border border-[#334155] text-white text-sm rounded-xl p-3.5 w-full">
                    </div>

                    <div>
                        <label class="text-[#00E073] text-xs uppercase font-bold mb-2">Nama Warung</label>
                        <input type="text" name="store_name" value="{{ $user->store_name }}" required
                            class="bg-[#0B1120] border border-[#00E073]/50 text-white text-sm rounded-xl p-3.5 w-full">
                    </div>

                    <div>
                        <label class="text-gray-400 text-xs uppercase font-bold mb-2">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" required
                            class="bg-[#0B1120] border border-[#334155] text-white text-sm rounded-xl p-3.5 w-full">
                    </div>

                    <div>
                        <label class="text-gray-400 text-xs uppercase font-bold mb-2">No WhatsApp</label>
                        <input type="text" name="phone" value="{{ $user->phone }}" required
                            class="bg-[#0B1120] border border-[#334155] text-white text-sm rounded-xl p-3.5 w-full">
                    </div>

                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row justify-between gap-6">

                <div class="w-full md:w-1/2">
                    <label class="text-gray-400 text-xs uppercase font-bold mb-2">Password Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak mengubah"
                        class="bg-[#0B1120] border border-[#334155] text-white text-sm rounded-xl p-3.5 w-full">
                </div>

                <button type="submit"
                    class="w-full md:w-auto bg-[#00E073] hover:bg-[#00C062] text-black font-bold py-3.5 px-8 rounded-xl shadow-[0_0_15px_rgba(0,224,115,0.3)] transition">
                    Simpan Perubahan
                </button>

            </div>

        </form>


{{-- REVIEW CUSTOMER --}}
<div class="bg-[#151F32] border border-white/5 rounded-2xl p-8 space-y-6 shadow-xl"
    x-data="{ sortRating: 'all' }">

    {{-- Header --}}
    <div class="flex justify-between items-center border-b border-white/5 pb-6">
        <div>
            <h2 class="text-xl font-bold text-white">Ulasan Customer</h2>
            <p class="text-gray-400 text-sm">Lihat pengalaman pelanggan terhadap warung Anda.</p>
        </div>

        {{-- Dropdown Filter --}}
        <select x-model="sortRating"
            class="bg-[#0B1120] border border-[#334155] text-white text-sm rounded-xl px-4 py-2 focus:outline-none">
            <option value="all">Semua Rating</option>
            <option value="5">Rating 5</option>
            <option value="4">Rating 4</option>
            <option value="3">Rating 3</option>
            <option value="2">Rating 2</option>
            <option value="1">Rating 1</option>
        </select>
    </div>

    {{-- Review List --}}
    @if(isset($reviews) && count($reviews) > 0)
    <div class="space-y-4 max-h-96 overflow-y-auto pr-2 custom-scroll">

        @foreach ($reviews as $review)
        <template x-if="sortRating === 'all' || sortRating == '{{ $review->rating }}'">

            <div class="bg-[#0B1120] p-5 rounded-xl border border-white/5 hover:border-[#00E073]/40 transition group">
                <div class="flex items-start gap-4">

                    {{-- Avatar --}}
                    <div class="w-12 h-12 rounded-full overflow-hidden border border-[#00E073]/40 flex-shrink-0">
                        <img src="{{ $review->reviewer->profile_picture 
                            ? asset('storage/'.$review->reviewer->profile_picture) 
                            : 'https://ui-avatars.com/api/?name='.urlencode($review->reviewer->name).'&background=00E073&color=000' }}"
                            class="w-full h-full object-cover" />
                    </div>

                    <div class="flex-1">

                        {{-- Nama + Rating --}}
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-white text-sm">
                                {{ $review->reviewer->name }}
                            </h3>

                            <div class="flex items-center gap-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($i <= (int)$review->rating)
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.286 3.966c.3.922-.755 1.688-1.54 1.118l-3.385-2.46a1 1 0 00-1.176 0l-3.385 2.46c-.784.57-1.838-.196-1.539-1.118l1.286-3.966a1 1 0 00-.364-1.118L2.045 9.394c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.967z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.286 3.966c.3.922-.755 1.688-1.54 1.118l-3.385-2.46a1 1 0 00-1.176 0l-3.385 2.46c-.784.57-1.838-.196-1.539-1.118l1.286-3.966a1 1 0 00-.364-1.118L2.045 9.394c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.967z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <p class="text-gray-500 text-xs mb-2">
                            {{ $review->created_at->format('d M Y') }}
                        </p>

                        {{-- Isi review --}}
                        <p class="text-gray-300 text-sm">
                            {{ $review->comment ?: 'Tidak ada komentar.' }}
                        </p>
                    </div>

                </div>
            </div>

        </template>
        @endforeach

    </div>

    @else
        <div class="text-center py-10 text-gray-500 text-sm">
            Belum ada ulasan dari customer.
        </div>
    @endif
</div>

<style>
    /* Scrollbar elegan */
    .custom-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #00E073;
        border-radius: 10px;
    }
</style>
    </div>
</div>

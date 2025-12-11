<div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 -mt-32 relative z-20 pb-20">
    @if($merchants->count() > 0)
    
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-8">
        @foreach($merchants as $merchant)
        @php
            $menusData = $merchant->products->map(function($p) use ($merchant) {
                $addons = [];
                if (!empty($p->addons)) {
                    if (is_array($p->addons)) {
                        $addons = $p->addons;
                    } elseif (is_string($p->addons)) {
                        $decoded = json_decode($p->addons, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $addons = $decoded;
                        }
                    }
                }

                $imageUrl = !empty($p->image) 
                    ? asset('storage/' . $p->image) 
                    : 'https://placehold.co/400x300?text=No+Image';

                return [
                    'id' => $p->id,
                    'merchant_id' => $merchant->id,
                    'name' => $p->name,
                    'price' => $p->price,
                    'desc' => $p->description,
                    'img' => $imageUrl, 
                    'addons' => $addons
                ];
            })->values()->toArray();

            $bannerPath = $merchant->banner ?? $merchant->store_banner;
            if (!empty($bannerPath)) {
                $merchantImg = asset('storage/' . $bannerPath);
            } else {
                $merchantImg = 'https://ui-avatars.com/api/?name='.urlencode($merchant->store_name).'&background=00E073&color=000&size=400&bold=true&font-size=0.33';
            }

           // Ambil review merchant
$reviews = $merchant->reviewsReceived()
    ->with('reviewer')
    ->get()
    ->map(function ($r) {
        return [
            'id' => $r->id,
            'rating' => $r->rating,
            'comment' => $r->comment,
            'created_at' => $r->created_at->diffForHumans(),
            'reviewer_name' => $r->reviewer->name ?? 'Pengguna',
        ];
    });

$merchantData = [
    'id' => $merchant->id,
    'name' => $merchant->store_name ?? $merchant->name,
    'lat' => $merchant->latitude,
    'lng' => $merchant->longitude,
    'category' => 'Aneka Kuliner',

    // DINAMIS ⭐
    'rating' => $merchant->average_rating,
    'review_count' => $merchant->total_reviews,

    'img' => $merchantImg,
    'menus' => $menusData,

    // PENTING!!! untuk modal review
    'reviews' => $reviews,
];



        @endphp

        <div @click="openMerchantModal({{ json_encode($merchantData) }})" class="glass-panel rounded-2xl md:rounded-3xl overflow-hidden hover:border-brand-green/50 transition duration-300 group cursor-pointer relative shadow-lg hover:shadow-brand-green/20 flex flex-col h-full">
            
            <div class="relative h-32 md:h-48 overflow-hidden bg-gray-800 shrink-0">
                <img src="{{ $merchantData['img'] }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                     onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=No+Image';">
                
                <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-transparent to-transparent"></div>
                
                <div class="absolute top-2 right-2 md:top-4 md:right-4 bg-brand-green text-black text-[10px] md:text-xs font-bold px-2 py-1 md:px-3 md:py-1.5 rounded-full shadow-lg flex items-center gap-1">
                    <span class="w-1.5 h-1.5 md:w-2 md:h-2 bg-black rounded-full animate-pulse"></span> Buka
                </div>
            </div>
            
            <div class="p-3 md:p-6 relative flex flex-col flex-1">
                <div class="flex justify-between items-start mb-1 md:mb-2 gap-2">
                    <h3 class="text-sm md:text-xl font-bold text-white line-clamp-1 group-hover:text-brand-green transition">
                        {{ $merchantData['name'] }}
                    </h3>
                    
                    <div class="flex items-center gap-1 bg-yellow-500/10 px-1.5 py-0.5 rounded md:rounded-lg border border-yellow-500/20 shrink-0">
                        <span class="font-bold text-yellow-500 text-[10px] md:text-sm">★ {{ $merchantData['rating'] }}</span>
                    </div>
                </div>
                
                <p class="text-gray-400 text-[10px] md:text-sm truncate flex items-center gap-1 mt-auto">
                    <svg class="w-3 h-3 md:w-4 md:h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span class="truncate">{{ $merchantData['category'] }}</span>
                </p>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-20 glass-panel rounded-3xl border border-dashed border-gray-700">
        <div class="text-6xl mb-4 grayscale opacity-50">🏪</div>
        <h2 class="text-2xl font-bold text-white mb-2">Belum Ada Warung Buka</h2>
        <p class="text-gray-400">Jadilah mitra pertama kami dan mulai berjualan!</p>
        <a href="{{ route('login') }}" class="inline-block mt-6 text-brand-green font-bold hover:underline">Gabung Sebagai Mitra &rarr;</a>
    </div>
    @endif
</div>
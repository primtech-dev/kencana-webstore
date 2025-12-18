@extends('frontend.components.layout')
@section('content')
<main class="container px-1 lg:px-[7%] mx-auto mt-8">
    @php
    $currentCatSlug = request('category');
    $catName = "Rekomendasi Spesial";
    $bannerImg = "https://cdn.ruparupa.io/filters:quality(80)/media/promotion/ruparupa/payday-oct-25/ms/header-d.png";
    $categoryDesc = "Temukan koleksi produk terbaik kami dengan harga distributor dan kualitas terjamin.";

    if($currentCatSlug) {
    $categoryData = $products->first() ? $products->first()->categories->where('slug', $currentCatSlug)->first() : null;

    if($categoryData) {
    $catName = $categoryData->name;
    if($categoryData->banner_path) {
    $bannerImg = env('APP_URL_BE'). '/' . $categoryData->banner_path;
    }
    $categoryDesc = "Menampilkan koleksi lengkap untuk kebutuhan " . $catName . " Anda.";
    } else {
    $catName = ucwords(str_replace('-', ' ', $currentCatSlug));
    }
    }
    @endphp

    @if($currentCatSlug)
    <nav class="flex px-4 mb-3 md:mb-4 text-gray-500 text-[10px] md:text-xs capitalize font-bold">
        <ol class="list-none p-0 inline-flex items-center">
            <li class="flex items-center">
                <a href="/" class="hover:text-primary transition">Home</a>
                <i class="fas fa-chevron-right px-2 md:px-3 text-[7px] md:text-[8px] text-gray-300"></i>
            </li>
            <li class="flex items-center">
                <a href="{{ url('/products') }}" class="hover:text-primary transition">Kategori</a>
                <i class="fas fa-chevron-right px-2 md:px-3 text-[7px] md:text-[8px] text-gray-300"></i>
            </li>
            <li class="text-primary truncate max-w-[100px] md:max-w-none">{{ $catName }}</li>
        </ol>
    </nav>
    @endif

    <section class="banner px-4 mb-4 md:mb-8">
        <div class="relative rounded-xl md:rounded-2xl overflow-hidden shadow-md border border-gray-100 bg-gray-100">
            <img src="{{ $bannerImg }}"
                alt="Banner {{ $catName }}"
                class="w-full h-auto block transition-transform duration-700 hover:scale-105"
                onerror="this.onerror=null;this.src='https://cdn.ruparupa.io/filters:quality(80)/media/promotion/ruparupa/payday-oct-25/ms/header-d.png';">
        </div>
    </section>


<section class="mb-6 md:mb-10 px-4 relative group">
    <div class="mb-3">
        <span class="text-[8px] font-extrabold text-primary uppercase tracking-widest block">Koleksi Kategori</span>
        <h1 class="text-lg md:text-xl font-black text-dark-grey uppercase">Kategori</h1>
    </div>

    <div class="relative">
        <button onclick="scrollKategori('left')" 
            class="absolute -left-2 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1.5 z-1 hidden md:flex items-center justify-center border border-gray-100 hover:bg-primary hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <div id="category-container" class="flex overflow-x-auto pb-2 gap-2 md:gap-3 snap-x snap-mandatory no-scrollbar scroll-smooth">
            @foreach ($categories as $category)
            @php $isActive = $category->slug == $currentCatSlug; @endphp
            
            <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                class="flex-none w-[160px] md:w-[210px] snap-start group/card">
                
                <div class="flex items-center rounded-lg p-2 border transition-all duration-200 h-16 md:h-20
                    {{ $isActive 
                        ? 'bg-gray-700 border-gray-700 shadow-md' 
                        : 'bg-gray-50 border-gray-100 hover:border-primary hover:bg-white hover:shadow-sm' 
                    }}">
                    
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-white rounded-md overflow-hidden flex-shrink-0 flex items-center justify-center p-1 shadow-sm border border-gray-50">
                        <img src="{{ env('APP_URL_BE'). '/' . $category->thumbnail }}"
                            alt="{{ $category->name }}"
                            class="max-w-full max-h-full object-contain transition-transform duration-300 group-hover/card:scale-110">
                    </div>

                    <div class="ml-3 flex-grow overflow-hidden">
                        <p class="text-[11px] md:text-xs font-bold leading-tight line-clamp-2 uppercase
                            {{ $isActive ? 'text-white' : 'text-gray-700' }}">
                            {{ $category->name }}
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <button onclick="scrollKategori('right')" 
            class="absolute -right-2 top-1/2 -translate-y-1/2 bg-white shadow-md rounded-full p-1.5 z-1 hidden md:flex items-center justify-center border border-gray-100 hover:bg-primary hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</section>

    {{-- INFO KATEGORI (Lebih Compact di Mobile) --}}
    @if($currentCatSlug)
    <div class="px-4 mb-6 md:mb-8">
        <div class="bg-gray-50 border-l-4 border-primary p-3 md:p-5 rounded-r-lg shadow-sm">
            <div class="flex items-center space-x-2 mb-0.5 md:mb-1">
                <span class="text-[8px] md:text-[10px] font-black text-primary uppercase ">Kategori</span>
            </div>
            {{-- Ukuran Judul: text-lg di mobile, text-3xl di desktop --}}
            <h1 class="text-lg md:text-2xl font-black text-dark-grey uppercase ">
                {{ $catName }}
            </h1>
            {{-- Ukuran Deskripsi: text-[11px] di mobile, text-sm di desktop --}}
            <p class="text-[11px] md:text-sm text-gray-500 mt-1 md:mt-2 leading-snug md:leading-relaxed max-w-2xl line-clamp-2 md:line-clamp-none">
                {{ $categoryDesc }}
            </p>
        </div>
    </div>
    @endif

    <section class="mb-12 px-4">
        @if(!$currentCatSlug)
        <div class="flex border-b border-light-grey mb-6">
            <button class="pb-2 mr-6 text-primary border-b-2 border-primary font-semibold">Spesial Rekomendasi</button>
            <button class="pb-2 text-dark-grey hover:text-primary">Produk Terlaris</button>
        </div>
        @else
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-dark-grey uppercase tracking-wider">Daftar Produk</h2>
            <span class="text-xs text-gray-400 font-bold uppercase tracking-widest">{{ $products->total() }} Produk Ditemukan</span>
        </div>
        @endif

        {{-- PRODUCT GRID (DESIGN ASLI ANDA) --}}
        <div class="relative">
            <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($products as $product)
                <a href="{{ route('products.show', $product->id) }}"
                    class="bg-white  rounded-lg  transition duration-200 cursor-pointer block hover:shadow-lg">
                    <div class="relative">
                        @php
                        $mainImage = $product->images->where('is_main', true)->first();
                        if ($mainImage) {
                        $baseUrl = env('APP_URL_BE');
                        $baseUrl = rtrim($baseUrl, '/') . '/';
                        $imageUrl = $baseUrl . ltrim($mainImage->url, '/');
                        } else {
                        $imageUrl = 'https://placehold.co/600x400/000/ffffff?text=No+Image';
                        }
                        $productName = $product->name;
                        $stockStatus = ($product->weight_gram > 50) ? 'Stok Terbatas' : 'Stok Tersedia';
                        $stockColor = ($product->weight_gram > 50) ? 'bg-discount' : 'bg-primary';
                        @endphp

                        <img src="{{ $imageUrl }}"
                            alt="{{ $productName }}"
                            onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                            class="h-25 sm:h-32 md:h-32 w-full object-cover rounded-t-lg">

                        <div class="absolute top-2 right-2 {{ $stockColor }} text-white text-xs font-bold px-2 py-1 rounded">
                            {{ $stockStatus }}
                        </div>
                    </div>

                    <div class="p-3 md:p-4">
                        <p class="text-xs text-dark-grey mb-1 line-clamp-1">
                            {{ $product->categories->first()->name ?? 'Tanpa Kategori' }}
                        </p>
                        <p class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                            {{ $productName }}
                        </p>
                        @php
                        $mainVariant = $product->variants->first();
                        $priceCents = $mainVariant ? $mainVariant->price : 0;
                        $displayPrice = 'Rp' . number_format($priceCents, 0, ',', '.');
                        @endphp
                        <p class="text-base md:text-lg font-bold text-discount">{{ $displayPrice }}</p>
                        <div class="flex items-center text-xs text-dark-grey mt-2">
                            <span class="text-primary">★</span>
                            <span class="ml-1">4.{{ rand(0, 9) }}</span>
                            <span class="ml-2 text-dark-grey">| {{ rand(1, 300) }} (ulasan)</span>
                        </div>
                        <p class="stock text-xs font-bold text-red-500 mt-2">
                            Stok: {{ $mainVariant ? $mainVariant->inventories->first()->available : 0 }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>

            @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6">
                {{ $products->links('frontend.components.custom-pagestyle') }}
            </div>
            @endif
        </div>
    </section>
</main>

@endsection


<script>
    function scrollKategori(direction) {
        const container = document.getElementById('category-container');
        const scrollAmount = 250; // Jarak geser
        if (direction === 'left') {
            container.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        } else {
            container.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
    }
</script>
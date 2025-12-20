@extends('frontend.components.layout')
@section('content')
<main class="container px-1 lg:px-[7%] mx-auto mt-8">
    @php
    $currentCatSlug = request('category');
    $catName = "Rekomendasi Spesial";
    $categoryDesc = "Temukan koleksi produk terbaik kami dengan harga distributor dan kualitas terjamin.";

    // Default fallback jika tidak ada banner sama sekali
    $fallbackImg = "https://cdn.ruparupa.io/filters:quality(80)/media/promotion/ruparupa/payday-oct-25/ms/header-d.png";

    // Inisialisasi variabel banner
    $desktopBanner = $fallbackImg;
    $mobileBanner = $fallbackImg;

    // 1. Prioritas: Banner Kategori (Jika ada kategori yang dipilih)
    if($currentCatSlug) {
    $categoryData = $categories->where('slug', $currentCatSlug)->first();

    if($categoryData && $categoryData->banner_path) {
    $catName = $categoryData->name;
    $categoryDesc = "Menampilkan koleksi lengkap untuk kebutuhan " . $catName . " Anda.";

    $desktopBanner = env('APP_URL_BE'). '/' . $categoryData->banner_path;
    // Gunakan thumbnail atau banner_path jika tidak ada mobile_path khusus di kategori
    $mobileBanner = isset($categoryData->thumbnail)
    ? env('APP_URL_BE'). '/' . $categoryData->thumbnail
    : $desktopBanner;
    }
    // 2. Jika Kategori dipilih tapi tidak punya banner, gunakan Home Banner dari Controller
    elseif($home_banner) {
    $desktopBanner = env('APP_URL_BE'). '/' . $home_banner->image_path;
    $mobileBanner = env('APP_URL_BE'). '/' . ($home_banner->image_mobile_path ?? $home_banner->image_path);
    }
    }
    // 3. Jika di Home (Tanpa Kategori), gunakan Home Banner dari Controller
    elseif($home_banner) {
    $desktopBanner = env('APP_URL_BE'). '/' . $home_banner->image_path;
    $mobileBanner = env('APP_URL_BE'). '/' . ($home_banner->image_mobile_path ?? $home_banner->image_path);
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
            <a href="{{ $currentCatSlug ? '#' : ($home_banner->link_url ?? '#') }}">
                <picture>
                    {{-- Source untuk Mobile --}}
                    <source media="(max-width: 767px)" srcset="{{ $mobileBanner }}">

                    {{-- Source untuk Desktop --}}
                    <source media="(min-width: 768px)" srcset="{{ $desktopBanner }}">

                    {{-- Img Fallback --}}
                    <img src="{{ $desktopBanner }}"
                        alt="Banner {{ $catName }}"
                        class="w-full h-auto block transition-transform duration-700 hover:scale-105"
                        onerror="this.onerror=null;this.src='{{ $fallbackImg }}';">
                </picture>
            </a>
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
                            <img src="{{ $category->thumbnail ? env('APP_URL_BE') . '/' . $category->thumbnail : 'https://placehold.co/100x100/000/ffffff?text=No+Image' }}"
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
        {{-- Header & Tab --}}
        <div class="flex items-start md:items-center justify-between mb-6 border-b border-light-grey pb-2">
            <div class="flex">
                @if(!$currentCatSlug)
                <button class="mr-6 text-primary border-b-2 border-primary font-semibold transition">Spesial Rekomendasi</button>
                <!-- <button class="text-dark-grey hover:text-primary transition">Produk Terlaris</button> -->
                @else
                <h2 class="text-lg font-bold text-dark-grey uppercase tracking-wider">Daftar Produk</h2>
                @endif
            </div>

            {{-- ID ini penting untuk update jumlah produk via JS --}}
            <span id="product-count" class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-widest bg-gray-50 px-2 py-1 rounded border border-gray-100">
                Memuat...
            </span>
        </div>

        <div class="relative min-h-[400px]">
            {{-- 1. SKELETON LOADER (Tampil saat awal & saat loading) --}}
            <div id="skeleton-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @for ($i = 0; $i < 12; $i++)
                    <div class="bg-white rounded-lg p-3 animate-pulse border border-gray-100 shadow-sm">
                    <div class="bg-gray-200 h-25 sm:h-32 md:h-32 w-full rounded-md mb-3"></div>
                    <div class="h-2 bg-gray-200 rounded w-1/3 mb-2"></div>
                    <div class="h-3 bg-gray-200 rounded w-full mb-1"></div>
                    <div class="h-3 bg-gray-200 rounded w-2/3 mb-3"></div>
                    <div class="h-5 bg-gray-200 rounded w-1/2 mb-2"></div>
                    <div class="h-2 bg-gray-100 rounded w-full"></div>
            </div>
            @endfor
        </div>

        {{-- 2. PRODUCT GRID CONTAINER (Data AJAX masuk ke sini) --}}
        {{-- Kita beri id 'scroll-target' untuk acuan auto-scroll --}}
        <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 hidden">
            {{-- Data di-inject oleh jQuery buildProductCard() --}}
        </div>

        {{-- 3. PAGINATION CONTAINER --}}
        <div id="pagination-container" class="mt-12 flex justify-center w-full">
            {{-- Navigasi angka di-inject oleh renderPagination() --}}
        </div>
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

@push('scripts')
<script>
    $(document).ready(function() {
        const baseUrlBe = "{{ rtrim(env('APP_URL_BE'), '/') }}/";
        let searchTimer;
        let isInitialLoad = true;

        window.fetchProducts = function(page = 1) {
            const urlParams = new URLSearchParams(window.location.search);
            const currentCategory = urlParams.get('category') || '';
            const currentSearch = urlParams.get('search') || '';

            $('#skeleton-grid').removeClass('hidden');
            $('#product-grid').addClass('hidden').empty();

            $.ajax({
                url: "{{ route('products.json') }}",
                type: "GET",
                data: {
                    page,
                    category: currentCategory,
                    search: currentSearch
                },
                success: function(res) {
                    let html = '';
                    if (res.data && res.data.length > 0) {
                        res.data.forEach(product => {
                            html += buildProductCard(product);
                        });
                        $('#product-grid').html(html).removeClass('hidden');
                        $('#product-count').text(`${res.total} Produk Ditemukan`);
                    } else {
                        $('#product-grid').html('<div class="col-span-full text-center py-20 text-gray-400 font-bold uppercase tracking-widest">Produk Tidak Ditemukan</div>').removeClass('hidden');
                        $('#product-count').text(`0 Produk Ditemukan`);
                    }
                    renderPagination(res);
                },
                complete: function() {
                    $('#skeleton-grid').addClass('hidden');

                    // --- LOGIKA AUTO SCROLL ---
                    if (!isInitialLoad) {
                        // Scroll ke arah judul "Daftar Produk"
                        $('html, body').animate({
                            scrollTop: $("#product-count").offset().top - 300
                        }, 500);
                    }
                    isInitialLoad = false;
                }
            });
        }

        function buildProductCard(product) {
            // Logika Image seperti di Blade Anda
            let mainImage = product.images.find(img => img.is_main == 1) || product.images[0];
            let imageUrl = mainImage ?
                baseUrlBe + '/' + mainImage.url.replace(/^\//, '') :
                'https://placehold.co/600x400/000/ffffff?text=No+Image';

            // Logika Harga & Stok
            let mainVariant = product.variants[0] || null;
            let price = mainVariant ?
                'Rp' + new Intl.NumberFormat('id-ID').format(mainVariant.price) :
                'Rp0';

            let stockAvailable = (mainVariant && mainVariant.inventories && mainVariant.inventories.length > 0) ?
                mainVariant.inventories[0].available :
                0;
            // jika barang itu hanya ada di 1 toko berarti stok terbatas
            let isSingleStore = product.variants.length === 1 && product.variants[0].inventories.length === 1;

            let stockStatus = isSingleStore ? 'Stok Terbatas' : 'Stok Tersedia';
            let stockColor = isSingleStore ? 'bg-primary' : 'bg-dark-grey';

            // cek rating dan ulasan
            // Hitung total rating dan jumlah ulasan
            let totalReviews = product.reviews ? product.reviews.length : 0;
            let averageRating = 0;

            if (totalReviews > 0) {
                let sumRating = product.reviews.reduce((total, review) => total + parseFloat(review.rating), 0);
                averageRating = (sumRating / totalReviews).toFixed(1); // Mengambil 1 angka di belakang koma (misal: 4.5)
            }

            // RETURN DESIGN ASLI ANDA
            return `
    <a href="/products/${product.id}" class="bg-white rounded-lg transition duration-200 cursor-pointer block hover:shadow-lg border border-gray-50 overflow-hidden">
        <div class="relative">
            <img src="${imageUrl}" 
                 alt="${product.name}" 
                 onerror="this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                 class="h-25 sm:h-32 md:h-32 w-full object-cover rounded-t-lg">
            <div class="absolute top-2 right-2 ${stockColor} text-white text-[10px] font-bold px-2 py-1 rounded">
                ${stockStatus}
            </div>
        </div>
        <div class="p-3 md:p-4">
            <p class="text-xs text-dark-grey mb-1 line-clamp-1 uppercase opacity-60">
                ${product.categories[0] ? product.categories[0].name : 'Tanpa Kategori'}
            </p>
            <p class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem] leading-tight">
                ${product.name}
            </p>
            <p class="text-base md:text-lg font-bold text-discount mt-1">${price}</p>
            
            <div class="flex items-center text-xs text-dark-grey mt-2">
                <span class="text-yellow-400">★</span>
                <span class="ml-1 font-bold">${averageRating > 0 ? averageRating : '0'}</span>
                <span class="ml-2 text-dark-grey opacity-60">| ${totalReviews} (ulasan)</span>
            </div>
            
            <p class="stock text-xs font-bold text-red-500 mt-2">
                Stok: ${stockAvailable}
            </p>
        </div>
    </a>`;
        }

        // --- EVENT HANDLERS (SEARCH) ---
        $('.search-input').on('keyup', function() {
            clearTimeout(searchTimer);
            let query = $(this).val();
            $('.search-input').val(query); // Sinkronisasi mobile-desktop
            searchTimer = setTimeout(() => updateUrlAndFetch('search', query), 500);
        });

        $('.search-form').on('submit', function(e) {
            e.preventDefault();
            updateUrlAndFetch('search', $(this).find('.search-input').val());
        });

        function updateUrlAndFetch(param, value) {
            const url = new URL(window.location.href);
            if (value) url.searchParams.set(param, value);
            else url.searchParams.delete(param);
            url.searchParams.set('page', 1);
            window.history.pushState({}, '', url);
            window.fetchProducts(1);
        }

        // Pagination Generator (Sederhana)
        function renderPagination(res) {
            const container = $('#pagination-container');
            if (res.last_page <= 1) {
                container.empty();
                return;
            }

            // --- TEMPLATE MOBILE ---
            let mobileHtml = `
        <div class="flex-1 flex justify-between sm:hidden w-full">
            ${res.current_page > 1 
                ? `<button onclick="fetchProducts(${res.current_page - 1})" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-dark-grey bg-white border border-gray-300 rounded-md hover:bg-gray-50">&laquo; Previous</button>`
                : `<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-light-grey border border-gray-300 cursor-default rounded-md">&laquo; Previous</span>`
            }

            ${res.current_page < res.last_page 
                ? `<button onclick="fetchProducts(${res.current_page + 1})" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-dark-grey bg-white border border-gray-300 rounded-md hover:bg-gray-50">Next &raquo;</button>`
                : `<span class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-light-grey border border-gray-300 cursor-default rounded-md">Next &raquo;</span>`
            }
        </div>`;

            // --- TEMPLATE DESKTOP ---
            let desktopHtml = `
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between w-full">
            <div>
                <p class="text-sm text-gray-700 leading-5">
                    Showing
                    <span class="font-medium">${res.from || 0}</span>
                    to
                    <span class="font-medium">${res.to || 0}</span>
                    of
                    <span class="font-medium">${res.total}</span>
                    results
                </p>
            </div>
            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    ${generatePageLinks(res)}
                </span>
            </div>
        </div>`;

            container.html(`<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between w-full">
        ${mobileHtml}
        ${desktopHtml}
    </nav>`);
        }

        function generatePageLinks(res) {
            let links = '';

            // Logika sederhana untuk menampilkan semua halaman 
            // (Jika halaman sangat banyak, Anda bisa membatasi loop ini)
            for (let i = 1; i <= res.last_page; i++) {
                if (i === res.current_page) {
                    links += `
                <span aria-current="page">
                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-primary border border-primary cursor-default rounded-md">
                        ${i}
                    </span>
                </span>`;
                } else {
                    links += `
                <button onclick="fetchProducts(${i})" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-dark-grey bg-white border border-gray-300 hover:bg-light-grey">
                    ${i}
                </button>`;
                }
            }
            return links;
        }

        fetchProducts(); // Initial Load
    });
</script>
@endpush
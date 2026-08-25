@extends('frontend.components.layout')
@section('content')
<main class="container px-1 lg:px-[7%] mx-auto mt-8">

    <nav class="flex px-4 mb-3 md:mb-4 text-gray-500 text-[10px] md:text-xs capitalize font-bold">
        <ol class="list-none p-0 inline-flex items-center">
            <li class="flex items-center">
                <a href="{{ url('/') }}" class="hover:text-primary transition">Home</a>
                <i class="fas fa-chevron-right px-2 md:px-3 text-[7px] md:text-[8px] text-gray-300"></i>
            </li>
            <li class="text-primary truncate max-w-[200px] md:max-w-none">{{ $keyword->name }}</li>
        </ol>
    </nav>

    <div class="px-4 mb-6 md:mb-8">
        <div class="bg-gray-50 border-l-4 border-primary p-3 md:p-5 rounded-r-lg shadow-sm">
            <span class="text-[8px] md:text-[10px] font-black text-primary uppercase">Kata Kunci</span>
            <h1 class="text-lg md:text-2xl font-black text-dark-grey uppercase">
                {{ $keyword->name }}
            </h1>
            <p class="text-[11px] md:text-sm text-gray-500 mt-1 md:mt-2 leading-snug md:leading-relaxed max-w-2xl">
                Menampilkan produk yang berkaitan dengan kata kunci "{{ $keyword->name }}".
            </p>
        </div>
    </div>

    <section class="mb-12 px-4">
        <div class="flex items-start md:items-center justify-between mb-6 border-b border-light-grey pb-2">
            <h2 class="text-lg font-bold text-dark-grey uppercase tracking-wider">Daftar Produk</h2>

            <span id="product-count" class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-widest bg-gray-50 px-2 py-1 rounded border border-gray-100">
                Memuat...
            </span>
        </div>

        <div class="relative min-h-[400px]">
            {{-- 1. SKELETON LOADER --}}
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

        {{-- 2. PRODUCT GRID CONTAINER --}}
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

@push('scripts')
<script>
    $(document).ready(function() {
        const baseUrlBe = "{{ rtrim(env('APP_URL_BE'), '/') }}/";
        const keywordSlug = "{{ $keyword->slug }}";
        let isInitialLoad = true;

        window.fetchProducts = function(page = 1) {
            $('#skeleton-grid').removeClass('hidden');
            $('#product-grid').addClass('hidden').empty();

            $.ajax({
                url: "{{ route('products.json') }}",
                type: "GET",
                data: {
                    page,
                    keyword: keywordSlug
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

                    if (!isInitialLoad) {
                        $('html, body').animate({
                            scrollTop: $("#product-count").offset().top - 300
                        }, 500);
                    }
                    isInitialLoad = false;
                }
            });
        }

        function buildProductCard(product) {
            let mainImage = product.images.find(img => img.is_main == 1) || product.images[0];
            let imageUrl = mainImage ?
                baseUrlBe + '/' + mainImage.url.replace(/^\//, '') :
                'https://placehold.co/600x400/000/ffffff?text=No+Image';

            let mainVariant = product.variants[0] || null;
            let price = mainVariant ?
                'Rp' + new Intl.NumberFormat('id-ID').format(mainVariant.price) :
                'Rp0';

            let stockAvailable = (mainVariant && mainVariant.inventories && mainVariant.inventories.length > 0) ?
                mainVariant.inventories[0].available :
                0;

            let isSingleStore = true;
            if (product.variants.length != 0) {
                isSingleStore = product.variants.length === 1 && product.variants[0].inventories.length === 1;
            }

            let stockStatus = isSingleStore ? 'Stok Terbatas' : 'Stok Tersedia';
            let stockColor = isSingleStore ? 'bg-primary' : 'bg-dark-grey';

            let totalReviews = product.reviews ? product.reviews.length : 0;
            let averageRating = 0;

            if (totalReviews > 0) {
                let sumRating = product.reviews.reduce((total, review) => total + parseFloat(review.rating), 0);
                averageRating = (sumRating / totalReviews).toFixed(1);
            }

            return `
    <a href="/products/${product.id}" class="bg-white rounded-lg transition duration-200 cursor-pointer block hover:shadow-lg border border-gray-50 overflow-hidden">
        <div class="relative">
            <img src="${imageUrl}"
                 alt="${product.name}"
                 onerror="this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                 class="h-25 sm:h-32 md:h-32 w-full p-2 object-contain rounded-t-lg p-2">
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

        function renderPagination(res) {
            const container = $('#pagination-container');
            if (res.last_page <= 1) {
                container.empty();
                return;
            }

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

        fetchProducts();
    });
</script>
@endpush

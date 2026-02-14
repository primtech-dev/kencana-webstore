@extends('frontend.components.layout')
@section('content')
<main class="container px-1 lg:px-[7%] mx-auto mt-8">

    <section class="banner">
        <div class="px-4 mb-8">
            <div class="relative rounded-xl overflow-hidden shadow-xl">

                <img src="https://cdn.ruparupa.io/filters:quality(80)/media/promotion/ruparupa/payday-oct-25/ms/header-d.png" alt="Banner Promo Koper Mochi & Pudding" class="w-full h-auto object-cover">

            </div>
        </div>

    </section>

    <section class="mb-8 px-4">
        <h2 class="text-xl font-bold mb-4 text-dark-grey">Rekomendasi Spesial Untukmu</h2>

        <p class="text-sm text-dark-grey mb-4">
            *Perbedaan harga mungkin terjadi, harga terbaru tertera pada halaman detail produk
        </p>

        <div class="flex border-b border-light-grey mb-6">
            <button class="pb-2 mr-6 text-primary border-b-2 border-primary font-semibold">Spesial
                Rekomendasi</button>
            <button class="pb-2 text-dark-grey hover:text-primary">Produk Terlaris</button>
        </div>
        <div class="relative">
            <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

                @foreach ($products as $product)

                <a href="{{ route('products.show', $product->id) }}"
                    class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer block">

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
                        @endphp

                        <img src="{{ $imageUrl }}"
                            alt="{{ $productName }}"
                            onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                            class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">

                        @php
                        $stockStatus = 'Stok Tersedia';
                        $stockColor = 'bg-primary';

                        if ($product->weight_gram > 50) {
                        $stockStatus = 'Stok Terbatas';
                        $stockColor = 'bg-discount';
                        }
                        @endphp

                        <div class="absolute top-2 right-2 {{ $stockColor }} text-white text-xs font-bold px-2 py-1 rounded">
                            {{ $stockStatus }}
                        </div>
                    </div>

                    <div class="p-3 md:p-4">

                        <p class="text-xs text-dark-grey mb-1 line-clamp-1">
                            @if ($product->categories->isNotEmpty())
                            {{ $product->categories->first()->name }}
                            @else
                            Tanpa Kategori
                            @endif
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
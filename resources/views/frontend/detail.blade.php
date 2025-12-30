@extends('frontend.components.layout')

@section('content')

<div class="modal-location fixed inset-0  bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none transition-opacity duration-300"
    id="location-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-title">

    <div class="bg-white rounded-xl w-full max-w-lg shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300 max-h-[90vh] flex flex-col" role="document">
        {{-- Header Modal --}}
        <div class="p-5 border-b border-light-grey/50 flex justify-between items-center flex-shrink-0">
            <h2 id="modal-title" class="text-xl font-extrabold text-dark-grey">Daftar Lokasi</h2>
            <button type="button" class="text-dark-grey/50 hover:text-primary" onclick="closeLocationModal()" aria-label="Tutup Modal Lokasi">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        {{-- Search & Info --}}
        <div class="p-5 flex flex-col space-y-4 flex-shrink-0">
            <div class="relative">
                <input type="text"
                    placeholder="Cari lokasi"
                    aria-label="Cari lokasi toko"
                    class="w-full p-3 pl-10 border border-light-grey rounded-lg focus:border-primary focus:ring-primary text-dark-grey font-semibold">
                <i class="fas fa-search absolute left-3 top-3.5 text-light-grey" aria-hidden="true"></i>
            </div>

            <div class="p-3 bg-blue-100 border border-blue-300 rounded-lg text-sm flex items-start space-x-2" role="alert">
                <i class="fas fa-info-circle text-blue-600 mt-0.5" aria-hidden="true"></i>
                <p class="text-dark-grey/80 text-xs md:text-sm">
                    Informasi jarak merupakan estimasi dan mungkin berbeda dengan perhitungan sesungguhnya
                </p>
            </div>
        </div>



        {{-- Location List di dalam Modal --}}
        <div class="flex-grow overflow-y-auto px-5 pb-5 space-y-3">
            @forelse ($inventory_data as $data)
            @php
            $statusColor = $data['status_color_class'];
            $distance = $data['distance_display'];
            // Cek apakah ini branch yang sedang aktif
            $isSelected = ($currentBranch && $currentBranch->id == $data['branch_id']);
            @endphp



            <label class="p-4 border {{ $isSelected ? 'border-primary bg-primary/5' : 'border-light-grey' }} rounded-lg hover:bg-light-bg/50 transition duration-150 cursor-pointer flex items-center justify-between"
                data-store-id="{{ $data['branch_id'] }}"
                data-store-name="{{ $data['branch_name'] }}"
                data-store-full-status="{{ $data['status_label'] }}"
                data-status-color="{{ $data['status_color_class'] }}"
                data-distance-value="{{ $data['distance_value'] }}">

                <div class="flex-grow pr-4">
                    <p class="font-bold text-dark-grey text-sm">
                        {{ $data['branch_name'] }}
                        @if($isSelected)
                        <span class="ml-2 px-2 py-0.5 text-xs font-semibold bg-green-500 text-white rounded-full">Aktif</span>
                        @endif
                    </p>
                    <p class="text-xs text-dark-grey/80">{{ $data['branch_address'] }}</p>
                    <!-- <p class="text-xs text-primary font-semibold mt-1">{{ $distance }}</p> -->
                    <p class="text-xs {{ $statusColor }} font-semibold mt-1">
                        {{ $data['status_label'] }}
                    </p>
                </div>

                <div class="flex-shrink-0">
                    <input type="radio" name="selected_store"
                        value="{{ $data['branch_id'] }}"
                        {{ $isSelected ? 'checked' : '' }} {{-- AUTO CHECK DISINI --}}
                        data-store-distance="{{ $distance }}"
                        data-store-full-status="{{ $data['status_label'] }}"
                        class="text-primary focus:ring-primary h-4 w-4 border-light-grey">
                </div>
            </label>
            @empty
            <p class="text-center py-8 text-dark-grey/80">Mohon maaf, stok produk ini sedang habis di semua cabang.</p>
            @endforelse
        </div>


        {{-- Footer Modal --}}
        <div class="p-5 border-t border-light-grey/50 flex justify-end space-x-3 flex-shrink-0">
            <button class="px-6 py-2 rounded-lg border border-light-grey text-dark-grey font-semibold hover:bg-light-bg transition" onclick="closeLocationModal()">
                Tutup
            </button>
            <button id="select-store-button" type="button" class="px-6 py-2 rounded-lg bg-primary text-white font-semibold opacity-50 cursor-not-allowed transition" disabled>
                Pilih
            </button>
        </div>
    </div>
</div>

{{-- 🖼️ IMAGE LIGHTBOX/MODAL (Tidak diubah) --}}
<div class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-[9999] opacity-0 pointer-events-none transition-opacity duration-300"
    id="image-lightbox"
    role="dialog"
    aria-modal="true"
    aria-hidden="true"
    aria-labelledby="lightbox-title"
    onclick="closeLightbox()">

    <div class="relative max-w-5xl w-full max-h-[90vh] flex items-center justify-center" onclick="event.stopPropagation()">
        <h2 id="lightbox-title" class="sr-only">Tampilan Penuh Gambar Produk</h2>

        <button type="button"
            class="absolute top-4 right-4 z-10 text-white text-3xl p-2 rounded-full bg-black/50 hover:bg-black/80 transition"
            onclick="closeLightbox()"
            aria-label="Tutup Tampilan Gambar">
            <i class="fas fa-times"></i>
        </button>

        <img id="lightbox-image-content"
            src=""
            alt="Gambar Produk Besar"
            class="max-w-full max-h-[90vh] object-contain cursor-pointer"
            onclick="closeLightbox()">
    </div>
</div>

@if(isset($customer_addresses) && count($customer_addresses) > 0)
<div class="modal-address fixed inset-0 bg-transparent bg-opacity-50 flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none transition-opacity duration-300"
    id="customer-address-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="address-modal-title">

    <div class="bg-white rounded-xl w-full max-w-lg shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300 max-h-[90vh] flex flex-col" role="document">
        {{-- Header Modal --}}
        <div class="p-5 border-b border-light-grey/50 flex justify-between items-center flex-shrink-0">
            <h2 id="address-modal-title" class="text-xl font-extrabold text-dark-grey">Pilih Alamat Pengiriman</h2>
            <button type="button" class="text-dark-grey/50 hover:text-primary" onclick="closeAddressModal()" aria-label="Tutup Modal Alamat">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        {{-- Search (Opsional) & Info --}}
        <div class="p-5 flex flex-col space-y-4 flex-shrink-0">
            <div class="p-3 bg-blue-100 border border-blue-300 rounded-lg text-sm flex items-start space-x-2" role="alert">
                <i class="fas fa-info-circle text-blue-600 mt-0.5" aria-hidden="true"></i>
                <p class="text-dark-grey/80 text-xs md:text-sm">
                    Alamat ini akan digunakan untuk perhitungan estimasi biaya dan waktu pengiriman.
                </p>
            </div>
            <a href="{{ url('customer/addresses/create') }}" class="w-full text-center py-2 text-sm bg-light-bg border border-light-grey rounded-lg text-dark-grey/80 font-semibold hover:bg-light-grey/50 transition duration-150">
                + Tambah Alamat Baru
            </a>
        </div>


        {{-- Address List --}}
        <div class="flex-grow overflow-y-auto px-5 pb-5 space-y-3">

            {{-- Ambil data dari Controller: $customer_addresses --}}
            @foreach ($customer_addresses as $address)
            <label class="p-4 border border-light-grey rounded-lg hover:bg-light-bg/50 transition duration-150 cursor-pointer flex items-start justify-between address-option"
                data-address-id="{{ $address->id }}"
                data-address-label="{{ $address->label }}"
                data-address-street="{{ $address->street }}"
                data-address-city="{{ $address->city }}">

                <div class="flex-grow pr-4">
                    <p class="font-bold text-dark-grey text-sm flex items-center">
                        {{ $address->label }}
                        @if ($address->is_default)
                        <span class="ml-2 px-2 py-0.5 bg-primary/10 text-primary text-xs font-bold rounded-full">Utama</span>
                        @endif
                    </p>
                    <p class="text-xs text-dark-grey/80 mt-1">{{ $address->street }}, {{ $address->city }}, {{ $address->province }} ({{ $address->postal_code }})</p>
                    <p class="text-xs text-dark-grey/80 pt-1">Telp: {{ $address->phone }}</p>
                </div>
                <div class="flex-shrink-0 pt-1">
                    {{-- Radio button value diset ke ID alamat --}}
                    <input type="radio" name="selected_address"
                        value="{{ $address->id }}"
                        @if ($address->is_default) checked @endif
                    class="text-primary focus:ring-primary h-4 w-4 border-light-grey address-radio">
                </div>
            </label>
            @endforeach

        </div>

        {{-- Footer Modal --}}
        <div class="p-5 border-t border-light-grey/50 flex justify-end space-x-3 flex-shrink-0">
            <button class="px-6 py-2 rounded-lg border border-light-grey text-dark-grey font-semibold hover:bg-light-bg transition" onclick="closeAddressModal()">
                Tutup
            </button>
            <button id="select-address-button" type="button" class="px-6 py-2 rounded-lg bg-primary text-white font-semibold transition" disabled>
                Pilih Alamat
            </button>
        </div>
    </div>
</div>
@endif

<section class="container lg:px-[8%] mx-auto ">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 lg:py-2 bg-white shadow-sm mt-8 mb-8">

        <div>
            <h2 class="text-xl font-extrabold text-dark-grey mb-6">Detail Produk</h2>
        </div>

        {{-- START: TATA LETAK 3 KOLOM UTAMA --}}
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">

            {{-- 1. KOLOM GAMBAR (lg:col-span-4) --}}
            <div class="lg:col-span-4 space-y-4">
                {{-- Product Image Gallery --}}
                <div class="flex flex-col space-y-4">
                    <div class="flex-grow">
                        {{-- Main Image Dinamis (Diklik untuk Lightbox) --}}
                        <div class="w-full aspect-square bg-light-bg rounded-lg shadow-md flex items-center justify-center overflow-hidden cursor-pointer"
                            onclick="openLightbox('{{ $product_main_image }}')"
                            role="button"
                            tabindex="0"
                            aria-label="Klik untuk melihat gambar produk lebih besar">
                            <img id="main-product-image"
                                src="{{ $product_main_image }}"
                                alt="{{ $product->name }}"
                                class="object-cover w-full h-full transition-opacity duration-300">
                        </div>
                    </div>

                    {{-- Thumbnail Gallery Dinamis --}}
                    <div class="flex space-x-4">
                        <div class=" flex space-x-2 overflow-x-auto w-full pb-1">
                            @foreach ($product_images as $index => $image)
                            @php
                            $isActive = ($image['url'] == $product_main_image);
                            $class = $isActive
                            ? 'border-2 border-primary'
                            : 'border border-light-grey';
                            @endphp
                            <div class="thumbnail flex-shrink-0 w-16 h-16 bg-light-bg {{ $class }} rounded-lg cursor-pointer flex items-center justify-center overflow-hidden"
                                data-image="{{ $image['url'] }}"
                                tabindex="0"
                                role="button"
                                aria-label="Gambar Produk {{ $index + 1 }}: {{ $product->name }}">
                                <img src="{{ $image['url'] }}" alt="{{ $product->name }} Thumbnail {{ $index + 1 }}" class="object-cover w-full h-full">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


            {{-- 2. KOLOM DESKRIPSI & INFO (lg:col-span-4) --}}
            <div class="lg:col-span-4 mt-6 lg:mt-0">
                <div class="p-0 sm:p-0">
                    {{-- Product Title and Info --}}
                    <h1 class="text-2xl font-extrabold text-dark-grey mb-1">
                        {{ $product->name }}
                    </h1>
                    <p class="text-sm text-dark-grey/80 mb-4">
                        <span class="font-bold">{{ $product->reviews->count() }}</span> Ulasan | Variant:
                        <span class="font-bold text-primary" id="current-variant-name">
                            {{ $product->variants[0]->variant_name ?? 'Pilih Varian' }}
                        </span>
                    </p>

                    {{-- Harga Dinamis --}}
                    <p class="text-3xl font-extrabold text-primary mb-4" id="current-price">
                        Rp {{ number_format($product->variants[0]->price ?? 0, 0, ',', '.') }}
                    </p>

                    {{-- PEMILIHAN VARIAN --}}
                    @if(count($product->variants) > 0)
                    <div class="mb-4 pt-2">
                        <p class="text-dark-grey font-semibold text-sm mb-2">Pilih Varian:</p>
                        <div class="flex flex-wrap gap-3 variant-selection" role="radiogroup">
                            @foreach ($product->variants as $index => $variant)
                            @php
                            $isChecked = $index === 0;
                            // Pastikan URL gambar diambil dari array images variant
                            $variant_image = (isset($variant->images) && count($variant->images) > 0)
                            ? env('APP_URL_BE') . '/' . $variant->images[0]->url
                            : $product_main_image;
                            @endphp

                            <label class="p-3 border rounded-lg cursor-pointer transition duration-150 ease-in-out flex items-center space-x-2 text-sm font-semibold {{ $isChecked ? 'border-primary bg-primary/10' : 'border-light-grey hover:border-dark-grey/50' }}">
                                <input type="radio"
                                    name="product_variant"
                                    value="{{ $variant->id }}"
                                    data-price="{{ number_format($variant->price, 0, '', '.') }}" {{-- Format tanpa titik untuk JS parsing --}}
                                    data-image-url="{{ $variant_image }}"
                                    data-variant-name="{{ $variant->variant_name }}"
                                    class="sr-only"
                                    {{ $isChecked ? 'checked' : '' }}>

                                <img src="{{ $variant_image }}" alt="{{ $variant->variant_name }}" class="w-8 h-8 object-cover rounded-md flex-shrink-0">
                                <span class="text-dark-grey">{{ $variant->variant_name }} ({{ $variant->unit->name ?? '-' }})</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="divider h-px bg-light-grey/50 mb-4"></div>

                    {{-- Ketersediaan Stok (Baru) --}}
                    <div class="mb-4 flex items-center space-x-2">
                        <span class="text-sm font-semibold text-dark-grey">Stok di Cabang Ini:</span>
                        <span id="variant-stock-display" class="text-sm font-bold">Memuat...</span>
                    </div>

                    {{-- Location Check --}}
                    <div class="flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 sm:space-x-6 text-sm text-dark-grey/80">
                        <div class="flex flex-col space-y-1">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-map-marker-alt text-primary flex-shrink-0"></i>
                                <span class="text-dark-grey font-semibold">Cek Lokasi Ketersediaan</span>
                            </div>
                            <div id="check-availability-button" class="cursor-pointer group" onclick="openLocationModal()">
                                <p id="current-store" class="text-sm text-primary font-bold group-hover:underline transition">
                                    Pilih Lokasi
                                </p>
                                <p id="store-status" class="text-xs text-dark-grey/80 pt-1">
                                    Memuat status lokasi... | <span class="underline text-primary">Ubah Lokasi</span>
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-1 hidden sm:flex border-l border-light-grey/50 pl-6">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-truck text-primary"></i>
                                <span class="text-dark-grey font-semibold">Lokasi Pengiriman</span>
                            </div>
                            <div id="shipping-address-display" class="pt-1">
                                @if(isset($customer_addresses) && count($customer_addresses) > 0)
                                @php $default_address = collect($customer_addresses)->firstWhere('is_default', true) ?? $customer_addresses[0]; @endphp
                                <p class="text-xs text-dark-grey/80">
                                    Kirim ke <span class="font-bold">{{ $default_address->label }}</span>... |
                                    <a href="#" class="underline text-primary" onclick="event.preventDefault(); openAddressModal();">Ganti</a>
                                </p>
                                @else
                                <p class="text-xs text-primary">
                                    <a href="{{ url('login') }}" class="underline">Login</a> untuk pilih alamat.
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Tabs --}}
                    <div class="mt-6">
                        <div class="flex border-b border-light-grey/50 text-sm font-semibold" role="tablist">
                            <button class="tab-button pb-3  px-4" data-target="content-spesifikasi">Ringkasan</button>
                            <button class="tab-button pb-3 text-dark-grey/80 px-4" data-target="content-informasi">Deskripsi Lengkap</button>
                        </div>

                        <div id="content-spesifikasi" class="tab-content pt-4 p-4 bg-light-bg text-sm space-y-2">
                            {!! $product->short_description !!}
                        </div>

                        <div id="content-informasi" class="tab-content pt-4 p-4 text-sm bg-light-bg space-y-2 hidden">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. ORDER SUMMARY (lg:col-span-4) --}}
            <div class="lg:col-span-4 mt-6 lg:mt-0 lg:sticky lg:top-20 self-start">
                <div class="p-6 bg-white rounded-xl shadow-md border border-light-grey/50">
                    <p class="text-dark-grey font-bold text-lg mb-4">Ringkasan Pesanan</p>

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-dark-grey font-semibold">Jumlah:</span>
                        <div class="border border-light-grey rounded flex items-center">
                            <button type="button" class="px-3 py-1 hover:bg-light-bg font-bold" id="qty-minus">-</button>
                            <input type="number" id="product-qty-input" value="1" min="1"
                                class="w-12 text-center font-bold border-none focus:ring-0 p-0">
                            <button type="button" class="px-3 py-1 hover:bg-light-bg font-bold" id="qty-plus">+</button>
                        </div>
                    </div>

                    <div class="divider h-px bg-light-grey/50 my-4"></div>

                    <div class="flex justify-between items-center mb-6">
                        <span class="text-dark-grey font-semibold">Subtotal:</span>
                        <span class="text-primary font-extrabold text-xl" id="subtotal-price">
                            Rp {{ number_format($product->variants[0]->price ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="space-y-3">
                        {{-- Hidden Input untuk dikirim ke Keranjang --}}
                        <input type="hidden" id="product-variant-id" value="{{ $product->variants[0]->id ?? '' }}">

                        <button type="button" id="buyNowButton" class="w-full py-3 rounded-xl bg-primary text-white font-bold text-lg hover:bg-primary-dark shadow-lg shadow-primary/30 transition">
                            Beli Sekarang
                        </button>

                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" id="add-to-cart-button" class="py-3 rounded-xl border border-primary text-primary font-bold hover:bg-primary/5 transition">
                                + Keranjang
                            </button>
                            <button type="button" class="py-3 rounded-xl border border-light-grey text-dark-grey/60 font-semibold hover:bg-light-bg transition flex items-center justify-center space-x-1">
                                <i class="far fa-heart"></i>
                                <span>Wishlist</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        {{-- END: TATA LETAK 3 KOLOM UTAMA --}}


        {{-- Customer Reviews --}}
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Ulasan Pelanggan</h2>

            @php
           
            $totalReviews = $reviews->total();
            $displayRating = $averageRating ?? 0;
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Ringkasan Rating --}}
                <div class="flex items-center space-x-4 p-4 border border-light-grey rounded-lg bg-light-bg/50 h-fit">
                    {{-- Menampilkan rating yang sudah dihitung (Bukan lagi 0.0) --}}
                    <div class="text-6xl font-extrabold text-primary">{{ number_format($displayRating, 1) }}/5</div>
                    <div>
                        <div class="flex items-center text-yellow-500 mb-1">
                            <span class="text-3xl">
                                {{-- Menampilkan bintang sesuai angka rata-rata --}}
                                @php $fullStars = floor($displayRating); @endphp
                                {{ str_repeat('★', $fullStars) . str_repeat('☆', 5 - $fullStars) }}
                            </span>
                        </div>
                        <p class="text-sm text-dark-grey/80">Dari {{ $totalReviews }} ulasan</p>
                    </div>
                </div>

                {{-- Daftar Ulasan --}}
                <div class="col-span-1 md:col-span-2 space-y-4">
                    @forelse($reviews as $item)
                    <div class="p-4 border border-light-grey rounded-lg bg-white shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                {{-- Akses sebagai Object karena menggunakan Eloquent get()/paginate() --}}
                                <p class="font-bold text-dark">{{ $item->customer->full_name ?? 'Pelanggan' }}</p>
                                <div class="flex text-yellow-500 text-sm">
                                    {{ str_repeat('★', $item->rating) . str_repeat('☆', 5 - $item->rating) }}
                                </div>
                            </div>
                            <span class="text-xs text-dark-grey/60">
                                {{ $item->created_at->format('d M Y') }}
                            </span>
                        </div>

                        <p class="text-dark-grey mt-2 text-sm italic">"{{ $item->body }}"</p>

                        {{-- Gambar --}}
                        @if($item->images->isNotEmpty())
                        <div class="flex gap-2 mt-3">
                            @foreach($item->images as $img)
                            <img src="{{ asset('storage/' . $img->image_path) }}"
                            onclick="openLightbox('{{ asset('storage/' . $img->image_path) }}')"
                                class="w-20 h-20 object-cover rounded-md border border-light-grey">
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="p-4 border border-light-grey rounded-lg bg-light-bg/50 text-sm text-center">
                        Belum ada ulasan untuk produk ini.
                    </div>
                    @endforelse

                    @if ($reviews instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-6">
                        {{ $reviews->links('frontend.components.custom-pagestyle') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </main>
</section>

@endsection




<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. Data & Variabel Global ---
        const inventoryData = @json($inventory_data);
        let currentBasePrice = 0;

        // Elemen Lokasi & Cabang
        const locationModal = document.getElementById('location-modal');
        const selectStoreButton = document.getElementById('select-store-button');
        const currentStoreDisplay = document.getElementById('current-store');
        const storeStatusDisplay = document.getElementById('store-status');
        const storeRadioButtons = document.querySelectorAll('input[name="selected_store"]');

        // Elemen Produk & Varian
        const variantRadios = document.querySelectorAll('input[name="product_variant"]');
        const productVariantIdInput = document.getElementById('product-variant-id');
        const basePriceTextElement = document.getElementById('current-price');
        const currentVariantNameElement = document.getElementById('current-variant-name');
        const variantStockDisplay = document.getElementById('variant-stock-display');

        // Elemen UI & Transaksi
        const mainImage = document.getElementById('main-product-image');
        const thumbnails = document.querySelectorAll('.thumbnail');
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        const productQtyInput = document.getElementById('product-qty-input');
        const qtyPlus = document.getElementById('qty-plus');
        const qtyMinus = document.getElementById('qty-minus');
        const subtotalPrice = document.getElementById('subtotal-price');
        const addToCartButton = document.getElementById('add-to-cart-button');
        const buyNowButton = document.getElementById('buyNowButton');

        // Elemen Lightbox
        const lightbox = document.getElementById('image-lightbox');
        const lightboxImage = document.getElementById('lightbox-image-content');

        // --- 2. Logika Helper ---

        function formatRupiah(number) {
            const cleanNumber = parseInt(number);
            if (isNaN(cleanNumber)) return 'Rp0';
            return 'Rp' + cleanNumber.toLocaleString('id-ID');
        }

        function updateMainImage(imageUrl) {
            if (!mainImage) return;
            mainImage.style.opacity = '0';
            setTimeout(() => {
                mainImage.src = imageUrl;
                mainImage.style.opacity = '1';
                const container = mainImage.closest('[onclick^="openLightbox"]');
                if (container) container.setAttribute('onclick', `openLightbox('${imageUrl}')`);

                thumbnails.forEach(t => {
                    t.classList.toggle('border-primary', t.getAttribute('data-image') === imageUrl);
                    t.classList.toggle('border-2', t.getAttribute('data-image') === imageUrl);
                });
            }, 100);
        }

        function getStockForSelectedVariant() {
            const selectedVariant = document.querySelector('input[name="product_variant"]:checked');
            const selectedStore = document.querySelector('input[name="selected_store"]:checked');
            if (!selectedVariant || !selectedStore) return 0;

            const variantId = parseInt(selectedVariant.value);
            const branchId = parseInt(selectedStore.value);
            const branchData = inventoryData.find(b => b.branch_id === branchId);

            if (branchData && branchData.items) {
                const item = branchData.items.find(i => i.variant_id === variantId);
                return item ? item.stock : 0;
            }
            return 0;
        }

        function updateStockUI() {
            const stock = getStockForSelectedVariant();
            if (variantStockDisplay) {
                variantStockDisplay.textContent = stock > 0 ? `${stock} pcs` : "Stok Habis / Indent";
                variantStockDisplay.className = stock > 0 ? "text-green-600 font-bold" : "text-red-600 font-bold";
            }
        }

        function updateSubtotal(qty) {
            let finalQty = parseInt(qty) || 1;
            const stockAvailable = getStockForSelectedVariant(); // Ambil stok saat ini

            if (finalQty < 1) finalQty = 1;

            // Opsional: Batasi input agar tidak melebihi 100 atau stok jika perlu
            if (finalQty > 99999) finalQty = 99999;

            productQtyInput.value = finalQty;

            if (basePriceTextElement) basePriceTextElement.textContent = formatRupiah(currentBasePrice);
            if (subtotalPrice) subtotalPrice.textContent = formatRupiah(finalQty * currentBasePrice);
        }

        // --- 3. Logika Varian ---

        function variantChangeListener() {
            let variantSelected = false;
            document.querySelectorAll('.variant-selection label').forEach(label => {
                label.classList.remove('border-primary', 'bg-primary/10');
            });

            variantRadios.forEach(radio => {
                if (radio.checked) {
                    const label = radio.closest('label');
                    if (label) label.classList.add('border-primary', 'bg-primary/10');

                    currentBasePrice = parseInt(radio.dataset.price.replace(/\./g, '')) || 0;
                    if (productVariantIdInput) productVariantIdInput.value = radio.value;
                    if (currentVariantNameElement) currentVariantNameElement.textContent = radio.dataset.variantName;
                    if (radio.dataset.imageUrl) updateMainImage(radio.dataset.imageUrl);

                    variantSelected = true;
                    updateStockUI();
                }
            });
            updateSubtotal(productQtyInput.value);
        }

        // --- 4. Logika Lokasi & Modal ---

        function updateMainLocationUI(targetLabel) {
            if (!targetLabel) return;

            const radio = targetLabel.querySelector('input[name="selected_store"]');
            if (!radio) return;

            const storeName = targetLabel.dataset.storeName;
            const storeStatus = targetLabel.dataset.storeFullStatus;
            const statusColorClass = targetLabel.dataset.statusColor;
            const distanceDisplay = radio.dataset.storeDistance || 'N/A';

            // Update Tampilan di Halaman Utama
            currentStoreDisplay.innerHTML = `<span class="${statusColorClass} font-bold">${storeStatus}</span> di ${storeName}`;

            const distanceText = (distanceDisplay && distanceDisplay !== 'N/A') ?
                `${distanceDisplay} dari lokasi Anda` : 'Produk dapat diambil atau dikirim';

            storeStatusDisplay.innerHTML = `${distanceText} | <a href="#" class="underline" onclick="event.preventDefault(); openLocationModal();">Ubah Lokasi</a>`;

            // Sinkronisasi input tersembunyi jika diperlukan dan update stok
            updateStockUI();
        }

        function sortAndHighlightClosestStore() {
            const container = document.querySelector('.modal-location .flex-grow.overflow-y-auto');
            if (!container) return;

            const labels = Array.from(container.querySelectorAll('label[data-store-id]'));

            // Sortir berdasarkan jarak
            labels.sort((a, b) => {
                return (parseFloat(a.dataset.distanceValue) || Infinity) - (parseFloat(b.dataset.distanceValue) || Infinity);
            });

            // Pindahkan elemen tanpa menghapus (ini menjaga event listener tetap aman)
            labels.forEach((label, index) => {
                if (index === 0 && !label.querySelector('.closest-badge')) {
                    const badge = document.createElement('span');
                    badge.className = 'closest-badge ml-2 px-2 py-0.5 text-xs font-semibold bg-primary text-white rounded-full';
                    badge.textContent = 'Terdekat';
                    label.querySelector('p')?.appendChild(badge);
                }
                container.appendChild(label);
            });
        }

        // --- 5. Event Listeners ---

        // Logika Delegasi Klik untuk Memilih Cabang di Modal
        document.addEventListener('change', function(e) {
            if (e.target && e.target.name === 'selected_store') {
                const selectButton = document.getElementById('select-store-button');
                const allLabels = document.querySelectorAll('.modal-location label');

                // 1. Aktifkan Tombol "Pilih"
                if (selectButton) {
                    selectButton.disabled = false;
                    selectButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    selectButton.classList.add('hover:bg-primary-dark'); // Opsional: tambah hover
                }

                // 2. Beri Highlight pada Label yang dipilih
                allLabels.forEach(label => {
                    label.classList.remove('border-primary', 'bg-primary/5');
                    label.classList.add('border-light-grey');
                });

                const activeLabel = e.target.closest('label');
                if (activeLabel) {
                    activeLabel.classList.remove('border-light-grey');
                    activeLabel.classList.add('border-primary', 'bg-primary/5');
                }
            }
        });

        // Tombol "Pilih" di Modal Lokasi
        if (selectStoreButton) {
            selectStoreButton.addEventListener('click', function() {
                const selectedRadio = document.querySelector('input[name="selected_store"]:checked');

                if (selectedRadio) {
                    const label = selectedRadio.closest('label');
                    updateMainLocationUI(label); // Update tampilan UI utama & Stock
                    closeLocationModal(); // Tutup modal

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Lokasi berhasil diubah',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }

        // --- 5. Event Listeners ---

        variantRadios.forEach(r => r.addEventListener('change', variantChangeListener));

        if (selectStoreButton) {
            selectStoreButton.addEventListener('click', function() {
                const selected = document.querySelector('input[name="selected_store"]:checked');
                if (selected) {
                    updateMainLocationUI(selected.closest('label'));
                    closeLocationModal();
                }
            });
        }

        qtyPlus?.addEventListener('click', () => updateSubtotal(parseInt(productQtyInput.value) + 1));
        qtyMinus?.addEventListener('click', () => updateSubtotal(parseInt(productQtyInput.value) - 1));

        // Update harga otomatis saat angka diketik langsung
        productQtyInput?.addEventListener('input', function() {
            updateSubtotal(this.value);
        });

        // Update harga saat input kehilangan fokus (untuk memastikan angka tidak kosong/nol)
        productQtyInput?.addEventListener('blur', function() {
            if (this.value === '' || parseInt(this.value) < 1) {
                updateSubtotal(1);
            }
        });

        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                updateMainImage(this.getAttribute('data-image'));
            });
        });

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                tabButtons.forEach(btn => btn.classList.remove('border-primary', 'text-primary'));
                tabContents.forEach(content => content.classList.add('hidden'));
                this.classList.add('border-primary', 'text-primary');
                document.getElementById(targetId).classList.remove('hidden');
            });
        });



        // --- Logika Add to Cart (AJAX) ---
        if (addToCartButton) {
            addToCartButton.addEventListener('click', function(e) {
                e.preventDefault();

                // Ambil data yang dibutuhkan
                const quantity = parseInt(productQtyInput.value) || 1;

                const selectedStoreRadio = document.querySelector('input[name="selected_store"]:checked');
                const branchId = selectedStoreRadio ? selectedStoreRadio.value : null;

                // MENGAMBIL ID VARIAN YANG DIPILIH DARI INPUT TERSEMBUNYI
                const productVariantId = productVariantIdInput ? productVariantIdInput.value : null;

                if (!branchId) {
                    //  sweetalert
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Silakan pilih lokasi toko/cabang terlebih dahulu.',
                    })
                    return;
                }

                if (!productVariantId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Silakan pilih varian produk terlebih dahulu.',
                    })
                    return;
                }

                // Tampilkan loading state jika perlu
                addToCartButton.textContent = 'Memproses...';
                addToCartButton.disabled = true;

                fetch("{{ route('cart.add') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            // ASUMSI: CSRF token ada di tag meta
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            variant_id: productVariantId,
                            quantity: quantity,
                            branch_id: branchId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    timer: 4000,
                                    showConfirmButton: true,
                                    confirmButtonColor: '#ee0d0dd6',
                                })
                                .then((result) => {
                                    if (result.dismiss === Swal.DismissReason.timer || result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan server.',
                                confirmButtonColor: '#ee0d0dd6',
                            });
                            console.error(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menambahkan Ke Keranjang!',
                            text: 'Anda harus login terlebih dahulu.',
                            confirmButtonColor: '#ee0d0dd6',
                        });
                    })
                    .finally(() => {
                        addToCartButton.textContent = '+  Keranjang';
                        addToCartButton.disabled = false;
                    });
            });
        }

        if (buyNowButton) {
            buyNowButton.addEventListener('click', function(e) {
                e.preventDefault(); // Kita cegah redirect otomatis dulu

                const qtyRequested = parseInt(productQtyInput.value);
                const stockAvailable = getStockForSelectedVariant();
                const branchId = document.querySelector('input[name="selected_store"]:checked')?.value;
                const branchName = document.querySelector('input[name="selected_store"]:checked')?.dataset.storeName || "Cabang";
                const variantId = productVariantIdInput.value;

                if (!branchId) return Swal.fire('Info', 'Pilih lokasi toko dahulu', 'warning');

                // Fungsi Helper untuk redirect ke halaman checkout
                const proceedToCheckout = () => {
                    const url = `{{ route('checkout.now') }}?variant_id=${variantId}&quantity=${qtyRequested}&branch_id=${branchId}`;
                    window.location.href = url;
                };

                // CEK STOK
                if (qtyRequested > stockAvailable) {
                    Swal.fire({
                        title: 'Stok Terbatas / Indent',
                        html: `Stok tersedia: <b>${stockAvailable} pcs</b>.<br>Anda ingin beli: <b>${qtyRequested} pcs</b>.<br><br>Tetap lanjutkan ke Checkout sebagai pesanan Indent?`,
                        icon: 'warning',
                        showCancelButton: true,
                        showDenyButton: true,
                        confirmButtonColor: '#3085d6', // Biru (WA)
                        denyButtonColor: '#10b981', // Hijau (Lanjutkan)
                        cancelButtonColor: '#d33', // Merah (Batal)
                        confirmButtonText: 'Hubungi Admin(WA)',
                        denyButtonText: 'Lanjutkan Beli',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Opsi 1: WhatsApp
                            const waMessage = `Halo Admin ${branchName}, saya ingin beli (indent) produk ${currentVariantNameElement.textContent} sebanyak ${qtyRequested} pcs.`;
                            window.open(`https://wa.me/6281234567890?text=${encodeURIComponent(waMessage)}`, '_blank');
                        } else if (result.isDenied) {
                            // Opsi 2: LANJUTKAN (Redirect ke Checkout)
                            proceedToCheckout();
                        }
                    });
                } else {
                    // Stok mencukupi, langsung gas ke checkout
                    proceedToCheckout();
                }
            });
        }

        // --- 7. Window Globals ---
        window.openLightbox = (url) => {
            lightboxImage.src = url;
            lightbox.classList.remove('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'hidden';
        };
        window.closeLightbox = () => {
            lightbox.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = '';
        };
        window.openLocationModal = () => {
            locationModal.classList.remove('opacity-0', 'pointer-events-none');
            sortAndHighlightClosestStore();
        };
        window.closeLocationModal = () => {
            locationModal.classList.add('opacity-0', 'pointer-events-none');
        };

        // --- 8. Inisialisasi Akhir ---
        sortAndHighlightClosestStore();
        const initialLabel = document.querySelector('input[name="selected_store"]:checked')?.closest('label') || document.querySelector('label[data-store-id]');
        if (initialLabel) {
            initialLabel.querySelector('input').checked = true;
            updateMainLocationUI(initialLabel);
        }
        variantChangeListener();
    });
</script>
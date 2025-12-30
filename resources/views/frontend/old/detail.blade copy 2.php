@extends('frontend.components.layout')

@section('content')

{{-- ... MODAL LOKASI & LIGHTBOX (Bagian ini TIDAK BERUBAH) ... --}}

<div class="modal-location fixed inset-0 bg-transparent bg-opacity-50 flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none transition-opacity duration-300"
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

        {{-- Location List --}}
        <div class="flex-grow overflow-y-auto px-5 pb-5 space-y-3">

            @forelse ($inventory_data as $data)
            @php
            $statusColor = $data['status_color_class'];
            // Jarak sudah dihitung dan diformat di Controller
            $distance = $data['distance_display'];
            @endphp
            <label class="p-4 border border-light-grey rounded-lg hover:bg-light-bg/50 transition duration-150 cursor-pointer flex items-center justify-between"
                data-store-id="{{ $data['branch_id'] }}"
                data-store-name="{{ $data['branch_name'] }}"
                data-store-full-status="{{ $data['status_label'] }}"
                data-status-color="{{ $data['status_color_class'] }}"
                data-distance-value="{{ $data['distance_value'] }}"> {{-- NILAI NUMERIK UNTUK SORTING JS --}}

                <div class="flex-grow pr-4">
                    <p class="font-bold text-dark-grey text-sm">{{ $data['branch_name'] }}</p>
                    <p class="text-xs text-dark-grey/80">{{ $data['branch_address'] }}</p>
                    <p class="text-xs text-primary font-semibold mt-1">{{ $distance }}</p> {{-- Jarak sudah ada --}}
                    <p class="text-xs {{ $statusColor }} font-semibold mt-1">
                        {{ $data['status_label'] }} ({{ $data['total_available_stock'] }} Unit)
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <input type="radio" name="selected_store"
                        value="{{ $data['branch_id'] }}"
                        data-store-distance="{{ $distance }}" {{-- NILAI TAMPILAN UNTUK JS --}}
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

<section class="container px-1 lg:px-[7%] mx-auto ">
 <meta name="csrf-token" content="{{ csrf_token() }}">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 bg-white shadow-sm mt-8 mb-8">

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
                    {{-- Product Title and Info (Primary H1 for SEO) --}}
                    {{-- GANTI: Nama Produk Dinamis --}}
                    <h1 class="text-2xl font-extrabold text-dark-grey mb-1">
                        {{ $product->name }}
                    </h1>

                    <!-- <p class="text-sm text-dark-grey/80 mb-3"> -->
                    <span class="font-bold">{{ 0 }}</span> Ulasan | variant: <span class="font-bold text-primary">{{$product->variants[0]->variant_name ?? 'Tidak Diketahui' }}</span>
                    </p>

                    {{-- GANTI: Harga Dinamis --}}
                    <p class="text-3xl font-extrabold text-primary mb-4" id="current-price">Rp {{ $product->price_formatted ?? number_format($subtotal_price, 0, ',', '.') }}</p>

                    <div class="divider h-px bg-light-grey/50 mb-4"></div>

                    {{-- Location Check --}}
                    <div class="flex items-start space-x-6 text-sm text-dark-grey/80">
                        <div class="flex flex-col space-y-1">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-map-marker-alt text-primary flex-shrink-0" aria-hidden="true"></i>
                                <span class="text-dark-grey font-semibold">Cek Lokasi Ketersediaan</span>
                            </div>
                            <div id="check-availability-button" class="cursor-pointer group" onclick="openLocationModal()">
                                <p id="current-store" class="text-sm text-primary font-bold group-hover:underline transition">
                                    Pilih Lokasi
                                </p>
                                <p id="store-status" class="text-xs text-dark-grey/80 pt-1">
                                    Produk dapat diambil atau dikirim | <a href="#" class="underline">Lihat Lokasi</a>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 flex-col items-start hidden sm:flex">

                            <div class="flex items-center space-x-2">

                                <i class="fas fa-truck text-primary" aria-hidden="true"></i>

                                <span class="text-dark-grey font-semibold">Lokasi Pengiriman</span>

                            </div>

                            <div id="shipping-address-display" class="pt-1">

                                @if(isset($customer_addresses) && count($customer_addresses) > 0)

                                @php

                                $default_address = collect($customer_addresses)->firstWhere('is_default', true) ?? $customer_addresses[0];

                                @endphp

                                <p id="current-shipping-address" class="text-xs text-dark-grey/80">

                                    Kirim ke **{{ $default_address->label }}** ({{ $default_address->street }} - {{ $default_address->city }}) |

                                    <a href="#" class="underline text-primary" onclick="event.preventDefault(); openAddressModal();">Ganti Alamat</a>

                                </p>

                                @else

                                <p class="text-xs text-primary">

                                    <a href="{{ url('login') }}" class="underline">Login</a> atau <a href="{{ url('register') }}" class="underline">Daftar</a> untuk mengatur alamat pengiriman

                                </p>

                                @endif

                            </div>

                        </div>


                    </div>


                    <div class="mt-6">
                        <div class="flex border-b border-light-grey/50 text-sm font-semibold" role="tablist">
                            <button id="tab-spesifikasi"
                                class="tab-button pb-3 border-b-2 border-primary text-primary px-4 transition duration-200"
                                data-target="content-spesifikasi"
                                role="tab"
                                aria-selected="true"
                                aria-controls="content-spesifikasi">
                                Ringkasan Produk
                            </button>
                            <button id="tab-informasi"
                                class="tab-button pb-3 text-dark-grey/80 px-4 hover:text-primary transition duration-200"
                                data-target="content-informasi"
                                role="tab"
                                aria-selected="false"
                                aria-controls="content-informasi">
                                Detail Deskripsi
                            </button>
                        </div>

                        {{-- GANTI: Konten Tab Ringkasan (Short Description) --}}
                        <div id="content-spesifikasi" class="tab-content pt-4 p-4 bg-light-bg rounded-b-lg text-sm space-y-2" role="tabpanel" aria-labelledby="tab-spesifikasi">
                            {!! $product->short_description !!}

                            {{-- Tampilkan beberapa atribut kunci jika ada --}}
                            @if (!empty($product->attributes))
                            <div class="pl-4 space-y-1 pt-2">
                                @foreach (array_slice($product->attributes, 0, 4) as $key => $value)
                                <p><i class="fas fa-circle text-xs text-light-grey mr-2" aria-hidden="true"></i> **{{ ucfirst($key) }}**: {{ $value }}</p>
                                @endforeach
                            </div>
                            @endif
                            <button class="text-primary font-semibold mt-2 hover:underline" data-target-tab="content-informasi" aria-expanded="false" aria-controls="content-informasi">Baca Deskripsi Lengkap ></button>
                        </div>

                        {{-- GANTI: Konten Tab Detail Deskripsi --}}
                        <div id="content-informasi" class="tab-content pt-4 p-4 bg-light-bg rounded-b-lg text-sm space-y-2 hidden" role="tabpanel" aria-labelledby="tab-informasi">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </div>


            {{-- 3. KOLOM ORDER SUMMARY/ACTION BUTTONS (lg:col-span-4 | Sticky) --}}
            <div class="lg:col-span-4 mt-6 lg:mt-0 lg:order-last lg:sticky lg:top-20 self-start">
                <div class="p-6 bg-white rounded-xl shadow-md border border-light-grey/50">

                    {{-- Quantity Counter & Subtotal --}}
                    <div class="mb-4">
                        <p class="text-dark-grey font-bold text-lg mb-3">Ringkasan Pesanan</p>

                        <div class="flex justify-between items-center text-xs text-dark-grey/80 space-x-2">
                            <span class="text-sm text-dark-grey font-semibold">Jumlah Produk:</span>

                            <div class="border border-light-grey rounded overflow-hidden flex ml-2">
                                {{-- Tombol Minus --}}
                                <button type="button" class="w-8 h-8 border-r border-light-grey hover:bg-light-bg text-dark-grey font-bold" id="qty-minus" aria-label="Kurangi jumlah produk">-</button>

                                {{-- GANTI: Input Number untuk QTY --}}
                                <input
                                    type="number"
                                    id="product-qty-input"
                                    value="1"
                                    min="1"
                                    max="100"
                                    class="w-12 h-8 text-center font-extrabold text-base border-none focus:ring-0 focus:outline-none p-0 text-dark-grey"
                                    role="status"
                                    aria-live="polite"
                                    aria-label="Jumlah produk yang akan dibeli">

                                {{-- Tombol Plus --}}
                                <button type="button" class="w-8 h-8 hover:bg-light-bg text-dark-grey font-bold border-l border-light-grey" id="qty-plus" aria-label="Tambah jumlah produk">+</button>
                            </div>
                        </div>

                        <div class="divider h-px bg-light-grey/50 my-4"></div>

                        <div class="flex justify-between items-center text-sm">
                            <span class="text-dark-grey font-semibold">Subtotal:</span>
                            {{-- GANTI: Subtotal Dinamis --}}
                            <span class="text-primary font-extrabold text-xl" id="subtotal-price" role="status" aria-live="polite">Rp{{ number_format($subtotal_price, 0, ',', '.') }}</span>
                        </div>
                    </div>


                    {{-- Action Buttons --}}
                    <div class="space-y-3 mb-4">
                        <button type="button" class="w-full py-3 rounded-xl bg-primary text-white font-bold text-lg hover:bg-primary-dark transition duration-150 shadow-lg shadow-primary/50">
                            <a href="{{url('checkout')}}">
                                Beli Sekarang
                            </a>
                        </button>
                        <div class="flex space-x-3">
                            <button type="button" class="w-full py-3 rounded-xl bg-white border border-primary text-primary font-bold text-lg hover:bg-light-bg transition duration-150">
                                <a href="{{url('keranjang')}}">
                                    + Keranjang
                                </a>
                            </button>
                            <button type="button" class="w-full py-3 rounded-xl bg-white border border-light-grey text-dark-grey/80 font-semibold text-lg hover:bg-light-bg transition duration-150 flex items-center justify-center space-x-2">
                                <i class="far fa-heart" aria-hidden="true"></i>
                                <span>Wishlist</span>
                            </button>
                        </div>
                    </div>

                    <div class="divider h-px bg-light-grey/50 my-4"></div>

                    <div class="flex justify-between items-center text-sm text-dark-grey/80">
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-share-alt" aria-hidden="true"></i>
                            <span>Share</span>
                        </div>
                        <span>Metode Pembayaran</span>
                    </div>

                </div>
            </div>

        </div>
        {{-- END: TATA LETAK 3 KOLOM UTAMA --}}


        {{-- Customer Reviews --}}
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Ulasan Pelanggan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-center space-x-4 p-4 border border-light-grey rounded-lg bg-light-bg/50">
                    {{-- Default rating 0/5 --}}
                    <div class="text-6xl font-extrabold text-primary">{{ $product->average_rating ?? 0 }}/5</div>
                    <div>
                        <div class="flex items-center text-yellow-500 mb-1" aria-label="Rating Bintang">
                            <span class="text-3xl" aria-hidden="true">
                                {{ str_repeat('★', floor($product->average_rating ?? 0)) . str_repeat('☆', 5 - floor($product->average_rating ?? 0)) }}
                            </span>
                        </div>
                        <p class="text-sm text-dark-grey/80">Dari 0 ulasan</p>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 p-4 border border-light-grey rounded-lg bg-light-bg/50 text-sm">
                    <p class="text-dark-grey/80">Belum ada ulasan untuk produk ini.</p>
                </div>
            </div>
        </div>


    </main>
</section>

@endsection



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Variabel Global & Elemen ---
        const locationModal = document.getElementById('location-modal');
        const selectStoreButton = document.getElementById('select-store-button');
        const currentStoreDisplay = document.getElementById('current-store');
        const storeStatusDisplay = document.getElementById('store-status');
        const storeRadioButtons = document.querySelectorAll('input[name="selected_store"]');

        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        const thumbnails = document.querySelectorAll('.thumbnail');
        const mainImage = document.getElementById('main-product-image');

        const qtyPlus = document.getElementById('qty-plus');
        const qtyMinus = document.getElementById('qty-minus');
        const productQtyInput = document.getElementById('product-qty-input');
        const subtotalPrice = document.getElementById('subtotal-price');

        // Lightbox/Modal Gambar
        const lightbox = document.getElementById('image-lightbox');
        const lightboxImage = document.getElementById('lightbox-image-content');

        // Modal Alamat Pelanggan
        const confirmAddressButton = document.getElementById('confirm-address-button');
        const customerAddressRadioButtons = document.querySelectorAll('input[name="selected_customer_address"]');

        // Tambahkan Elemen baru
        const addToCartButton = document.getElementById('add-to-cart-button');

        // --- Logika Helper ---

        /** Memperbarui gambar utama produk */
        function updateMainImage(imageUrl) {
            mainImage.style.opacity = '0';
            setTimeout(() => {
                mainImage.src = imageUrl;
                mainImage.style.opacity = '1';

                const mainImageContainer = mainImage.closest('[onclick^="openLightbox"]');
                if (mainImageContainer) {
                    // Update fungsi openLightbox pada container gambar utama
                    mainImageContainer.setAttribute('onclick', `openLightbox('${imageUrl}')`);
                }
            }, 100);
        }

        /** Memformat angka menjadi Rupiah */
        function formatRupiah(number) {
            const cleanNumber = parseInt(number);
            if (isNaN(cleanNumber)) return 'Rp0';
            return 'Rp' + cleanNumber.toLocaleString('id-ID');
        }

        /** Mengupdate total harga dan kuantitas */
        function updateSubtotal(currentQty) {
            let finalQty = parseInt(currentQty) || 1;
            if (finalQty < 1) finalQty = 1;

            productQtyInput.value = finalQty;

            const basePriceTextElement = document.getElementById('current-price');
            const basePriceText = basePriceTextElement ? basePriceTextElement.textContent.replace('Rp', '').replace(/\./g, '') : '0';
            const basePrice = parseInt(basePriceText) || 0;

            subtotalPrice.textContent = formatRupiah(finalQty * basePrice);
        }


        // --- Logika Input QTY (Sudah Berjalan Baik) ---
        if (productQtyInput) {
            productQtyInput.addEventListener('change', function() {
                let val = parseInt(this.value);
                if (isNaN(val) || val < 1) {
                    val = 1;
                } else if (val > 100) {
                    val = 100;
                }
                updateSubtotal(val);
            });

            productQtyInput.addEventListener('keyup', function() {
                updateSubtotal(this.value);
            });
        }

        if (qtyPlus && productQtyInput) {
            qtyPlus.addEventListener('click', function() {
                let currentQty = parseInt(productQtyInput.value);
                if (currentQty < 100) {
                    currentQty++;
                    updateSubtotal(currentQty);
                }
            });
        }

        if (qtyMinus && productQtyInput) {
            qtyMinus.addEventListener('click', function() {
                let currentQty = parseInt(productQtyInput.value);
                if (currentQty > 1) {
                    currentQty--;
                    updateSubtotal(currentQty);
                }
            });
        }
        updateSubtotal(productQtyInput.value);


        // --- Logika Image Lightbox/Popup (DIPERBAIKI) ---

        /** Membuka Lightbox */
        window.openLightbox = function(imageUrl) {
            if (!lightbox || !lightboxImage) return;
            lightboxImage.src = imageUrl;
            lightbox.classList.remove('pointer-events-none', 'opacity-0');
            lightbox.classList.add('opacity-100');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            lightbox.focus();
        }

        /** Menutup Lightbox */
        window.closeLightbox = function() {
            if (!lightbox) return;
            lightbox.classList.remove('opacity-100');
            lightbox.classList.add('opacity-0', 'pointer-events-none');
            lightbox.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        // Listener untuk tombol Escape pada Lightbox
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && lightbox && !lightbox.classList.contains('pointer-events-none')) {
                closeLightbox();
            }
        });

        // Listener untuk klik di luar gambar pada Lightbox
        if (lightbox) {
            lightbox.addEventListener('click', function(e) {
                if (e.target.id === 'image-lightbox' || e.target.classList.contains('close-lightbox-button')) {
                    closeLightbox();
                }
            });
        }


        // --- Logika Galeri Thumbnail (DIPERBAIKI) ---

        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const imageUrl = this.getAttribute('data-image');

                // Hapus border dari semua thumbnail
                thumbnails.forEach(t => {
                    t.classList.remove('border-primary', 'border-2');
                    t.classList.add('border-light-grey', 'border');
                });

                // Tambahkan border pada thumbnail yang dipilih
                this.classList.add('border-primary', 'border-2');
                this.classList.remove('border-light-grey', 'border');

                // Update gambar utama
                updateMainImage(imageUrl);
            });

            // Tambahkan fungsionalitas keyboard
            thumb.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });


        // --- Logika Modal Lokasi (Global & Ditingkatkan) ---

        // Fungsi Modal Visibility (Global)
        window.openLocationModal = function() {
            if (!locationModal) return;
            locationModal.classList.remove('pointer-events-none', 'opacity-0');
            locationModal.classList.add('opacity-100');
            locationModal.querySelector('[role="document"]').classList.remove('scale-95');
            locationModal.querySelector('[role="document"]').classList.add('scale-100');
            document.body.style.overflow = 'hidden';

            // Panggil fungsi untuk sorting dan memilih yang terdekat saat modal dibuka
            sortAndHighlightClosestStore();
        }

        window.closeLocationModal = function() {
            if (!locationModal) return;
            locationModal.classList.remove('opacity-100');
            locationModal.classList.add('opacity-0');
            locationModal.querySelector('[role="document"]').classList.remove('scale-100');
            locationModal.querySelector('[role="document"]').classList.add('scale-95');

            setTimeout(() => {
                locationModal.classList.add('pointer-events-none');
                document.body.style.overflow = '';
            }, 300);
        }

        /**
         * Menggunakan data-distance-value (numerik) untuk memastikan
         * toko terdekat muncul paling atas dan dipilih secara default
         */
        function sortAndHighlightClosestStore() {
            const tabStoreList = document.getElementById('tab-store-list');
            const locationListContainer = tabStoreList ? tabStoreList.querySelector('.flex-grow.overflow-y-auto') : null;

            if (!locationListContainer) {
                selectStoreButton.disabled = true;
                selectStoreButton.classList.add('opacity-50', 'cursor-not-allowed');
                return;
            }

            const labels = Array.from(locationListContainer.querySelectorAll('label[data-store-id]'));

            if (labels.length === 0) {
                selectStoreButton.disabled = true;
                selectStoreButton.classList.add('opacity-50', 'cursor-not-allowed');
                return;
            }

            // 1. Sortir berdasarkan jarak (nilai numerik)
            labels.sort((a, b) => {
                const distA = parseFloat(a.dataset.distanceValue) || Infinity;
                const distB = parseFloat(b.dataset.distanceValue) || Infinity;
                return distA - distB;
            });

            // 2. Clear container
            locationListContainer.innerHTML = '';

            let firstRadio = null;

            // 3. Masukkan kembali yang sudah disortir, tambahkan label 'Terdekat', dan pilih radio button yang pertama
            labels.forEach((label, index) => {
                // Hapus label terdekat sebelumnya
                let closestSpan = label.querySelector('.closest-badge');
                if (closestSpan) closestSpan.remove();

                const radio = label.querySelector('input[name="selected_store"]');
                const nameParagraph = label.querySelector('p:first-child');

                if (index === 0 && radio) {
                    // Tambahkan badge 'Terdekat'
                    if (nameParagraph) {
                        const newSpan = document.createElement('span');
                        newSpan.className = 'closest-badge ml-2 px-2 py-0.5 text-xs font-semibold bg-primary text-white rounded-full';
                        newSpan.textContent = 'Terdekat';
                        nameParagraph.appendChild(newSpan);
                    }

                    // Set radio button pertama sebagai terpilih
                    radio.checked = true;
                    firstRadio = radio;

                } else if (nameParagraph) {
                    // Hapus badge jika bukan yang pertama
                    const existingBadge = nameParagraph.querySelector('.closest-badge');
                    if (existingBadge) existingBadge.remove();
                    // Pastikan radio button lainnya tidak terpilih
                    if (radio) radio.checked = false;
                }

                locationListContainer.appendChild(label);
            });

            // 4. Inisialisasi tombol "Pilih"
            if (firstRadio) {
                selectStoreButton.disabled = false;
                selectStoreButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                selectStoreButton.disabled = true;
                selectStoreButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }


        // --- Event Listeners Logika Lokasi ---

        // Radio button cabang
        storeRadioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    selectStoreButton.disabled = false;
                    selectStoreButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            });
        });

        // Tombol Pilih Toko
        if (selectStoreButton) {
            selectStoreButton.addEventListener('click', function() {
                const selectedRadio = document.querySelector('input[name="selected_store"]:checked');
                if (selectedRadio) {
                    const label = selectedRadio.closest('label');
                    const storeName = label.dataset.storeName;
                    const storeStatus = selectedRadio.dataset.storeFullStatus;
                    const distanceDisplay = selectedRadio.dataset.storeDistance;
                    const statusColorClass = label.dataset.statusColor;

                    // Update UI utama
                    currentStoreDisplay.innerHTML = `<span class="${statusColorClass} font-bold">${storeStatus}</span> di ${storeName}`;

                    const distanceText = distanceDisplay !== 'N/A' ?
                        `${distanceDisplay} dari lokasi Anda` :
                        'Produk dapat diambil atau dikirim';

                    storeStatusDisplay.innerHTML = `${distanceText} | <a href="#" class="underline" onclick="event.preventDefault(); openLocationModal();">Ubah Lokasi</a>`;

                    storeStatusDisplay.className = 'text-xs pt-1 text-dark-grey/80';
                    closeLocationModal();
                }
            });
        }

        // Event listener untuk menutup modal ketika klik di luar area modal atau tombol Escape
        if (locationModal) {
            locationModal.addEventListener('click', function(e) {
                if (e.target.id === 'location-modal') {
                    closeLocationModal();
                }
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !locationModal.classList.contains('pointer-events-none')) {
                    closeLocationModal();
                }
            });
        }


        // --- Logika Inisialisasi Tampilan Lokasi Utama ---

        function initializeMainLocationDisplay() {
            // Kita ambil label pertama, yang sudah disortir dan merupakan toko terdekat di Controller
            const firstLabel = document.querySelector('label[data-store-id]');

            if (firstLabel) {
                const storeName = firstLabel.dataset.storeName;
                const storeStatus = firstLabel.dataset.storeFullStatus;
                const statusColorClass = firstLabel.dataset.statusColor;

                // Ambil jarak dari radio button di dalam label pertama
                const firstRadio = firstLabel.querySelector('input[name="selected_store"]');
                const distanceDisplay = firstRadio ? firstRadio.dataset.storeDistance : 'N/A';

                // Update UI utama
                currentStoreDisplay.innerHTML = `<span class="${statusColorClass} font-bold">${storeStatus}</span> di ${storeName}`;

                const distanceText = distanceDisplay !== 'N/A' ?
                    `${distanceDisplay} dari lokasi Anda` :
                    'Produk dapat diambil atau dikirim';

                storeStatusDisplay.innerHTML = `${distanceText} | <a href="#" class="underline" onclick="event.preventDefault(); openLocationModal();">Ubah Lokasi</a>`;
                storeStatusDisplay.className = 'text-xs pt-1 text-dark-grey/80';
            }
        }

        initializeMainLocationDisplay();


        // --- Logika Tabs ---
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');

                tabButtons.forEach(btn => {
                    btn.classList.remove('border-primary', 'text-primary');
                    btn.classList.add('text-dark-grey/80');
                    btn.style.borderBottomWidth = '0px';
                    btn.setAttribute('aria-selected', 'false');
                });

                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                this.classList.add('border-primary', 'text-primary');
                this.classList.remove('text-dark-grey/80');
                this.style.borderBottomWidth = '2px';
                this.setAttribute('aria-selected', 'true');

                document.getElementById(targetId).classList.remove('hidden');

                // Jika pindah ke tab store list, panggil sorting lagi
                if (targetId === 'tab-store-list') {
                    sortAndHighlightClosestStore();
                }
            });
        });

        const readMoreButton = document.querySelector('[data-target-tab]');
        if (readMoreButton) {
            readMoreButton.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-target-tab');
                const targetButton = document.querySelector(`[data-target="${targetId}"]`);
                if (targetButton) {
                    targetButton.click();
                }
            });
        }

        // --- BARU: Logika Modal Alamat Pelanggan ---

        // Event listener untuk radio buttons alamat
        customerAddressRadioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    confirmAddressButton.disabled = false;
                    confirmAddressButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            });
        });

        // Tombol Konfirmasi Alamat (SIMULASI/AJAX TRIGGER)
        if (confirmAddressButton) {
            confirmAddressButton.addEventListener('click', function() {
                const selectedAddressRadio = document.querySelector('input[name="selected_customer_address"]:checked');
                if (selectedAddressRadio) {
                    const lat = selectedAddressRadio.dataset.lat;
                    const lon = selectedAddressRadio.dataset.lon;

                    // *SIMULASI PENGGANTIAN ALAMAT*
                    // Jika Anda ingin ini memicu perhitungan ulang Jarak Haversine di backend
                    // Anda harus mengirimkan lat/lon ini melalui AJAX ke endpoint controller/API.

                    // Untuk saat ini, kita hanya melakukan simulasi dengan beralih tab.
                    console.log(`Alamat baru dipilih: LAT ${lat}, LON ${lon}. Perlu hitung ulang jarak di server.`);

                    // Ganti ke tab daftar toko
                    const storeListTabButton = document.querySelector('[data-target="tab-store-list"]');
                    if (storeListTabButton) {
                        storeListTabButton.click();
                        // Asumsi: Jika AJAX berhasil, storeList akan di-render ulang
                    }
                }
            });
        }

        // --- Logika Add to Cart (AJAX) ---
        if (addToCartButton) {
            addToCartButton.addEventListener('click', function(e) {
                e.preventDefault();

                // Ambil data yang dibutuhkan
                const quantity = parseInt(productQtyInput.value) || 1;

                // Ambil ID Cabang yang sedang dipilih (Perlu diperbaiki di HTML/Modal agar ID tersedia)
                // ASUMSI: Anda menyimpan ID Cabang di elemen UI utama, atau mengambil dari selected radio button terakhir.
                // Untuk saat ini, kita akan ambil dari radio button yang ter-check di modal, jika modal dibuka.
                // Jika tidak, kita harus mengambil ID dari suatu tempat di DOM utama.

                const selectedStoreRadio = document.querySelector('input[name="selected_store"]:checked');
                const branchId = selectedStoreRadio ? selectedStoreRadio.value : null;

                // ASUMSI: Anda harus mendapatkan ID Varian Produk dari suatu elemen input tersembunyi/data atribut
                const productVariantId = document.getElementById('product-variant-id').value; // Ganti dengan ID elemen yang benar

                if (!branchId) {
                    alert('Silakan pilih lokasi toko/cabang terlebih dahulu.');
                    return;
                }

                if (!productVariantId) {
                    alert('Data produk tidak lengkap (Varian ID hilang).');
                    return;
                }

                // Tampilkan loading state jika perlu
                addToCartButton.textContent = 'Memproses...';
                addToCartButton.disabled = true;

                fetch('{{ route('cart.add') }}', { // Ganti dengan URL yang benar jika bukan Blade
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Penting untuk Laravel
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
                            alert(data.message);
                            // Opsional: Update jumlah keranjang di header
                            // document.getElementById('cart-count').textContent = data.cart_count; 
                        } else {
                            alert('Gagal: ' + (data.message || 'Terjadi kesalahan server.'));
                            console.error(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan koneksi.');
                    })
                    .finally(() => {
                        // Kembalikan tombol ke kondisi awal
                        addToCartButton.textContent = 'Masukkan ke Keranjang';
                        addToCartButton.disabled = false;
                    });
            });
        }

    });
</script>
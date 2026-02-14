@extends('frontend.components.layout')

@section('content')

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

            @php
            
            $locations = [
            ['name' => 'INFORMA Pondok Indah', 'address' => 'Jl. Sultan Iskandar Muda no 19 Arteri Pondok Indah 12240', 'distance' => '1.84 km', 'status' => 'Tersedia', 'color' => 'text-green-600'],
            ['name' => 'INFORMA Living Plaza Palem Semi', 'address' => 'Jl. Palem Raja Raya, RT.001/RW.009, Bencongan Indah, Kec. Klp. Dua, Kota Tangerang, Banten', 'distance' => '19.88 km', 'status' => 'Tersedia', 'color' => 'text-green-600'],
            ['name' => 'INFORMA Grand Metropolitan', 'address' => 'MALL GRAND METROPOLITAN LANTAI 1, Jl. K.H. Noer Ali RT.007/RW.003, Pekayon Jaya, Kec. Bekasi Selatan, Kota Bekasi, Jawa Barat 17148', 'distance' => '22.15 km', 'status' => 'Tersedia', 'color' => 'text-green-600'],
            ['name' => 'INFORMA Aeon Mall BSD', 'address' => 'AEON Mall BSD City Lantai 3, Jl. BSD Raya Utama, Pagedangan, Tangerang, Banten 15339', 'distance' => '25.50 km', 'status' => 'Terbatas', 'color' => 'text-orange-500'],
            ['name' => 'INFORMA Cihampelas Walk', 'address' => 'Cihampelas Walk Cihampelas Walk Lantai LG, Jl. Cihampelas No.160, Bandung', 'distance' => '150.00 km', 'status' => 'Tidak Tersedia', 'color' => 'text-red-600'],
            ];
            @endphp

            @foreach ($locations as $location)
            <label class="p-4 border border-light-grey rounded-lg hover:bg-light-bg/50 transition duration-150 cursor-pointer flex items-center justify-between"
                data-store-name="{{ $location['name'] }}"
                data-store-status="{{ $location['status'] }}"
                data-status-color="{{ $location['color'] }}"> {{-- Tambahkan data status --}}
                <div class="flex-grow pr-4">
                    <p class="font-bold text-dark-grey text-sm">{{ $location['name'] }}</p>
                    <p class="text-xs text-dark-grey/80">{{ $location['address'] }}</p>
                    <p class="text-xs text-primary font-semibold mt-1">{{ $location['distance'] }}</p>
                    <p class="text-xs {{ $location['color'] }} font-semibold mt-1" data-status-text>{{ $location['status'] }}</p> {{-- Tampilkan status --}}
                </div>
                <div class="flex-shrink-0">
                    <input type="radio" name="selected_store" value="{{ $location['name'] }}" data-store-distance="{{ $location['distance'] }}" data-store-full-status="{{ $location['status'] }}" class="text-primary focus:ring-primary h-4 w-4 border-light-grey">
                </div>
            </label>
            @endforeach

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


<section class="container px-1 lg:px-[7%] mx-auto ">

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 bg-white shadow-sm mt-8 mb-8">

        <div>
            {{-- Mengganti h1 di sini dengan nama produk sebagai h1 utama di bawah untuk SEO yang lebih baik --}}
            <h2 class="text-xl font-extrabold text-dark-grey mb-6">Detail Produk</h2>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-8">

            <div class="lg:col-span-7 space-y-4">
                {{-- Product Image Gallery --}}
                <div class="flex flex-col space-y-4">
                    {{-- Main Image Area --}}
                    <div class="flex-grow">
                        <div class="w-full aspect-square bg-light-bg rounded-lg shadow-md flex items-center justify-center overflow-hidden">
                            <img id="main-product-image"
                                src="https://image1ws.indotrading.com/s3/productimages/webp/co228746/p778217/w600-h600/385b7c34-ae39-462c-b059-a3f2b9122566.png"
                                alt="Informa Carson Sofa Bed Moduler Sudut Fabric Kiri - Abu-abu"
                                class="object-cover w-full h-full transition-opacity duration-300">
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <div class=" flex space-x-2 overflow-x-auto w-full pb-1">
                            <div class="thumbnail flex-shrink-0 w-16 h-16 bg-light-bg border-2 border-primary rounded-lg cursor-pointer flex items-center justify-center"
                                data-image="https://image1ws.indotrading.com/s3/productimages/webp/co228746/p778217/w600-h600/385b7c34-ae39-462c-b059-a3f2b9122566.png"
                                tabindex="0" role="button" aria-label="Gambar Produk 1: Sofa Bed Moduler Kiri">
                                <span class="text-xs text-light-grey">Gbr 1</span>
                            </div>
                            <div class="thumbnail flex-shrink-0 w-16 h-16 bg-light-bg border border-light-grey rounded-lg cursor-pointer flex items-center justify-center"
                                data-image="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSV_4jimNfbjtF9fOFwBQKsuUMly0IF6-L3NA&s"
                                tabindex="0" role="button" aria-label="Gambar Produk 2: Detail Sandaran">
                                <span class="text-xs text-light-grey">Gbr 2</span>
                            </div>
                            <div class="thumbnail flex-shrink-0 w-16 h-16 bg-light-bg border border-light-grey rounded-lg cursor-pointer flex items-center justify-center"
                                data-image="https://image1ws.indotrading.com/s3/productimages/webp/co228746/p778217/w600-h600/65a1dec1-58a1-4cfb-94bd-26454d0750ec.png"
                                tabindex="0" role="button" aria-label="Gambar Produk 3: Sofa Dalam Mode Tidur">
                                <span class="text-xs text-light-grey">Gbr 3</span>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="p-0 sm:p-4">
                    {{-- Product Title and Info (Primary H1 for SEO) --}}
                    <h1 class="text-2xl font-extrabold text-dark-grey mb-1">
                        Kedai Steel Door Motif Kayu
                    </h1>
                    <p class="text-sm text-dark-grey/80 mb-3">
                        <span class="font-bold">1</span> Ulasan | Brand: <span class="font-bold text-primary">Kedai Steel Door</span>
                    </p>

                    <p class="text-3xl font-extrabold text-primary mb-2" id="current-price">Rp450.000</p>


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
                            <p class="text-xs text-primary pt-1">Cek estimasi pengiriman ke | <a href="#" class="underline">Atur Alamat</a></p>
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
                                Spesifikasi Produk
                            </button>
                            <button id="tab-informasi"
                                class="tab-button pb-3 text-dark-grey/80 px-4 hover:text-primary transition duration-200"
                                data-target="content-informasi"
                                role="tab"
                                aria-selected="false"
                                aria-controls="content-informasi">
                                Informasi Produk
                            </button>
                        </div>

                        <div id="content-spesifikasi" class="tab-content pt-4 p-4 bg-light-bg rounded-b-lg text-sm space-y-2" role="tabpanel" aria-labelledby="tab-spesifikasi">
                            <div class="flex items-center space-x-2 text-primary font-semibold">
                                <i class="fas fa-check-circle" aria-hidden="true"></i>
                                <span>Anti Rayap & Tahan Cuaca | Keamanan Maksimal</span>
                            </div>
                            <div class="pl-4 space-y-1">
                                <p><i class="fas fa-circle text-xs text-light-grey mr-2" aria-hidden="true"></i> Material utama: **Plat Baja (Steel)**</p>
                                <p><i class="fas fa-circle text-xs text-light-grey mr-2" aria-hidden="true"></i> Finishing: **Wood Grain / Motif Kayu (Powder Coating)**</p>
                                <p><i class="fas fa-circle text-xs text-light-grey mr-2" aria-hidden="true"></i> Ketebalan plat daun pintu: **0.6 mm**</p>
                                <p><i class="fas fa-circle text-xs text-light-grey mr-2" aria-hidden="true"></i> Sistem pengunci: **Multi-Point Lock System**</p>
                                <p><i class="fas fa-circle text-xs text-light-grey mr-2" aria-hidden="true"></i> Tahan benturan dan tidak memuai</p>
                                <p><i class="fas fa-circle text-xs text-light-grey mr-2" aria-hidden="true"></i> Desain elegan menyerupai kayu asli</p>
                            </div>
                            <button class="text-primary font-semibold mt-2 hover:underline" aria-expanded="false" aria-controls="full-spesifikasi-details">Baca Selengkapnya ></button>
                        </div>

                        <div id="content-informasi" class="tab-content pt-4 p-4 bg-light-bg rounded-b-lg text-sm space-y-2 hidden" role="tabpanel" aria-labelledby="tab-informasi">
                            <h4 class="font-bold text-lg mb-2">Informasi Lainnya</h4>
                            <p>Pintu Baja Motif Kayu adalah solusi modern yang menggabungkan kekuatan baja dengan keindahan estetika serat kayu. Dilengkapi sistem keamanan yang canggih.</p>
                            <ul class="list-disc list-inside pl-4 text-dark-grey/80">
                                <li>Pemasangan mudah dan cepat (Knock Down)</li>
                                <li>Dilengkapi kusen baja yang menyatu</li>
                                <li>Perawatan minim, cukup dilap</li>
                                <li>Tersedia untuk ukuran standar (Single/Double Door)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Order Summary/Action Buttons (Made sticky on large screens) --}}
            <div class="lg:col-span-5 mt-6 lg:mt-0 lg:order-last lg:sticky lg:top-10 self-start">
                <div class="p-6 bg-white rounded-xl shadow-md border border-light-grey/50"> {{-- Rounded-xl untuk konsistensi --}}

                    {{-- Quantity Counter & Subtotal --}}
                    <div class="flex justify-end items-center text-xs text-dark-grey/80 mb-4 space-x-2">
                        <span class="hidden md:inline">Atur Jumlah</span>

                        <div class="border border-light-grey rounded overflow-hidden flex ml-2">
                            <button type="button" class="w-6 h-6 border-r border-light-grey hover:bg-light-bg text-dark-grey" id="qty-minus" aria-label="Kurangi jumlah produk">-</button>
                            <span class="w-6 h-6 flex items-center justify-center font-bold text-sm" id="product-qty" role="status" aria-live="polite">1</span>
                            <button type="button" class="w-6 h-6 hover:bg-light-bg text-dark-grey font-bold" id="qty-plus" aria-label="Tambah jumlah produk">+</button>
                        </div>

                        <span class="ml-4 hidden md:inline">Subtotal Pembelian:</span>
                        <span class="text-primary font-extrabold text-lg ml-2" id="subtotal-price" role="status" aria-live="polite">Rp450.000</span>
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

        {{-- Customer Reviews --}}
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Ulasan Pelanggan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-center space-x-4 p-4 border border-light-grey rounded-lg bg-light-bg/50">
                    <div class="text-6xl font-extrabold text-primary">5/5</div>
                    <div>
                        <div class="flex items-center text-yellow-500 mb-1" aria-label="Rating Bintang 5">
                            <span class="text-3xl" aria-hidden="true">★★★★★</span>
                        </div>
                        <p class="text-sm text-dark-grey/80">
                            **100%** pelanggan puas | <span class="font-bold">1</span> Ulasan
                        </p>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 p-4 border border-light-grey rounded-lg bg-light-bg/50 text-sm">
                    <div class="space-y-1">
                        @for ($i = 5; $i >= 1; $i--)
                        @php
                        $rating_count = $i == 5 ? 1 : 0;
                        $percentage = $i == 5 ? 100 : 0;
                        @endphp
                        <div class="flex items-center space-x-2">
                            <span class="w-2 font-semibold">{{ $i }}</span>
                            <span class="text-yellow-500" aria-hidden="true">★</span>
                            <div class="w-full bg-light-grey h-2 rounded-full">
                                <div class="bg-primary h-2 rounded-full"></div>
                            </div>
                            <span class="w-4 text-right">{{ $rating_count }}</span>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>


        {{-- Related Products --}}
        <div class="mt-12">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-dark-grey">Produk yang Mungkin Kamu Suka</h2>
                <a href="#" class="text-primary text-sm font-semibold">Lihat Semua ></a>
            </div>
            <p class="text-sm text-dark-grey/80 mb-4">Direkomendasikan berdasarkan produk terbaru, harga terendah pada halaman detail produk</p>
            @php
            // Data produk
            $products_data = [
            ['id' => 'P001', 'name' => 'Panel Ceiling 3d pu 4@1.5x', 'price' => 120000, 'category' => 'Dekoratif / Arsitektural', 'rating' => 4.8, 'ulasan' => 10, 'stok' => 'Tersedia', 'url_img' => asset('/asset/produk/ceiling 3d pu 4@1.5x.png')],
            ['id' => 'P002', 'name' => 'Louvre Vent 100', 'price' => 85000, 'category' => 'Dekoratif / Arsitektural', 'rating' => 4.5, 'ulasan' => 15, 'stok' => 'Tersedia', 'url_img' => asset('/asset/produk/Louvre.png')],
            ['id' => 'P003', 'name' => 'Pintu Steel Door Motif Kayu', 'price' => 450000, 'category' => 'Dekoratif / Arsitektural', 'rating' => 4.0, 'ulasan' => 3, 'stok' => 'Terbatas', 'url_img' => 'https://image1ws.indotrading.com/s3/productimages/webp/co228746/p778244/w300-h300/fe89573f-0209-4c1b-8899-94e65e2fa858.png'],
            ['id' => 'P101', 'name' => 'Genteng Metal Roof', 'price' => 220000, 'category' => 'Roofing & Walling', 'rating' => 4.9, 'ulasan' => 200, 'stok' => 'Tersedia', 'url_img' => 'https://agenbajaringan.com/img/genteng-metal.png'],
            ['id' => 'P102', 'name' => 'Kanal C75 baja ringan', 'price' => 75000, 'category' => 'Dekoratif & Arsitektural', 'rating' => 4.2, 'ulasan' => 58, 'stok' => 'Tersedia', 'url_img' => asset('/asset/produk/1. Kanal C75-1.png')],
            ['id' => 'P201', 'name' => 'Reng Asimetris', 'price' => 45000, 'category' => 'Kerangka Green House', 'rating' => 3.5, 'ulasan' => 1, 'stok' => 'Tersedia', 'url_img' => asset('/asset/produk/reng-asimetris-1.jpg')],
            ];

            $products = array_map(function($product) {
            $price_int = $product['price'];
            $old_price_int = round($price_int / 0.8, -3);

            $product['price'] = number_format($price_int, 0, ',', '.');
            $product['old_price'] = number_format($old_price_int, 0, ',', '.');
            return $product;
            }, $products_data);
            @endphp

            <div class="flex overflow-x-scroll space-x-4 pb-4">
                @foreach ($products as $product)
                <div
                    class="flex-shrink-0 w-40 sm:w-48 bg-white p-3 rounded-lg shadow-sm border border-light-grey/50 hover:shadow-md transition duration-200 cursor-pointer">
                    <div class="relative">
                        <div class="w-full aspect-square bg-light-bg mb-2 rounded-md overflow-hidden">
                            <img
                                src="{{ $product['url_img'] }}"
                                alt="{{ $product['name'] }}"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                        </div>
                        <div
                            class="absolute top-2 right-2 {{ $product['stok'] == 'Tersedia' ? 'bg-primary' : 'bg-discount' }} text-white text-xs font-bold px-2 py-1 rounded">
                            {{ $product['stok'] == 'Tersedia' ? 'Stok Tersedia' : 'Stok Terbatas' }}
                        </div>
                    </div>
                    <div class="p-1">
                        <p class="text-xs text-dark-grey/80 truncate mb-1">{{ $product['category'] }}</p>
                        <p
                            class="text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                            {{ $product['name'] }}
                        </p>

                        <p class="text-xs text-light-grey line-through mt-2">Rp{{ $product['old_price'] }}</p>
                        <p class="text-base font-bold text-discount">Rp{{ $product['price'] }}</p>

                        <div class="flex items-center text-xs text-dark-grey mt-2" aria-label="Rating {{ $product['rating'] }}">
                            <span class="text-primary" aria-hidden="true">★</span><span class="ml-1">{{ $product['rating'] }}</span><span
                                class="ml-2 text-dark-grey">| {{ $product['ulasan'] }} (ulasan)</span>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="flex-shrink-0 w-8 h-full flex items-center justify-center">
                    <i class="fas fa-chevron-right text-dark-grey/50" aria-hidden="true"></i>
                </div>
            </div>
        </div>

    </main>
</section>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const locationModal = document.getElementById('location-modal');
        if (!locationModal) return;

        const modalContent = locationModal.querySelector('[role="document"]');
        const selectStoreButton = document.getElementById('select-store-button');
        const currentStoreDisplay = document.getElementById('current-store');
        const storeStatusDisplay = document.getElementById('store-status');
        const radioButtons = document.querySelectorAll('input[name="selected_store"]');

        const defaultStoreText = 'Pilih Lokasi';
        const defaultStatusText = 'Produk dapat diambil atau dikirim | <a href="#" class="underline">Lihat Lokasi</a>';

        // PENTING: Mendefinisikan fungsi global agar bisa dipanggil oleh onclick="openLocationModal()" di HTML
        window.openLocationModal = function() {
            locationModal.classList.remove('pointer-events-none', 'opacity-0');
            locationModal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
            document.body.style.overflow = 'hidden';
            // Set fokus ke elemen yang dapat ditutup, misalnya tombol tutup
            locationModal.querySelector('button[aria-label="Tutup Modal Lokasi"]').focus();
        }

        window.closeLocationModal = function() {
            locationModal.classList.remove('opacity-100');
            locationModal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');

            setTimeout(() => {
                locationModal.classList.add('pointer-events-none');
                document.body.style.overflow = '';
            }, 300);
        }

        window.resetStoreSelection = function() {
            // Uncheck semua radio
            radioButtons.forEach(radio => {
                radio.checked = false;
            });
            // Reset tampilan di halaman utama
            if (currentStoreDisplay) currentStoreDisplay.textContent = defaultStoreText;
            if (storeStatusDisplay) {
                storeStatusDisplay.innerHTML = defaultStatusText;
                storeStatusDisplay.classList.remove('text-green-600', 'text-orange-500', 'text-red-600');
                storeStatusDisplay.classList.add('text-dark-grey/80');
            }
            // Nonaktifkan tombol pilih
            selectStoreButton.disabled = true;
            selectStoreButton.classList.add('opacity-50', 'cursor-not-allowed');
        }

        // Logika untuk mengaktifkan tombol 'Pilih'
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    selectStoreButton.disabled = false;
                    selectStoreButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            });
        });

        // Aksi saat tombol 'Pilih' diklik
        if (selectStoreButton) {
            selectStoreButton.addEventListener('click', function() {
                const selectedRadio = document.querySelector('input[name="selected_store"]:checked');
                if (selectedRadio) {
                    const storeName = selectedRadio.value;
                    const distance = selectedRadio.getAttribute('data-store-distance');
                    const status = selectedRadio.getAttribute('data-store-full-status');

                    // Ambil warna dari elemen parent (label) yang memiliki data-status-color
                    const storeDiv = selectedRadio.closest('[data-store-name]');
                    const statusColor = storeDiv ? storeDiv.getAttribute('data-status-color') : 'text-dark-grey/80';

                    if (currentStoreDisplay) currentStoreDisplay.textContent = storeName;
                    if (storeStatusDisplay) {
                        storeStatusDisplay.innerHTML = `${status} (${distance}) | <a href="#" class="underline" onclick="openLocationModal()">Ubah Lokasi</a>`;

                        // Hapus semua kelas status dan tambahkan kelas status yang sesuai
                        storeStatusDisplay.classList.remove('text-dark-grey/80', 'text-green-600', 'text-orange-500', 'text-red-600');
                        storeStatusDisplay.classList.add(statusColor.replace('text-', 'text-')); // Tambahkan kelas warna dari data atribut
                    }

                    closeLocationModal();
                }
            });
        }


        // Menutup modal jika klik di luar area modal
        locationModal.addEventListener('click', function(e) {
            if (e.target.id === 'location-modal') {
                closeLocationModal();
            }
        });

        // Menutup modal dengan tombol ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !locationModal.classList.contains('pointer-events-none')) {
                closeLocationModal();
            }
        });

        // --- Logika Tabs ---
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');

                tabButtons.forEach(btn => {
                    btn.classList.remove('border-primary', 'text-primary');
                    btn.classList.add('text-dark-grey/80');
                    btn.style.borderBottomWidth = '0px';
                    btn.setAttribute('aria-selected', 'false'); // A11y
                });

                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                this.classList.add('border-primary', 'text-primary');
                this.classList.remove('text-dark-grey/80');
                this.style.borderBottomWidth = '2px';
                this.setAttribute('aria-selected', 'true'); // A11y

                document.getElementById(targetId).classList.remove('hidden');
            });
        });

        // --- Logika Galeri Thumbnail ---
        const thumbnails = document.querySelectorAll('.thumbnail');
        const mainImage = document.getElementById('main-product-image');

        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                // ... (Logika yang sama, dipertahankan) ...
                const imageUrl = this.getAttribute('data-image');

                thumbnails.forEach(t => {
                    t.classList.remove('border-primary', 'border-2');
                    t.classList.add('border-light-grey', 'border');
                });

                this.classList.add('border-primary', 'border-2');
                this.classList.remove('border-light-grey', 'border');

                // Fade out, change src, fade in
                mainImage.style.opacity = '0';
                setTimeout(() => {
                    mainImage.src = imageUrl;
                    mainImage.style.opacity = '1';
                }, 100);
            });
            // Tambahkan event keydown untuk aksesibilitas (Enter/Space)
            thumb.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });

        // --- Logika Quantity Counter ---
        const qtyPlus = document.getElementById('qty-plus');
        const qtyMinus = document.getElementById('qty-minus');
        const productQtyElement = document.getElementById('product-qty');
        const subtotalPrice = document.getElementById('subtotal-price');
        // Ambil harga dari teks elemen dan konversi ke integer (Rp450.000 -> 11999000)
        const basePriceText = document.getElementById('current-price').textContent.replace('Rp', '').replace(/\./g, '');
        const basePrice = parseInt(basePriceText) || 11999000;

        function formatRupiah(number) {
            return 'Rp' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updateSubtotal(currentQty) {
            // Update nilai di elemen span jumlah di sebelah kanan
            document.querySelector('.space-x-2 > span.text-sm.font-bold').textContent = currentQty;
            productQtyElement.textContent = currentQty;
            subtotalPrice.textContent = formatRupiah(currentQty * basePrice);
        }

        if (qtyPlus) {
            qtyPlus.addEventListener('click', function() {
                let currentQty = parseInt(productQtyElement.textContent);
                if (currentQty < 10) { // Batas maksimal 10
                    currentQty++;
                    updateSubtotal(currentQty);
                }
            });
        }

        if (qtyMinus) {
            qtyMinus.addEventListener('click', function() {
                let currentQty = parseInt(productQtyElement.textContent);
                if (currentQty > 1) {
                    currentQty--;
                    updateSubtotal(currentQty);
                }
            });
        }
    });
</script>
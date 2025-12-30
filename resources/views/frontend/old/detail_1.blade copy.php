@extends('frontend.components.layout')

@section('content')

{{-- ... MODAL LOKASI & LIGHTBOX (Bagian ini TIDAK BERUBAH) ... --}}

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

            {{-- Ambil data dari Controller: $inventory_data --}}
            @if (isset($inventory_data) && count($inventory_data) > 0)
                @foreach ($inventory_data as $data)
                    @php
                        // Tentukan warna berdasarkan status_label dari Controller
                        $statusColor = 'text-red-600';
                        if ($data['status_label'] === 'Stok Banyak') {
                            $statusColor = 'text-green-600';
                        } elseif ($data['status_label'] === 'Stok Terbatas') {
                            $statusColor = 'text-orange-500';
                        }
                        
                        // NOTE: Jarak (distance) tidak tersedia di controller, menggunakan nilai default
                        $distance = 'N/A';
                    @endphp

                    <label class="p-4 border border-light-grey rounded-lg hover:bg-light-bg/50 transition duration-150 cursor-pointer flex items-center justify-between"
                        data-store-id="{{ $data['branch_id'] }}"
                        data-store-name="{{ $data['branch_name'] }}"
                        data-store-status="{{ $data['status_label'] }}"
                        data-status-color="{{ $statusColor }}">
                        <div class="flex-grow pr-4">
                            <p class="font-bold text-dark-grey text-sm">{{ $data['branch_name'] }}</p>
                            <p class="text-xs text-dark-grey/80">{{ $data['branch_address'] }}</p>
                            <p class="text-xs text-primary font-semibold mt-1">{{ $distance }}</p>
                            <p class="text-xs {{ $statusColor }} font-semibold mt-1" data-status-text>
                                {{ $data['status_label'] }} ({{ $data['total_available_stock'] }} Unit)
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            {{-- Radio button value diset ke ID cabang untuk memudahkan pemrosesan di JS --}}
                            <input type="radio" name="selected_store" 
                                value="{{ $data['branch_id'] }}" 
                                data-store-distance="{{ $distance }}" 
                                data-store-full-status="{{ $data['status_label'] }}" 
                                class="text-primary focus:ring-primary h-4 w-4 border-light-grey">
                        </div>
                    </label>
                @endforeach
            @else
                <div class="p-4 bg-red-100 border border-red-300 rounded-lg text-sm text-red-800">
                    <p class="font-semibold">Mohon maaf,</p>
                    <p>Produk ini saat ini tidak tersedia (stok habis) di cabang manapun.</p>
                </div>
            @endif

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

<section class="container px-1 lg:px-[7%] mx-auto ">

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
                    <p class="text-sm text-dark-grey/80 mb-3">
                        <span class="font-bold">{{ 0 }}</span> Ulasan | Brand: <span class="font-bold text-primary">{{ $product->brand->name ?? 'Tidak Diketahui' }}</span>
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
        const radioButtons = document.querySelectorAll('input[name="selected_store"]');
        
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        const thumbnails = document.querySelectorAll('.thumbnail');
        const mainImage = document.getElementById('main-product-image');
        
        const qtyPlus = document.getElementById('qty-plus');
        const qtyMinus = document.getElementById('qty-minus');
        
        // GANTI: Menggunakan elemen INPUT baru
        const productQtyInput = document.getElementById('product-qty-input');
        
        const subtotalPrice = document.getElementById('subtotal-price');

        // Lightbox/Modal Gambar
        const lightbox = document.getElementById('image-lightbox');
        const lightboxImage = document.getElementById('lightbox-image-content');


        // --- Logika Helper ---
        
        function updateMainImage(imageUrl) {
            mainImage.style.opacity = '0';
            setTimeout(() => {
                mainImage.src = imageUrl;
                mainImage.style.opacity = '1';
                
                const mainImageContainer = mainImage.closest('[onclick^="openLightbox"]');
                if (mainImageContainer) {
                    mainImageContainer.setAttribute('onclick', `openLightbox('${imageUrl}')`);
                }
            }, 100);
        }

        /** Memformat angka menjadi Rupiah */
        function formatRupiah(number) {
            // Memastikan input adalah angka
            const cleanNumber = parseInt(number);
            if (isNaN(cleanNumber)) return 'Rp0'; 
            
            // Menggunakan Intl.NumberFormat untuk format yang lebih baik
            return 'Rp' + cleanNumber.toLocaleString('id-ID');
        }

        /** Mengupdate total harga dan kuantitas */
        function updateSubtotal(currentQty) {
            // Pastikan QTY adalah angka valid dan minimal 1
            let finalQty = parseInt(currentQty) || 1;
            if (finalQty < 1) finalQty = 1;
            
            // Update nilai input
            productQtyInput.value = finalQty;
            
            // Ambil harga dasar dari teks elemen dan parse
            const basePriceTextElement = document.getElementById('current-price');
            // Menghapus 'Rp' dan semua titik (separator ribuan)
            const basePriceText = basePriceTextElement ? basePriceTextElement.textContent.replace('Rp', '').replace(/\./g, '') : '0';
            const basePrice = parseInt(basePriceText) || 0;
            
            subtotalPrice.textContent = formatRupiah(finalQty * basePrice);
        }
        
        
        // --- Logika Input QTY (Baru) ---
        
        // 1. Event listener untuk perubahan langsung pada input
        if (productQtyInput) {
             productQtyInput.addEventListener('change', function() {
                // Batasi input pada rentang min/max
                let val = parseInt(this.value);
                if (isNaN(val) || val < 1) {
                    val = 1;
                } else if (val > 100) { // Batas maksimal 100
                    val = 100;
                }
                updateSubtotal(val);
             });
             
             // Tambahkan event keyup agar lebih responsif saat mengetik
             productQtyInput.addEventListener('keyup', function() {
                 // Cukup panggil updateSubtotal untuk validasi dan perhitungan
                 updateSubtotal(this.value);
             });
        }

        // 2. Event listener untuk tombol Plus (+)
        if (qtyPlus && productQtyInput) {
            qtyPlus.addEventListener('click', function() {
                let currentQty = parseInt(productQtyInput.value);
                if (currentQty < 100) { 
                    currentQty++;
                    updateSubtotal(currentQty);
                }
            });
        }

        // 3. Event listener untuk tombol Minus (-)
        if (qtyMinus && productQtyInput) {
            qtyMinus.addEventListener('click', function() {
                let currentQty = parseInt(productQtyInput.value);
                if (currentQty > 1) {
                    currentQty--;
                    updateSubtotal(currentQty);
                }
            });
        }
        
        // Panggil updateSubtotal di awal untuk memastikan subtotal awal benar berdasarkan nilai input (default 1)
        updateSubtotal(productQtyInput.value);


        // --- Logika Image Lightbox/Popup (Dipertahankan) ---
        
        window.openLightbox = function(imageUrl) {
            lightboxImage.src = imageUrl;
            lightbox.classList.remove('pointer-events-none', 'opacity-0');
            lightbox.classList.add('opacity-100');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden'; 
            lightbox.focus(); 
        }

        window.closeLightbox = function() {
            lightbox.classList.remove('opacity-100');
            lightbox.classList.add('opacity-0', 'pointer-events-none');
            lightbox.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = ''; 
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && lightbox && !lightbox.classList.contains('pointer-events-none')) {
                closeLightbox();
            }
        });


        // --- Logika Galeri Thumbnail (Dipertahankan) ---

        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const imageUrl = this.getAttribute('data-image');

                thumbnails.forEach(t => {
                    t.classList.remove('border-primary', 'border-2');
                    t.classList.add('border-light-grey', 'border');
                });

                this.classList.add('border-primary', 'border-2');
                this.classList.remove('border-light-grey', 'border');

                updateMainImage(imageUrl); 
            });
            
            thumb.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
        
        // --- Logika Modal Lokasi (Dipertahankan) ---

        window.openLocationModal = function() {
            locationModal.classList.remove('pointer-events-none', 'opacity-0');
            locationModal.classList.add('opacity-100');
            locationModal.querySelector('[role="document"]').classList.remove('scale-95');
            locationModal.querySelector('[role="document"]').classList.add('scale-100');
            document.body.style.overflow = 'hidden';
            locationModal.querySelector('button[aria-label="Tutup Modal Lokasi"]').focus();
        }

        window.closeLocationModal = function() {
            locationModal.classList.remove('opacity-100');
            locationModal.classList.add('opacity-0');
            locationModal.querySelector('[role="document"]').classList.remove('scale-100');
            locationModal.querySelector('[role="document"]').classList.add('scale-95');

            setTimeout(() => {
                locationModal.classList.add('pointer-events-none');
                document.body.style.overflow = '';
            }, 300);
        }

        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    selectStoreButton.disabled = false;
                    selectStoreButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            });
        });

        if (selectStoreButton) {
            selectStoreButton.addEventListener('click', function() {
                const selectedRadio = document.querySelector('input[name="selected_store"]:checked');
                if (selectedRadio) {
                    const storeName = selectedRadio.value;
                    const distance = selectedRadio.getAttribute('data-store-distance');
                    const status = selectedRadio.getAttribute('data-store-full-status');
                    const storeDiv = selectedRadio.closest('[data-store-name]');
                    const statusColor = storeDiv ? storeDiv.getAttribute('data-status-color') : 'text-dark-grey/80';

                    if (currentStoreDisplay) currentStoreDisplay.textContent = storeName;
                    if (storeStatusDisplay) {
                        storeStatusDisplay.innerHTML = `${status} (${distance}) | <a href="#" class="underline" onclick="openLocationModal()">Ubah Lokasi</a>`;
                        storeStatusDisplay.className = 'text-xs pt-1'; // Reset classes
                        storeStatusDisplay.classList.add(statusColor); // Apply new color
                    }
                    closeLocationModal();
                }
            });
        }
        
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
        
        // --- Logika Tabs (Dipertahankan) ---
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
        
    });
</script>
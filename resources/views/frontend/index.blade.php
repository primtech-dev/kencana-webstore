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

    <!-- Section Product - Memastikan padding konsisten -->
    <section class="mb-8 px-4">
        <h2 class="text-xl font-bold mb-4 text-dark-grey">Rekomendasi Spesial Untukmu</h2>

        <p class="text-sm text-dark-grey mb-4">
            *Perbedaan harga mungkin terjadi, harga terbaru tertera pada halaman detail produk
        </p>

        <!-- Navigasi Tab -->
        <div class="flex border-b border-light-grey mb-6">
            <button class="pb-2 mr-6 text-primary border-b-2 border-primary font-semibold">Spesial
                Rekomendasi</button>
            <button class="pb-2 text-dark-grey hover:text-primary">Produk Terlaris</button>
        </div>

        <!-- <div class="relative">
            <a href="{{url('detail-produk')}}">
                <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://id.pvcpanelchina.com/uploads/202334835/white-pvc-ceiling-panelsc71d0f4e-4fed-441a-88b3-144a09284153.jpg"
                                alt="Panel Ceiling A"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Tersedia</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Dekoratif / Arsitektural</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Panel Ceiling A</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp150.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp120.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">4.8</span><span
                                    class="ml-2 text-light-grey">| 10 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnfxIEAPNi00H1vA5Ydp5Duz6AsTjxdfxu_g&s"
                                alt="Louvre Vent 100"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Tersedia</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Dekoratif / Arsitektural</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Louvre Vent 100</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp100.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp85.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">4.5</span><span
                                    class="ml-2 text-light-grey">| 15 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://image1ws.indotrading.com/s3/productimages/webp/co228746/p778244/w300-h300/fe89573f-0209-4c1b-8899-94e65e2fa858.png"
                                alt="Kedai Steel Door Motif Kayu"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg opacity-80">
                            <div
                                class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Terbatas</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Dekoratif / Arsitektural</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Kedai Steel Door Motif Kayu</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp500.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp450.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">4.0</span><span
                                    class="ml-2 text-light-grey">| 3 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://agenbajaringan.com/img/genteng-metal.png"
                                alt="Genteng Metal Roof"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Tersedia</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Roofing & Walling</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Genteng Metal Roof</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp250.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp220.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">4.9</span><span
                                    class="ml-2 text-light-grey">| 200 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQezJFWtbbuMTX18v7CaDS-_jv93an4e5h18A&s"
                                alt="Atap Insulasi 5mm"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Tersedia</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Roofing & Walling</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Atap Insulasi 5mm</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp200.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp175.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">4.2</span><span
                                    class="ml-2 text-light-grey">| 58 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="hidden lg:block bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSmb-HFHwIl4XasXloHWmq4puQ1U46_gDQjkw&s"
                                alt="Spring Clip Green"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Tersedia</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Kerangka Green House</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Spring Clip Green</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp60.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp45.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">3.5</span><span
                                    class="ml-2 text-light-grey">| 1 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                </div>
            </a>
        </div> -->

        <div class="relative">
            <a href="{{url('detail-produk')}}">
                <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

                    {{-- 1. Panel Ceiling A (DEKORATIF) --}}
                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://id.pvcpanelchina.com/uploads/202334835/white-pvc-ceiling-panelsc71d0f4e-4fed-441a-88b3-144a09284153.jpg"
                                alt="Panel Ceiling A"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Tersedia</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Dekoratif / Arsitektural</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Panel Ceiling A</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp150.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp120.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">4.8</span><span
                                    class="ml-2 text-light-grey">| 10 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Louvre Vent 100 (DEKORATIF) --}}
                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnfxIEAPNi00H1vA5Ydp5Duz6AsTjxdfxu_g&s"
                                alt="Louvre Vent 100"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Tersedia</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Dekoratif / Arsitektural</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Louvre Vent 100</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp100.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp85.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">4.5</span><span
                                    class="ml-2 text-light-grey">| 15 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Pintu Steel Door Motif Kayu (DEKORATIF) --}}
                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://image1ws.indotrading.com/s3/productimages/webp/co228746/p778244/w300-h300/fe89573f-0209-4c1b-8899-94e65e2fa858.png"
                                alt="Pintu Steel Door Motif Kayu"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg opacity-80">
                            <div
                                class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Terbatas</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Dekoratif / Arsitektural</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Pintu Steel Door Motif Kayu</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp500.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp450.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">4.0</span><span
                                    class="ml-2 text-light-grey">| 3 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    {{-- 4. Genteng Metal Roof (ROOFING) --}}
                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://agenbajaringan.com/img/genteng-metal.png"
                                alt="Genteng Metal Roof"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Tersedia</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Roofing & Walling</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Genteng Metal Roof</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp250.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp220.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">4.9</span><span
                                    class="ml-2 text-light-grey">| 200 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    {{-- 5. Atap Insulasi 5mm (ROOFING) --}}
                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQezJFWtbbuMTX18v7CaDS-_jv93an4e5h18A&s"
                                alt="Atap Insulasi 5mm"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Tersedia</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Roofing & Walling</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Atap Insulasi 5mm</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp200.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp175.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">4.2</span><span
                                    class="ml-2 text-light-grey">| 58 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    {{-- 6. Spring Clip Green (Kerangka Green House) - Mengubah tampilan menjadi block di LG --}}
                    <div
                        class="hidden lg:block bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSmb-HFHwIl4XasXloHWmq4puQ1U46_gDQjkw&s"
                                alt="Spring Clip Green"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Tersedia</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Kerangka Green House</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Spring Clip Green</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp60.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp45.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">3.5</span><span
                                    class="ml-2 text-light-grey">| 1 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    {{-- 7. Rangka Baja Ringan 4m (STRUKTURAL) - Produk Tambahan 1 --}}
                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://kontainerindonesia.co.id/blog/wp-content/uploads/2024/08/Profil-Baja-Ringan-U-600x375.webp"
                                alt="Rangka Baja Ringan 4m"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Tersedia</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Struktural</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Rangka Baja Ringan 4m</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp850.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp680.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">5.0</span><span
                                    class="ml-2 text-light-grey">| 35 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    {{-- 8. Pipa Galvanis 2" (STRUKTURAL) - Produk Tambahan 2 --}}
                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://image.menarasinarbaja.co.id/s3/productimages/webp/co244175/p1201966/w600-h600/1a763e6f-bb8d-4996-93b4-67e28d92afd0.jpg"
                                alt="Pipa Galvanis 2&quot;"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Tersedia</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1 line-clamp-1">Struktural</p>
                            <p
                                class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                                Pipa Galvanis 2"</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp187.500</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp150.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">4.7</span><span
                                    class="ml-2 text-light-grey">| 80 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                </div>
            </a>
        </div>

    </section>
</main>

@endsection
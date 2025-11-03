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

            <!-- Daftar Produk - Grid Responsif: 2 (mobile) sm:3 (tablet) lg:6 (desktop) -->
            <div class="relative">
                <a href="{{url('detail-produk')}}">
                <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

                    <!-- KARTU PRODUK 1 -->
                    
                    <div 
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://cdn.ruparupa.io/fit-in/400x400/filters:format(webp)/filters:quality(90)/ruparupa-com/image/upload/Products/10578759_1.jpg"
                                alt="Informa Letty Kursi Kantor"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/EE0D0D/ffffff?text=Error';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <!-- Diskon menggunakan warna Dark Grey (#31311E) -->
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                26%</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1">? Warna</p>
                            <p class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[2.5rem]">
                                Informa Letty Kursi Kantor - Pink</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp1.299.000</p>
                            <!-- Harga Diskon menggunakan warna Dark Grey (#31311E) -->
                            <p class="text-base md:text-lg font-bold text-discount">Rp969.900</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">5</span><span
                                    class="ml-2 text-light-grey">| 5 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    <!-- KARTU PRODUK 2 -->
                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://placehold.co/600x400/CBCBCB/31311E?text=RAK+TROLI"
                                alt="Stora Kassy Rak Troli"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/CBCBCB/31311E?text=Error';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                26%</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1">2 Warna</p>
                            <p class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[2.5rem]">Stora
                                Kassy Rak Troli 4 Tingkat Slim - Putih</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp499.900</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp369.900</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">5</span><span
                                    class="ml-2 text-light-grey">| 16 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    <!-- KARTU PRODUK 3 -->
                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://placehold.co/600x400/31311E/FEF3E2?text=SOFA+BED"
                                alt="Selma Greesa Sofa Bed"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/31311E/FEF3E2?text=Error';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                13%</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1"></p>
                            <p class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[2.5rem]">Selma
                                Greesa Sofa Bed Kulit - Hitam</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp3.199.900</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp2.799.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">5</span><span
                                    class="ml-2 text-light-grey">| 227 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    <!-- KARTU PRODUK 4 -->
                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://placehold.co/600x400/F5F5F0/31311E?text=KOMPOR" alt="Kris Kompor Listrik"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/F5F5F0/31311E?text=Error';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                -</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1"></p>
                            <p class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[2.5rem]">Kris
                                Kompor Listrik Double 1000 Watt</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp 499.900</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp299.900</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">5</span><span
                                    class="ml-2 text-light-grey">| 22 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    <!-- KARTU PRODUK 5 -->
                    <div
                        class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://placehold.co/600x400/FEF3E2/EE0D0D?text=SOFA+L"
                                alt="Ashley Alessio Sofa L"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/FEF3E2/EE0D0D?text=Error';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                -44%</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1"></p>
                            <p class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[2.5rem]">
                                Ashley Alessio Sofa L Sectional Fabric - Grey</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp 15.497.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp5.499.000</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">5</span><span
                                    class="ml-2 text-light-grey">| 1 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    <!-- KARTU PRODUK 6 (Baru, untuk mengisi 6 kolom) -->
                    <div
                        class="hidden lg:block bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="relative">
                            <img src="https://placehold.co/600x400/EE0D0D/F5F5F0?text=AIR+PURIFIER"
                                alt="Air Purifier Krisbow"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/EE0D0D/F5F5F0?text=Error';"
                                class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                            <div
                                class="absolute top-2 right-2 bg-discount text-white text-xs font-bold px-2 py-1 rounded">
                                10%</div>
                        </div>
                        <div class="p-3 md:p-4">
                            <p class="text-xs text-light-grey mb-1">1 Warna</p>
                            <p class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[2.5rem]">Air
                                Purifier Smart 5 Stages Krisbow</p>
                            <p class="text-xs text-light-grey line-through mt-2">Rp 1.499.000</p>
                            <p class="text-base md:text-lg font-bold text-discount">Rp1.349.100</p>
                            <div class="flex items-center text-xs text-dark-grey mt-2">
                                <span class="text-primary">★</span><span class="ml-1">5</span><span
                                    class="ml-2 text-light-grey">| 9 (ulasan)</span>
                            </div>
                        </div>
                    </div>

                    
                </div>
                </a>
            </div>

        </section>
    </main>

@endsection
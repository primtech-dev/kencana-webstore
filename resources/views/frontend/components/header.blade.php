<div id="mobile-menu" class="fixed top-0 left-0 w-full h-full bg-light-grey bg-opacity-75 z-[99] hidden">
    <div id="mobile-menu-drawer"
        class="w-72 sm:w-80 h-full bg-white shadow-2xl p-4 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">
        <div class="flex justify-between items-center pb-4 border-b border-light-grey">
            <a href="{{ url('/') }}" class="text-lg font-extrabold text-primary">KENCANA</a>
            <button id="close-menu-btn"
                class="text-dark-grey hover:text-primary p-2 rounded-full hover:bg-light-bg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div class="pt-4 space-y-3">
            <a href="#"
                class="block text-center border border-primary text-primary font-semibold py-2 rounded-lg transition duration-150 hover:bg-light-bg">Masuk</a>
            <a href="#"
                class="block text-center bg-primary text-white font-semibold py-2 rounded-lg transition duration-150 hover:bg-primary-dark">Daftar</a>
        </div>
        <nav class="mt-6 space-y-2">
            <a href="{{url('/')}}" class="block p-3 font-semibold text-dark-grey hover:bg-light-bg rounded-lg">Home</a>
            <a href="{{url('/')}}" class="block p-3 font-semibold text-primary bg-light-bg rounded-lg">Kategori Produk</a>
            <a href="{{url('/promo')}}" class="block p-3 font-semibold text-dark-grey hover:bg-light-bg rounded-lg">Promo</a>
            <a href="{{url('/keranjang')}}" class="block p-3 font-semibold text-dark-grey hover:bg-light-bg rounded-lg">Keranjang</a>
            <!-- <a href="#" class="block p-3 font-semibold text-dark-grey hover:bg-light-bg rounded-lg">Inspirasi & Ide</a> -->
            <a href="#" class="block p-3 font-semibold text-dark-grey hover:bg-light-bg rounded-lg">Pusat
                Bantuan</a>
        </nav>
        <div class="mt-6 pt-4 border-t border-light-grey">
            <h4 class="font-bold text-dark-grey mb-3">Layanan Lainnya</h4>
            <a href="#" class="block text-sm p-3 text-dark-grey hover:bg-light-bg rounded-lg">Kencana Bisnis <span
                    class="text-xs bg-primary text-white px-1 ml-1 rounded">NEW</span></a>
            <!-- <a href="#" class="block text-sm p-3 text-dark-grey hover:bg-light-bg rounded-lg">Jasa Desain
                    Interior</a> -->
        </div>
    </div>
</div>


<header class="shadow-md sticky top-0 z-50">
    <!-- Top Bar (Hanya muncul di desktop/tablet) -->
    <div class="bg-primary text-white text-sm hidden md:block">
        <div class="container mx-auto px-4 py-2 flex justify-between items-center">
            <div class="flex space-x-4">
                <a href="#" class="flex items-center hover:text-primary">Download aplikasi</a>
                <a href="#" class="flex items-center hover:text-primary">Pusat Bantuan</a>
                <a href="#" class="flex items-center hover:text-primary">Kencana.com</a>
            </div>
            <div class="flex space-x-4">
                <a href="#" class="flex items-center hover:text-primary">Kencana bisnis <span
                        class="text-xs bg-primary text-white px-1 ml-1 rounded">NEW</span></a>
                <!-- <a href="#" class="hover:text-primary">Jasa Desain Interior</a> -->
                <a href="#" class="hover:text-primary">Gratis Ongkir</a>
            </div>
        </div>
    </div>

    <div class="bg-primary text-white border-b border-gray-100">
        <div class="container mx-auto px-4 py-3 md:py-4 flex items-center justify-between">

            <div class="flex items-center space-x-2 md:space-x-6 flex-shrink-0">
                <button id="open-menu-btn" class="md:hidden text-white p-1 hover:text-primary">☰</button>

                <a href="#" class="flex flex-col items-center leading-none flex-shrink-0 mr-4">
                    <div class="flex items-center bg-transparent p-1 rounded-md">
                        <span class="text-2xl font-extrabold text-white ml-1">KENCANA</span>
                    </div>
                    <span class="text-xs text-white mt-0.5 hidden sm:block">sahabat bangunan anda</span>
                </a>

                <!-- <div class="hidden lg:flex font-semibold text-gray-700 space-x-6 text-base">
                    <a href="{{url('/')}}" class="hover:text-primary transition duration-150">Kategori</a>
                    <a href="{{url('/promo')}}" class="hover:text-primary transition duration-150">Promo</a>
                </div> -->
            </div>

            <div class="flex-grow mx-2 md:mx-6 w-full max-w-lg lg:max-w-2xl">
                <div class="flex border border-gray-300 rounded-lg overflow-hidden h-10">
                    <input type="text" placeholder="Cari bantal"
                        class="w-full py-2 px-4 text-sm text-gray-700 focus:outline-none focus:ring-0 bg-white placeholder-gray-400">
                    <button
                        class="bg-primary hover:bg-primary-dark text-white w-10 md:w-16 flex items-center justify-center transition duration-200 flex-shrink-0">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center space-x-3 md:space-x-4 flex-shrink-0 ml-4">

                <button class="text-white hover:text-white relative p-1 md:p-2 hidden sm:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v2a2 2 0 11-4 0v-2m4 0H9"></path>
                    </svg>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center h-4 w-4 text-[10px] font-bold leading-none text-primary transform translate-x-1/2 -translate-y-1/2 bg-white rounded-full">3</span>
                </button>

                <button class="text-white hover:text-white relative p-1 md:p-2 hidden sm:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3-7 3V5z"></path>
                    </svg>
                </button>

                <a href="{{ url('keranjang') }}" class="text-white hover:text-white relative p-1 md:p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center h-4 w-4 text-[10px] font-bold leading-none text-primary transform translate-x-1/2 -translate-y-1/2 bg-white rounded-full">1</span>
                </a>

                <a href="#"
                    class="bg-gray-200 text-gray-700 font-semibold py-1 px-3 rounded-full text-sm flex items-center space-x-1 hover:bg-gray-300 transition duration-150 hidden lg:flex">
                    <svg class="w-4 h-4 text-gray-700" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm-5 8a5 5 0 1110 0 5 5 0 01-10 0zM8 8a2 2 0 104 0 2 2 0 00-4 0z"></path>
                    </svg>
                    <span>Silver</span>
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>

                <div class="flex items-center space-x-1 text-white font-semibold hover:text-light-grey cursor-pointer hidden md:flex">
                   
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                     <a href="{{url('/profile')}}">
                    <span>Hi, Hairul Bahri</span>
                     </a>
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                   
                </div>
            </div>
        </div>


    </div>

    <!-- Bottom Bar (Category Slider & Dropdowns) -->
    <div id="bottom-bar" class="bg-primary border-t border-b border-light-grey shadow-sm hidden md:block">
        <div class="container mx-auto flex items-center relative">

            <!-- Panah Kiri Slider Kategori (Fungsional) -->
            <button id="category-scroll-left"
                class=" hidden absolute left-0 top-0 bottom-0 px-2 bg-primary h-full flex items-center border-r border-light-grey shadow-lg cursor-pointer z-10 hover:bg-light-bg transition duration-150">
                <svg class="w-4 h-4 text-dark-grey" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                    </path>
                </svg>
            </button>

            <div id="category-list"
                class="flex flex-1 mx-10 px-2 lg:mx-12 overflow-x-auto whitespace-nowrap scrollbar-hide scroll-smooth py-3">

                <div class="group flex-shrink-0 category-link-container">
                    <a href="#"
                        class="category-link hover:text-light-grey font-medium py-1 inline-block transition duration-150 text-white">
                        Kencana Bisnis <span class="text-xs bg-white text-primary px-1 ml-1 rounded">NEW</span>
                    </a>
                    <div id="dropdown-1" data-width="384px" class="js-dropdown-source hidden">
                        <div class="flex p-5 text-dark-grey">
                            <div class="w-1/2 pr-4 border-r border-light-grey">
                                <h4 class="font-bold mb-2 text-sm">Layanan B2B</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Pengadaan Proyek</a></li>
                                    <li><a href="#" class="block hover:text-primary">Invoice & Pajak</a></li>
                                    <li><a href="#" class="block hover:text-primary">Kredit Term Of Payment</a></li>
                                </ul>
                            </div>
                            <div class="w-1/2 pl-4">
                                <h4 class="font-bold mb-2 text-sm">Keuntungan</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Harga Distributor</a></li>
                                    <li><a href="#" class="block hover:text-primary">Konsultasi Teknis</a></li>
                                    <li><a href="#" class="block hover:text-primary">Prioritas Pengiriman</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group flex-shrink-0 category-link-container">
                    <a href="#"
                        class="category-link hover:text-light-grey font-medium py-1 inline-block transition duration-150 text-white">
                        Official Partner
                    </a>
                    <div id="dropdown-2" data-width="384px" class="js-dropdown-source hidden">
                        <div class="flex p-5 text-dark-grey">
                            <div class="w-1/2 pr-4 border-r border-light-grey">
                                <h4 class="font-bold mb-2 text-sm">Brand Baja</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Krakatau Steel</a></li>
                                    <li><a href="#" class="block hover:text-primary">Gunung Garuda</a></li>
                                    <li><a href="#" class="block hover:text-primary">Taso & Canal C</a></li>
                                </ul>
                            </div>
                            <div class="w-1/2 pl-4">
                                <h4 class="font-bold mb-2 text-sm">Layanan Partner</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Sertifikat SNI</a></li>
                                    <li><a href="#" class="block hover:text-primary">Program Loyalti</a></li>
                                    <li><a href="#" class="block hover:text-primary">Dukungan Garansi</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group flex-shrink-0 category-link-container">
                    <a href="{{url('/promo')}}"
                        class="category-link hover:text-light-grey font-medium py-1 inline-block transition duration-150 text-white">
                        Promo
                    </a>
                    <div id="dropdown-3" data-width="384px" class="js-dropdown-source hidden">
                        <div class="flex p-5 text-dark-grey">
                            <div class="w-1/2 pr-4 border-r border-light-grey">
                                <h4 class="font-bold mb-2 text-sm">Diskon Baja</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Baja Ringan Promo</a></li>
                                    <li><a href="#" class="block hover:text-primary">Flash Sale Besi Beton</a></li>
                                    <li><a href="#" class="block hover:text-primary">Voucher Pengiriman</a></li>
                                </ul>
                            </div>
                            <div class="w-1/2 pl-4">
                                <h4 class="font-bold mb-2 text-sm">Penawaran Spesial</h4>
                                <div
                                    class="relative rounded-lg overflow-hidden h-20 bg-primary flex items-center justify-center text-center text-white p-2 shadow-md">
                                    <h5 class="font-bold text-sm">Beli 5 Ton, Gratis 1 Kawat!</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

              

                <div class="group flex-shrink-0 category-link-container">
                    <a href="{{url('/')}}"
                        class="category-link hover:text-light-grey font-medium py-1 inline-block text-white border-b-2 border-white transition duration-150">
                        Kategori
                    </a>
                    <div id="dropdown-5" data-width="900px" data-layout="center" class="js-dropdown-source hidden">
                        <div class="flex p-6 text-dark-grey">
                            <div class="w-1/5 pr-4 border-r border-light-grey">
                                <h4 class="font-bold text-primary mb-3">Besi Beton</h4>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Besi Polos SNI</a></li>
                                    <li><a href="#" class="block hover:text-primary">Besi Ulir SNI</a></li>
                                    <li><a href="#" class="block hover:text-primary">Besi Non-SNI</a></li>
                                    <li><a href="#" class="block hover:text-primary">Begel (Cincin)</a></li>
                                </ul>

                                <h4 class="font-bold text-primary mb-3 mt-4">Kawat & Mesh</h4>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Kawat Bendrat</a></li>
                                    <li><a href="#" class="block hover:text-primary">Wiremesh</a></li>
                                </ul>
                            </div>
                            <div class="w-1/5 px-4 border-r border-light-grey">
                                <h4 class="font-bold text-primary mb-3">Baja Struktural</h4>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Besi WF (Wide Flange)</a></li>
                                    <li><a href="#" class="block hover:text-primary">Besi H-Beam</a></li>
                                    <li><a href="#" class="block hover:text-primary">Plat Besi</a></li>
                                    <li><a href="#" class="block hover:text-primary">Besi Siku</a></li>
                                </ul>

                                <h4 class="font-bold text-primary mb-3 mt-4">Material Pondasi</h4>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Semen</a></li>
                                    <li><a href="#" class="block hover:text-primary">Pasir & Agregat</a></li>
                                </ul>
                            </div>
                            <div class="w-1/5 px-4 border-r border-light-grey">
                                <h4 class="font-bold text-primary mb-3">Pipa & Profil</h4>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Pipa Hitam</a></li>
                                    <li><a href="#" class="block hover:text-primary">Pipa Galvanis</a></li>
                                    <li><a href="#" class="block hover:text-primary">Besi UNP (Kanal U)</a></li>
                                    <li><a href="#" class="block hover:text-primary">Besi CNP (Kanal C)</a></li>
                                </ul>

                                <h4 class="font-bold text-primary mb-3 mt-4">Pagar & Tralis</h4>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Pagar BRC</a></li>
                                    <li><a href="#" class="block hover:text-primary">Material Tralis</a></li>
                                </ul>
                            </div>
                            <div class="w-2/5 pl-6">
                                <h4 class="font-bold mb-3">Panduan dan Inspirasi Proyek</h4>
                                <div class="space-y-4">
                                    <div
                                        class="flex items-center space-x-3 bg-light-bg rounded-lg p-3 hover:bg-light-bg/70 transition">
                                        <div class="h-16 w-16 bg-light-grey rounded-lg flex-shrink-0">


                                            [Image]

                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm">Cara Menghitung Kebutuhan Besi Beton</p>
                                            <span class="text-xs text-primary">Lihat Kalkulator →</span>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center space-x-3 bg-light-bg rounded-lg p-3 hover:bg-light-bg/70 transition">
                                        <div class="h-16 w-16 bg-light-grey rounded-lg flex-shrink-0">


                                            [Image]

                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm">Perbedaan Baja WF, H-Beam, dan Kanal C</p>
                                            <span class="text-xs text-primary">Baca Artikel Teknis →</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group flex-shrink-0 category-link-container">
                    <a href="#"
                        class="category-link hover:text-light-grey font-medium py-1 inline-block transition duration-150 text-white">
                        Kegiatan
                    </a>
                    <!-- <div id="dropdown-6" data-width="384px" class="js-dropdown-source hidden">
                        <div class="flex p-5 text-dark-grey">
                            <div class="w-1/2 pr-4 border-r border-light-grey">
                                <h4 class="font-bold mb-2 text-sm">Atap Metal</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Spandek</a></li>
                                    <li><a href="#" class="block hover:text-primary">Genteng Metal</a></li>
                                    <li><a href="#" class="block hover:text-primary">Seng Galvalum</a></li>
                                </ul>
                            </div>
                            <div class="w-1/2 pl-4">
                                <h4 class="font-bold mb-2 text-sm">Material Lain</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Genteng Beton</a></li>
                                    <li><a href="#" class="block hover:text-primary">Insulasi Atap</a></li>
                                    <li><a href="#" class="block hover:text-primary">Material Talang</a></li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="group flex-shrink-0 category-link-container">
                    <a href="{{url('faq')}}"
                        class="category-link hover:text-light-grey font-medium py-1 inline-block transition duration-150 text-white">
                        FAQ
                    </a>
                    <!-- <div id="dropdown-7" data-width="384px" class="js-dropdown-source hidden">
                        <div class="flex p-5 text-dark-grey">
                            <div class="w-1/2 pr-4 border-r border-light-grey">
                                <h4 class="font-bold mb-2 text-sm">Alat & Mesin</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Mesin Las</a></li>
                                    <li><a href="#" class="block hover:text-primary">Gerinda Pemotong</a></li>
                                    <li><a href="#" class="block hover:text-primary">Perkakas Tangan</a></li>
                                </ul>
                            </div>
                            <div class="w-1/2 pl-4">
                                <h4 class="font-bold mb-2 text-sm">Perlengkapan K3</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Helm Proyek</a></li>
                                    <li><a href="#" class="block hover:text-primary">Sarung Tangan Safety</a></li>
                                    <li><a href="#" class="block hover:text-primary">Sepatu Safety</a></li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                </div>

                <!-- <div class="group flex-shrink-0 category-link-container">
                    <a href="#"
                        class="category-link hover:text-light-grey font-medium py-1 inline-block transition duration-150 text-dark-grey">
                        Finishing & Pengecatan
                    </a>
                    <div id="dropdown-8" data-width="384px" class="js-dropdown-source hidden">
                        <div class="flex p-5 text-dark-grey">
                            <div class="w-1/2 pr-4 border-r border-light-grey">
                                <h4 class="font-bold mb-2 text-sm">Cat & Pelapis</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Cat Anti Karat</a></li>
                                    <li><a href="#" class="block hover:text-primary">Cat Dasar (Primer)</a></li>
                                    <li><a href="#" class="block hover:text-primary">Cat Besi/Kayu</a></li>
                                </ul>
                            </div>
                            <div class="w-1/2 pl-4">
                                <h4 class="font-bold mb-2 text-sm">Aksesoris</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Kuas & Roller</a></li>
                                    <li><a href="#" class="block hover:text-primary">Tiner & Pelarut</a></li>
                                    <li><a href="#" class="block hover:text-primary">Amplifier</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group flex-shrink-0 category-link-container">
                    <a href="#"
                        class="category-link hover:text-light-grey font-medium py-1 inline-block transition duration-150 text-dark-grey">
                        Pintu & Jendela
                    </a>
                    <div id="dropdown-9" data-width="384px" class="js-dropdown-source hidden">
                        <div class="flex p-5 text-dark-grey">
                            <div class="w-1/2 pr-4 border-r border-light-grey">
                                <h4 class="font-bold mb-2 text-sm">Pintu</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Pintu Baja</a></li>
                                    <li><a href="#" class="block hover:text-primary">Pintu PVC/Aluminium</a></li>
                                    <li><a href="#" class="block hover:text-primary">Kunci & Engsel</a></li>
                                </ul>
                            </div>
                            <div class="w-1/2 pl-4">
                                <h4 class="font-bold mb-2 text-sm">Jendela</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Kusen Aluminium</a></li>
                                    <li><a href="#" class="block hover:text-primary">Jendela Kaca</a></li>
                                    <li><a href="#" class="block hover:text-primary">Aksesoris Jendela</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group flex-shrink-0 category-link-container">
                    <a href="#"
                        class="category-link hover:text-light-grey font-medium py-1 inline-block transition duration-150 text-dark-grey">
                        Peralatan Plumbing
                    </a>
                    <div id="dropdown-10" data-width="384px" class="js-dropdown-source hidden">
                        <div class="flex p-5 text-dark-grey">
                            <div class="w-1/2 pr-4 border-r border-light-grey">
                                <h4 class="font-bold mb-2 text-sm">Pipa</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Pipa PVC</a></li>
                                    <li><a href="#" class="block hover:text-primary">Pipa Air Panas</a></li>
                                    <li><a href="#" class="block hover:text-primary">Fitting Pipa</a></li>
                                </ul>
                            </div>
                            <div class="w-1/2 pl-4">
                                <h4 class="font-bold mb-2 text-sm">Sanitasi</h4>
                                <ul class="space-y-1 text-sm">
                                    <li><a href="#" class="block hover:text-primary">Keran & Valve</a></li>
                                    <li><a href="#" class="block hover:text-primary">Wastafel</a></li>
                                    <li><a href="#" class="block hover:text-primary">Saluran Air</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>

            <!-- Panah Kanan Slider Kategori (Fungsional) -->
            <button id="category-scroll-right"
                class=" hidden absolute right-0 top-0 bottom-0 px-2 bg-white h-full flex items-center border-l border-light-grey shadow-lg cursor-pointer z-10 hover:bg-light-bg transition duration-150">
                <svg class="w-4 h-4 text-dark-grey" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>
</header>

<!-- GLOBAL DROPDOWN CONTAINER -->
<div id="global-dropdown" class="fixed hidden bg-white shadow-2xl rounded-lg border border-light-grey z-[90]"
    style="transition: opacity 0.1s ease;">
    <!-- Konten akan di-inject di sini oleh JavaScript -->
</div>
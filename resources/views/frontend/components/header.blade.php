<div id="mobile-menu" 
     class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-[99] hidden transition-opacity duration-300 ease-in-out" 
     aria-modal="true" 
     role="dialog">
     
    <div id="mobile-menu-drawer"
        class="w-full h-full bg-white shadow-2xl p-6 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">

        <div class="flex justify-between items-center pb-5 border-b border-gray-100">
            <a href="{{ url('/') }}" class="text-xl font-extrabold text-primary">
                <img src="{{ asset('asset/Kencana Store.png') }}" alt="Logo Kencana" class="w-28 h-auto">
            </a>
            <button id="close-menu-btn" aria-label="Tutup Menu"
                class="text-gray-500 hover:text-primary p-2 rounded-full transition duration-150 ease-in-out">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            
        </div>

        <div class="pt-6 pb-6 border-b border-gray-100">
            @auth('customer')
                <div class="flex items-center space-x-3 mb-4">
                    <span class="w-10 h-10 flex items-center justify-center bg-primary text-white text-lg font-bold rounded-full">
                        {{ substr(auth('customer')->user()->full_name, 0, 1) }}
                    </span>
                    <div>
                        <p class="font-bold text-gray-800 truncate">{{ auth('customer')->user()->full_name }}</p>
                        <p class="text-sm text-gray-500">{{ auth('customer')->user()->email }}</p>
                    </div>
                </div>

                <a href="{{ route('member.index') }}" aria-label="Dashboard Akun"
                    class="block text-center border-2 border-primary bg-primary text-white font-bold py-2.5 rounded-xl transition duration-150 hover:bg-primary-dark hover:shadow-lg">
                    Dashboard Akun
                </a>
                <form action="{{ route('customer.logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" aria-label="Keluar dari Akun"
                        class="w-full text-center bg-gray-200 text-gray-700 font-bold py-2.5 rounded-xl transition duration-150 hover:bg-gray-300 shadow-sm">
                        Keluar (Logout)
                    </button>
                </form>
            @else
                <div class="pt-2 space-y-3">
                    <a href="{{ route('customer.login') }}" aria-label="Masuk ke Akun Anda"
                        class="block text-center border-2 border-primary text-primary font-bold py-2.5 rounded-xl transition duration-150 hover:bg-primary hover:text-white hover:shadow-lg">Masuk</a>
                    <a href="{{ route('customer.register') }}" aria-label="Daftar Akun Baru"
                        class="block text-center bg-gray-200 text-gray-700 font-bold py-2.5 rounded-xl transition duration-150 hover:bg-gray-300 shadow-sm">Daftar</a>
                </div>
            @endauth
        </div>

        <div class="mt-6 mb-6">
            <button id="search-icon-btn" aria-expanded="false" aria-controls="search-form-container"
                class="w-full flex items-center p-3.5 bg-primary hover:bg-primary-dark rounded-xl transition duration-150 text-white shadow-md">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span class="font-bold text-base">Cari Produk</span>
            </button>

            

            <div id="search-form-container" class="hidden mt-4 transition-all duration-300 ease-in-out">
                <form action="#" method="GET" class="relative">
                    <input type="search" name="q" id="mobile-search" placeholder="Ketik kata kunci..."
                        class="w-full pl-12 pr-4 py-3 text-lg font-medium border-2 border-primary rounded-xl focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition duration-150 shadow-md">
                    <button type="submit" aria-label="Cari" class="absolute inset-y-0 left-0 flex items-center pl-4 text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>


        </div>
        
        <nav class="mt-6 space-y-1">
            <a href="{{ url('/') }}"
                class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-primary-light hover:text-primary rounded-xl transition duration-150">
                <span class="mr-3 text-xl">🏠</span> Home
            </a>
            <a href="{{ url('/') }}"
                class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-primary-light hover:text-primary rounded-xl transition duration-150">
                <span class="mr-3 text-xl">🏷️</span> Kategori Produk
            </a>
            <a href="{{ url('/promo') }}"
                class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-primary-light hover:text-primary rounded-xl transition duration-150">
                <span class="mr-3 text-xl">🔥</span> Promo
            </a>
            <a href="{{ url('/keranjang') }}"
                class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-primary-light hover:text-primary rounded-xl transition duration-150">
                <span class="mr-3 text-xl">🛒</span> Keranjang
            </a>
        </nav>

        <nav class="mt-6 pt-4 border-t border-gray-100 space-y-1">
            <h4 class="font-bold text-gray-600 mb-3 text-sm uppercase tracking-wider">Informasi & Bantuan</h4>
            <a href="{{ url('/faq') }}"
                class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-primary-light hover:text-primary rounded-xl transition duration-150">
                <span class="mr-3 text-xl">❓</span> FAQ
            </a>
            <a href="#"
                class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-primary-light hover:text-primary rounded-xl transition duration-150">
                <span class="mr-3 text-xl">💬</span> Pusat Bantuan
            </a>
            <a href="#" class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-primary-light hover:text-primary rounded-xl transition duration-150">
                <span class="mr-3 text-xl">💼</span> Kencana Bisnis
                <span class="text-xs bg-red-500 text-white font-medium px-2 py-0.5 ml-2 rounded-full transform -translate-y-px">NEW</span>
            </a>
        </nav>

    </div>
</div>

<header class="shadow-md sticky top-0 z-50">
    <div class="bg-primary text-white text-sm hidden md:block">
        <div class="container mx-auto px-4 py-2 flex justify-between items-center">
            <div class="flex space-x-4">
                <a href="#" class="flex items-center hover:text-white/80 transition duration-150">Download aplikasi</a>
                <a href="#" class="flex items-center hover:text-white/80 transition duration-150">Pusat Bantuan</a>
                <a href="#" class="flex items-center hover:text-white/80 transition duration-150">Kencana.com</a>
            </div>
            <div class="flex space-x-4">
                <a href="#" class="flex items-center hover:text-white/80 transition duration-150">Kencana bisnis <span
                        class="text-xs bg-white text-primary px-1 ml-1 rounded">NEW</span></a>
                <a href="#" class="hover:text-white/80 transition duration-150">Gratis Ongkir</a>
            </div>
        </div>
    </div>

   <div class="bg-primary text-white border-b border-gray-100">
    <div class="container mx-auto px-4 sm:px-[5%] md:px-[9%] py-3 md:py-4 flex items-center justify-between">

        <div class="flex items-center space-x-2 md:space-x-6 flex-shrink-0">
            <button id="open-menu-btn" aria-label="Buka Menu" class="md:hidden text-white p-2 rounded-md transition duration-200">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <a href="{{ url('/') }}" class="flex flex-col items-center leading-none flex-shrink-0 mr-4">
                <img src="{{ asset('asset/Kencana Store Putih.png') }}" alt="Logo Kencana" class="w-24 h-auto md:w-32">
                <span class="text-[10px] text-white mt-0.5 hidden sm:block md:hidden mt-2 leading-tight text-center">Sahabat <br> <span>Rumah & Bangunan</span> </span>
            </a>
        </div>

        <div class="flex-grow mx-2 md:mx-6 w-full max-w-lg lg:max-w-2xl hidden sm:block">
            <form action="#" method="GET" class="flex border border-gray-300 rounded-lg overflow-hidden h-10 w-full">
                <input type="text" name="q" placeholder="Cari bantal, besi, semen..."
                    class="w-full py-2 px-4 text-sm text-gray-700 focus:outline-none focus:ring-0 bg-white placeholder-gray-400">
                <button type="submit" aria-label="Cari Produk"
                    class="bg-primary text-white w-10 md:w-16 flex items-center justify-center transition duration-200 flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>

        <div class="flex items-center space-x-3 md:space-x-4 flex-shrink-0 ml-4">

            <button aria-label="Buka Pencarian" class="sm:hidden text-white p-2 rounded-md transition duration-200">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>

            @auth('customer')
            <button aria-label="Lihat Notifikasi" class="text-white hover:text-white relative p-1 md:p-2 hidden sm:block">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v2a2 2 0 11-4 0v-2m4 0H9"></path>
                </svg>
                <span class="absolute top-0 right-0 inline-flex items-center justify-center h-4 w-4 text-[10px] font-bold leading-none text-primary transform translate-x-1/2 -translate-y-1/2 bg-white rounded-full">
                    {{-- Ganti dengan hitungan notifikasi: {{ auth('customer')->user()->unreadNotifications()->count() }} --}}
                    3
                </span>
            </button>
            
            <button aria-label="Lihat Wishlist" class="text-white hover:text-white relative p-1 md:p-2 hidden sm:block">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3-7 3V5z"></path>
                </svg>
                {{-- Placeholder Wishlist Dinamis --}}
                {{-- <span class="absolute top-0 right-0 inline-flex items-center justify-center h-4 w-4 text-[10px] font-bold leading-none text-primary transform translate-x-1/2 -translate-y-1/2 bg-white rounded-full">1</span> --}}
            </button>

             <a href="{{ url('/keranjang') }}" aria-label="Lihat Keranjang Belanja" class="text-white relative p-2 rounded-md transition duration-200">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                @if($cartCount > 0)
                
                <span class="absolute top-0 right-0 inline-flex items-center justify-center h-4 w-4 text-[10px] font-bold leading-none text-primary transform translate-x-1/2 -translate-y-1/2 bg-white rounded-full">
                    {{-- Ganti dengan hitungan keranjang: {{ Cart::count() }} --}}
                    {{ $cartCount }}
                </span>

                @endif
            </a>

            
            @endauth

           

            @auth('customer')
                <a href="#" aria-label="Status Loyalty"
                    class="bg-gray-200 text-gray-700 font-semibold py-1 px-3 rounded-full text-sm flex items-center space-x-1 hover:bg-gray-300 transition duration-150 hidden lg:flex">
                    <svg class="w-4 h-4 text-gray-700" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm-5 8a5 5 0 1110 0 5 5 0 01-10 0zM8 8a2 2 0 104 0 2 2 0 00-4 0z"></path>
                    </svg>
                    <span>{{ auth('customer')->user()->loyalty_status ?? 'Member' }}</span> 
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
                
                <a href="{{ route('member.index') }}" aria-label="Profile Pengguna"
                    class="flex items-center space-x-1 text-white font-semibold hover:text-white/80 transition duration-150 cursor-pointer hidden md:flex group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-sm">Hi, {{ Str::limit(auth('customer')->user()->full_name, 12, '..') }}</span>
                    <svg class="w-3 h-3 ml-1 group-hover:rotate-180 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
            @else
                <a href="{{ route('customer.login') }}" aria-label="Masuk Akun"
                   class="bg-white text-primary font-semibold py-1.5 px-3 rounded-lg text-sm transition duration-150 hover:bg-gray-100 hidden md:flex">
                    Masuk
                </a>
                <a href="{{ route('customer.register') }}" aria-label="Daftar Akun"
                   class="border border-white text-white font-semibold py-1.5 px-3 rounded-lg text-sm transition duration-150 hover:bg-white hover:text-primary hidden md:flex">
                    Daftar
                </a>
            @endauth
        </div>
    </div>
</div>

    <div id="bottom-bar" class="bg-primary border-t border-b border-light-grey shadow-sm hidden md:block">
        <div class="container mx-auto px-[9%] flex items-center relative">

            <!-- <button id="category-scroll-left" aria-label="Gulir Kategori ke Kiri"
                class="absolute left-[2%] top-0 bottom-0 px-2 bg-primary h-full flex items-center border-r border-light-grey shadow-lg cursor-pointer z-10 hover:bg-primary-dark transition duration-150">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button> -->

            <div id="category-list"
                class="flex flex-1 mx-2 overflow-x-scroll whitespace-nowrap scrollbar-hide scroll-smooth py-3">
                <div class="group flex-shrink-0 category-link-container px-3 first:pl-0 last:pr-0">
                    <a href="#" class="category-link hover:text-white/80 font-semibold py-1 inline-block transition duration-150 text-white">
                        Kencana Bisnis <span class="text-xs bg-white text-primary px-1 ml-1 rounded">NEW</span>
                    </a>
                    <div id="dropdown-1" data-width="384px" class="js-dropdown-source hidden">
                        <div class="flex p-5 text-gray-700">
                            <div class="w-1/2 pr-4 border-r border-gray-100">
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

                <div class="group flex-shrink-0 category-link-container px-3 first:pl-0 last:pr-0">
                    <a href="#" class="category-link hover:text-white/80 font-semibold py-1 inline-block transition duration-150 text-white">
                        Official Partner
                    </a>
                    <div id="dropdown-2" data-width="384px" class="js-dropdown-source hidden">
                        <div class="flex p-5 text-gray-700">
                            <div class="w-1/2 pr-4 border-r border-gray-100">
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

                <div class="group flex-shrink-0 category-link-container px-3 first:pl-0 last:pr-0">
                    <a href="{{url('/promo')}}" class="category-link hover:text-white/80 font-semibold py-1 inline-block transition duration-150 text-white">
                        Promo
                    </a>
                    <div id="dropdown-3" data-width="384px" class="js-dropdown-source hidden">
                        <div class="flex p-5 text-gray-700">
                            <div class="w-1/2 pr-4 border-r border-gray-100">
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

                <div class="group flex-shrink-0 category-link-container px-3 first:pl-0 last:pr-0">
                    <a href="{{url('/')}}" class="category-link hover:text-white/80 font-semibold py-1 inline-block text-white border-b-2 border-white transition duration-150">
                        Kategori
                    </a>
                    <div id="dropdown-5" data-width="900px" data-layout="center" class="js-dropdown-source hidden">
                        <div class="flex p-6 text-gray-700">
                            <div class="w-1/5 pr-4 border-r border-gray-100">
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
                            <div class="w-1/5 px-4 border-r border-gray-100">
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
                            <div class="w-1/5 px-4 border-r border-gray-100">
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
                                        class="flex items-center space-x-3 bg-gray-100 rounded-lg p-3 hover:bg-gray-200 transition cursor-pointer">
                                        <div class="h-16 w-16 bg-gray-300 rounded-lg flex-shrink-0">

                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm">Cara Menghitung Kebutuhan Besi Beton</p>
                                            <span class="text-xs text-primary">Lihat Kalkulator →</span>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center space-x-3 bg-gray-100 rounded-lg p-3 hover:bg-gray-200 transition cursor-pointer">
                                        <div class="h-16 w-16 bg-gray-300 rounded-lg flex-shrink-0">


                                            [Image of Structural Steel Profiles]

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

                <div class="group flex-shrink-0 category-link-container px-3 first:pl-0 last:pr-0">
                    <a href="#" class="category-link hover:text-white/80 font-semibold py-1 inline-block transition duration-150 text-white">
                        Kegiatan
                    </a>
                </div>

                <div class="group flex-shrink-0 category-link-container px-3 first:pl-0 last:pr-0">
                    <a href="{{url('faq')}}" class="category-link hover:text-white/80 font-semibold py-1 inline-block transition duration-150 text-white">
                        FAQ
                    </a>
                </div>
            </div>

            <!-- <button id="category-scroll-right" aria-label="Gulir Kategori ke Kanan"
                class="absolute right-[5%] top-0 bottom-0 px-2 bg-primary h-full flex items-center border-l border-light-grey shadow-lg cursor-pointer z-10 hover:bg-primary-dark transition duration-150">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button> -->
        </div>
    </div>
</header>

<div id="global-dropdown" class="fixed hidden bg-white shadow-2xl rounded-lg border border-gray-100 z-[90]"
    style="transition: opacity 0.1s ease;">
</div>


<script>
    // Anda dapat meletakkan ini di dalam tag <script> di bagian akhir <body>

    document.addEventListener('DOMContentLoaded', () => {
        const searchIconBtn = document.getElementById('search-icon-btn');
        const searchFormContainer = document.getElementById('search-form-container');
        const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
        const openMenuBtn = document.getElementById('open-menu-btn');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        // Toggle Search Form in Mobile Menu
        searchIconBtn.addEventListener('click', () => {
            const isExpanded = searchIconBtn.getAttribute('aria-expanded') === 'true' || false;

            searchFormContainer.classList.toggle('hidden');
            searchIconBtn.setAttribute('aria-expanded', !isExpanded);

            // Opsional: Fokuskan input setelah dibuka
            if (!isExpanded) {
                document.getElementById('mobile-search').focus();
            }
        });

        // Mobile Menu Open/Close Logic
        const openMenu = () => {
            mobileMenu.classList.remove('hidden');
            setTimeout(() => {
                mobileMenu.classList.add('opacity-100');
                mobileMenuDrawer.classList.remove('-translate-x-full');
            }, 10); // Jeda kecil untuk transisi overlay
        };

        const closeMenu = () => {
            mobileMenu.classList.remove('opacity-100');
            mobileMenuDrawer.classList.add('-translate-x-full');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
            }, 300); // Waktu yang sama dengan durasi transisi

            // Opsional: Sembunyikan form pencarian saat menu ditutup
            searchFormContainer.classList.add('hidden');
            searchIconBtn.setAttribute('aria-expanded', 'false');
        };

        openMenuBtn.addEventListener('click', openMenu);
        closeMenuBtn.addEventListener('click', closeMenu);

        // Close menu when clicking outside the drawer
        mobileMenu.addEventListener('click', (e) => {
            if (e.target.id === 'mobile-menu') {
                closeMenu();
            }
        });

        // Optional: Close menu with ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                closeMenu();
            }
        });
    });
</script>
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
                    <input type="search" name="search" id="mobile-search" placeholder="Ketik kata kunci..."
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
            {{-- Home --}}
            <a href="{{ url('/') }}"
                class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition duration-150">
                <span class="mr-3 text-xl w-8 text-center"><i class="fas fa-home text-gray-700"></i></span> Home
            </a>

            {{-- Kategori Produk (Accordion Style) --}}
            <div class="relative">
                <button id="mobile-category-btn"
                    class="w-full flex items-center justify-between p-3.5 font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition duration-150">
                    <div class="flex items-center">
                        <span class="mr-3 text-xl w-8 text-center"><i class="fas fa-tags text-gray-700"></i></span>
                        Kategori Produk
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" id="cat-chevron"></i>
                </button>

                {{-- Dropdown Content --}}
                <div id="mobile-category-list" class="hidden overflow-hidden bg-gray-50 rounded-xl mt-1 ml-4 border-l-2 border-primary/20">
                    @foreach($categoriesHeader as $category)
                    <div class="border-b border-gray-100 last:border-0">
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                            class="flex items-center p-3 text-sm font-bold text-gray-700 hover:text-primary">
                            {{ $category->name }}
                        </a>

                        @if($category->children->count() > 0)
                        <ul class="pb-2 pl-4">
                            @foreach($category->children as $child)
                            <li>
                                <a href="{{ route('products.index', ['category' => $child->slug]) }}"
                                    class="block p-2 text-xs text-gray-500 hover:text-primary active:font-bold">
                                    {{ $child->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Promo --}}
            <a href="{{ url('/promo') }}"
                class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition duration-150">
                <span class="mr-3 text-xl w-8 text-center"><i class="fas fa-fire text-gray-700"></i></span> Promo
            </a>

            {{-- Keranjang --}}
            <a href="{{ url('/keranjang') }}"
                class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition duration-150">
                <span class="mr-3 text-xl w-8 text-center"><i class="fas fa-shopping-cart text-gray-700"></i></span> Keranjang
            </a>
        </nav>

        <nav class="mt-6 pt-4 border-t border-gray-100 space-y-1">
            <h4 class="font-bold text-gray-600 mb-3 text-sm uppercase tracking-wider">Informasi & Bantuan</h4>
            {{-- Navigasi Informasi & Bantuan --}}
            <a href="{{ url('/faq') }}"
                class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-primary-light hover:text-primary rounded-xl transition duration-150">
                <span class="mr-3 text-xl"><i class="fas fa-question-circle"></i></span> FAQ
            </a>
            <a href="#"
                class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-primary-light hover:text-primary rounded-xl transition duration-150">
                <span class="mr-3 text-xl"><i class="fas fa-comments"></i></span> Pusat Bantuan
            </a>
            <a href="#" class="flex items-center p-3.5 font-semibold text-gray-700 hover:bg-primary-light hover:text-primary rounded-xl transition duration-150">
                <span class="mr-3 text-xl"><i class="fas fa-briefcase"></i></span> Kencana Bisnis
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
        <div class="container mx-auto px-4 sm:px-[5%] md:px-[9%] py-3 md:py-4 flex items-center justify-between overflow-x-hidden">

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
                    <input type="text" name="search" placeholder="Cari bantal, besi, semen..."
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

            <div class="flex items-center space-x-3 md:space-x-4 flex-shrink-0 ">

                <button aria-label="Buka Pencarian" class="hidden sm:hidden text-white p-2 rounded-md transition duration-200">
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
                    class="flex items-center space-x-1 text-white font-semibold hover:text-white/80 transition duration-150 cursor-pointer md:flex group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-sm hidden md:block">Hi, {{ Str::limit(auth('customer')->user()->full_name, 8, '..') }}</span>
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

    <div id="global-dropdown" class="fixed hidden bg-white shadow-2xl rounded-lg border border-gray-100 z-[90]"
        style="transition: opacity 0.1s ease;">
    </div>

    <div id="bottom-bar" class="bg-primary border-t border-b border-light-grey shadow-sm hidden md:block">
        <div class="container mx-auto px-[9%] flex items-center relative">


            <div id="category-list" class="flex flex-1 mx-2 overflow-x-scroll whitespace-nowrap scrollbar-hide scroll-smooth py-3">

                <div class="group flex-shrink-0 category-link-container px-3 first:pl-0 last:pr-0">
                    <a href="#" class="category-link hover:text-white/80 font-semibold py-1 inline-block transition duration-150 text-white">
                        Kencana Bisnis <span class="text-xs bg-white text-primary px-1 ml-1 rounded">NEW</span>
                    </a>
                </div>

                <div class="group flex-shrink-0 category-link-container px-3 first:pl-0 last:pr-0">
                    <a href="#" class="category-link hover:text-white/80 font-semibold py-1 inline-block transition duration-150 text-white">
                        Official Partner
                    </a>
                </div>

                <div class="group flex-shrink-0 category-link-container px-3 first:pl-0 last:pr-0">
                    <a href="{{url('/promo')}}" class="category-link hover:text-white/80 font-semibold py-1 inline-block transition duration-150 text-white">
                        Promo
                    </a>
                </div>

                <div class="group flex-shrink-0 category-link-container px-3 first:pl-0 last:pr-0">
                    <a href="{{ url('/') }}"
                        data-dropdown-id="category-dropdown-content"
                        class="js-dropdown-trigger hover:text-white/80 font-semibold py-1 inline-block text-white transition duration-150">
                        Kategori
                    </a>

                    <div id="category-dropdown-content" class="hidden">
                        <div class="p-4 w-[300px] bg-white shadow-xl rounded-b-lg">
                            <div class="flex flex-col space-y-4 text-gray-700">
                                @foreach($categoriesHeader as $category)
                                <div class="flex flex-col group/item">
                                    {{-- Parent Category --}}
                                    <h4 class="font-bold text-gray-800 text-sm mb-1 pb-1 border-b border-gray-50 tracking-tight flex items-center justify-between group-hover/item:text-primary transition-colors">
                                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="hover:text-primary transition">
                                            {{ $category->name }}
                                        </a>
                                        @if($category->children->count() > 0)
                                        <i class="fas fa-chevron-right text-[10px] text-gray-300 group-hover/item:text-primary"></i>
                                        @endif
                                    </h4>

                                    {{-- Children List --}}
                                    @if($category->children->count() > 0)
                                    <ul class="space-y-1 ml-2 mt-1">
                                        @foreach($category->children as $child)
                                        <li>
                                            <a href="{{ route('products.index', ['category' => $child->slug]) }}"
                                                class="text-xs text-gray-500 hover:text-primary hover:pl-2 transform transition-all duration-200 block py-1">
                                                • {{ $child->name }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group flex-shrink-0 category-link-container px-3 first:pl-0 last:pr-0">
                    <a href="#" class="category-link hover:text-white/80 font-semibold py-1 inline-block transition duration-150 text-white">Kegiatan</a>
                </div>
                <div class="group flex-shrink-0 category-link-container px-3 first:pl-0 last:pr-0">
                    <a href="{{url('faq')}}" class="category-link hover:text-white/80 font-semibold py-1 inline-block transition duration-150 text-white">FAQ</a>
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

        // --- LOGIKA ACCORDION KATEGORI ---
        const categoryBtn = document.getElementById('mobile-category-btn');
        const categoryList = document.getElementById('mobile-category-list');
        const catChevron = document.getElementById('cat-chevron');

        if (categoryBtn) {
            categoryBtn.addEventListener('click', () => {
                const isHidden = categoryList.classList.contains('hidden');
                if (isHidden) {
                    categoryList.classList.remove('hidden');
                    catChevron.style.transform = 'rotate(180deg)';
                } else {
                    categoryList.classList.add('hidden');
                    catChevron.style.transform = 'rotate(0deg)';
                }
            });
        }
    });



    document.addEventListener('DOMContentLoaded', () => {
        const globalDropdown = document.getElementById('global-dropdown');
        const triggers = document.querySelectorAll('.js-dropdown-trigger');
        let hideTimeout;

        const showDropdown = (trigger) => {
            clearTimeout(hideTimeout);
            const contentId = trigger.getAttribute('data-dropdown-id');
            const contentSource = document.getElementById(contentId);

            if (contentSource && globalDropdown) {
                globalDropdown.innerHTML = contentSource.innerHTML;
                globalDropdown.classList.remove('hidden');

                // 1. Ambil posisi tombol (trigger)
                const rect = trigger.getBoundingClientRect();

                // 2. Terapkan posisi FIXED
                globalDropdown.style.position = 'fixed';

                // TEPAT DI BAWAH TOMBOL
                globalDropdown.style.top = `${rect.bottom}px`;

                // TEPAT SEJAJAR SISI KIRI TOMBOL
                let leftPos = rect.left;

                // 3. Proteksi agar tidak keluar layar kanan (Opsional)
                const dropdownWidth = 300; // Lebar menu Anda
                if (leftPos + dropdownWidth > window.innerWidth) {
                    // Jika menu terlalu lebar ke kanan, geser ke kiri secukupnya
                    leftPos = window.innerWidth - dropdownWidth - 20;
                }

                globalDropdown.style.left = `${leftPos}px`;

                // Efek muncul
                setTimeout(() => {
                    globalDropdown.style.opacity = '1';
                }, 50);
            }
        };

        const startHideTimer = () => {
            hideTimeout = setTimeout(() => {
                globalDropdown.style.opacity = '0';
                setTimeout(() => {
                    globalDropdown.classList.add('hidden');
                }, 200);
            }, 150);
        };

        triggers.forEach(trigger => {
            trigger.addEventListener('mouseenter', () => showDropdown(trigger));
            trigger.addEventListener('mouseleave', startHideTimer);
        });

        globalDropdown.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
        globalDropdown.addEventListener('mouseleave', startHideTimer);

        // Otomatis tutup saat scroll agar posisi tetap sinkron
        window.addEventListener('scroll', () => {
            if (!globalDropdown.classList.contains('hidden')) {
                globalDropdown.classList.add('hidden');
                globalDropdown.style.opacity = '0';
            }
        });
    });
</script>
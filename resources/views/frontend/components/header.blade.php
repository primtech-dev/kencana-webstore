<style>
    /* Menghilangkan scrollbar tapi tetap bisa di-scroll */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
<div id="mobile-menu"
    class="fixed top-0 left-0 w-full h-full bg-slate-900/60 backdrop-blur-sm z-[99] hidden transition-opacity duration-300 ease-in-out"
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
        <p class="font-bold text-gray-800">Kencana Menu</p>

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
                <span class="mr-3 text-xl"><i class="fas fa-briefcase"></i></span> Official Partner
                <span class="text-xs bg-red-500 text-white font-medium px-2 py-0.5 ml-2 rounded-full transform -translate-y-px">NEW</span>
            </a>
        </nav>

    </div>
</div>

<header class="w-full shadow-md sticky top-0 z-[5] font-sans">

    <div class="bg-primary py-2 md:py-3">
        <div class="container mx-auto px-4 lg:px-[8%] flex items-center gap-3 md:gap-6">

            <button id="open-menu-btn" class="md:hidden text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div class="shrink-0">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('asset/Kencana Store Putih.png') }}" alt="Logo" class="w-10 md:w-28 h-auto">
                </a>
            </div>

            <div class="hidden sm:block flex-1 max-w-2xl">
                <form action="{{ route('products.index') }}" method="GET" class="flex bg-white rounded overflow-hidden p-0.5">
                    <input type="text" name="search" placeholder="Cari Merek, Nama, atau Tipe Produk..."
                        class="w-full px-4 py-2 text-sm text-gray-700 focus:outline-none">
                    <button type="submit" class="bg-[#cc0000] text-white px-5 hover:bg-black transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <div class="flex items-center space-x-3 md:space-x-6 text-white ml-auto md:ml-0">


                <a href="{{ url('/keranjang') }}" class="relative group flex items-center space-x-2">
                    <div class="relative">
                        <i class="fas fa-shopping-cart text-2xl md:text-2xl"></i>
                        @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-yellow-400 text-black  font-black h-5 w-5 flex items-center justify-center rounded-full border-2 border-primary">{{ $cartCount }}</span>
                        @endif
                    </div>
                    <span class=" leading-tight font-bold hidden md:block capitalize text-left">Keranjang</span>
                </a>

                <!-- whistlist -->
                <a href="#" class="relative group flex items-center space-x-2">
                    <div class="relative">
                        <i class="fas fa-heart text-2xl md:text-2xl"></i>
                    </div>
                    <span class=" leading-tight font-bold hidden md:block capitalize text-left">Wishlist</span>
                </a>

                <!-- Notifikasi -->
                <a href="#" class="relative group flex items-center space-x-2">
                    <div class="relative">
                        <i class="fas fa-bell text-2xl md:text-2xl"></i>
                        @if($notificationCount ?? 0)
                        <span class="absolute -top-2 -right-2 bg-yellow-400 text-black  font-black h-5 w-5 flex items-center justify-center rounded-full border-2 border-primary">{{ $notificationCount }}</span>
                        @endif
                    </div>
                    <span class=" leading-tight font-bold hidden md:block capitalize text-left">Notifikasi</span>

                <!-- akun -->
                @auth('customer')
                <a href="{{ route('member.index') }}" class="relative group flex items-center space-x-2">
                    <div class="relative">
                        <i class="fas fa-user text-2xl md:text-2xl"></i>
                    </div>
                    <span class=" leading-tight font-bold hidden md:block capitalize text-left"> {{ Str::limit(auth('customer')->user()->full_name, 12) }}</span>
                </a>
                @else
                <a href="{{ route('customer.login') }}" class="relative group flex items-center space-x-2">
                    <div class="relative">
                        <i class="fas fa-user text-2xl md:text-2xl"></i>
                    </div>
                    <span class=" leading-tight font-bold hidden md:block capitalize text-left">Akun</span>
                </a>
                @endauth

            </div>
        </div>

        <div class="px-4 mt-2 sm:hidden">
            <form action="{{ route('products.index') }}" method="GET" class="flex bg-white rounded overflow-hidden p-0.5">
                <input type="text" name="search" placeholder="Cari di Kencana Store..." class="w-full px-3 py-1.5 text-sm text-gray-700 focus:outline-none">
                <button type="submit" class="bg-[#cc0000] text-white px-4"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>

    <div class="bg-white px-[1%] md:px-[3.5%] border-b border-gray-200 py-1 md:py-2">
        <div class="container mx-auto px-4 lg:px-[5%] flex items-center justify-between">
            <nav class="flex items-center space-x-5 text-[12px] md:text-[13px] font-bold text-gray-700 overflow-x-auto no-scrollbar whitespace-nowrap">
                <button class="flex items-center text-primary js-dropdown-trigger" data-dropdown-id="category-dropdown-content">
                    SEMUA KATEGORI
                </button>
                <div class="h-4 w-[1px] bg-gray-300 hidden md:block"></div>
                <a href="#" class="hover:text-primary hidden md:block">Official Partner</a>
                <a href="#" class="hover:text-primary hidden md:block">Promo</a>
                <a href="#" class="hover:text-primary hidden md:block">FAQ</a>
                <a href="{{route('branches.index')}}" class="hover:text-primary hidden md:block">Lokasi Toko</a>
                <a href="#" class="hover:text-primary hidden md:block">Download APP</a>
            </nav>

            <div class="flex items-center space-x-2 ml-4">
                @auth('customer')
                {{-- Tampilan Cabang --}}
                <div class="flex flex-col items-end mr-4">
                    <!-- <span class="text-[10px] text-gray-400 font-bold leading-none uppercase tracking-tight">Lokasi Belanja:</span> -->

                    {{-- Klik pada nama cabang langsung membuka modal --}}
                    <button type="button" onclick="openBranchModal()"
                        class="flex items-center text-primary hover:text-primary-dark transition-colors duration-200 group" title="{{ $currentBranch->name ?? 'pilih cabang'}}">
                        <i class="fas fa-map-marker-alt mr-1.5 text-xs"></i>
                        <span class="text-sm font-bold border-b border-dotted border-primary group-hover:border-primary-dark">
                            {{$currentBranch != null ? Str::limit($currentBranch->name, 18, '...') : 'Pilih Cabang' }}
                        </span>
                        <i class="fas fa-chevron-down ml-1.5 text-[10px] opacity-50 group-hover:rotate-180 transition-transform"></i>
                    </button>
                </div>
                @else
                {{-- Tampilan Cabang --}}
                <div class="flex flex-col items-end mr-4">
                    <!-- <span class="text-[10px] text-gray-400 font-bold leading-none uppercase tracking-tight">Lokasi Belanja:</span> -->

                    {{-- Klik pada nama cabang langsung membuka modal --}}
                    <button type="button" onclick="openBranchModal()"
                        class="flex items-center text-primary hover:text-primary-dark transition-colors duration-200 group" title="{{ $currentBranch->name ?? 'pilih cabang'}}">
                        <i class="fas fa-map-marker-alt mr-1.5 text-xs"></i>
                        <span class="text-sm font-bold border-b border-dotted border-primary group-hover:border-primary-dark">
                            {{$currentBranch != null ? Str::limit($currentBranch->name, 8, '...') : 'Pilih Cabang' }}
                        </span>
                        <i class="fas fa-chevron-down ml-1.5 text-[10px] opacity-50 group-hover:rotate-180 transition-transform"></i>
                    </button>
                </div>
                <a href="{{ route('customer.login') }}" class="border border-primary text-primary px-5 py-1.5 rounded font-bold text-xs capitalize hover:bg-blue-50 transition">Login</a>
                <a href="{{ route('customer.register') }}" class=" hidden md:block bg-primary text-white px-5 py-1.5 rounded font-bold text-xs capitalize hover:bg-[#002a54] transition shadow-sm">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</header>

<div id="category-dropdown-content" class="hidden">
    <div class="w-[280px] bg-white rounded-b-lg border-t-2 border-primary py-2">
        @foreach($categoriesHeader as $category)
        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="flex items-center justify-between px-4 py-2.5 text-sm font-bold text-gray-700 hover:bg-red-50 hover:text-primary border-b border-gray-50 last:border-0">
            {{ $category->name }}
            <i class="fas fa-chevron-right  opacity-30"></i>
        </a>
        @endforeach
    </div>
</div>



<div id="global-dropdown" class="fixed hidden bg-white shadow-xl rounded-b-xl border border-gray-100 z-[100] opacity-0 transition-opacity duration-200"></div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const mobileMenu = document.getElementById('mobile-menu');
        const drawer = document.getElementById('mobile-menu-drawer');
        const openBtn = document.getElementById('open-menu-btn');
        const closeBtn = document.getElementById('close-menu-btn');

        // Drawer Logic
        const toggleMenu = (isOpen) => {
            if (isOpen) {
                mobileMenu.classList.remove('hidden');
                setTimeout(() => {
                    mobileMenu.classList.add('opacity-100');
                    drawer.classList.remove('-translate-x-full');
                }, 10);
                document.body.style.overflow = 'hidden'; // Lock scroll
            } else {
                mobileMenu.classList.remove('opacity-100');
                drawer.classList.add('-translate-x-full');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);
                document.body.style.overflow = '';
            }
        };

        openBtn.addEventListener('click', () => toggleMenu(true));
        closeBtn.addEventListener('click', () => toggleMenu(false));
        mobileMenu.addEventListener('click', (e) => {
            if (e.target === mobileMenu) toggleMenu(false);
        });

        // Accordion Kategori Mobile
        const catBtn = document.getElementById('mobile-category-btn');
        const catList = document.getElementById('mobile-category-list');
        const chevron = document.getElementById('cat-chevron');

        if (catBtn) {
            catBtn.addEventListener('click', () => {
                const isHidden = catList.classList.toggle('hidden');
                chevron.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        }

        // Global Dropdown Logic (Tetap seperti sebelumnya namun dengan style update)
        // ... (Logika showDropdown Anda sudah bagus, biarkan tetap ada)
        // --- DESKTOP DROPDOWN LOGIC ---
        const globalDropdown = document.getElementById('global-dropdown');
        const triggers = document.querySelectorAll('.js-dropdown-trigger');
        let hideTimeout;

        const showDropdown = (trigger) => {
            clearTimeout(hideTimeout);
            const contentId = trigger.getAttribute('data-dropdown-id');
            const source = document.getElementById(contentId);

            if (source) {
                globalDropdown.innerHTML = source.innerHTML;
                globalDropdown.classList.remove('hidden');

                const rect = trigger.getBoundingClientRect();
                globalDropdown.style.top = `${rect.bottom}px`;
                globalDropdown.style.left = `${rect.left}px`;
                globalDropdown.style.width = `300px`; // Set fixed width

                setTimeout(() => globalDropdown.style.opacity = '1', 50);
            }
        };

        triggers.forEach(t => {
            t.addEventListener('mouseenter', () => showDropdown(t));
            t.addEventListener('mouseleave', () => {
                hideTimeout = setTimeout(() => {
                    globalDropdown.style.opacity = '0';
                    setTimeout(() => globalDropdown.classList.add('hidden'), 200);
                }, 150);
            });
        });

        globalDropdown.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
        globalDropdown.addEventListener('mouseleave', () => {
            globalDropdown.style.opacity = '0';
            setTimeout(() => globalDropdown.classList.add('hidden'), 200);
        });

    });
</script>
@endpush
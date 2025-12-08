<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Webstore - Kencana') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-cream-custom">


    @include('frontend.components.header')


    @if (session('success'))
    <script>
        Swal.fire({
            title: 'Success',
            text: "{{ session('success')}}",
            icon: 'success',
            showConfirmButton: true,
            confirmButtonText: 'Oke',
            confirmButtonColor: '#ee0d0dd6',

            timer: 3000
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error')}}",
            showConfirmButton: true,
            timer: 3000,
            confirmButtonColor: '#ee0d0dd6',
        });
    </script>
    @endif


    @if ($errors->any())
    <div class="mt-4 p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    @yield('content')

    @include('frontend.components.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- VARIABEL SLIDER ---
            const categoryList = document.getElementById('category-list');
            const catScrollLeft = document.getElementById('category-scroll-left');
            const catScrollRight = document.getElementById('category-scroll-right');
            const scrollAmount = 300; // Jumlah scroll per klik

            // --- VARIABEL MENU MOBILE ---
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
            const openMenuBtn = document.getElementById('open-menu-btn');
            const closeMenuBtn = document.getElementById('close-menu-btn');

            // --- VARIABEL DROPDOWN BARU ---
            const globalDropdown = document.getElementById('global-dropdown');
            const categoryListElement = document.getElementById('category-list');
            const categoryLinks = categoryListElement ? categoryListElement.querySelectorAll('.category-link') : [];
            const bottomBar = document.getElementById('bottom-bar');
            let hideTimeout; // Untuk mengelola jeda mouseout

            // Dapatkan semua elemen container tautan kategori (DIV yang membungkus A dan dropdown source)
            const categoryContainers = document.querySelectorAll('.category-link-container');


            // 1. FUNGSI SLIDER KATEGORI
            if (categoryList) {
                catScrollLeft.addEventListener('click', () => {
                    categoryList.scrollBy({
                        left: -scrollAmount,
                        behavior: 'smooth'
                    });
                });

                catScrollRight.addEventListener('click', () => {
                    categoryList.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                });
            }

            // 2. FUNGSI MENU MOBILE
            function openMobileMenu() {
                mobileMenu.classList.remove('hidden');
                setTimeout(() => {
                    mobileMenuDrawer.classList.remove('-translate-x-full');
                }, 10);
                document.body.style.overflow = 'hidden';
            }

            function closeMobileMenu() {
                mobileMenuDrawer.classList.add('-translate-x-full');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                    document.body.style.overflow = '';
                }, 300);
            }

            openMenuBtn.addEventListener('click', openMobileMenu);
            closeMenuBtn.addEventListener('click', closeMobileMenu);
            mobileMenu.addEventListener('click', (e) => {
                if (e.target === mobileMenu) {
                    closeMobileMenu();
                }
            });

            // 3. FUNGSI DROPDOWN

            const hideDropdown = () => {
                // Sembunyikan dropdown setelah jeda singkat, kecuali jika mouse masuk ke dalam dropdown itu sendiri
                hideTimeout = setTimeout(() => {
                    if (!globalDropdown.matches(':hover')) {
                        globalDropdown.classList.add('hidden');
                    }
                }, 100);
            };

            // Mouse Enter pada Tautan Kategori
            categoryContainers.forEach(container => {
                const link = container.querySelector('.category-link');
                if (!link) return;

                link.addEventListener('mouseenter', function() {
                    clearTimeout(hideTimeout);

                    const dropdownContent = container.querySelector('.js-dropdown-source');
                    if (!dropdownContent) return;

                    // 1. Ambil Data
                    const rect = this.getBoundingClientRect();
                    const barRect = bottomBar.getBoundingClientRect();
                    const contentWidth = parseFloat(dropdownContent.dataset.width.replace('px', ''));
                    const isCentered = dropdownContent.dataset.layout === 'center';

                    // 2. Inject Konten & Ukuran
                    globalDropdown.innerHTML = dropdownContent.innerHTML;
                    globalDropdown.style.width = dropdownContent.dataset.width;

                    // 3. Hitung Posisi Top (Tepat di bawah Bottom Bar)
                    const topPosition = barRect.bottom;

                    // 4. Hitung Posisi Left
                    let leftPosition = rect.left;

                    if (isCentered) {
                        // Centering logic: Posisi kiri link + (lebar link / 2) - (lebar dropdown / 2)
                        leftPosition = rect.left + (rect.width / 2) - (contentWidth / 2);

                        // Batasan layar (agar tidak keluar dari layar kiri/kanan)
                        if (leftPosition < 10) leftPosition = 10;
                        if (leftPosition + contentWidth > window.innerWidth - 10) {
                            leftPosition = window.innerWidth - contentWidth - 10;
                        }
                    }

                    // 5. Atur Posisi dan Tampilkan
                    globalDropdown.style.top = `${topPosition}px`;
                    globalDropdown.style.left = `${leftPosition}px`;
                    globalDropdown.classList.remove('hidden');
                });

                // Mouse Leave pada Tautan Kategori
                link.addEventListener('mouseleave', hideDropdown);
            });

            // Mouse Leave pada Dropdown Global
            globalDropdown.addEventListener('mouseleave', () => {
                globalDropdown.classList.add('hidden');
            });

            // Mouse Enter pada Dropdown Global (Untuk mencegah penutupan)
            globalDropdown.addEventListener('mouseenter', () => {
                clearTimeout(hideTimeout);
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
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

    {{-- Opsional: Tampilkan status cabang yang aktif --}}
    @if (session('selected_branch_id'))
    <div class="px-4 mb-4 p-3 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg">
        Anda sedang melihat produk untuk cabang: 
        <strong>{{ $branches->where('id', session('selected_branch_id'))->first()->name ?? 'Cabang Tidak Ditemukan' }}</strong>
    </div>
    @elseif (!session('selected_branch_id') && !session('success'))
    <div class="px-4 mb-4 p-3 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg cursor-pointer" onclick="document.getElementById('branch-modal').classList.remove('hidden')">
        ⚠️ Anda belum memilih cabang toko. Klik di sini untuk memilih cabang terdekat.
    </div>
    @endif
    
    {{-- Tampilkan notifikasi jika ada --}}
    @if (session('info'))
    <div class="px-4 mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('info') }}
    </div>
    @endif

    <section class="mb-8 px-4">
        <h2 class="text-xl font-bold mb-4 text-dark-grey">Rekomendasi Spesial Untukmu</h2>

        <p class="text-sm text-dark-grey mb-4">
            *Perbedaan harga mungkin terjadi, harga terbaru tertera pada halaman detail produk
        </p>

        <div class="flex border-b border-light-grey mb-6">
            <button class="pb-2 mr-6 text-primary border-b-2 border-primary font-semibold">Spesial
                Rekomendasi</button>
            <button class="pb-2 text-dark-grey hover:text-primary">Produk Terlaris</button>
        </div>
        <div class="relative">
            <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

                @foreach ($products as $product)
                {{-- Product card rendering logic remains the same --}}
                <a href="{{ route('products.show', $product->id) }}"
                    class="bg-white border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer block">
                    <div class="relative">
                        @php
                        $mainImage = $product->images->where('is_main', true)->first();
                        if ($mainImage) {
                        $baseUrl = env('APP_URL_BE');
                        $baseUrl = rtrim($baseUrl, '/') . '/';
                        $imageUrl = $baseUrl . ltrim($mainImage->url, '/');
                        } else {
                        $imageUrl = 'https://placehold.co/600x400/000/ffffff?text=No+Image';
                        }
                        $productName = $product->name;
                        // Logika stok berdasarkan weight_gram (seperti yang ada di kode awal Anda)
                        $stockStatus = ($product->weight_gram > 50) ? 'Stok Terbatas' : 'Stok Tersedia';
                        $stockColor = ($product->weight_gram > 50) ? 'bg-discount' : 'bg-primary';
                        @endphp

                        <img src="{{ $imageUrl }}"
                            alt="{{ $productName }}"
                            onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                            class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">

                        <div class="absolute top-2 right-2 {{ $stockColor }} text-white text-xs font-bold px-2 py-1 rounded">
                            {{ $stockStatus }}
                        </div>
                    </div>

                    <div class="p-3 md:p-4">
                        <p class="text-xs text-dark-grey mb-1 line-clamp-1">
                            {{ $product->categories->first()->name ?? 'Tanpa Kategori' }}
                        </p>
                        <p class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem]">
                            {{ $productName }}
                        </p>
                        @php
                        $mainVariant = $product->variants->first();
                        $priceCents = $mainVariant ? $mainVariant->price : 0;
                        $displayPrice = 'Rp' . number_format($priceCents, 0, ',', '.');
                        @endphp
                        <p class="text-base md:text-lg font-bold text-discount">{{ $displayPrice }}</p>
                        <div class="flex items-center text-xs text-dark-grey mt-2">
                            <span class="text-primary">★</span>
                            <span class="ml-1">4.{{ rand(0, 9) }}</span>
                            <span class="ml-2 text-dark-grey">| {{ rand(1, 300) }} (ulasan)</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6">
                {{ $products->links('frontend.components.custom-pagestyle') }}
            </div>
            @endif
        </div>
    </section>
</main>

@if (session('success') || !session('selected_branch_id'))
<div id="branch-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 {{ session('selected_branch_id') ? 'hidden' : '' }}">
    <div class="bg-white rounded-lg shadow-2xl max-w-sm w-full p-6">
        <h3 class="text-xl font-bold mb-4 text-primary">🎉 Selamat Datang!</h3>
        <p class="text-dark-grey mb-4">Pilih lokasi toko cabang terdekat Anda untuk mendapatkan informasi stok dan harga yang akurat.</p>
        
        {{-- Menambahkan kelas default untuk styling status --}}
        <div id="location-status" class="mb-4 text-sm text-center p-2 rounded-md bg-gray-100 text-gray-600 transition-colors duration-300">
            Tekan **'Cari Lokasi Saya'** untuk menemukan cabang terdekat.
        </div>
        
        <button id="find-location-btn" type="button" 
            class="w-full mb-4 px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-md hover:bg-green-600 focus:outline-none transition duration-150 flex items-center justify-center">
            <svg id="spinner" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Cari Lokasi Saya Saat Ini
        </button>

        <form action="{{ route('set.branch') }}" id="branch-form" method="POST"> 
            @csrf
            <input type="hidden" name="user_lat" id="user_lat_input">
            <input type="hidden" name="user_lon" id="user_lon_input">
            <div class="mb-4">
                <label for="branch_select" class="block text-sm font-medium text-dark-grey mb-2">Pilih Cabang:</label>
                <select id="branch_select" name="branch_id" required
                    class="block w-full px-3 py-2 border border-light-grey rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                    disabled> {{-- Disabled by default --}}
                    <option value="">Pilih Cabang Toko</option>
                    {{-- Opsi akan diisi oleh JS, atau default oleh PHP jika JS gagal --}}
                    @isset($branches)
                        @foreach ($branches as $branch)
                            {{-- Pengecekan ini penting jika fillBranchSelectDefault tidak dipanggil oleh DOMContentLoaded --}}
                            {{-- Jika Anda hanya mengandalkan JS, bagian ini bisa dihapus, tetapi ini fallback yang baik --}}
                            @if (!session('selected_branch_id'))
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endif
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('branch-modal').classList.add('hidden')"
                    class="px-4 py-2 text-sm font-medium text-dark-grey border border-light-grey rounded-md hover:bg-light-grey transition duration-150">
                    Nanti Saja
                </button>
                <button type="submit" id="submit-branch-btn"
                    class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-md hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150">
                    Pilih Cabang
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    // Pastikan variabel ini ada di controller dan berisi data lat/lon cabang yang sudah di-map menjadi array of objects.
    const ALL_BRANCHES = @json($branchesForJS ?? $branches);
    

    const BRANCH_SELECT = document.getElementById('branch_select');
    const MODAL = document.getElementById('branch-modal');
    const FIND_LOCATION_BTN = document.getElementById('find-location-btn');
    const LOCATION_STATUS = document.getElementById('location-status');
    const SPINNER = document.getElementById('spinner');
    const USER_LAT_INPUT = document.getElementById('user_lat_input');
    const USER_LON_INPUT = document.getElementById('user_lon_input');
    
    // Kelas status untuk UI
    const STATUS_CLASSES = {
        default: ['bg-gray-100', 'text-gray-600'],
        loading: ['bg-blue-100', 'text-blue-700'],
        success: ['bg-green-100', 'text-green-700'],
        error: ['bg-red-100', 'text-red-700'],
        timeout: ['bg-yellow-100', 'text-yellow-700'] 
    };
    
    // Fungsi utilitas untuk membersihkan dan menerapkan kelas status
    function updateLocationStatusUI(message, statusKey) {
        Object.values(STATUS_CLASSES).forEach(classes => {
            LOCATION_STATUS.classList.remove(...classes);
        });
        LOCATION_STATUS.classList.add(...STATUS_CLASSES[statusKey]);
        LOCATION_STATUS.innerHTML = message;
    }


    // Fungsi untuk menghitung jarak Haversine (tetap sama)
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius Bumi dalam kilometer
        const dLat = (lat2 - lat1) * (Math.PI / 180);
        const dLon = (lon2 - lon1) * (Math.PI / 180);
        const a = 
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; // Jarak dalam kilometer
    }
    
    // Fungsi REVERSE GEOCODING (Nominatim API) 
    async function getNominatimAddress(lat, lng) {
        const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;
        try {
            const response = await fetch(url, {
                headers: {
                    'User-Agent': 'AplikasiECommerce/1.0 (contact@example.com)' 
                }
            });
            const data = await response.json();
            return data.display_name || "Alamat tidak ditemukan."; 
        } catch (error) {
            console.error("Nominatim Reverse Geocoding Gagal:", error);
            return "Gagal mendapatkan alamat.";
        }
    }


    // Fungsi utama pencarian lokasi
    function findUserLocation() {
        if (!navigator.geolocation) {
            updateLocationStatusUI("⚠️ Geolocation tidak didukung oleh browser ini.", 'error');
            fillBranchSelectDefault();
            return;
        }
        
        updateLocationStatusUI("⏳ **Sedang mencari lokasi Anda...**", 'loading');
        FIND_LOCATION_BTN.disabled = true;
        SPINNER.classList.remove('hidden');

        navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    }

    // Fungsi jika berhasil mendapatkan lokasi
    async function successCallback(position) {
        const userLat = position.coords.latitude;
        const userLon = position.coords.longitude;
        
        console.log(`Posisi Pengguna Ditemukan: Lat=${userLat}, Lon=${userLon}`);

        USER_LAT_INPUT.value = userLat;
        USER_LON_INPUT.value = userLon;

        // 1. Hitung jarak dan urutkan
        const branchesWithDistance = ALL_BRANCHES.map(branch => {
            // *** PERBAIKAN MASALAH 1: Menggunakan 'latitude' dan 'longitude' ***
            const branchLat = parseFloat(branch.latitude); 
            const branchLon = parseFloat(branch.longitude);

            // Jika data lat/lon cabang tidak valid, set jarak ke Infinity (akan diurutkan ke akhir)
            if (isNaN(branchLat) || isNaN(branchLon)) {
                console.error(`LAT atau LON cabang ${branch.name} TIDAK VALID, diabaikan dari urutan terdekat. Data Cabang:`, branch);
                return { ...branch, distance: Infinity }; 
            }
            
            const distance = calculateDistance(userLat, userLon, branchLat, branchLon);
            console.log(`Jarak ke ${branch.name}: ${distance.toFixed(2)} km`);

            return { ...branch, distance: distance };
        }).sort((a, b) => a.distance - b.distance); // Urutkan dari yang terdekat

        // 2. Isi dropdown
        fillBranchSelect(branchesWithDistance);
        
        // 3. Dapatkan dan tampilkan alamat
        const address = await getNominatimAddress(userLat, userLon);
        
        // 4. Update status sukses
        updateLocationStatusUI(`✅ **Lokasi Ditemukan:** ${address} (Cabang terdekat terurut otomatis)`, 'success');
        
        // Kembalikan tombol
        FIND_LOCATION_BTN.disabled = false;
        SPINNER.classList.add('hidden');
    }

    // Fungsi jika gagal mendapatkan lokasi
    function errorCallback(error) {
        let message;
        let statusKey = 'error';
        
        if (error.code === error.PERMISSION_DENIED) {
            message = "❌ **Akses lokasi ditolak.** Silakan izinkan akses lokasi di pengaturan browser Anda, atau pilih cabang manual.";
        } else if (error.code === error.TIMEOUT) {
            message = "⚠️ **Waktu pengambilan lokasi habis.** Jaringan mungkin lambat. Silakan coba lagi atau pilih cabang manual.";
            statusKey = 'timeout'; 
        } else {
            message = "❌ **Gagal mengambil lokasi Anda.** Pilih cabang manual.";
        }
        
        console.error("Geolocation Error:", error.message, error.code);
        updateLocationStatusUI(message, statusKey);
        fillBranchSelectDefault(); // Tetap isi dropdown default agar user bisa memilih manual
        
        // Kembalikan tombol
        FIND_LOCATION_BTN.disabled = false;
        SPINNER.classList.add('hidden');
    }

    // Mengisi SELECT dengan hasil perhitungan (diurutkan)
    function fillBranchSelect(branches) {
        let options = '<option value="">-- Cabang Terdekat (Terurut) --</option>';
        branches.forEach(branch => {
            // Menggunakan Infinity check untuk menampilkan N/A pada cabang yang datanya buruk
            const distanceKm = (branch.distance !== Infinity && branch.distance) ? branch.distance.toFixed(2) : 'N/A';
            options += `<option value="${branch.id}">${branch.name} (${distanceKm} km)</option>`;
        });
        BRANCH_SELECT.innerHTML = options;
        BRANCH_SELECT.disabled = false; // Aktifkan dropdown
    }

    // Mengisi SELECT dengan data default
    function fillBranchSelectDefault() {
        let options = `<option value="">-- Pilih Cabang Toko --</option>`;
        ALL_BRANCHES.forEach(branch => {
            options += `<option value="${branch.id}">${branch.name}</option>`;
        });
        BRANCH_SELECT.innerHTML = options;
        BRANCH_SELECT.disabled = false; // Aktifkan dropdown
    }
    
    // Event listener untuk tombol 'Cari Lokasi Saya Saat Ini'
    FIND_LOCATION_BTN.addEventListener('click', findUserLocation);

    // Initial check on DOM load
    document.addEventListener('DOMContentLoaded', function() {
        
        @if (!session('selected_branch_id'))
            fillBranchSelectDefault(); // Pastikan default list terisi saat modal muncul pertama kali
        @endif

        // *** PERBAIKAN MASALAH 2: Menggunakan ID spesifik 'branch-warning-alert' ***
        // Pastikan Anda telah menambahkan ID="branch-warning-alert" di HTML Blade
        const branchInfoDiv = document.getElementById('branch-warning-alert'); 
        if (branchInfoDiv) {
            branchInfoDiv.addEventListener('click', () => {
                MODAL.classList.remove('hidden');
                updateLocationStatusUI("Tekan **'Cari Lokasi Saya'** untuk menemukan cabang terdekat.", 'default');
                fillBranchSelectDefault();
            });
        }
    });
</script>

@endsection
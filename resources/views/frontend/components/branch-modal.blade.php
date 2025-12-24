{{-- PERUBAHAN DI SINI: Modal selalu ada di DOM, tapi defaultnya hidden --}}
{{-- Modal akan muncul otomatis HANYA jika TIDAK ada session('selected_branch_id') --}}
<div id="branch-modal" class="fixed inset-0 z-[999] @if (session('selected_branch_id')) hidden @endif bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
        <div class="relative bg-black p-6 text-white text-center">
            <h3 class="text-xl font-bold tracking-tight">Pilih Cabang Terdekat</h3>
            <p class="text-blue-100 text-xs mt-1 opacity-80">Dapatkan stok & harga yang akurat sesuai lokasi Anda</p>

            {{-- Tombol Close (X) --}}
            <button onclick="closeBranchModal()" class="absolute top-4 right-4 text-white/70 hover:text-white transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div class="p-6">
            {{-- Status Lokasi (Dibuat lebih subtle) --}}
            <div id="location-status" class="mb-5 text-xs text-center py-2 px-4 rounded-full bg-slate-50 border border-slate-100 text-slate-500 transition-all">
                <i class="fas fa-info-circle mr-1"></i> Tekan tombol di bawah untuk deteksi otomatis
            </div>

            {{-- Tombol Deteksi Lokasi yang Modern --}}
            <button id="find-location-btn" type="button"
                class="w-full mb-6 group relative flex items-center justify-center px-6 py-3 font-bold text-primary border-2 border-primary rounded-xl hover:bg-primary hover:text-white transition-all duration-300 overflow-hidden">
                <div id="spinner" class="animate-spin mr-3 h-5 w-5 hidden">
                    <svg class="h-full w-full" fill="none" viewBox="0 0 24 24 text-current">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <i class="fas fa-location-arrow mr-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm">Cari Lokasi Saya Sekarang</span>
            </button>

            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center"><span class="w-full border-t border-slate-100"></span></div>
                <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-3 text-slate-400 font-medium">Atau Pilih Manual</span></div>
            </div>

            <form action="{{ route('set.branch') }}" id="branch-form" method="POST">
                @csrf
                <input type="hidden" name="user_lat" id="user_lat_input">
                <input type="hidden" name="user_lon" id="user_lon_input">

                <div class="mb-6 relative">
                    <select id="branch_select" name="branch_id" required
                        class="block w-full pl-4 pr-10 py-3.5 bg-slate-50 border-0 ring-1 ring-slate-200 rounded-xl appearance-none focus:ring-2 focus:ring-primary focus:bg-white transition-all text-sm font-medium text-slate-700 disabled:opacity-50"
                        disabled>
                        <option value="">-- Pilih Cabang Toko --</option>
                        @isset($branches)
                        @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                        @endisset
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" id="submit-branch-btn"
                        class="w-full px-6 py-4 text-sm font-black uppercase tracking-widest text-white bg-[#e60000] rounded-xl hover:bg-[#c40000] shadow-lg shadow-red-200 transition-all active:scale-[0.98]">
                        Konfirmasi Pilihan
                    </button>

                    <button type="button" onclick="closeBranchModal()"
                        class="w-full px-6 py-2 text-xs font-bold text-slate-400 hover:text-slate-600 transition tracking-wide">
                        NANTI SAJA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Fungsi Global untuk Membuka Modal
    window.openBranchModal = function() {
        const modal = document.getElementById('branch-modal');
        if (modal) {
            // Menghapus hidden dan memastikan menggunakan flex agar posisi di tengah
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Animasi halus (Opsional: jika Anda menambahkan class transition)
            setTimeout(() => {
                modal.style.opacity = "1";
            }, 10);

            // Reset UI Modal ke kondisi awal
            if (typeof updateLocationStatusUI === "function") {
                updateLocationStatusUI("Tekan **'Cari Lokasi Saya'** untuk menemukan cabang terdekat.", 'default');
            }

            if (typeof fillBranchSelectDefault === "function") {
                fillBranchSelectDefault();
            }
        }
    };

    // Fungsi Global untuk Menutup Modal
    window.closeBranchModal = function() {
        const modal = document.getElementById('branch-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    };

    // Tambahan: Menutup modal jika user klik di area luar (overlay)
    window.onclick = function(event) {
        const modal = document.getElementById('branch-modal');
        if (event.target == modal) {
            closeBranchModal();
        }
    };


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
        success: ['bg-light-gray', 'text-dark-grey'],
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
            // Menggunakan 'latitude' dan 'longitude'
            const branchLat = parseFloat(branch.latitude);
            const branchLon = parseFloat(branch.longitude);

            // Jika data lat/lon cabang tidak valid, set jarak ke Infinity (akan diurutkan ke akhir)
            if (isNaN(branchLat) || isNaN(branchLon)) {
                console.error(`LAT atau LON cabang ${branch.name} TIDAK VALID, diabaikan dari urutan terdekat. Data Cabang:`, branch);
                return {
                    ...branch,
                    distance: Infinity
                };
            }

            const distance = calculateDistance(userLat, userLon, branchLat, branchLon);
            console.log(`Jarak ke ${branch.name}: ${distance.toFixed(2)} km`);

            return {
                ...branch,
                distance: distance
            };
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
            options += `<option value="${branch.id}"" class="branch-option">${branch.name} (${distanceKm} km)</option>`;
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

        // Pastikan dropdown terisi, terutama jika modal muncul otomatis
        @if(!session('selected_branch_id'))
        fillBranchSelectDefault();
        @endif

        // 1. Event listener untuk Div Peringatan (jika belum memilih cabang)
        const branchInfoDiv = document.getElementById('branch-warning-alert');
        if (branchInfoDiv) {
            branchInfoDiv.addEventListener('click', () => {
                MODAL.classList.remove('hidden');
                updateLocationStatusUI("Tekan **'Cari Lokasi Saya'** untuk menemukan cabang terdekat.", 'default');
                fillBranchSelectDefault();
            });
        }

        // 2. Event listener untuk Tombol Ganti Cabang (jika sudah memilih cabang)
        const changeBranchBtn = document.getElementById('change-branch-btn');
        if (changeBranchBtn) {
            changeBranchBtn.addEventListener('click', () => {
                MODAL.classList.remove('hidden');
                updateLocationStatusUI("Tekan **'Cari Lokasi Saya'** untuk mengurutkan ulang cabang terdekat.", 'default');
                fillBranchSelectDefault(); // Isi ulang list default
            });
        }
    });
</script>
@extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto">

        <h1 class="text-2xl font-extrabold text-gray-800 mb-6">Daftar Alamat Saya</h1>

        {{-- GRID UTAMA: Navigasi Sidebar dan Konten Utama --}}
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">

            {{-- KOLOM KIRI: Sidebar Navigasi --}}
            <div class="lg:col-span-3 mb-6 lg:mb-0">
                {{-- Panggil komponen, dan kirim 'daftar-alamat' sebagai menu aktif --}}
                @include('frontend.components.member-sidebar', ['activeMenu' => 'daftar-alamat'])
            </div>

            {{-- KOLOM KANAN: Konten Utama (Daftar Alamat) --}}
            <div class="lg:col-span-9">
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    {{-- Header dan Tombol Tambah Alamat (tetap sama) --}}
                    <div class="flex justify-between items-center mb-6 border-b pb-3">
                        <h2 class="text-xl font-extrabold text-gray-800">Alamat Tersimpan</h2>
                        {{-- Tombol untuk memicu Modal Tambah Alamat --}}
                        <button id="openMapModal" class="py-2 px-4 rounded-lg bg-primary text-white font-bold text-sm hover:bg-primary-dark transition duration-150 shadow-md">
                            <i class="fas fa-plus mr-2"></i> Tambah Alamat Baru
                        </button>
                    </div>



                    <div class="space-y-4">
                        {{-- LOGIKA LOOPING ALAMAT --}}
                        @forelse($addresses as $address)
                        <div class="p-4 border {{ $address->is_default ? 'border-primary-500 shadow-lg bg-primary-50' : 'border-gray-200 shadow-sm' }} rounded-lg relative">
                            @if ($address->is_default)
                            <span class="absolute top-0 right-0 bg-primary text-white text-xs font-bold px-3 py-1 rounded-bl-lg">UTAMA</span>
                            @endif

                            <p class="font-bold text-gray-800 {{ $address->is_default ? 'mt-2' : '' }}">{{ $address->label }}</p>
                            {{-- Asumsi Anda menyimpan nama penerima di kolom 'label' atau 'street' sementara --}}
                            <p class="text-sm text-gray-700">Telp: {{ $address->phone }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $address->street }},
                                {{ $address->city }},
                                {{ $address->province }} - {{ $address->postal_code }}
                                ({{ $address->latitude }}, {{ $address->longitude }})
                            </p>
                            <div class="mt-3 flex space-x-3 text-sm">

                                {{-- TOMBOL UBAH (Nanti akan memicu modal EDIT) --}}
                                <button type="button"
                                    class="text-primary hover:underline font-semibold edit-address-btn"
                                    data-address-id="{{ $address->id }}"
                                    data-label="{{ $address->label }}"
                                    data-street="{{ $address->street }}"
                                    data-city="{{ $address->city }}"
                                    data-province="{{ $address->province }}"
                                    data-postal-code="{{ $address->postal_code }}"
                                    data-phone="{{ $address->phone }}"
                                    data-latitude="{{ $address->latitude }}"
                                    data-longitude="{{ $address->longitude }}"
                                    data-is-default="{{ $address->is_default ? 'true' : 'false' }}">
                                    Ubah
                                </button>

                                {{-- FORM HAPUS --}}
                                <form action="{{ route('member.addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alamat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-semibold">Hapus</button>
                                </form>

                                {{-- FORM JADIKAN UTAMA --}}
                                @unless($address->is_default)
                                <form action="{{ route('member.addresses.default', $address) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-green-600 hover:underline font-semibold border-l pl-3">
                                        Jadikan Utama
                                    </button>
                                </form>
                                @endunless
                            </div>
                        </div>
                        @empty
                        {{-- Jika daftar kosong --}}
                        <div class="text-center py-10 text-gray-500">
                            <i class="fas fa-map-marker-alt text-4xl mb-3"></i>
                            <p>Anda belum memiliki alamat tersimpan. Silakan tambahkan!</p>
                        </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- Masukkan Modal Peta di sini (akan didefinisikan di bagian selanjutnya) --}}
@include('frontend.components.map-modal')

@endsection

{{-- Script untuk Leaflet.js akan diletakkan di bagian bawah layout atau file ini --}}
{{-- Anda perlu memastikan Leaflet CSS dan JS di-load --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


<!-- <script>
    // Pastikan kode ini diletakkan di dalam tag <script> di akhir file member/addresses.blade.php

    document.addEventListener('DOMContentLoaded', function() {
        // === 1. PENGAMBILAN ELEMEN DOM ===
        const mapModal = document.getElementById('mapModal');
        const openMapModalBtn = document.getElementById('openMapModal');
        const closeMapModalBtn = document.getElementById('closeMapModal');
        const latlngOutput = document.getElementById('latlngOutput');
        const inputLatitude = document.getElementById('inputLatitude');
        const inputLongitude = document.getElementById('inputLongitude');
        const fullAddressTextarea = document.getElementById('full_address');

        // Elemen DOM untuk Pencarian
        const searchInput = document.getElementById('addressSearchInput');
        const searchButton = document.getElementById('searchAddressBtn');
        const searchMessage = document.getElementById('searchMessage');

        // === 2. VARIABEL PETA ===
        let map = null;
        let marker = null;
        const initialLat = -6.2088; // Default: Jakarta
        const initialLng = 106.8456; // Default: Jakarta
        let isMapInitialized = false;

        // === 3. FUNGSI GEOCoding ===

        // FUNGSI A: Reverse Geocoding (Lat/Lng -> Alamat)
        function reverseGeocode(lat, lng) {
            fullAddressTextarea.value = "Mencari detail alamat...";

            // Menggunakan Nominatim API
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    let address = data.display_name || "Alamat tidak ditemukan.";

                    // Format alamat yang lebih rapi dari komponen address
                    if (data.address) {
                        const components = data.address;
                        address = [
                            components.road,
                            components.suburb,
                            components.city || components.town || components.village,
                            components.state,
                            components.postcode,
                            components.country
                        ].filter(part => part).join(', ');
                    }

                    fullAddressTextarea.value = address;
                })
                .catch(error => {
                    console.error('Error fetching address:', error);
                    fullAddressTextarea.value = "Gagal mengambil alamat detail. Silakan isi manual.";
                });
        }

        // FUNGSI B: Forward Geocoding (Alamat -> Lat/Lng)
        function forwardGeocode(query) {
            if (!map) return;
            searchMessage.classList.add('hidden');

            // Tampilkan loading state
            searchInput.disabled = true;
            searchButton.disabled = true;
            searchButton.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;

            // Menggunakan Nominatim API
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);

                        // Pindahkan marker dan pusatkan peta
                        const newLatLng = L.latLng(lat, lng);
                        marker.setLatLng(newLatLng);
                        map.setView(newLatLng, 15);

                        // Update koordinat dan panggil reverse geocode
                        updateCoordinates(lat, lng);
                    } else {
                        searchMessage.innerText = "Alamat tidak ditemukan. Coba kata kunci lain.";
                        searchMessage.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error searching address:', error);
                    searchMessage.innerText = "Terjadi kesalahan saat mencari alamat.";
                    searchMessage.classList.remove('hidden');
                })
                .finally(() => {
                    // Hentikan loading state
                    searchInput.disabled = false;
                    searchButton.disabled = false;
                    searchButton.innerHTML = `<i class="fas fa-search"></i> <span class="hidden sm:inline ml-2">Cari</span>`;
                });
        }

        // FUNGSI C: Update Koordinat dan Trigger Reverse Geocode
        function updateCoordinates(lat, lng) {
            latlngOutput.innerHTML = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
            inputLatitude.value = lat.toFixed(6);
            inputLongitude.value = lng.toFixed(6);

            reverseGeocode(lat, lng);
        }


        // === 4. LOGIKA MODAL DAN PETA ===

        openMapModalBtn.addEventListener('click', function() {
            mapModal.classList.remove('hidden');
            mapModal.classList.add('flex');
            searchInput.value = ''; // Kosongkan input pencarian
            searchMessage.classList.add('hidden'); // Sembunyikan pesan error

            setTimeout(() => {
                if (!isMapInitialized) {
                    // INISIALISASI PERTAMA KALI
                    map = L.map('leafletMap', {
                        center: [initialLat, initialLng],
                        zoom: 15,
                        scrollWheelZoom: true
                    });

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    // Tambahkan Marker yang bisa di-drag
                    marker = L.marker([initialLat, initialLng], {
                        draggable: true
                    }).addTo(map);

                    // Event listener ketika marker di-drag
                    marker.on('dragend', function(e) {
                        const latlng = marker.getLatLng();
                        updateCoordinates(latlng.lat, latlng.lng);
                    });

                    // Update koordinat awal dan lakukan reverse geocode pertama kali
                    updateCoordinates(initialLat, initialLng);

                    isMapInitialized = true;

                } else {
                    // REFRESH PETA SAAT MODAL DIBUKA KEMBALI
                    map.invalidateSize();
                    map.setView(marker.getLatLng(), map.getZoom());
                }
            }, 50);
        });

        closeMapModalBtn.addEventListener('click', function() {
            mapModal.classList.add('hidden');
            mapModal.classList.remove('flex');
        });

        mapModal.addEventListener('click', function(e) {
            if (e.target === mapModal) {
                closeMapModalBtn.click();
            }
        });

        // === 5. LOGIKA PENCARIAN ALAMAT ===

        // Event listener untuk tombol 'Cari'
        searchButton.addEventListener('click', function() {
            const query = searchInput.value.trim();
            if (query) {
                forwardGeocode(query);
            }
        });

        // Event listener untuk tombol 'Enter' pada input pencarian
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchButton.click();
            }
        });
    });
</script> -->




<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === 1. PENGAMBILAN ELEMEN DOM ===
        const mapModal = document.getElementById('mapModal');
        const openMapModalBtn = document.getElementById('openMapModal');
        const closeMapModalBtn = document.getElementById('closeMapModal');
        const latlngOutput = document.getElementById('latlngOutput');
        const inputLatitude = document.getElementById('inputLatitude');
        const inputLongitude = document.getElementById('inputLongitude');
        // ID field form yang sesuai dengan skema DB:
        const inputLabel = document.getElementById('label');
        const inputStreet = document.getElementById('street');
        const inputCity = document.getElementById('city');
        const inputProvince = document.getElementById('province');
        const inputPostalCode = document.getElementById('postal_code');
        const inputPhone = document.getElementById('phone'); // Optional: jika ingin default phone

        // Elemen DOM untuk Pencarian
        const searchInput = document.getElementById('addressSearchInput');
        const searchButton = document.getElementById('searchAddressBtn');
        const searchMessage = document.getElementById('searchMessage');

        // === 2. VARIABEL PETA ===
        let map = null;
        let marker = null;
        const initialLat = -6.2088; // Default: Jakarta
        const initialLng = 106.8456; // Default: Jakarta
        let isMapInitialized = false;

        // === 3. FUNGSI GEOCoding & FORM FILL ===

        // FUNGSI UTAMA: Mengisi field form dengan data yang diekstrak
        function fillAddressForm(components) {
            // Ambil nama komponen dari Nominatim
            const city = components.city || components.town || components.village || components.county || '';
            const province = components.state || components.province || '';
            const postcode = components.postcode || '';

            // Coba bangun detail jalan/street
            const streetDetail = [
                components.road,
                components.house_number,
                components.suburb,
                components.neighbourhood
            ].filter(part => part).join(', ');

            // Teks alamat lengkap (untuk ditampilkan/disimpan di field 'street')
            const fullAddressText = [
                streetDetail || components.display_name,
                city,
                province,
                postcode
            ].filter(part => part).join(', ');

            // Mengisi field form
            inputStreet.value = streetDetail || fullAddressText; // Lebih spesifik ke detail jalan
            inputCity.value = city;
            inputProvince.value = province;
            inputPostalCode.value = postcode;

            // Opsional: set label default jika belum diisi
            if (!inputLabel.value) {
                inputLabel.value = streetDetail ? 'Rumah Baru' : 'Alamat Baru';
            }

            searchMessage.classList.add('hidden');
        }


        // FUNGSI A: Reverse Geocoding (Lat/Lng -> Alamat)
        function reverseGeocode(lat, lng) {
            inputStreet.value = "Mencari detail alamat...";

            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.address) {
                        // Panggil fungsi pengisi form dengan komponen alamat terstruktur
                        fillAddressForm(data.address);
                    } else {
                        inputStreet.value = data.display_name || "Alamat tidak ditemukan. Silakan isi manual.";
                    }
                })
                .catch(error => {
                    console.error('Error fetching address:', error);
                    inputStreet.value = "Gagal mengambil alamat detail. Silakan isi manual.";
                });
        }

        // FUNGSI B: Forward Geocoding (Alamat -> Lat/Lng)
        function forwardGeocode(query) {
            if (!map) return;
            searchMessage.classList.add('hidden');

            searchInput.disabled = true;
            searchButton.disabled = true;
            searchButton.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;

            // Menambahkan boundarybox untuk memprioritaskan Indonesia/Asia Tenggara (optional)
            // bbox=-6.21,106.85,-7.21,107.85 (Contoh area Jakarta/Bandung)
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1&addressdetails=1`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);

                        const newLatLng = L.latLng(lat, lng);
                        marker.setLatLng(newLatLng);
                        map.setView(newLatLng, 15);

                        // Update koordinat output
                        updateCoordinates(lat, lng, false); // Jangan panggil reverse geocode lagi

                        // Isi form langsung dari hasil forward geocoding (lebih cepat)
                        fillAddressForm(data[0].address);

                    } else {
                        searchMessage.innerText = "Alamat tidak ditemukan. Coba kata kunci lain.";
                        searchMessage.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error searching address:', error);
                    searchMessage.innerText = "Terjadi kesalahan saat mencari alamat.";
                    searchMessage.classList.remove('hidden');
                })
                .finally(() => {
                    searchInput.disabled = false;
                    searchButton.disabled = false;
                    searchButton.innerHTML = `<i class="fas fa-search"></i> <span class="hidden sm:inline ml-2">Cari</span>`;
                });
        }

        // FUNGSI C: Update Koordinat dan Trigger Reverse Geocode (Default: true)
        function updateCoordinates(lat, lng, shouldReverseGeocode = true) {
            latlngOutput.innerHTML = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
            inputLatitude.value = lat.toFixed(6);
            inputLongitude.value = lng.toFixed(6);

            if (shouldReverseGeocode) {
                reverseGeocode(lat, lng);
            }
        }


        // === 4. LOGIKA MODAL DAN PETA ===

        openMapModalBtn.addEventListener('click', function() {
            mapModal.classList.remove('hidden');
            mapModal.classList.add('flex');

            // Reset state saat modal dibuka
            searchInput.value = '';
            searchMessage.classList.add('hidden');

            // Set input phone default jika ada (misal dari data member)
            // inputPhone.value = "{{ $customer->phone ?? '' }}"; // Jika Anda memiliki variabel $customer

            // Kosongkan alamat saat dibuka, agar user tahu harus mengisi
            inputStreet.value = '';
            inputCity.value = '';
            inputProvince.value = '';
            inputPostalCode.value = '';


            setTimeout(() => {
                if (!isMapInitialized) {
                    // INISIALISASI PERTAMA KALI
                    map = L.map('leafletMap', {
                        center: [initialLat, initialLng],
                        zoom: 15,
                        scrollWheelZoom: true
                    });

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    marker = L.marker([initialLat, initialLng], {
                        draggable: true
                    }).addTo(map);

                    // Event listener ketika marker di-drag
                    marker.on('dragend', function(e) {
                        const latlng = marker.getLatLng();
                        updateCoordinates(latlng.lat, latlng.lng); // Reverse Geocoding saat digeser
                    });

                    // Update koordinat awal dan lakukan reverse geocode pertama kali
                    updateCoordinates(initialLat, initialLng);

                    isMapInitialized = true;

                } else {
                    // REFRESH PETA SAAT MODAL DIBUKA KEMBALI
                    map.invalidateSize();
                    map.setView(marker.getLatLng(), map.getZoom());
                }
            }, 50);
        });

        closeMapModalBtn.addEventListener('click', function() {
            mapModal.classList.add('hidden');
            mapModal.classList.remove('flex');
        });

        mapModal.addEventListener('click', function(e) {
            if (e.target === mapModal) {
                closeMapModalBtn.click();
            }
        });

        // === 5. LOGIKA PENCARIAN ALAMAT ===
        searchButton.addEventListener('click', function() {
            const query = searchInput.value.trim();
            if (query) {
                forwardGeocode(query);
            }
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchButton.click();
            }
        });
    });
</script>
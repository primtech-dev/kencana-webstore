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
                    <div class="flex justify-between items-center mb-6 border-b pb-3">
                        <h2 class="text-xl font-extrabold text-gray-800">Alamat Tersimpan</h2>
                        {{-- Tombol untuk memicu Modal Tambah Alamat --}}
                        <button id="openMapModal" class="py-2 px-4 rounded-lg bg-primary text-white font-bold text-sm hover:bg-primary-dark transition duration-150 shadow-md">
                            <i class="fas fa-plus mr-2"></i> Tambah Alamat Baru
                        </button>
                    </div>

                    <div class="space-y-4">

                        {{-- Kartu Alamat 1 (Utama) --}}
                        <div class="p-4 border border-primary-500 rounded-lg shadow-lg relative bg-primary-50">
                            <span class="absolute top-0 right-0 bg-primary text-white text-xs font-bold px-3 py-1 rounded-bl-lg">UTAMA</span>
                            <p class="font-bold text-gray-800 mt-2">Rumah Budi Setiawan</p>
                            <p class="text-sm text-gray-700">Penerima: Budi Setiawan (0812-3456-7890)</p>
                            <p class="text-sm text-gray-500 mt-1">Jln. Mawar No. 12, RT 01/ RW 02, Kel. Sukamaju, Kec. Cikupa, Tangerang, Banten 15710</p>
                            <div class="mt-3 flex space-x-3 text-sm">
                                <button class="text-primary hover:underline font-semibold">Ubah</button>
                                <button class="text-red-600 hover:underline font-semibold">Hapus</button>
                            </div>
                        </div>

                        {{-- Kartu Alamat 2 (Kantor) --}}
                        <div class="p-4 border border-gray-200 rounded-lg shadow-sm">
                            <p class="font-bold text-gray-800">Kantor Utama</p>
                            <p class="text-sm text-gray-700">Penerima: Sekretaris (021-xxxxxxx)</p>
                            <p class="text-sm text-gray-500 mt-1">Jl. Sudirman Kav. 52-53, Jakarta Selatan, DKI Jakarta 12190</p>
                            <div class="mt-3 flex space-x-3 text-sm">
                                <button class="text-primary hover:underline font-semibold">Ubah</button>
                                <button class="text-red-600 hover:underline font-semibold">Hapus</button>
                                <button class="text-green-600 hover:underline font-semibold border-l pl-3">Jadikan Utama</button>
                            </div>
                        </div>

                        {{-- Jika daftar kosong --}}
                        {{-- <div class="text-center py-10 text-gray-500">
                            <i class="fas fa-map-marker-alt text-4xl mb-3"></i>
                            <p>Anda belum memiliki alamat tersimpan. Silakan tambahkan!</p>
                        </div> --}}

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


<script>
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
</script>
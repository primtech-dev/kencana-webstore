@extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto">

        <h1 class="text-2xl font-extrabold text-gray-800 mb-6">Daftar Alamat Saya</h1>

        {{-- GRID UTAMA: Navigasi Sidebar dan Konten Utama --}}
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">

            {{-- KOLOM KIRI: Sidebar Navigasi --}}
            <div class="lg:col-span-3 mb-6 lg:mb-0">
                @include('frontend.components.member-sidebar', ['activeMenu' => 'daftar-alamat'])
            </div>

            {{-- KOLOM KANAN: Konten Utama (Daftar Alamat) --}}
            <div class="lg:col-span-9">
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    
                    {{-- Header dan Tombol Tambah Alamat --}}
                    <div class="flex justify-between items-center mb-6 border-b pb-3">
                        <h2 class="text-xl font-extrabold text-gray-800">Alamat Tersimpan</h2>
                        {{-- Tombol untuk memicu Modal Tambah Alamat --}}
                        <button id="openMapModal" class="py-2 px-4 rounded-lg bg-primary text-white font-bold text-sm hover:bg-primary-dark transition duration-150 shadow-md">
                            <i class="fas fa-plus mr-2"></i> Tambah Alamat Baru
                        </button>
                    </div>

                   
                    @if ($errors->any())
                        <div class="mt-4 p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-4">
                        {{-- LOGIKA LOOPING ALAMAT --}}
                        @forelse($addresses as $address)
                        <div class="p-4 border {{ $address->is_default ? 'border-primary-500 shadow-lg bg-primary-50' : 'border-gray-200 shadow-sm' }} rounded-lg relative">
                            
                            {{-- Label Utama --}}
                            @if ($address->is_default)
                            <span class="absolute top-0 right-0 bg-primary text-white text-xs font-bold px-3 py-1 rounded-bl-lg">UTAMA</span>
                            @endif

                            <p class="font-bold text-gray-800 {{ $address->is_default ? 'mt-2' : '' }}">{{ $address->label }}</p>
                            <p class="text-sm text-gray-700">Telp: {{ $address->phone }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $address->street }},
                                {{ $address->city }},
                                {{ $address->province }} - {{ $address->postal_code }}
                                ({{ number_format($address->latitude, 6) }}, {{ number_format($address->longitude, 6) }})
                            </p>
                            
                            <div class="mt-3 flex space-x-3 text-sm">
                                
                                {{-- TOMBOL UBAH (Memicu Modal Edit) --}}
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
                                    data-is-default="{{ $address->is_default ? 'true' : 'false' }}"
                                >
                                    Ubah
                                </button>
                                
                                {{-- FORM HAPUS --}}
                                <form action="{{ route('member.addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alamat ini? Jika alamat ini utama, Anda harus menetapkan yang lain sebagai utama terlebih dahulu.');">
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

{{-- Masukkan Modal Peta --}}
@include('frontend.components.map-modal')

@endsection

{{-- Leaflet.js CDN --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

{{-- SCRIPT UTAMA UNTUK PETA DAN MODAL --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === 1. PENGAMBILAN ELEMEN DOM ===
        const mapModal = document.getElementById('mapModal');
        const openMapModalBtn = document.getElementById('openMapModal');
        const closeMapModalBtn = document.getElementById('closeMapModal');
        const latlngOutput = document.getElementById('latlngOutput');
        const inputLatitude = document.getElementById('inputLatitude');
        const inputLongitude = document.getElementById('inputLongitude');
        const inputLabel = document.getElementById('label');
        const inputStreet = document.getElementById('street');
        const inputCity = document.getElementById('city');
        const inputProvince = document.getElementById('province');
        const inputPostalCode = document.getElementById('postal_code');
        const inputPhone = document.getElementById('phone');
        const inputIsDefault = document.getElementById('is_default');

        // Elemen DOM untuk Pencarian & Form
        const searchInput = document.getElementById('addressSearchInput');
        const searchButton = document.getElementById('searchAddressBtn');
        const searchMessage = document.getElementById('searchMessage');
        const addressForm = document.getElementById('addressForm');
        const formMethod = document.getElementById('formMethod');
        const submitButton = document.getElementById('submitButton');
        const modalTitle = document.getElementById('modalTitle');
        const editButtons = document.querySelectorAll('.edit-address-btn');


        // === 2. VARIABEL PETA ===
        let map = null;
        let marker = null;
        const initialLat = -6.2088; // Default: Jakarta
        const initialLng = 106.8456; // Default: Jakarta
        let isMapInitialized = false;

        // === 3. FUNGSI GEOCoding & FORM FILL ===

        function fillAddressForm(components) {
            const city = components.city || components.town || components.village || components.county || '';
            const province = components.state || components.province || '';
            const postcode = components.postcode || '';

            const streetDetail = [
                components.road, 
                components.house_number, 
                components.suburb, 
                components.neighbourhood
            ].filter(part => part).join(', ');

            // Mengisi field form
            inputStreet.value = streetDetail || components.display_name || ''; 
            inputCity.value = city;
            inputProvince.value = province;
            inputPostalCode.value = postcode;
            
            // Opsional: set label default jika belum diisi
            if (!inputLabel.value) {
                inputLabel.value = streetDetail ? 'Rumah Baru' : 'Alamat Baru';
            }

            searchMessage.classList.add('hidden');
        }


        function reverseGeocode(lat, lng) {
            inputStreet.value = "Mencari detail alamat...";
            
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.address) {
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

        function forwardGeocode(query) {
            if (!map) return;
            searchMessage.classList.add('hidden');
            
            searchInput.disabled = true;
            searchButton.disabled = true;
            searchButton.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;
            
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1&addressdetails=1`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);
                        
                        // Gunakan initializeMap untuk update peta
                        initializeMap(lat, lng);
                        
                        updateCoordinates(lat, lng, false); // Update koordinat output, jangan panggil reverse geocode lagi
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

        function updateCoordinates(lat, lng, shouldReverseGeocode = true) {
            latlngOutput.innerHTML = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
            inputLatitude.value = lat.toFixed(6);
            inputLongitude.value = lng.toFixed(6);
            
            if (shouldReverseGeocode) {
                reverseGeocode(lat, lng);
            }
        }
        
        // FUNGSI INISIALISASI/UPDATE PETA (PENTING UNTUK MENGATASI MODAL)
        function initializeMap(lat, lng) {
            if (!isMapInitialized) {
                // INISIALISASI PERTAMA KALI
                map = L.map('leafletMap', {
                    center: [lat, lng],
                    zoom: 15,
                    scrollWheelZoom: true
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                marker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(map);

                marker.on('dragend', function(e) {
                    const latlng = marker.getLatLng();
                    updateCoordinates(latlng.lat, latlng.lng);
                });

                isMapInitialized = true;
            }
            
            // Update lokasi marker dan tampilan peta
            marker.setLatLng(L.latLng(lat, lng));
            map.setView(L.latLng(lat, lng), 15);
        }


        // === 4. LOGIKA MODAL DAN PETA (TAMBAH/CREATE) ===

        openMapModalBtn.addEventListener('click', function() {
            // 1. Reset form ke mode TAMBAH
            addressForm.action = "{{ route('member.addresses.store') }}";
            formMethod.value = 'POST';
            submitButton.innerHTML = 'Simpan Alamat';
            modalTitle.innerText = 'Tentukan Lokasi di Peta';
            addressForm.reset();
            
            // 2. Tampilkan Modal
            mapModal.classList.remove('hidden');
            mapModal.classList.add('flex');
            
            searchInput.value = ''; 
            searchMessage.classList.add('hidden');

            setTimeout(() => {
                // 3. Inisialisasi/Update Peta ke lokasi default
                initializeMap(initialLat, initialLng);
                map.invalidateSize(); // BARIS KRUSIAL: Refresh ukuran setelah modal muncul
                updateCoordinates(initialLat, initialLng);
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
        
        // === 6. LOGIKA EDIT ALAMAT (UPDATE) ===
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const data = this.dataset;
                const addressId = data.addressId;
                const lat = parseFloat(data.latitude);
                const lng = parseFloat(data.longitude);
                const isDefault = data.isDefault === 'true';

                // 1. Ubah Form untuk Mode EDIT
                addressForm.action = `{{ url('member/daftar-alamat') }}/${addressId}`;
                formMethod.value = 'PUT';
                submitButton.innerHTML = 'Perbarui Alamat';
                modalTitle.innerText = 'Ubah Detail Alamat';
                
                // 2. Isi Data ke Form Fields
                inputLabel.value = data.label;
                inputStreet.value = data.street;
                inputCity.value = data.city;
                inputProvince.value = data.province;
                inputPostalCode.value = data.postalCode;
                inputPhone.value = data.phone;
                inputIsDefault.checked = isDefault;

                // 3. Tampilkan Modal
                mapModal.classList.remove('hidden');
                mapModal.classList.add('flex');
                
                // PENTING: Panggil logika peta di dalam setTimeout
                setTimeout(() => {
                    // 4. Inisialisasi/Update Peta ke lokasi alamat yang diedit
                    initializeMap(lat, lng);
                    map.invalidateSize(); // BARIS KRUSIAL: Refresh ukuran setelah modal muncul
                    updateCoordinates(lat, lng, false); // Update koordinat output, tanpa reverse geocode
                }, 100); 
            });
        });
    });
</script>
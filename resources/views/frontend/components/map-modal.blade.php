{{-- File: frontend/components/map-modal.blade.php --}}

<div id="mapModal" class="fixed inset-0 bg-light-grey bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4">
        
        {{-- Header Modal --}}
        <div class="p-5 border-b flex justify-between items-center sticky top-0 bg-white z-10">
            <h3 class="text-xl font-bold text-gray-800">Tentukan Lokasi di Peta</h3>
            <button id="closeMapModal" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        {{-- Body Modal --}}
        <div class="p-5 space-y-5">
            
            {{-- Bagian Pencarian Alamat (BARU DITAMBAHKAN) --}}
            <div class="flex space-x-2">
                <input type="text" id="addressSearchInput" placeholder="Cari alamat atau nama tempat..." 
                       class="flex-grow border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-primary focus:border-primary">
                <button id="searchAddressBtn" class="py-2 px-4 rounded-lg bg-primary text-white font-bold hover:bg-primary-dark transition duration-150 flex-shrink-0">
                    <i class="fas fa-search"></i>
                    <span class="hidden sm:inline ml-2">Cari</span>
                </button>
            </div>
            <p id="searchMessage" class="text-sm text-red-500 hidden">Alamat tidak ditemukan. Coba kata kunci lain.</p>
            
            {{-- Bagian Peta Leaflet --}}
            <div id="map-container" class="w-full rounded-lg overflow-hidden border border-gray-300">
                <div id="leafletMap" style="height: 450px;"></div>
            </div>

            {{-- Informasi Koordinat yang Dipilih --}}
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <p class="text-sm font-semibold text-gray-700 mb-1">Koordinat Terpilih:</p>
                <p id="latlngOutput" class="font-bold text-lg text-primary">Lat: -6.2088, Lng: 106.8456</p>
                <p class="text-xs text-red-500 mt-1">Geser pin merah di peta untuk mengubah lokasi atau klik "Cari" di atas.</p>
            </div>
            
            {{-- Form Detail Alamat --}}
            <form action="{{ url('member/addresses') }}" method="POST" class="space-y-4">
                <input type="hidden" name="latitude" id="inputLatitude" value="-6.2088">
                <input type="hidden" name="longitude" id="inputLongitude" value="106.8456">

                <div>
                    <label for="address_name" class="block text-sm font-medium text-gray-700">Nama Alamat (Contoh: Rumah, Kantor)</label>
                    <input type="text" id="address_name" name="address_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-primary focus:border-primary" required>
                </div>

                <div>
                    <label for="full_address" class="block text-sm font-medium text-gray-700">Detail Alamat Lengkap (Jalan, RT/RW, Kelurahan)</label>
                    {{-- ID full_address harus tetap ada --}}
                    <textarea id="full_address" name="full_address" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-primary focus:border-primary" required></textarea>
                </div>
                
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label for="recipient_name" class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                        <input type="text" id="recipient_name" name="recipient_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-primary focus:border-primary" required>
                    </div>
                    <div class="w-1/2">
                        <label for="recipient_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="tel" id="recipient_phone" name="recipient_phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-primary focus:border-primary" required>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="is_main" name="is_main" type="checkbox" class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary">
                    <label for="is_main" class="ml-2 block text-sm text-gray-900">Jadikan alamat utama</label>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3 rounded-lg bg-primary text-white font-bold text-lg hover:bg-primary-dark transition duration-150">
                        Simpan Alamat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="mapModal" class="fixed inset-0 bg-light-grey bg-opacity-50 hidden items-center justify-center " style="z-index: 999;">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4">

        {{-- Header Modal --}}
        <div class="p-5 border-b flex justify-between items-center sticky top-0 bg-white z-10">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-800">Tentukan Lokasi di Peta</h3>
            <button id="closeMapModal" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        {{-- Body Modal --}}
        <div class="p-5 space-y-5">

            {{-- Bagian Pencarian Alamat --}}
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
            <form id="addressForm" action="{{ route('member.addresses.store') }}" method="POST" class="space-y-4">
                @csrf
                {{-- Hidden input untuk metode (POST atau PUT) --}}
                <input type="hidden" name="_method" value="POST" id="formMethod">

                {{-- Hidden Inputs untuk Koordinat --}}
                <input type="hidden" name="latitude" id="inputLatitude" value="-6.2088">
                <input type="hidden" name="longitude" id="inputLongitude" value="106.8456">

                {{-- Field: Label (Nama Alamat) --}}
                <div>
                    <label for="label" class="block text-sm font-medium text-gray-700">Label Alamat (Contoh: Rumah Utama, Kantor)</label>
                    <input type="text" id="label" name="label" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-primary focus:border-primary" required>
                </div>

                {{-- Field: Street (Alamat Lengkap) --}}
                <div>
                    <label for="street" class="block text-sm font-medium text-gray-700">Detail Jalan/Alamat Lengkap (Jalan, RT/RW, Kelurahan)</label>
                    <textarea id="street" name="street" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-primary focus:border-primary" required></textarea>
                </div>

                {{-- Field: City, Province, Postal Code --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Kota</label>
                        <input type="text" id="city" name="city" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-primary focus:border-primary" required>
                    </div>
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <input type="text" id="province" name="province" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-primary focus:border-primary" required>
                    </div>
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                        <input type="text" id="postal_code" name="postal_code" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-primary focus:border-primary" required>
                    </div>
                </div>

                {{-- Field: Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon (Penerima)</label>
                    <input type="tel" id="phone" name="phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-primary focus:border-primary" required>
                </div>

                {{-- Field: is_default --}}
                <div class="flex items-center">
                    <input id="is_default" name="is_default" type="checkbox" value="1" class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary">
                    <label for="is_default" class="ml-2 block text-sm text-gray-900">Jadikan alamat utama (Default)</label>
                </div>

                <div class="pt-4">
                    <button type="submit" id="submitButton" class="w-full py-3 rounded-lg bg-primary text-white font-bold text-lg hover:bg-primary-dark transition duration-150">
                        Simpan Alamat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
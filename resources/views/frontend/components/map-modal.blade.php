<div id="mapModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center"
    style="z-index: 9999;">

    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4"
        style="position: relative; z-index: 10000;">

        {{-- Header Modal (Sticky agar tidak hilang saat scroll form) --}}
        <div class="p-5 border-b flex justify-between items-center sticky top-0 bg-white"
            style="z-index: 10010;">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-800">Tentukan Lokasi di Peta</h3>
            <button id="closeMapModal" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        {{-- Body Modal --}}
        <div class="p-5 space-y-5">
            {{-- Bagian Pencarian --}}
            <div class="space-y-3">
                <div class="flex space-x-2">
                    <input type="text" id="addressSearchInput" placeholder="Cari lokasi..."
                        class="flex-grow border border-gray-300 rounded-lg p-2 text-sm focus:ring-primary focus:border-primary">
                    <button id="searchAddressBtn" class="py-2 px-4 rounded-lg bg-primary text-white font-bold">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <div class="flex justify-end">
                    <button type="button" id="getCurrentLocationBtn"
                        class="text-xs bg-blue-50 text-blue-600 font-bold py-1.5 px-3 rounded-md border border-blue-200">
                        <i class="fas fa-location-arrow mr-2"></i> Gunakan Lokasi Saat Ini
                    </button>
                </div>
            </div>

            {{-- Container Peta (Z-index rendah agar tidak menembus header) --}}
            <div id="map-container" class="w-full rounded-lg overflow-hidden border border-gray-300"
                style="position: relative; z-index: 1;">
                <div id="leafletMap" style="height: 400px; width: 100%; z-index: 1;"></div>
            </div>

            {{-- Info Koordinat --}}
            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                <p class="text-[10px] font-bold text-gray-500 uppercase">Koordinat Terpilih</p>
                <p id="latlngOutput" class="font-mono text-sm font-bold text-primary">Lat: -6.2088, Lng: 106.8456</p>
            </div>

            {{-- Form Alamat --}}
            <form id="addressForm" action="{{ route('member.addresses.store') }}" method="POST" class="grid grid-cols-1 gap-4 border-t pt-5">
                @csrf
                <input type="hidden" name="_method" value="POST" id="formMethod">
                <input type="hidden" name="latitude" id="inputLatitude" value="-6.2088">
                <input type="hidden" name="longitude" id="inputLongitude" value="106.8456">

                <div class="block grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase">Label Alamat</label>
                        <input type="text" id="label" name="label" placeholder="Rumah / Kantor" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" required>
                    </div>
                    <!-- phone -->
                    <div class="">
                        <label class="block text-xs font-bold text-gray-700 uppercase">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" placeholder="081234567890" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" required>
                    </div>
                </div>


                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">Detail Alamat</label>
                    <textarea id="street" name="street" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" required></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <input type="text" id="city" name="city" placeholder="Kota" class="border border-gray-300 rounded-md p-2 text-sm" required>
                    <input type="text" id="province" name="province" placeholder="Provinsi" class="border border-gray-300 rounded-md p-2 text-sm" required>
                    <input type="text" id="postal_code" name="postal_code" placeholder="Kode Pos" class="border border-gray-300 rounded-md p-2 text-sm" required>
                </div>

                <button type="submit" class="w-full py-3 rounded-lg bg-primary text-white font-bold text-lg shadow-lg">
                    Simpan Alamat
                </button>
            </form>
        </div>
    </div>
</div>
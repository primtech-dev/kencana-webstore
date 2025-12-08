@extends('frontend.components.layout')

@section('content')

{{-- ========================================================= --}}
{{-- 1. MODAL TAMBAH ALAMAT BARU (ADD ADDRESS MODAL) --}}
{{-- ========================================================= --}}
<div class="fixed inset-0 bg-light-grey bg-opacity-75 flex items-start justify-center p-4 z-50 opacity-0 pointer-events-none transition-opacity duration-300 max-h-screen overflow-y-auto" id="add-address-modal">
    <div class="bg-white rounded-lg w-full max-w-lg mt-8 mb-8 shadow-2xl overflow-hidden transform translate-y-[-20px] transition-transform duration-300" id="add-modal-content">

        <div class="p-5 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white z-10">
            <h2 class="text-xl font-extrabold text-gray-800">Tambah Alamat Baru</h2>

            <button class="text-gray-400 hover:text-primary transition" onclick="closeAddAddressModal()">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form action="#" method="POST" class="p-5 space-y-5">
            <div class="space-y-3">
                <label class="block text-sm font-bold text-gray-800">Simpan Alamat Sebagai</label>

                <div class="flex flex-wrap gap-2">
                    <button type="button" class="tag-alamat bg-primary text-white text-sm font-semibold px-4 py-2 rounded-full border border-primary transition" data-label="Rumah">
                        Rumah
                    </button>
                    <button type="button" class="tag-alamat text-gray-700 text-sm font-semibold px-4 py-2 rounded-full border border-gray-300 hover:border-primary transition" data-label="Apartemen">
                        Apartemen
                    </button>
                    <button type="button" class="tag-alamat text-gray-700 text-sm font-semibold px-4 py-2 rounded-full border border-gray-300 hover:border-primary transition" data-label="Kantor">
                        Kantor
                    </button>
                    <button type="button" class="tag-alamat text-gray-700 text-sm font-semibold px-4 py-2 rounded-full border border-gray-300 hover:border-primary transition" data-label="Kost">
                        Kost
                    </button>
                </div>
            </div>

            <div class="space-y-1">
                <label for="label_alamat" class="block text-sm text-gray-700">Cth: Rumah, Kantor, Apartemen, Kost</label>
                <div class="relative">
                    <input type="text" id="label_alamat" value="Rumah" class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-800 font-semibold">
                    <span class="absolute right-3 top-3 text-xs text-gray-400">5/35</span>
                </div>
            </div>

            <div class="space-y-1">
                <label for="nama_penerima" class="block text-sm text-gray-700">Nama Penerima</label>
                <div class="relative">
                    <input type="text" id="nama_penerima" value="Hairul Bahri" class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-800 font-semibold">
                    <span class="absolute right-3 top-3 text-xs text-gray-400">12/60</span>
                </div>
            </div>

            <div class="space-y-1">
                <label for="nomor_hp" class="block text-sm text-gray-700">Nomor Handphone Penerima</label>
                <div class="relative flex">
                    <span class="bg-gray-50 text-gray-700 px-3 py-3 border border-r-0 border-gray-300 rounded-l-lg font-semibold">+62</span>
                    <input type="text" id="nomor_hp" value="8584740671" class="flex-grow p-3 border border-gray-300 rounded-r-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-800 font-semibold">
                </div>
                <p class="text-xs text-gray-400">Hanya menerima nomor handphone negara Indonesia</p>
            </div>

            <div class="space-y-1">
                <label for="alamat_lengkap" class="block text-sm text-gray-700">Alamat Lengkap dan Catatan untuk Kurir</label>
                <textarea id="alamat_lengkap" rows="4" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 font-semibold resize-none" placeholder="Cantumkan Nama jalan, No. Rumah, & No. RT/RW">LAOK BINDUNG DESA LANDANGAN RT 01 RW 03 KECAMATAN KAPONGAN KABUPATEN SITUBONDO</textarea>
                <p class="text-xs text-gray-400">Cantumkan **Nama jalan, No. Rumah, & No. RT/RW**</p>
            </div>
            
            <div class="space-y-5">
                <div class="space-y-1">
                    <label for="province" class="block text-sm text-gray-700">Provinsi</label>
                    <div class="relative">
                        <select id="province" class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-800 font-semibold select-dropdown">
                            <option value="">Pilih Provinsi</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400 text-xs pointer-events-none"></i>
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="city" class="block text-sm text-gray-700">Kota/Kabupaten</label>
                    <div class="relative">
                        <select id="city" class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-800 font-semibold select-dropdown" disabled>
                            <option value="">Pilih Kota/Kabupaten</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400 text-xs pointer-events-none"></i>
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="postal_code" class="block text-sm text-gray-700">Kode Pos</label>
                    <input type="text" id="postal_code" placeholder="Cth: 68371" class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-800 font-semibold">
                </div>
            </div>
            
            <input type="hidden" id="latitude" name="latitude" value="">
            <input type="hidden" id="longitude" name="longitude" value="">

            <div class="pt-5">
                <button type="submit" class="w-full py-3 rounded-lg bg-primary text-white font-bold text-lg hover:bg-orange-600 transition duration-150 shadow-md shadow-orange-500/50">
                    Simpan Alamat
                </button>
            </div>

        </form>
    </div>
</div>

{{-- ========================================================= --}}
{{-- 2. MODAL PILIH ALAMAT PENGIRIMAN (SELECT ADDRESS MODAL) --}}
{{-- ========================================================= --}}
<div class="fixed inset-0 bg-light-grey bg-opacity-75 flex items-start justify-center p-4 z-50 opacity-0 pointer-events-none transition-opacity duration-300 max-h-screen overflow-y-auto" id="select-address-modal">
    <div class="bg-white rounded-lg w-full max-w-2xl mt-8 mb-8 shadow-2xl overflow-hidden transform translate-y-[-20px] transition-transform duration-300" id="select-modal-content">

        <div class="p-5 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white z-10">
            <h2 class="text-xl font-extrabold text-gray-800">Pilih Alamat Pengiriman</h2>
            <button class="text-gray-400 hover:text-primary transition" onclick="closeSelectAddressModal()">
                 <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="p-5 space-y-4 max-h-[70vh] overflow-y-auto">
            <input type="hidden" id="selected-branch-id">
            
            <button class="w-full py-2 rounded-lg border border-dashed border-primary text-primary font-bold text-md hover:bg-primary/10 transition mb-4" onclick="closeSelectAddressModal(); openAddAddressModal();">
                <i class="fas fa-plus mr-2"></i> Tambah Alamat Baru
            </button>
            
            @forelse ($customer_addresses as $address)
            <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-center transition hover:shadow-md address-option cursor-pointer" 
                 data-address-id="{{ $address->id }}"
                 data-address-label="{{ $address->label ?? 'Alamat' }}"
                 data-address-recipient="{{ $address->customer->full_name ?? 'N/A' }} ({{ $address->phone ?? 'N/A' }})"
                 data-address-detail="{{ $address->street ?? 'Alamat lengkap belum terisi' }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}"
                 data-lat="{{ $address->latitude ?? '0' }}" 
                 data-lng="{{ $address->longitude ?? '0' }}">
                
                <div class="flex items-start space-x-3">
                    <i class="fas fa-home text-gray-700 mt-1 flex-shrink-0"></i>
                    <div>
                        <p class="font-bold text-gray-800 address-label">{{ $address->label ?? 'Alamat' }} 
                            @if ($address->is_default) <span class="text-xs bg-primary text-white px-2 py-0.5 rounded-full ml-2">Utama</span> @endif
                        </p>
                        <p class="text-sm text-gray-700 address-recipient">{{ $address->customer->full_name ?? 'N/A' }} ({{ $address->phone ?? 'N/A' }})</p>
                        <p class="text-sm text-gray-800 address-detail line-clamp-2">
                            {{ $address->street ?? 'Alamat lengkap belum terisi' }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}
                        </p>
                    </div>
                </div>

                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-gray-300 check-icon text-xl"></i>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500 py-4">Belum ada alamat yang tersimpan.</p>
            @endforelse

        </div>

        <div class="p-5 border-t border-gray-100 sticky bottom-0 bg-white z-10">
            <button class="w-full py-3 rounded-lg bg-primary text-white font-bold text-lg hover:bg-orange-600 transition duration-150 shadow-md shadow-primary/50" id="confirm-select-address">
                Konfirmasi Alamat
            </button>
        </div>
    </div>
</div>


{{-- ========================================================= --}}
{{-- 3. HALAMAN UTAMA CHECKOUT --}}
{{-- ========================================================= --}}
<section class="min-h-screen pt-8 pb-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="text-2xl font-extrabold text-gray-800 mb-6">Checkout</h1>
        
        {{-- FORM UTAMA --}}
        <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}">
            @csrf

            <div class="lg:grid lg:grid-cols-12 lg:gap-8">

                <div class="lg:col-span-8 space-y-6">
                    
                    {{-- Input tersembunyi untuk data checkout yang dikumpulkan JS --}}
                    <input type="hidden" name="shipping_details_json" id="shipping-details-input">
                    {{-- Ganti '1' dengan ID Payment Method yang dipilih user di halaman ini jika ada --}}
                    <input type="hidden" name="payment_method_id" value="1"> 
                    
                    {{-- --- BLOK PENGIRIMAN PER CABANG/TOKO --- --}}

                    @php $delivery_count = 0; @endphp
                    @foreach ($selectedItems as $branchId => $itemsPerBranch)
                    @php
                        $delivery_count++;
                        $firstItem = $itemsPerBranch->first();
                        $branchName = $firstItem->cart->branch->name ?? 'Toko Tidak Diketahui'; 
                        
                        $branchLat = $firstItem->cart->branch->latitude ?? '0'; 
                        $branchLng = $firstItem->cart->branch->longitude ?? '0'; 

                        $defaultAddress = $customer_main_address; 
                        
                        $customerDefaultLat = $defaultAddress->latitude ?? '0'; 
                        $customerDefaultLng = $defaultAddress->longitude ?? '0'; 
                    @endphp

                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100 delivery-block" 
                        data-branch-id="{{ $branchId }}"
                        data-branch-lat="{{ $branchLat }}"
                        data-branch-lng="{{ $branchLng }}"
                        data-shipping-cost="0"
                        data-mode="delivery"> {{-- Mode default Delivery --}}
                        
                        <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                            <h2 class="text-lg font-bold text-gray-800">
                                Pengiriman {{ $delivery_count }} ({{ $branchName }})
                            </h2>
                            <button type="button" class="text-primary font-bold text-sm hover:underline select-address-btn" data-branch-id="{{ $branchId }}">
                                Pilih Alamat Lain
                            </button>
                        </div>
                        
                        {{-- TOMBOL PILIHAN AMBIL/KIRIM --}}
                        <div class="pt-4 pb-4 border-b border-gray-100 mb-4 flex space-x-4">
                            <button type="button" class="flex-1 py-2 px-4 rounded-lg font-bold text-sm transition delivery-mode-btn mode-delivery-{{ $branchId }} bg-primary text-white"
                                    data-branch-id="{{ $branchId }}" data-mode="delivery">
                                <i class="fas fa-truck mr-1"></i> Kirim ke Alamat
                            </button>
                            <button type="button" class="flex-1 py-2 px-4 rounded-lg font-bold text-sm transition delivery-mode-btn mode-pickup-{{ $branchId }} bg-gray-100 text-gray-700 hover:bg-gray-200"
                                    data-branch-id="{{ $branchId }}" data-mode="pickup">
                                <i class="fas fa-store mr-1"></i> Ambil Sendiri
                            </button>
                        </div>
                        {{-- END TOMBOL PILIHAN AMBIL/KIRIM --}}

                        {{-- BLOK ALAMAT PENGIRIMAN (DYNAMICALLY SHOWN/HIDDEN) --}}
                        <div class="address-and-cost-block address-block-{{ $branchId }}">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Tujuan Pengiriman:</label>
                            <div class="relative border-2 {{ $defaultAddress ? 'border-primary' : 'border-gray-300' }} rounded-lg p-4 bg-gray-50/50 address-display-container" 
                                 id="address-display-{{ $branchId }}" 
                                 data-selected-address-id="{{ $defaultAddress->id ?? '0' }}"
                                 data-lat="{{ $customerDefaultLat }}"
                                 data-lng="{{ $customerDefaultLng }}">
                                @if ($defaultAddress)
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-home text-gray-700 mt-1 flex-shrink-0"></i>
                                    <div class="address-details">
                                        <p class="font-bold text-gray-800 address-label">{{ $defaultAddress->label ?? 'Alamat Utama' }}</p>
                                        <p class="text-sm text-gray-700 address-recipient">{{ $defaultAddress->customer->full_name ?? 'N/A' }} ({{ $defaultAddress->phone ?? 'N/A' }})</p>
                                        <p class="text-sm text-gray-800 address-detail">
                                            {{ $defaultAddress->street ?? 'Alamat lengkap belum terisi' }}, {{ $defaultAddress->city }}, {{ $defaultAddress->province }} {{ $defaultAddress->postal_code }}
                                        </p>
                                    </div>
                                </div>
                                @else
                                <div class="text-center text-red-500">
                                    <p class="font-semibold">⚠️ Mohon Pilih Alamat Pengiriman.</p>
                                </div>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-2 text-right">Jarak ke toko: <span class="font-bold text-gray-800 distance-display" id="distance-{{ $branchId }}">N/A</span></p>
                        </div>
                        {{-- END BLOK ALAMAT --}}

                        @php $branchSubtotal = 0; @endphp
                        @foreach ($itemsPerBranch as $cartItem)
                        @php
                        $productName = $cartItem->product->name ?? 'Produk Tidak Ditemukan';
                        $variantName = $cartItem->variant->variant_name ?? 'Varian Utama';
                        $price = $cartItem->price_cents;
                        $subtotal = $cartItem->quantity * $price;
                        $branchSubtotal += $subtotal;

                        $productImage = env('APP_URL_BE') . ($cartItem->product->images->where('is_main', true)->first()->url ?? 'https://placehold.co/100x100/eeeeee/333333?text=Product');
                        @endphp

                        <div class="flex flex-col sm:flex-row space-x-0 sm:space-x-4 space-y-4 sm:space-y-0 items-start py-4 border-b border-gray-100 last:border-b-0">
                            <div class="flex space-x-4 items-start w-full sm:w-auto">
                                <div class="flex-shrink-0 w-20 h-20 bg-gray-50 rounded-md overflow-hidden">
                                    <img src="{{ $productImage }}" alt="{{ $productName }}" class="object-cover w-full h-full">
                                </div>

                                <div class="flex-grow space-y-1 sm:space-y-2 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 line-clamp-2">{{ $productName }}</p>
                                    <p class="text-xs text-gray-700">{{ $variantName }}</p>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="font-bold text-primary">{{ 'Rp' . number_format($price, 0, ',', '.') }}</span>
                                        <span class="text-gray-700">x {{ $cartItem->quantity }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-3 w-full sm:w-60 flex-shrink-0">
                                {{-- BLOK BIAYA PENGIRIMAN/PICKUP --}}
                                <div class="flex flex-col space-y-1">
                                    <span class="text-sm font-semibold text-gray-700 shipping-label">Biaya Pengiriman:</span>
                                    <div class="text-sm font-bold text-gray-800 shipping-cost-display" id="shipping-cost-{{ $branchId }}" data-cost="0">Rp0</div>
                                    <div class="text-xs text-gray-500 loading-message-{{ $branchId }}">Pilih metode pengiriman.</div>
                                </div>
                                {{-- END BLOK BIAYA --}}
                                
                                {{-- Pilihan Kurir (Hidden) --}}
                                <select class="w-full p-3 border border-gray-300 rounded-lg bg-white text-sm font-semibold text-gray-700 appearance-none focus:border-primary courier-select hidden" data-branch-id="{{ $branchId }}">
                                    <option value="DELIVERY">Pengiriman Jasa Kurir</option>
                                </select>
                            </div>
                        </div>
                        @endforeach

                        <div class="border-t border-gray-100 pt-4 mt-4">
                            <div class="flex justify-between items-start pt-4 text-sm flex-wrap">
                                <div class="flex items-center space-x-2 mb-2 sm:mb-0">
                                    <i class="fas fa-shield-alt text-blue-500"></i>
                                    <span class="text-gray-800 font-semibold">Tambah Proteksi Kerusakan</span>
                                </div>
                                 <span class="font-bold text-gray-800">Rp0</span>
                            </div>
                        </div>

                    </div>
                    @endforeach

                </div>

                <div class="lg:col-span-4 mt-8 lg:mt-0">
                    <div class="space-y-4">

                        <div class="p-6 bg-white rounded-lg shadow-md border border-gray-100 lg:sticky lg:top-8">
                            @php
                            $totalSubtotal = 0;
                            $totalQuantity = 0;
                            foreach ($selectedItems as $items) {
                                foreach ($items as $item) {
                                    $totalSubtotal += $item->quantity * $item->price_cents; 
                                    $totalQuantity += $item->quantity;
                                }
                            }
                            $totalSubtotalRp = number_format($totalSubtotal, 0, ',', '.');
                            $hargaProteksi = 0;
                            $totalHarga = $totalSubtotal + $hargaProteksi;
                            @endphp

                            <h2 class="text-lg font-extrabold text-gray-800 mb-4">Detail Rincian Pembayaran</h2>

                            <div class="space-y-3 pb-4 border-b border-gray-100 text-sm">
                                <div class="flex justify-between items-center text-gray-700">
                                    <span>Subtotal Harga ({{ $totalQuantity }} produk)</span>
                                    <span class="font-bold">Rp{{ $totalSubtotalRp }}</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-700">
                                    <span>Harga Proteksi</span>
                                    <span class="font-bold">Rp{{ number_format($hargaProteksi, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-700">
                                    <span>Total Ongkir</span>
                                    <span class="font-bold" id="total-ongkir-display">Rp0</span> 
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-4 text-xl font-extrabold">
                                <span>Total Pembayaran</span>
                                <span class="text-gray-800" id="final-total-display">Rp{{ number_format($totalHarga, 0, ',', '.') }}</span>
                            </div>

                            <button type="submit" class="w-full py-3 mt-6 rounded-lg bg-primary text-white font-bold text-lg hover:bg-orange-600 transition duration-150 shadow-md shadow-primary/50">
                                Lanjut ke Pembayaran
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</section>

{{-- ========================================================= --}}
{{-- 4. JAVASCRIPT LOGIC (Pickup vs Delivery & Data Collection) --}}
{{-- ========================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variabel Modal
        const addModal = document.getElementById('add-address-modal');
        const addModalContent = document.getElementById('add-modal-content');
        const selectAddressModal = document.getElementById('select-address-modal');
        const selectAddressContent = document.getElementById('select-modal-content');
        const selectedBranchIdInput = document.getElementById('selected-branch-id');
        const addressOptions = document.querySelectorAll('.address-option');
        const selectAddressBtns = document.querySelectorAll('.select-address-btn');
        const confirmSelectAddressBtn = document.getElementById('confirm-select-address');
        const deliveryModeBtns = document.querySelectorAll('.delivery-mode-btn');
        
        // Form & Input untuk Data Order
        const checkoutForm = document.getElementById('checkout-form');
        const shippingDetailsInput = document.getElementById('shipping-details-input');

        // Konstanta Biaya Pengiriman Default
        const DEFAULT_DELIVERY_COST = 15000; 

        // --- FUNGSI MODAL TAMBAH ALAMAT ---
        window.openAddAddressModal = function() {
            addModal.classList.remove('pointer-events-none', 'opacity-0');
            addModal.classList.add('opacity-100');
            addModalContent.classList.remove('translate-y-[-20px]');
            addModalContent.classList.add('translate-y-0');
            document.body.style.overflow = 'hidden';
        }

        window.closeAddAddressModal = function() {
            addModal.classList.remove('opacity-100');
            addModal.classList.add('opacity-0');
            addModalContent.classList.remove('translate-y-0');
            addModalContent.classList.add('translate-y-[-20px]');

            setTimeout(() => {
                addModal.classList.add('pointer-events-none');
                document.body.style.overflow = '';
            }, 300);
        }
        
        // --- FUNGSI MODAL PILIH ALAMAT ---
        window.openSelectAddressModal = function(branchId) {
            selectedBranchIdInput.value = branchId;
            selectAddressModal.classList.remove('pointer-events-none', 'opacity-0');
            selectAddressModal.classList.add('opacity-100');
            selectAddressContent.classList.remove('translate-y-[-20px]');
            selectAddressContent.classList.add('translate-y-0');
            document.body.style.overflow = 'hidden';
            
            let currentSelectedId = '0';
            const displayContainer = document.getElementById(`address-display-${branchId}`);
            if (displayContainer) {
                currentSelectedId = displayContainer.getAttribute('data-selected-address-id');
            }
            
            // Tandai alamat yang sedang aktif di modal
            addressOptions.forEach(option => {
                option.classList.remove('border-primary', 'bg-primary/5');
                option.querySelector('.check-icon').classList.remove('text-primary');
                option.querySelector('.check-icon').classList.add('text-gray-300');
                
                if (option.getAttribute('data-address-id') == currentSelectedId) {
                    option.classList.add('border-primary', 'bg-primary/5');
                    option.querySelector('.check-icon').classList.add('text-primary');
                    option.querySelector('.check-icon').classList.remove('text-gray-300');
                }
            });
        }

        window.closeSelectAddressModal = function() {
            selectAddressModal.classList.remove('opacity-100');
            selectAddressModal.classList.add('opacity-0');
            selectAddressContent.classList.remove('translate-y-0');
            selectAddressContent.classList.add('translate-y-[-20px]');
            
            setTimeout(() => {
                selectAddressModal.classList.add('pointer-events-none');
                document.body.style.overflow = '';
            }, 300);
        }
        
        // --- LOGIKA JARAK (HANYA UNTUK DISPLAY) ---
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * (Math.PI / 180);
            const dLon = (lon2 - lon1) * (Math.PI / 180);
            const a = 
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distance = R * c;
            
            return distance.toFixed(2); 
        }
        
        function updateDistanceDisplay(branchId, customerLat, customerLng, branchLat, branchLng) {
            const distanceDisplay = document.getElementById(`distance-${branchId}`);
            if (!distanceDisplay) return;

            if (customerLat == '0' || customerLng == '0' || branchLat == '0' || branchLng == '0') {
                 distanceDisplay.textContent = 'Koordinat tidak valid';
                 return;
            }

            const distance = calculateDistance(parseFloat(customerLat), parseFloat(customerLng), parseFloat(branchLat), parseFloat(branchLng));
            distanceDisplay.textContent = `${distance} km`;
        }

        // --- LOGIKA BIAYA & TOTAL ---
        
        function updateShippingCostDisplay(branchId, cost, mode) {
            const shippingCostDisplay = document.getElementById(`shipping-cost-${branchId}`);
            const loadingMessage = document.querySelector(`.loading-message-${branchId}`);
            const shippingLabel = document.querySelector(`.delivery-block[data-branch-id="${branchId}"] .shipping-label`);
            const deliveryBlock = document.querySelector(`.delivery-block[data-branch-id="${branchId}"]`);

            if (!shippingCostDisplay || !deliveryBlock || !loadingMessage || !shippingLabel) return;
            
            const totalCost = parseInt(cost) || 0;
            
            shippingCostDisplay.textContent = `Rp${totalCost.toLocaleString('id-ID')}`;
            shippingCostDisplay.setAttribute('data-cost', totalCost);

            // Simpan biaya di elemen parent block untuk perhitungan total
            deliveryBlock.setAttribute('data-shipping-cost', totalCost);
            
            // Perbarui label & pesan
            if (mode === 'pickup') {
                shippingLabel.textContent = 'Biaya Ambil Sendiri:';
                loadingMessage.textContent = 'Pengambilan di lokasi toko.';
            } else {
                shippingLabel.textContent = 'Biaya Pengiriman:';
                loadingMessage.textContent = 'Biaya pengiriman standar.';
            }

            calculateFinalTotal();
        }
        
        function calculateFinalTotal() {
            let totalShippingCost = 0;
            const deliveryBlocks = document.querySelectorAll('.delivery-block');
            
            deliveryBlocks.forEach(block => {
                totalShippingCost += parseInt(block.getAttribute('data-shipping-cost')) || 0;
            });

            // Nilai PHP dari Blade
            const subtotalHarga = {{ $totalSubtotal }}; 
            const hargaProteksi = {{ $hargaProteksi }}; 
            const finalTotal = subtotalHarga + hargaProteksi + totalShippingCost;
            
            document.getElementById('total-ongkir-display').textContent = `Rp${totalShippingCost.toLocaleString('id-ID')}`;
            document.getElementById('final-total-display').textContent = `Rp${finalTotal.toLocaleString('id-ID')}`;
        }
        
        // --- EVENT LISTENER PILIHAN MODE (PICKUP / DELIVERY) ---
        deliveryModeBtns.forEach(button => {
            button.addEventListener('click', function() {
                const branchId = this.getAttribute('data-branch-id');
                const mode = this.getAttribute('data-mode');
                const deliveryBlock = document.querySelector(`.delivery-block[data-branch-id="${branchId}"]`);
                const addressBlock = document.querySelector(`.address-block-${branchId}`);
                const selectAddressButton = document.querySelector(`.select-address-btn[data-branch-id="${branchId}"]`);
                
                // 1. Update style tombol
                document.querySelectorAll(`.delivery-mode-btn[data-branch-id="${branchId}"]`).forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white');
                    btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                });
                this.classList.add('bg-primary', 'text-white');
                this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                
                // 2. Simpan mode di data attribute
                deliveryBlock.setAttribute('data-mode', mode);

                let cost = 0;
                if (mode === 'delivery') {
                    // Tampilkan blok alamat dan tombol ganti alamat
                    addressBlock.classList.remove('hidden');
                    selectAddressButton.classList.remove('hidden');
                    // Terapkan biaya pengiriman default
                    cost = DEFAULT_DELIVERY_COST; 
                    
                } else { // mode === 'pickup'
                    // Sembunyikan blok alamat dan tombol ganti alamat
                    addressBlock.classList.add('hidden');
                    selectAddressButton.classList.add('hidden');
                    // Biaya pickup = 0
                    cost = 0; 
                }

                // 3. Update biaya pengiriman dan total
                updateShippingCostDisplay(branchId, cost, mode);
            });
        });
        
        // --- EVENT LISTENER PILIH ALAMAT (Modal Address) ---
        selectAddressBtns.forEach(button => {
            button.addEventListener('click', function() {
                const branchId = this.getAttribute('data-branch-id');
                openSelectAddressModal(branchId);
            });
        });

        // Event listener untuk memilih alamat di dalam modal
        addressOptions.forEach(option => {
            option.addEventListener('click', function() {
                addressOptions.forEach(btn => {
                    btn.classList.remove('border-primary', 'bg-primary/5');
                    btn.querySelector('.check-icon').classList.remove('text-primary');
                    btn.querySelector('.check-icon').classList.add('text-gray-300');
                });
                this.classList.add('border-primary', 'bg-primary/5');
                this.querySelector('.check-icon').classList.add('text-primary');
                this.querySelector('.check-icon').classList.remove('text-gray-300');
            });
        });
        
        // Konfirmasi dan Terapkan Alamat dari Modal
        confirmSelectAddressBtn.addEventListener('click', function() {
            const branchId = selectedBranchIdInput.value;
            const selectedAddress = document.querySelector('.address-option.border-primary');
            
            if (!selectedAddress) {
                alert('Mohon pilih salah satu alamat.');
                return;
            }

            const addressId = selectedAddress.getAttribute('data-address-id');
            const addressLabel = selectedAddress.getAttribute('data-address-label');
            const addressRecipient = selectedAddress.getAttribute('data-address-recipient');
            const addressDetail = selectedAddress.getAttribute('data-address-detail');
            const customerLat = selectedAddress.getAttribute('data-lat'); 
            const customerLng = selectedAddress.getAttribute('data-lng'); 
            
            const updateDeliveryBlock = (id) => {
                const displayContainer = document.getElementById(`address-display-${id}`);
                const deliveryBlock = document.querySelector(`.delivery-block[data-branch-id="${id}"]`);
                if (!displayContainer || !deliveryBlock) return;

                const branchLat = deliveryBlock.getAttribute('data-branch-lat');
                const branchLng = deliveryBlock.getAttribute('data-branch-lng');

                // 1. Update data attribute Alamat di tampilan
                displayContainer.setAttribute('data-selected-address-id', addressId);
                displayContainer.setAttribute('data-lat', customerLat);
                displayContainer.setAttribute('data-lng', customerLng);
                displayContainer.classList.remove('border-gray-300');
                displayContainer.classList.add('border-primary');

                // 2. Update detail yang ditampilkan (inner HTML)
                const isDefault = selectedAddress.querySelector('.text-xs.bg-primary') ? '<span class="text-xs bg-primary text-white px-2 py-0.5 rounded-full ml-2">Utama</span>' : '';
                displayContainer.innerHTML = `
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-home text-gray-700 mt-1 flex-shrink-0"></i>
                        <div class="address-details">
                            <p class="font-bold text-gray-800 address-label">${addressLabel} ${isDefault}</p>
                            <p class="text-sm text-gray-700 address-recipient">${addressRecipient}</p>
                            <p class="text-sm text-gray-800 address-detail">${addressDetail}</p>
                        </div>
                    </div>
                `;

                // 3. Update jarak
                updateDistanceDisplay(id, customerLat, customerLng, branchLat, branchLng);
                
                // 4. Otomatis pindah ke mode Delivery dan terapkan biaya
                // Trigger klik tombol delivery untuk memastikan mode, biaya, dan tampilan alamat muncul.
                document.querySelector(`.mode-delivery-${branchId}`).click();

            };

            updateDeliveryBlock(branchId);
            
            closeSelectAddressModal();
        });

        // --- FUNGSI PENGUMPULAN DATA CHECKOUT ---
        function collectShippingDetails() {
            const shippingDetails = {};
            const deliveryBlocks = document.querySelectorAll('.delivery-block');
            let isAddressMissing = false;

            deliveryBlocks.forEach(block => {
                const branchId = block.getAttribute('data-branch-id');
                const mode = block.getAttribute('data-mode');
                const shippingCost = parseInt(block.getAttribute('data-shipping-cost')) || 0;
                
                let addressId = null;
                
                // Jika mode delivery, ambil ID alamat yang dipilih
                if (mode === 'delivery') {
                    const addressContainer = document.getElementById(`address-display-${branchId}`);
                    addressId = addressContainer ? addressContainer.getAttribute('data-selected-address-id') : '0';
                    
                    if (addressId === '0' || !addressId) {
                        isAddressMissing = true;
                    }
                }
                
                shippingDetails[branchId] = {
                    mode: mode,
                    address_id: addressId,
                    shipping_cost: shippingCost, // FE cost (server harus hitung ulang)
                };
            });
            
            // Simpan data ke input tersembunyi
            shippingDetailsInput.value = JSON.stringify(shippingDetails);
            
            return { details: shippingDetails, isMissing: isAddressMissing };
        }
        
        // --- EVENT LISTENER FORM SUBMIT ---
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const collectedData = collectShippingDetails();
            
            if (collectedData.isMissing) {
                alert('⚠️ Ada blok pengiriman mode "Kirim ke Alamat" yang belum memilih alamat tujuan. Silakan pilih alamat.');
                return; 
            }
            
            // Lanjutkan submit form ke Controller
            this.submit(); 
        });


        // --- INISIASI AWAL SAAT HALAMAN DIMUAT ---
        
        // 1. Inisiasi Mode Default: Delivery dengan biaya default
        document.querySelectorAll('.delivery-block').forEach(block => {
            const branchId = block.getAttribute('data-branch-id');
            const branchLat = block.getAttribute('data-branch-lat');
            const branchLng = block.getAttribute('data-branch-lng');
            
            const displayContainer = document.getElementById(`address-display-${branchId}`);
            const customerLat = displayContainer.getAttribute('data-lat');
            const customerLng = displayContainer.getAttribute('data-lng');
            
            // Hitung dan tampilkan jarak (hanya display)
            updateDistanceDisplay(branchId, customerLat, customerLng, branchLat, branchLng);

            // Update biaya pengiriman default (Rp15.000)
            updateShippingCostDisplay(branchId, DEFAULT_DELIVERY_COST, 'delivery');
        });

        // 2. Hitung total saat halaman pertama kali dimuat
        calculateFinalTotal(); 
    });
</script>
@endsection
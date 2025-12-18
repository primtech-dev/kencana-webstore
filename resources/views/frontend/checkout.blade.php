@extends('frontend.components.layout')

@section('content')



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

            <button class="w-full py-2 rounded-lg border border-dashed border-primary text-primary font-bold text-md hover:bg-primary/10 transition mb-4">
                <a href="{{route('member.addresses.index')}}" class="text-gray-400 hover:text-primary transition">
                    <i class="fas fa-plush text-xl text-gray-400 hover:text-primary transition"></i>
                    Tambah Alamat Baru
                </a>
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
{{-- 3. HALAMAN UTAMA CHECKOUT (MODIFIKASI SATU ALAMAT) --}}
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
                    <input type="hidden" name="payment_method_id" value="1">
                    <input type="hidden" name="items_json" value='@json($selectedItemIds)'>
                    <input type="hidden" name="variant_id" value="{{ request('variant_id') }}">
                    <input type="hidden" name="quantity" value="{{ request('quantity') }}">
                    <input type="hidden" name="branch_id" value="{{ request('branch_id') }}">



                    {{-- 🟢 BLOK ALAMAT UTAMA (SATU-SATUNYA) --}}
                    @php
                    $defaultAddress = $customer_main_address;
                    $customerDefaultLat = $defaultAddress->latitude ?? '0';
                    $customerDefaultLng = $defaultAddress->longitude ?? '0';
                    @endphp

                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100 mb-6">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-100 mb-4">
                            <h2 class="text-lg font-bold text-gray-800">Alamat Tujuan Pengiriman</h2>
                            {{-- Button ini akan membuka modal pemilihan alamat untuk SEMUA pengiriman --}}
                            <button type="button" class="text-primary font-bold text-sm hover:underline select-address-btn" data-branch-id="0">
                                Pilih Alamat Lain
                            </button>
                        </div>

                        {{-- Kontainer Alamat Utama --}}
                        <div class="relative border-2 {{ $defaultAddress ? 'border-primary' : 'border-gray-300' }} rounded-lg p-4 bg-gray-50/50"
                            id="main-address-display" {{-- ID UNTUK MERUJUK DARI JS --}}
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
                        {{-- END Kontainer Alamat Utama --}}
                    </div>
                    {{-- ❌ END BLOK ALAMAT UTAMA --}}


                    {{-- --- BLOK PENGIRIMAN PER CABANG/TOKO --- --}}

                    @php $delivery_count = 0; @endphp
                    @foreach ($selectedItems as $branchId => $itemsPerBranch)
                    @php
                    $delivery_count++;
                    $firstItem = $itemsPerBranch->first();
                    $branchName = $firstItem->cart->branch->name ?? 'Toko Tidak Diketahui';

                    $branchLat = $firstItem->cart->branch->latitude ?? '0';
                    $branchLng = $firstItem->cart->branch->longitude ?? '0';
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
                            {{-- Tampilkan jarak ke toko ini --}}
                            <p class="text-xs text-gray-500">
                                Jarak: <span class="font-bold text-gray-800 distance-display" id="distance-{{ $branchId }}">N/A</span>
                            </p>
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

                        {{-- BLOK ALAMAT DIHAPUS DARI SINI. CUKUP TAMBAHKAN BLOK DUMMY INI JIKA ANDA MEMBUTUHKAN REFERENCE UNTUK JS LAMA --}}
                        <div class="address-and-cost-block address-block-{{ $branchId }} hidden">
                            {{-- Blok ini disembunyikan dan hanya digunakan untuk referensi JS jika mode: delivery --}}
                        </div>
                        {{-- END BLOK DUMMY ALAMAT --}}

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

                                {{-- BLOK BIAYA PENGIRIMAN/PICKUP (Dibuat sejajar) --}}
                                <div class="flex flex-col space-y-1">

                                    {{-- BARIS LABEL DAN BIAYA: Gunakan 'flex justify-between' untuk membuat sejajar --}}
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-semibold text-gray-700 shipping-label">Biaya Pengiriman:</span>
                                        <div
                                            class="text-sm font-bold text-gray-800 shipping-cost-display"
                                            id="shipping-cost-{{ $branchId }}"
                                            data-cost="0">
                                            Rp0
                                        </div>
                                    </div>

                                    {{-- Pesan status/loading tetap di bawah --}}
                                    <div class="text-xs text-gray-500 loading-message-{{ $branchId }}">Pilih metode pengiriman.</div>
                                </div>
                                {{-- END BLOK BIAYA --}}

                                {{-- Pilihan Kurir (Hidden) --}}
                                <select
                                    class="w-full p-3 border border-gray-300 rounded-lg bg-white text-sm font-semibold text-gray-700 appearance-none focus:border-primary courier-select hidden"
                                    data-branch-id="{{ $branchId }}">
                                    <option value="DELIVERY">Pengiriman Jasa Kurir</option>
                                </select>
                            </div>

                            <!-- <div class="flex flex-col space-y-3 w-full sm:w-60 flex-shrink-0">
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
                            </div> -->
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
                                Proses Pesanan
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Referensi DOM ---
        const addModal = document.getElementById('add-address-modal');
        const addModalContent = document.getElementById('add-modal-content');
        const selectAddressModal = document.getElementById('select-address-modal');
        const selectAddressContent = document.getElementById('select-modal-content');
        const addressOptions = document.querySelectorAll('.address-option');
        const selectAddressBtns = document.querySelectorAll('.select-address-btn');
        const confirmSelectAddressBtn = document.getElementById('confirm-select-address');
        const deliveryModeBtns = document.querySelectorAll('.delivery-mode-btn');

        const checkoutForm = document.getElementById('checkout-form');
        const shippingDetailsInput = document.getElementById('shipping-details-input');

        const DEFAULT_DELIVERY_COST = 0;

        let currentSelectedAddress = null; // Menyimpan DOM element dari alamat yang dipilih di modal

        // PENTING: Ambil referensi ke SATU-SATUNYA blok alamat di luar loop
        const mainAddressDisplay = document.getElementById('main-address-display');

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

        window.openSelectAddressModal = function(initialBranchId) {
            selectAddressModal.classList.remove('pointer-events-none', 'opacity-0');
            selectAddressModal.classList.add('opacity-100');
            selectAddressContent.classList.remove('translate-y-[-20px]');
            selectAddressContent.classList.add('translate-y-0');
            document.body.style.overflow = 'hidden';

            let currentSelectedId = mainAddressDisplay ? mainAddressDisplay.getAttribute('data-selected-address-id') : '0';

            addressOptions.forEach(option => {
                option.classList.remove('border-primary', 'bg-primary/5');
                option.querySelector('.check-icon').classList.remove('text-primary');
                option.querySelector('.check-icon').classList.add('text-gray-300');

                if (option.getAttribute('data-address-id') == currentSelectedId) {
                    option.classList.add('border-primary', 'bg-primary/5');
                    option.querySelector('.check-icon').classList.add('text-primary');
                    option.querySelector('.check-icon').classList.remove('text-gray-300');
                    currentSelectedAddress = option;
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

        // --- LOGIKA JARAK & BIAYA ---
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

        function updateShippingCostDisplay(branchId, cost, mode) {
            const shippingCostDisplay = document.getElementById(`shipping-cost-${branchId}`);
            const loadingMessage = document.querySelector(`.loading-message-${branchId}`);
            const shippingLabel = document.querySelector(`.delivery-block[data-branch-id="${branchId}"] .shipping-label`);
            const deliveryBlock = document.querySelector(`.delivery-block[data-branch-id="${branchId}"]`);

            if (!shippingCostDisplay || !deliveryBlock || !loadingMessage || !shippingLabel) return;

            const totalCost = parseInt(cost) || 0;

            shippingCostDisplay.textContent = `Rp${totalCost.toLocaleString('id-ID')}`;
            shippingCostDisplay.setAttribute('data-cost', totalCost);

            // Perubahan: Update data-shipping-cost dan data-mode pada setiap blok
            deliveryBlock.setAttribute('data-shipping-cost', totalCost);
            deliveryBlock.setAttribute('data-mode', mode);

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

            // Nilai PHP dari Blade (asumsi variabel Blade sudah tersedia)
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

                // 1. Update style tombol
                document.querySelectorAll(`.delivery-mode-btn[data-branch-id="${branchId}"]`).forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white');
                    btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                });
                this.classList.add('bg-primary', 'text-white');
                this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');

                let cost = 0;
                const customerLat = mainAddressDisplay.getAttribute('data-lat');
                const addressSelected = customerLat !== '0';

                if (mode === 'delivery') {
                    if (addressSelected) {
                        // Terapkan biaya pengiriman default (atau hitung ulang)
                        cost = DEFAULT_DELIVERY_COST;
                    } else {
                        // Biaya tetap 0, tapi beri pesan peringatan
                        const loadingMessage = document.querySelector(`.loading-message-${branchId}`);
                        if (loadingMessage) {
                            loadingMessage.textContent = 'Mohon pilih alamat tujuan pengiriman.';
                        }
                    }
                } else { // mode === 'pickup'
                    cost = 0;
                }

                // 2. Update biaya pengiriman dan total
                updateShippingCostDisplay(branchId, cost, mode);
            });
        });

        // --- EVENT LISTENER PILIH ALAMAT (Modal Address) ---
        selectAddressBtns.forEach(button => {
            button.addEventListener('click', function() {
                openSelectAddressModal('0'); // Gunakan dummy ID 0
            });
        });

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

                currentSelectedAddress = this;
            });
        });

        // Konfirmasi dan Terapkan Alamat dari Modal
        confirmSelectAddressBtn.addEventListener('click', function() {
            const selectedAddress = currentSelectedAddress || document.querySelector('.address-option.border-primary');

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

            // 🟢 FUNGSI UTAMA BERGANTI: Update HANYA BLOK ALAMAT UTAMA
            mainAddressDisplay.setAttribute('data-selected-address-id', addressId);
            mainAddressDisplay.setAttribute('data-lat', customerLat);
            mainAddressDisplay.setAttribute('data-lng', customerLng);
            mainAddressDisplay.classList.remove('border-gray-300');
            mainAddressDisplay.classList.add('border-primary');

            // Update detail yang ditampilkan (inner HTML)
            const isDefault = selectedAddress.querySelector('.text-xs.bg-primary') ? '<span class="text-xs bg-primary text-white px-2 py-0.5 rounded-full ml-2">Utama</span>' : '';
            mainAddressDisplay.innerHTML = `
                <div class="flex items-start space-x-3">
                    <i class="fas fa-home text-gray-700 mt-1 flex-shrink-0"></i>
                    <div class="address-details">
                        <p class="font-bold text-gray-800 address-label">${addressLabel} ${isDefault}</p>
                        <p class="text-sm text-gray-700 address-recipient">${addressRecipient}</p>
                        <p class="text-sm text-gray-800 address-detail">${addressDetail}</p>
                    </div>
                </div>
            `;

            // 3. Update SEMUA Delivery Block (jarak dan biaya)
            document.querySelectorAll('.delivery-block').forEach(deliveryBlock => {
                const id = deliveryBlock.getAttribute('data-branch-id');
                const branchLat = deliveryBlock.getAttribute('data-branch-lat');
                const branchLng = deliveryBlock.getAttribute('data-branch-lng');
                const currentMode = deliveryBlock.getAttribute('data-mode');

                // Update jarak di blok masing-masing
                updateDistanceDisplay(id, customerLat, customerLng, branchLat, branchLng);

                // Update biaya hanya jika mode saat ini adalah 'delivery'
                if (currentMode === 'delivery') {
                    updateShippingCostDisplay(id, DEFAULT_DELIVERY_COST, 'delivery');
                } else {
                    updateShippingCostDisplay(id, 0, 'pickup');
                }
            });

            closeSelectAddressModal();
        });

        // --- FUNGSI PENGUMPULAN DATA CHECKOUT (PENTING: Data dikirim sebagai SATU OBJEK TUNGGAL) ---
        function collectShippingDetails() {
            const shippingDetails = {};
            const deliveryBlocks = document.querySelectorAll('.delivery-block');
            let isAddressMissing = false;
            let totalShippingCost = 0;

            // Ambil ID Alamat dari BLOK ALAMAT UTAMA
            const selectedAddressId = mainAddressDisplay.getAttribute('data-selected-address-id');
            const hasValidAddress = selectedAddressId !== '0' && selectedAddressId;

            // Ambil mode dan biaya dari blok PERTAMA (asumsi seragam)
            // Atau, kita bisa menghitung total biaya dan mode dari semua blok jika perlu.

            let finalMode = 'delivery'; // Default
            let totalCost = 0;

            deliveryBlocks.forEach(block => {
                const mode = block.getAttribute('data-mode');
                const shippingCost = parseInt(block.getAttribute('data-shipping-cost')) || 0;

                // Cek validasi untuk setiap cabang
                if (mode === 'delivery' && !hasValidAddress) {
                    isAddressMissing = true;
                }

                // Kumpulkan total biaya pengiriman untuk dimasukkan ke data JSON (jika perlu)
                totalCost += shippingCost;

                // Jika ada mode yang berbeda antar cabang, ini akan menjadi rumit. 
                // Untuk kesederhanaan, kita asumsikan mode yang dipilih terakhir menang atau mode yang paling umum.
                // Namun, karena Controller akan memproses per branch, kita hanya mengirim DATA UTAMA.

                // Simpan mode yang terakhir dilihat (atau mode yang paling penting)
                finalMode = mode;
            });

            // 🟢 PERUBAHAN: Data dikirim sebagai satu objek tunggal
            shippingDetailsInput.value = JSON.stringify({
                mode: finalMode,
                address_id: selectedAddressId,
                // Mengirim total biaya pengiriman untuk semua cabang, atau biaya per cabang pertama.
                // Pilihan aman: Kirim total biaya pengiriman
                shipping_cost: totalCost,
            });

            // NOTE: Di Controller, kita akan mengabaikan 'shipping_cost' ini dan menggunakan nilai $requestShippingCost
            // jika logika Anda memisahkan biaya pengiriman per order.

            return {
                details: shippingDetails,
                isMissing: isAddressMissing
            };
        }

        // --- EVENT LISTENER FORM SUBMIT ---
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const collectedData = collectShippingDetails();

            if (collectedData.isMissing) {
                alert('⚠️ Ada blok pengiriman mode "Kirim ke Alamat" yang belum memilih alamat tujuan. Silakan pilih alamat.');
                return;
            }

            this.submit();
        });

        // --- INISIASI AWAL SAAT HALAMAN DIMUAT ---

        const initialCustomerLat = mainAddressDisplay.getAttribute('data-lat');
        const initialAddressId = mainAddressDisplay.getAttribute('data-selected-address-id');

        // 1. Inisiasi Mode Default: Delivery dengan biaya default
        document.querySelectorAll('.delivery-block').forEach(block => {
            const branchId = block.getAttribute('data-branch-id');
            const branchLat = block.getAttribute('data-branch-lat');
            const branchLng = block.getAttribute('data-branch-lng');
            const initialCustomerLng = mainAddressDisplay.getAttribute('data-lng');

            updateDistanceDisplay(branchId, initialCustomerLat, initialCustomerLng, branchLat, branchLng);

            if (initialAddressId && initialAddressId !== '0') {
                updateShippingCostDisplay(branchId, DEFAULT_DELIVERY_COST, 'delivery');

                document.querySelector(`.mode-delivery-${branchId}`).classList.add('bg-primary', 'text-white');
                document.querySelector(`.mode-delivery-${branchId}`).classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');

                document.querySelector(`.mode-pickup-${branchId}`).classList.remove('bg-primary', 'text-white');
                document.querySelector(`.mode-pickup-${branchId}`).classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            } else {
                updateShippingCostDisplay(branchId, 0, 'delivery');

                const loadingMessage = document.querySelector(`.loading-message-${branchId}`);
                if (loadingMessage) {
                    loadingMessage.textContent = 'Mohon pilih alamat tujuan pengiriman.';
                }
            }
        });

        // 2. Hitung total saat halaman pertama kali dimuat
        calculateFinalTotal();
    });
</script>
@endsection
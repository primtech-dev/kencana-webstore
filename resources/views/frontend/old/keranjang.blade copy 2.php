@extends('frontend.components.layout')

@section('content')

<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto">

        <h1 class="text-2xl font-extrabold text-gray-800 mb-6">Keranjang Belanja</h1>

        @if ($keranjang->isEmpty())
        {{-- Empty Cart View --}}
        <div class="p-12 bg-white rounded-lg shadow-lg text-center border-4 border-dashed border-gray-200">
            <i class="fas fa-shopping-cart text-5xl text-gray-400 mb-4"></i>
            <p class="text-xl font-semibold text-gray-600">Keranjang Anda Kosong</p>
            <p class="text-gray-500 mt-2">Ayo, temukan barang-barang menarik yang Anda inginkan!</p>
            <a href="{{ url('/') }}" class="mt-6 inline-block py-2 px-6 bg-primary text-white font-bold rounded-lg hover:bg-primary-dark transition duration-150">
                Mulai Belanja
            </a>
        </div>
        @else
        {{-- Main Grid: Product List and Payment Summary --}}
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">

            {{-- Left Column: Product List --}}
            <div class="lg:col-span-8 space-y-4">

                {{-- Select All and Delete Options --}}
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-100 flex justify-between items-center">
                    <label class="flex items-center space-x-3 text-lg font-bold cursor-pointer">
                        <input type="checkbox" class="
                        appearance-none h-6 w-6 border-2 border-gray-300 rounded-md bg-white 
                        checked:bg-primary checked:border-primary transition relative flex items-center justify-center
                    " checked>
                        <span class="text-gray-800">Pilih Semua Produk</span>
                    </label>

                    <button class="text-primary font-bold hover:underline text-sm sm:text-base">
                        <span class="hidden sm:inline">Hapus Produk Terpilih</span>
                        <i class="fas fa-trash-alt sm:hidden text-lg"></i>
                    </button>
                </div>

                {{-- LOOP: Iterate Per Branch/Cart --}}
                @foreach ($keranjang as $cart_per_branch)
                @php
                $branch_name = 'Cabang ' . $cart_per_branch->branch->name;
                @endphp
                <div class="bg-white rounded-lg shadow-md border border-gray-100">

                    {{-- Branch Header --}}
                    <div class="p-4 border-b border-gray-100 flex items-center space-x-3 text-sm font-semibold">
                        <label class="flex items-center cursor-pointer flex-shrink-0">
                            <input type="checkbox" class="appearance-none h-5 w-5 border-2 border-gray-300 rounded-md bg-white checked:bg-primary checked:border-primary transition relative flex items-center justify-center" checked>
                        </label>

                        <span class="text-gray-800 truncate">Diproses dari :  <span class="font-bold"> <i class="fas fa-store text-primary text-xs cursor-pointer flex-shrink-0" title="Info Toko"></i>
                                {{ $branch_name }}
                            </span> </span>

                    </div>

                    {{-- LOOP: Iterate Per Product Item --}}
                    @foreach ($cart_per_branch->items as $item)
                    @php
                    $product = $item->product;
                    $unit_price_rp = $item->price_cents;
                    @endphp
                    <div class="p-4 flex space-x-4 items-start border-t border-gray-100 first:border-t-0">

                        <label class="flex-shrink-0 pt-1 cursor-pointer">
                            <input type="checkbox" class="appearance-none h-5 w-5 border-2 border-gray-300 rounded-md bg-white checked:bg-primary checked:border-primary transition relative flex items-center justify-center" checked>
                        </label>

                        {{-- Product Image --}}
                        <div class="flex-shrink-0 w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-md overflow-hidden">
                            <img src="{{ env('APP_URL_BE') . $product->images->where('is_main', true)->first()->url ?? 'https://placehold.co/100x100/eeeeee/333333?text=Product' }}"
                                alt="{{ $product->nama_produk ?? 'Produk Tidak Ditemukan' }}"
                                class="object-cover w-full h-full"
                                onerror="this.onerror=null;this.src='https://placehold.co/100x100/eeeeee/333333?text=No+Image';">
                        </div>

                        {{-- Product Content (Name & Price) --}}
                        <div class="flex-grow min-w-0">
                            <p class="text-sm font-semibold text-gray-800 mb-1 leading-snug line-clamp-2">
                                {{ $product->name ?? 'Produk Dihapus' }}
                            </p>
                            {{-- Variant --}}
                            @if ($item->variant)
                            <span class="text-xs text-gray-500 block mb-1">Varian: {{ $item->variant->variant_name ?? '' }}</span>
                            @endif

                            <div class="flex items-center space-x-2 mb-2 flex-wrap">
                                {{-- Item Final Price --}}
                                <span class="text-base font-extrabold text-primary sm:text-lg">
                                    Rp{{ number_format($unit_price_rp, 0, ',', '.') }}
                                </span>

                                {{-- Discount Placeholder (Uncomment/Update with actual logic) --}}
                                {{-- <span class="text-xs text-gray-400 line-through">Rp450.000</span>
                                <span class="text-xs font-bold text-red-600 border border-red-600 rounded px-1 mt-1 sm:mt-0">22.22%</span> --}}
                            </div>
                        </div>

                        {{-- Actions & Quantity --}}
                        <div class="flex flex-col items-end space-y-3 flex-shrink-0">
                            {{-- Delete Button (Desktop) --}}
                            <button data-item-id="{{ $item->id }}" class="text-gray-400 hover:text-red-500 transition hidden sm:block delete-btn">
                                <i class="fas fa-trash-alt text-lg"></i>
                            </button>

                            {{-- Quantity Control --}}
                            <div class="flex items-center border border-gray-300 rounded-md overflow-hidden text-base">
                                <button class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-200 transition">-</button>
                                <span class="w-8 h-8 flex items-center justify-center font-bold border-l border-r border-gray-300">{{ $item->quantity }}</span>
                                <button class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-200 transition">+</button>
                            </div>

                            {{-- Delete Button (Mobile) --}}
                            <button data-item-id="{{ $item->id }}" class="text-gray-400 hover:text-red-500 transition sm:hidden text-sm delete-btn">
                                Hapus
                            </button>
                        </div>
                    </div>

                    {{-- Add Note Link --}}
                    <div class="px-4 pb-4 text-sm">
                        <a href="#" class="text-primary hover:underline">Tambah Catatan</a>
                    </div>
                    @endforeach

                    {{-- Divider for separation between carts/branches --}}
                    @if (!$loop->last)
                    <div class="h-2 bg-gray-50"></div>
                    @endif
                </div>
                @endforeach

                <div class="text-sm text-gray-500 text-center py-4">
                    Terdapat {{ $keranjang->count() }} keranjang terpisah (berdasarkan cabang/toko).
                </div>
            </div>

            {{-- Right Column: Payment Summary Detail --}}
            <div class="lg:col-span-4 mt-8 lg:mt-0">
                @php
                $subtotal_price = $total_harga_global;
                $discount = 0;
                $shipping = 0;
                $final_total = $subtotal_price - $discount + $shipping;
                $total_items = $keranjang->sum(fn($c) => $c->items->count());
                @endphp

                <div class="p-6 bg-white rounded-lg shadow-md border border-gray-100 lg:sticky lg:top-8">

                    <h2 class="text-lg font-extrabold text-gray-800 mb-4">Detail Rincian Pembayaran</h2>

                    <div class="space-y-3 pb-4 border-b border-gray-100 text-sm">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Subtotal Harga ({{ $total_items }} produk)</span>
                            <span class="font-bold">Rp{{ number_format($subtotal_price, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between items-start text-gray-600 pt-1">
                            <div class="pr-2">
                                <p>Promo Produk</p>
                                <p class="text-xs text-gray-400 mt-0.5">Harga di atas belum termasuk potongan promo apapun</p>
                            </div>
                            <span class="font-bold text-red-600 flex-shrink-0">-Rp{{ number_format($discount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 text-lg font-extrabold">
                        <span>Total Pembayaran</span>
                        <span class="text-gray-800">Rp{{ number_format($final_total, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-xs text-right text-gray-600 mb-6">Belum termasuk ongkos kirim</p>

                    {{-- Checkout Button --}}
                    <button class="w-full py-3 rounded-lg bg-primary text-white font-bold text-lg hover:bg-primary-dark transition duration-150 shadow-md shadow-primary-500/50">
                        <a href="{{url('checkout')}}" class="block">
                            Lanjut Bayar
                        </a>
                    </button>
                </div>
            </div>
        </div>
        @endif


    </div>

</section>
@endsection


@push('scripts')
<script>
    $(document).ready(function() {

        // --- Fungsi Pembantu untuk Menghitung Ulang Total ---
        function updateCartSummary() {
            let totalProduct = 0;
            let subtotalPrice = 0;
            const discount = 0; // Tetap 0 untuk skenario klien-saja

            // Iterasi melalui setiap item produk yang masih ada di DOM
            $('.p-4.flex').each(function() {
                const itemRow = $(this);
                const isChecked = itemRow.find('label input[type="checkbox"]').is(':checked');

                if (isChecked) {
                    const quantity = parseInt(itemRow.find('.flex.items-center.border span.font-bold').text());
                    const priceText = itemRow.find('.text-base.font-extrabold.text-primary').text().replace('Rp', '').replace(/\./g, '');
                    const unitPrice = parseInt(priceText);

                    if (!isNaN(quantity) && !isNaN(unitPrice)) {
                        subtotalPrice += quantity * unitPrice;
                        totalProduct += quantity;
                    }
                }
            });

            const finalTotal = subtotalPrice - discount;

            // Update DOM di kolom kanan (Detail Rincian Pembayaran)
            $('.lg\\:col-span-4 .space-y-3 span.font-bold:eq(0)').html(`Rp${new Intl.NumberFormat('id-ID').format(subtotalPrice)}`);
            $('.lg\\:col-span-4 .space-y-3 span:contains("Subtotal Harga")').closest('.flex').find('span:eq(0)').text(`Subtotal Harga (${totalProduct} produk)`);

            $('.lg\\:col-span-4 .text-lg.font-extrabold span.text-gray-800').html(`Rp${new Intl.NumberFormat('id-ID').format(finalTotal)}`);

            // Update jumlah produk di header "Pilih Semua"
            $('span:contains("Pilih Semua")').text(`Pilih Semua (${totalProduct} Produk)`);

            // Tampilkan atau sembunyikan tampilan keranjang kosong jika semua item terhapus
            if ($('.p-4.flex').length === 0) {
                $('.lg\\:grid.lg\\:grid-cols-12').hide();
                $('.max-w-7xl > .p-12').show(); // Tampilkan Tampilan Keranjang Kosong
            }
        }


        // --- 1. Fungsionalitas Hapus Item (Client-Side) ---
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const itemRow = $(this).closest('.p-4.flex');

            // Hapus elemen dari DOM
            itemRow.fadeOut(300, function() {
                $(this).remove();
                // Setelah item dihapus, hitung ulang total harga
                updateCartSummary();
            });
        });

        // --- 2. Fungsionalitas Ubah Kuantitas (Client-Side) ---
        $(document).on('click', '.flex.items-center.border button', function() {
            const button = $(this);
            const parentDiv = button.closest('.flex.items-center.border');
            const quantitySpan = parentDiv.find('span.font-bold');
            const currentQuantity = parseInt(quantitySpan.text());

            let newQuantity;

            if (button.text() === '+') {
                newQuantity = currentQuantity + 1;
            } else if (button.text() === '-') {
                newQuantity = currentQuantity > 1 ? currentQuantity - 1 : 1;
            } else {
                return;
            }

            // Update DOM dan hitung ulang total
            quantitySpan.text(newQuantity);
            updateCartSummary();
        });

        // --- 3. Fungsionalitas Pilih Semua & Pilih Per Toko (Client-Side) ---

        // Listener untuk Checkbox 'Pilih Semua' Global
        const $globalCheckbox = $('h1').closest('.max-w-7xl').find('input[type="checkbox"]').first();

        $globalCheckbox.on('change', function() {
            const isChecked = $(this).is(':checked');
            // Terapkan ke semua checkbox toko dan item
            $('.bg-white input[type="checkbox"]').prop('checked', isChecked);
            updateCartSummary();
        });

        // Listener untuk Checkbox Per Toko
        $(document).on('change', '.p-4.border-b input[type="checkbox"]', function() {
            const isChecked = $(this).is(':checked');
            const $branchContainer = $(this).closest('.bg-white.rounded-lg.shadow-md');

            // Pilih/batalkan pilih semua item dalam toko tersebut
            $branchContainer.find('.p-4.flex input[type="checkbox"]').prop('checked', isChecked);
            updateCartSummary();

            // Perbarui status checkbox global
            if (!isChecked) {
                $globalCheckbox.prop('checked', false);
            } else {
                // Cek apakah semua checkbox toko sekarang terpilih
                const allBranchChecked = $('.p-4.border-b input[type="checkbox"]').length === $('.p-4.border-b input[type="checkbox"]:checked').length;
                $globalCheckbox.prop('checked', allBranchChecked);
            }
        });

        // Listener untuk Checkbox Per Item
        $(document).on('change', '.p-4.flex input[type="checkbox"]', function() {
            const $itemCheckbox = $(this);
            const $branchContainer = $itemCheckbox.closest('.bg-white.rounded-lg.shadow-md');
            const $branchCheckbox = $branchContainer.find('.p-4.border-b input[type="checkbox"]');

            updateCartSummary();

            // Cek apakah semua item di toko ini terpilih
            const totalItems = $branchContainer.find('.p-4.flex input[type="checkbox"]').length;
            const checkedItems = $branchContainer.find('.p-4.flex input[type="checkbox"]:checked').length;

            if (checkedItems === 0) {
                $branchCheckbox.prop('checked', false);
                $globalCheckbox.prop('checked', false);
            } else if (checkedItems === totalItems) {
                $branchCheckbox.prop('checked', true);

                // Cek apakah semua checkbox toko sekarang terpilih untuk update global
                const allBranchChecked = $('.p-4.border-b input[type="checkbox"]').length === $('.p-4.border-b input[type="checkbox"]:checked').length;
                if (allBranchChecked) {
                    $globalCheckbox.prop('checked', true);
                }
            } else {
                $branchCheckbox.prop('checked', false);
                $globalCheckbox.prop('checked', false);
            }
        });

        // Panggil saat halaman pertama dimuat untuk memastikan total benar
        updateCartSummary();

    });
</script>
@endpush
@extends('frontend.components.layout')

@section('content')

{{-- Tampilan Keranjang Kosong (Disembunyikan jika ada isi keranjang) --}}
<div class="max-w-7xl mt-5 mx-auto @if (!$keranjang->isEmpty()) hidden @endif" id="empty-cart-view">
    <div class="p-12 bg-white rounded-lg shadow-lg text-center border-4 border-dashed border-gray-200">
        <i class="fas fa-shopping-cart text-5xl text-gray-400 mb-4"></i>
        <p class="text-xl font-semibold text-gray-600">Keranjang Anda Kosong</p>
        <p class="text-gray-500 mt-2">Ayo, temukan barang-barang menarik yang Anda inginkan!</p>
        <a href="{{ url('/') }}" class="mt-6 inline-block py-2 px-6 bg-primary text-white font-bold rounded-lg hover:bg-primary-dark transition duration-150">
            Mulai Belanja
        </a>
    </div>
</div>

<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto" id="cart-content">

        <h1 class="text-2xl font-extrabold text-gray-800 mb-6">Keranjang Belanja</h1>

        @if (!$keranjang->isEmpty())

        <div class="lg:grid lg:grid-cols-12 lg:gap-8">

            {{-- KOLOM KIRI: Daftar Produk --}}
            <div class="lg:col-span-8 space-y-4">

                {{-- Opsi Pilih Semua dan Hapus Produk --}}
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-100 flex justify-between items-center">
                    <label class="flex items-center space-x-3 text-lg font-bold cursor-pointer">
                        <input type="checkbox" id="global-select-all" class="
                         h-5 w-5 border-2 border-gray-300 rounded-md bg-white 
                        checked:bg-primary checked:border-primary transition relative flex items-center justify-center
                    " checked>
                        <span class="text-gray-800" id="global-product-count">Pilih Semua Produk</span>
                    </label>

                
                </div>

                {{-- LOOP: ITERASI PER KARTU TOKO / GUDANG --}}
                @foreach ($keranjang as $cart_per_branch)
                @php
                $branch_name = $cart_per_branch->branch->name ?? 'Cabang Tidak Ditemukan';
                @endphp
                <div class="bg-white rounded-lg shadow-md border border-gray-100 cart-branch-container" data-branch-id="{{ $cart_per_branch->branch_id }}">

                    {{-- Header Toko --}}
                    @if($cart_per_branch->items ->count() > 0)
                    <div class="p-4 border-b border-gray-100 flex items-center space-x-3 text-sm font-semibold">
                        <label class="flex items-center cursor-pointer flex-shrink-0">
                            <input type="checkbox" class="branch-select-all  h-5 w-5 border-2 border-gray-300 rounded-md bg-white checked:bg-primary checked:border-primary transition relative flex items-center justify-center" checked>
                        </label>

                        <span class="text-gray-800 truncate">Diproses dari : <span class="font-bold"> <i class="fas fa-store text-primary text-xs cursor-pointer flex-shrink-0" title="Info Toko"></i>
                                {{ $branch_name }}
                            </span> </span>

                    </div>
                    @endif

                    {{-- LOOP: ITERASI PER ITEM PRODUK DALAM SATU KERANJANG --}}
                    @foreach ($cart_per_branch->items as $item)
                    @php
                    $product = $item->product;
                    $unit_price_rp = $item->price_cents;
                    @endphp
                    <div class="p-4 flex space-x-4 items-start border-t border-gray-100 first:border-t-0 cart-item-row" data-item-id="{{ $item->id }}" data-price="{{ $unit_price_rp }}">

                        <label class="flex-shrink-0 pt-1 cursor-pointer">
                            <input type="checkbox" class="item-checkbox  h-5 w-5 border-2 border-gray-300 rounded-md bg-white checked:bg-primary checked:border-primary transition relative flex items-center justify-center" checked>
                        </label>

                        {{-- Product Image --}}
                        <div class="flex-shrink-0 w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-md overflow-hidden">
                            <img src="{{ env('APP_URL_BE') . $product->images->where('is_main', true)->first()->url ?? 'https://placehold.co/100x100/eeeeee/333333?text=Product' }}"
                                alt="{{ $product->name ?? 'Produk Tidak Ditemukan' }}"
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
                                <span class="text-base font-extrabold text-primary sm:text-lg item-price">
                                    Rp{{ number_format($unit_price_rp, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- Actions & Quantity --}}
                        <div class="flex flex-col items-end space-y-3 flex-shrink-0">
                            {{-- Delete Button (Desktop) --}}
                            <button data-item-id="{{ $item->id }}" class="text-gray-400 hover:text-red-500 transition hidden sm:block delete-btn">
                                <i class="fas fa-trash-alt text-lg"></i>
                            </button>

                            {{-- Quantity Control --}}
                            <div class="flex items-center border border-gray-300 rounded-md overflow-hidden text-base item-quantity-control">
                                <button class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-200 transition quantity-minus">-</button>
                                <span class="w-8 h-8 flex items-center justify-center font-bold border-l border-r border-gray-300 item-quantity-value">{{ $item->quantity }}</span>
                                <button class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-200 transition quantity-plus">+</button>
                            </div>

                            {{-- Delete Button (Mobile) --}}
                            <button data-item-id="{{ $item->id }}" class="text-gray-400 hover:text-red-500 transition sm:hidden text-sm delete-btn">
                                Hapus
                            </button>
                        </div>
                    </div>

                    <!-- {{-- Add Note Link --}}
                    <div class="px-4 pb-4 text-sm">
                        <a href="#" class="text-primary hover:underline">Tambah Catatan</a>
                    </div> -->
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

            {{-- KOLOM KANAN: Detail Rincian Pembayaran --}}
            <div class="lg:col-span-4 mt-8 lg:mt-0">
                <div class="p-6 bg-white rounded-lg shadow-md border border-gray-100 lg:sticky lg:top-8">
                    @php
                    $subtotal_price = $total_harga_global;
                    $discount = 0;
                    $shipping = 0;
                    $final_total = $subtotal_price - $discount + $shipping;
                    $total_items = $keranjang->sum(fn($c) => $c->items->count());
                    @endphp
                    <h2 class="text-lg font-extrabold text-gray-800 mb-4">Detail Rincian Pembayaran</h2>

                    <div class="space-y-3 pb-4 border-b border-gray-100 text-sm">
                        <div class="flex justify-between items-center text-gray-600">
                            <span id="summary-product-count">Subtotal Harga ({{ $total_items }} produk)</span>
                            <span class="font-bold" id="summary-subtotal">Rp{{ number_format($subtotal_price, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between items-start text-gray-600 pt-1">
                            <div class="pr-2">
                                <p>Promo Produk</p>
                                <p class="text-xs text-gray-400 mt-0.5">Harga di atas belum termasuk potongan promo apapun</p>
                            </div>
                            <span class="font-bold text-red-600 flex-shrink-0" id="summary-discount">-Rp{{ number_format($discount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 text-lg font-extrabold">
                        <span>Total Pembayaran</span>
                        <span class="text-gray-800" id="summary-final-total">Rp{{ number_format($final_total, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-xs text-right text-gray-600 mb-6">Belum termasuk ongkos kirim</p>

                    {{-- Checkout Button --}}
                    <button id="checkout-button" class="w-full py-3 rounded-lg bg-primary text-white font-bold text-lg hover:bg-primary-dark transition duration-150 shadow-md shadow-primary-500/50">
                        Lanjut Pesan
                    </button>

                    {{-- FORM TERSEMBUNYI UNTUK SUBMISSION CHECKOUT --}}
                    <form id="checkout-form" method="POST" action="{{ route('checkout.index') }}">
                        @csrf
                        {{-- Input tersembunyi ini akan diisi oleh JavaScript dengan ID item yang dicentang --}}
                        <input type="hidden" name="selected_items" id="selected-items-input">
                    </form>
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

        // --- FUNGSI PEMBANTU: Menghitung Ulang Total Harga dan Produk ---
        function updateCartSummary() {
            let totalProductCount = 0;
            let subtotalPrice = 0;
            const discount = 0; // Tetap 0

            // 1. Iterasi melalui setiap item produk yang DICENTANG di DOM
            $('.cart-item-row').each(function() {
                const itemRow = $(this);
                const isChecked = itemRow.find('.item-checkbox').is(':checked');

                if (isChecked) {
                    const quantity = parseInt(itemRow.find('.item-quantity-value').text());
                    const priceText = itemRow.data('price'); // Mengambil harga dari data attribute
                    const unitPrice = parseInt(priceText);

                    if (!isNaN(quantity) && !isNaN(unitPrice)) {
                        subtotalPrice += quantity * unitPrice;
                        totalProductCount += quantity; // Menghitung total kuantitas produk
                    }
                }
            });

            const finalTotal = subtotalPrice - discount;

            // 2. Format Rupiah
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            // 3. Update DOM di kolom Rincian Pembayaran
            $('#summary-subtotal').html(formatter.format(subtotalPrice));
            $('#summary-product-count').text(`Subtotal Harga (${totalProductCount} produk)`);
            $('#summary-final-total').html(formatter.format(finalTotal));
            $('#summary-discount').html('-' + formatter.format(discount));

            // 4. Update count di header "Pilih Semua"
            $('#global-product-count').text(`Pilih Semua (${$('.cart-item-row').length} Produk)`);

            // 5. Menampilkan/Menyembunyikan tampilan keranjang kosong
            if ($('.cart-item-row').length === 0) {
                $('#cart-content').hide();
                $('#empty-cart-view').removeClass('hidden').show();
            } else {
                $('#empty-cart-view').addClass('hidden').hide();
                $('#cart-content').show();
            }
        }


        // 1. Fungsionalitas Hapus Item (AJAX ke Backend)
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const itemId = $(this).data('item-id');
            const itemRow = $(this).closest('.cart-item-row');

            swal.fire({
                    title: 'Anda yakin ingin menghapus produk ini dari keranjang?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        // Panggilan AJAX ke Controller Laravel
                        $.ajax({
                            url: '{{ route("cart.destroy", ["itemId" => ":itemId"]) }}'.replace(':itemId', itemId),
                            type: 'POST', // Kirim sebagai POST
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE' // Metode palsu untuk rute DELETE
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Hapus elemen dari DOM setelah sukses dari server
                                    itemRow.fadeOut(300, function() {
                                        $(this).remove();
                                        // Hitung ulang total dan perbarui tampilan
                                        updateCartSummary();
                                        // refresh page
                                        location.reload();
                                    });
                                } else {
                                    alert('Gagal menghapus item: ' + (response.message || 'Terjadi kesalahan.'));
                                }
                            },
                            error: function(xhr) {
                                const errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Gagal terhubung ke server atau terjadi error tidak terduga.';
                                alert('Gagal menghapus produk: ' + errorMessage);
                            }
                        });
                    }
                });


        });

        // 2. Fungsionalitas Ubah Kuantitas (AJAX ke Backend)
        $(document).on('click', '.quantity-plus, .quantity-minus', function() {
            const button = $(this);
            const itemRow = button.closest('.cart-item-row');
            const itemId = itemRow.data('item-id');
            const quantitySpan = button.siblings('.item-quantity-value');
            let currentQuantity = parseInt(quantitySpan.text());
            let newQuantity;

            if (button.hasClass('quantity-plus')) {
                newQuantity = currentQuantity + 1;
            } else if (button.hasClass('quantity-minus')) {
                newQuantity = currentQuantity > 1 ? currentQuantity - 1 : 1;
            } else {
                return; // Hindari eksekusi jika bukan tombol +/-
            }

            // Batalkan jika kuantitas tidak berubah dan sudah 1
            if (newQuantity === currentQuantity && newQuantity === 1 && button.hasClass('quantity-minus')) {
                return;
            }

            // Simpan kuantitas lama untuk rollback
            const oldQuantity = currentQuantity;

            // Perbarui Tampilan Sementara
            quantitySpan.text(newQuantity);

            // Panggil AJAX ke Controller Laravel
            $.ajax({
                url: '{{ route("cart.update-quantity", ["itemId" => ":itemId"]) }}'.replace(':itemId', itemId),
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quantity: newQuantity
                },
                success: function(response) {
                    if (response.success) {
                        // Sukses: Pastikan kuantitas terbaru di DOM sudah benar (dari respons)
                        quantitySpan.text(response.new_quantity);

                        updateCartSummary();
                    } else {
                        // Gagal: Kembalikan kuantitas ke nilai lama dan tampilkan pesan
                        quantitySpan.text(oldQuantity);
                        swal.fire('Gagal!', response.message || 'Gagal memperbarui kuantitas.', 'error');

                        // Jika ada data max_stock, perbarui tampilan kuantitas ke max_stock
                        if (response.max_stock !== undefined) {
                            quantitySpan.text(response.max_stock);
                            updateCartSummary(); // Hitung ulang dengan stok maksimum yang benar
                        }
                    }
                },
                error: function(xhr) {
                    // Error Server: Kembalikan kuantitas ke nilai lama
                    quantitySpan.text(oldQuantity);
                    const errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Gagal terhubung ke server.';
                    swal.fire('Error!', 'Terjadi kesalahan: ' + errorMessage, 'error');
                }
            });
        });


        // 3. Fungsionalitas Pilih Semua & Checkbox Logic
        // Global Select All
        $('#global-select-all').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.item-checkbox, .branch-select-all').prop('checked', isChecked);
            updateCartSummary();
        });

        // Branch Select All
        $(document).on('change', '.branch-select-all', function() {
            const isChecked = $(this).is(':checked');
            const $branchContainer = $(this).closest('.cart-branch-container');

            // Pilih/batalkan pilih semua item dalam toko tersebut
            $branchContainer.find('.item-checkbox').prop('checked', isChecked);
            updateCartSummary();

            // Perbarui status checkbox global
            if (!isChecked) {
                $('#global-select-all').prop('checked', false);
            } else {
                const allBranchChecked = $('.branch-select-all').length === $('.branch-select-all:checked').length;
                $('#global-select-all').prop('checked', allBranchChecked);
            }
        });

        // Item Checkbox Change
        $(document).on('change', '.item-checkbox', function() {
            const $itemCheckbox = $(this);
            const $branchContainer = $itemCheckbox.closest('.cart-branch-container');
            const $branchCheckbox = $branchContainer.find('.branch-select-all');

            updateCartSummary();

            const totalItems = $branchContainer.find('.item-checkbox').length;
            const checkedItems = $branchContainer.find('.item-checkbox:checked').length;

            if (checkedItems === 0) {
                $branchCheckbox.prop('checked', false);
                $('#global-select-all').prop('checked', false);
            } else if (checkedItems === totalItems) {
                $branchCheckbox.prop('checked', true);

                const allBranchChecked = $('.branch-select-all').length === $('.branch-select-all:checked').length;
                if (allBranchChecked) {
                    $('#global-select-all').prop('checked', true);
                }
            } else {
                $branchCheckbox.prop('checked', false);
                $('#global-select-all').prop('checked', false);
            }
        });

        // --- Fungsionalitas Lanjut Bayar ---
        $('#checkout-button').on('click', function(e) {
            e.preventDefault();

            const selectedItemIds = [];

            // 1. Kumpulkan ID dari semua item yang dicentang
            $('.cart-item-row').each(function() {
                const itemRow = $(this);
                const isChecked = itemRow.find('.item-checkbox').is(':checked');

                if (isChecked) {
                    const itemId = itemRow.data('item-id');
                    selectedItemIds.push(itemId);
                }
            });

            // 2. Validasi: Pastikan ada item yang dipilih
            if (selectedItemIds.length === 0) {
                swal.fire({
                    title: 'Perhatian',
                    text: 'Anda harus memilih minimal satu produk untuk melanjutkan pembayaran.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // 3. Masukkan ID item ke input tersembunyi
            // Kita ubah array JavaScript menjadi string JSON agar mudah diproses di sisi server (Controller)
            const selectedItemsJson = JSON.stringify(selectedItemIds);
            $('#selected-items-input').val(selectedItemsJson);

            // 4. Submit form
            $('#checkout-form').submit();
        });

        // Panggil saat halaman pertama dimuat untuk inisialisasi total
        updateCartSummary();
    });

</script>
@endpush
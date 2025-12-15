@extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-6 sm:mt-10 mb-10 sm:mb-16">
    <div class="max-w-7xl mx-auto">

        {{-- Header & Order Number --}}
        <div class="flex items-center mb-6 sm:mb-8 pb-3 border-b border-gray-100">
            {{-- Tombol Kembali --}}
            <a href="{{ route('history.transactions.index') }}" title="Kembali ke Daftar Transaksi"
                class="text-primary hover:text-primary-dark mr-3 p-2 rounded-full bg-primary-light/10 transition duration-150 flex-shrink-0">
                <i class="fas fa-arrow-left text-base sm:text-lg"></i>
            </a>
            {{-- Judul --}}
            <h1 class="text-xl sm:text-3xl font-extrabold text-gray-900 truncate mr-4">Detail Transaksi</h1>
            {{-- Nomor Order --}}
            <span class="ml-auto text-base sm:text-xl font-extrabold text-primary-dark tracking-wider flex-shrink-0" aria-label="Nomor Order">
                #{{ $transaction->order_no }}
            </span>
        </div>

        @php
            // Hitung total kuantitas produk untuk rincian pembayaran
            $totalQuantity = $transaction->items->sum('line_quantity');
            $status = strtolower($transaction->status);
            $paymentStatus = strtolower($transaction->payment_status ?? 'pending');

            // --- Definisi Status ---
            $statusMapping = [
                'pending' => ['text' => 'Menunggu Pembayaran', 'icon' => 'fas fa-hourglass-half', 'color' => 'bg-red-50 text-red-700 border-red-300'],
                'paid' => ['text' => 'Pembayaran Diterima', 'icon' => 'fas fa-check-circle', 'color' => 'bg-green-50 text-green-700 border-green-300'],
                'processing' => ['text' => 'Pesanan Diproses Penjual', 'icon' => 'fas fa-box-open', 'color' => 'bg-blue-50 text-blue-700 border-blue-300'],
                'shipped' => ['text' => 'Dalam Pengiriman Kurir', 'icon' => 'fas fa-truck-moving', 'color' => 'bg-indigo-50 text-indigo-700 border-indigo-300'],
                'complete' => ['text' => 'Selesai', 'icon' => 'fas fa-medal', 'color' => 'bg-green-50 text-green-700 border-green-300'],
                'cancelled' => ['text' => 'Dibatalkan', 'icon' => 'fas fa-times-circle', 'color' => 'bg-gray-100 text-gray-700 border-gray-300'],
                'return' => ['text' => 'Dikembalikan', 'icon' => 'fas fa-undo', 'color' => 'bg-yellow-50 text-yellow-700 border-yellow-300'],
            ];

            $currentStatus = $statusMapping[$status] ?? ['text' => 'Status Tidak Dikenal', 'icon' => 'fas fa-info-circle', 'color' => 'bg-gray-100 text-gray-700 border-gray-300'];

            // Definisi urutan langkah (untuk progress bar)
            $orderSteps = [
                'pending' => 'Dipesan', 'paid' => 'Dibayar', 'processing' => 'Diproses',
                'shipped' => 'Dikirim', 'complete' => 'Selesai',
            ];
            $orderStepKeys = array_keys($orderSteps);
            $currentStepIndex = array_search($status, $orderStepKeys);
            $stepCount = count($orderStepKeys);
            $progressWidth = ($stepCount > 1 && $currentStepIndex !== false) ? ($currentStepIndex / ($stepCount - 1)) * 100 : 0;
            // Batas waktu pembayaran
            $paymentDeadline = $transaction->placed_at ? \Carbon\Carbon::parse($transaction->placed_at)->addHours(24) : null;

        @endphp

        {{-- GRID UTAMA: Detail Transaksi (Order-2 di mobile agar Rincian Pembayaran di bawah) --}}
        {{-- Menggunakan flex-col dan lg:grid untuk responsivitas --}}
        <div class="flex flex-col lg:grid lg:grid-cols-12 lg:gap-8">

            {{-- KOLOM KIRI: Detail Produk & Pengiriman (lg:col-span-7) | Order-1 di mobile --}}
            <div class="lg:col-span-7 space-y-6 order-1 lg:order-1">

                {{-- Status dan Info Transaksi (DIREFINEMENT) --}}
                <div class="p-4 sm:p-5 rounded-xl shadow-lg border {{ $currentStatus['color'] }} flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-2 sm:space-y-0">
                    <p class="text-sm sm:text-base font-extrabold flex items-center">
                        <i class="{{ $currentStatus['icon'] }} mr-3 text-xl flex-shrink-0"></i>
                        Status Saat Ini: **{{ $currentStatus['text'] }}**
                    </p>
                    @if ($status == 'pending' && $paymentDeadline)
                        <p class="text-xs sm:text-sm font-semibold text-right whitespace-nowrap">
                            Batas Bayar:
                            <span class="text-red-700 font-bold">
                                **{{ $paymentDeadline->translatedFormat('d M Y') }} Pukul {{ $paymentDeadline->translatedFormat('H:i') }} WIB**
                            </span>
                        </p>
                    @elseif ($status == 'shipped')
                        <p class="text-xs sm:text-sm font-semibold text-right whitespace-nowrap">
                            Estimasi Tiba: **{{ $transaction->estimated_delivery_date ?? 'Cek resi' }}**
                        </p>
                    @endif
                </div>

                {{-- Visualisasi Status/Progress Bar (DIREFINEMENT) --}}
                @if (!in_array($status, ['cancelled', 'return']))
                    <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-gray-100">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 sm:mb-6 border-b pb-3"><i class="fas fa-layer-group text-primary mr-2"></i> Perkembangan Order</h2>
                        <div class="flex justify-between items-start relative py-4">

                            {{-- Line Progress Bar --}}
                            {{-- Line progress bar diletakkan di bawah step untuk visualisasi yang lebih baik --}}
                            <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 transform -translate-y-1/2 mx-2 sm:mx-8" aria-hidden="true">
                                <div class="h-1 bg-primary transition-all duration-500 rounded-full" style="width: {{ $progressWidth }}%"></div>
                            </div>

                            @foreach ($orderSteps as $stepKey => $stepName)
                                @php
                                    $i = array_search($stepKey, $orderStepKeys);
                                    $isActive = $i <= $currentStepIndex;
                                    $isCurrent = $i == $currentStepIndex;

                                    // Menggunakan ring dan warna yang lebih halus
                                    $circleClass = $isActive ? 'bg-primary text-white shadow-primary/50 ring-2 ring-primary' : 'bg-gray-100 text-gray-500 ring-2 ring-gray-300';
                                @endphp

                                {{-- Circle Status --}}
                                <div class="flex flex-col items-center flex-1 z-20 px-1" aria-current="{{ $isCurrent ? 'step' : 'false' }}">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300 {{ $circleClass }}">
                                        {{-- Icon dinamis yang lebih spesifik atau tetap generik --}}
                                        @if($isCurrent)
                                            <i class="fas fa-dot-circle text-base sm:text-lg"></i> {{-- Icon khusus untuk status saat ini --}}
                                        @elseif($isActive)
                                            <i class="fas fa-check text-xs sm:text-sm"></i>
                                        @else
                                            <i class="fas fa-circle text-xs text-gray-400"></i> {{-- Icon untuk status yang belum tercapai --}}
                                        @endif
                                    </div>
                                    <span class="text-xs sm:text-sm mt-2 text-center {{ $isCurrent ? 'font-bold text-primary' : ($isActive ? 'text-gray-700 font-semibold' : 'text-gray-500') }}">{{ $stepName }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Informasi Dasar Transaksi --}}
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-gray-100">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 border-b pb-3"><i class="fas fa-receipt text-primary mr-2"></i> Info Pembayaran & Order</h2>
                    <dl class="space-y-3 text-xs sm:text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Tanggal Order</dt>
                            <dd class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($transaction->placed_at)->translatedFormat('d M Y, H:i') }} WIB</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Kode Transaksi</dt>
                            <dd class="font-bold text-gray-800 tracking-wider">{{ $transaction->order_no }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Metode Pembayaran</dt>
                            <dd class="font-bold text-gray-800">{{ $transaction->paymentMethod->name ?? 'Belum Dipilih' }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-gray-500">Status Pembayaran</dt>
                            <dd class="font-extrabold text-white px-2 py-0.5 rounded-full text-xs uppercase {{ $paymentStatus == 'paid' ? 'bg-green-500' : 'bg-red-500' }}">{{ $transaction->payment_status }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Detail Produk (Looping Dinamis) --}}
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-gray-100">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 border-b pb-3"><i class="fas fa-shopping-basket text-primary mr-2"></i> Produk yang Dibeli (<span class="text-primary">{{ $totalQuantity }}</span> item)</h2>

                    @forelse ($transaction->items as $item)
                    @php
                        // Memastikan URL gambar aman
                        $imgUrl = $item->product->images->where('is_main', true)->first()->url ?? 'https://via.placeholder.com/80?text=No+Image';
                        $fullImgUrl = str_starts_with($imgUrl, 'http') ? $imgUrl : env('APP_URL_BE') . $imgUrl;

                        $unitPrice = $item->unit_price;
                        $quantity = $item->line_quantity;
                        $lineTotalBeforeDiscount = $item->line_total_before_discount;
                        $lineDiscount = $item->line_discount;
                        $lineTotalAfterDiscount = $item->line_total_after_discount;

                        $discountPercentage = ($lineTotalBeforeDiscount > 0) ? round(($lineDiscount / $lineTotalBeforeDiscount) * 100, 0) : 0;
                    @endphp

                    <div class="flex space-x-3 items-start border-b last:border-b-0 py-3 sm:py-4 last:pb-0">
                        {{-- Gambar Produk --}}
                        <div class="flex-shrink-0 w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                            <img src="{{ $fullImgUrl }}" alt="{{ $item->product_name }}" loading="lazy" class="object-cover w-full h-full">
                        </div>

                        {{-- Konten Produk (Nama, Varian, Harga) --}}
                        <div class="flex-grow min-w-0">
                            <p class="text-sm sm:text-base font-bold text-gray-900 mb-1 leading-snug line-clamp-2">
                                {{ $item->product_name }}
                            </p>
                            @if ($item->variant_name)
                                <p class="text-xs text-gray-500 mb-1">Varian: **{{ $item->variant_name }}**</p>
                            @endif
                            {{-- Kuantitas dan Harga Satuan --}}
                            <p class="text-sm text-gray-600 mb-1 font-semibold">{{ $quantity }} x Rp{{ number_format($unitPrice, 0, ',', '.') }}</p>

                            <div class="flex flex-wrap items-center space-x-2 mt-2">
                                {{-- Harga setelah diskon line item --}}
                                <span class="text-base sm:text-lg font-extrabold text-primary" aria-label="Total Harga Item">
                                    Rp{{ number_format($lineTotalAfterDiscount, 0, ',', '.') }}
                                </span>

                                @if ($lineDiscount > 0)
                                    <span class="text-xs text-gray-400 line-through">Rp{{ number_format($lineTotalBeforeDiscount, 0, ',', '.') }}</span>
                                    <span class="text-xs font-extrabold text-red-700 bg-red-100 rounded-full px-2 py-0.5 mt-1 sm:mt-0">{{ $discountPercentage }}% OFF</span>
                                @endif
                            </div>

                            @if (!empty($item->notes))
                                <div class="text-xs text-gray-700 mt-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                    <p class="font-bold text-yellow-800">Catatan Item:</p>
                                    <p class="italic break-words">{{ $item->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @empty
                        <p class="text-center py-6 text-gray-500 italic text-sm">Tidak ada detail produk untuk transaksi ini.</p>
                    @endforelse

                    @if (!empty($transaction->notes))
                        <div class="text-sm text-gray-700 pt-4 border-t mt-4 bg-gray-50 p-4 rounded-lg">
                            <p class="font-bold text-gray-800">Catatan Umum Order:</p>
                            <p class="italic break-words">{{ $transaction->notes }}</p>
                        </div>
                    @endif
                </div>

                {{-- INFORMASI TOKO ASAL PENGIRIMAN --}}
                @if ($transaction->branch)
                    <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-gray-100">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 border-b pb-3"><i class="fas fa-store text-primary mr-2"></i> Info Toko Asal Pengiriman</h2>
                        <address class="space-y-1 text-sm not-italic">
                            <p class="font-bold text-base mb-1 text-gray-800">{{ $transaction->branch->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $transaction->branch->address ?? 'Alamat tidak tersedia' }}
                            </p>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $transaction->branch->city ?? 'N/A' }}{{ $transaction->branch->city && $transaction->branch->province ? ', ' : '' }}{{ $transaction->branch->province ?? 'N/A' }}
                            </p>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Telp: <a href="tel:{{ $transaction->branch->phone }}" class="hover:text-primary-dark">{{ $transaction->branch->phone ?? '-' }}</a>
                            </p>
                        </address>
                    </div>
                @endif


                {{-- Detail Pengiriman --}}
                @if ($transaction->shipping_cost > 0 || in_array($status, ['processing', 'shipped', 'complete']))
                    <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-gray-100">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 border-b pb-3"><i class="fas fa-shipping-fast text-primary mr-2"></i> Detail Pengiriman</h2>
                        <dl class="space-y-3 text-xs sm:text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Layanan Kurir</dt>
                                <dd class="font-bold text-gray-800 text-right">{{ $transaction->shipping_courier ?? 'N/A' }} ({{ $transaction->shipping_service ?? 'N/A' }})</dd>
                            </div>
                            <div class="flex justify-between items-center">
                                <dt class="text-gray-500">Nomor Resi</dt>
                                <dd class="font-extrabold text-gray-800 tracking-wide">{{ $transaction->tracking_number ?? '-' }}</dd>
                            </div>
                            @if ($transaction->tracking_number)
                                <div class="pt-2 text-right">
                                    <a href="{{ $transaction->tracking_url ?? '#' }}" target="_blank" rel="noopener noreferrer"
                                       class="text-xs sm:text-sm text-primary hover:text-primary-dark font-extrabold flex items-center justify-end transition duration-150">
                                        Lacak Sekarang <i class="fas fa-external-link-alt ml-2 text-xs"></i>
                                    </a>
                                </div>
                            @endif

                            <div class="text-gray-800 mt-4 border-t pt-4">
                                <p class="font-bold text-base mb-1">Alamat Penerima:</p>
                                <p class="text-sm text-gray-700 font-semibold mb-1">
                                    **{{ $transaction->customer->full_name }}** ({{ $transaction->address->phone }})
                                </p>
                                <address class="text-sm text-gray-600 leading-relaxed not-italic">
                                    {{ $transaction->address->street }}, {{ $transaction->address->city }}, {{ $transaction->address->province }} - {{ $transaction->address->postal_code }}
                                </address>
                            </div>
                        </dl>
                    </div>
                @endif

            </div>

            {{-- KOLOM KANAN: Rincian Pembayaran & Aksi (lg:col-span-5) | Order-2 di mobile --}}
            <div class="lg:col-span-5 mt-6 lg:mt-0 order-2 lg:order-2">
                {{-- Membuat sticky di desktop --}}
                <div class="p-4 sm:p-6 bg-white rounded-xl shadow-2xl border border-gray-100 lg:sticky lg:top-24">

                    <h2 class="text-xl font-extrabold text-gray-900 mb-5 border-b pb-3"><i class="fas fa-wallet text-primary mr-2"></i> Rincian Pembayaran</h2>

                    {{-- Detail Harga --}}
                    <dl class="space-y-3 pb-4 border-b border-gray-200 text-sm">
                        <div class="flex justify-between items-center text-gray-600">
                            <dt>Harga Barang ({{ $totalQuantity }} item)</dt>
                            <dd class="font-bold">Rp{{ number_format($transaction->subtotal_before_discount, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between items-center text-gray-600">
                            <dt>Diskon Produk & Voucher</dt>
                            <dd class="font-extrabold text-red-600">-Rp{{ number_format($transaction->discount_total, 0, ',', '.') }}</dd>
                        </div>
                    </dl>

                    {{-- Subtotal Akhir Produk (setelah diskon) --}}
                    <div class="flex justify-between items-center py-3 border-b border-gray-200 text-sm sm:text-md font-extrabold text-gray-800">
                        <dt>Subtotal Produk Bersih</dt>
                        <dd class="font-extrabold">Rp{{ number_format($transaction->subtotal_after_discount, 0, ',', '.') }}</dd>
                    </div>

                    {{-- Biaya Tambahan --}}
                    <dl class="space-y-3 py-3 border-b border-gray-200 text-xs sm:text-sm">
                        <div class="flex justify-between items-center text-gray-600">
                            <dt>Ongkos Kirim</dt>
                            <dd class="font-bold">Rp{{ number_format($transaction->shipping_cost, 0, ',', '.') }}</dd>
                        </div>
                        @if ($transaction->other_charges > 0)
                            <div class="flex justify-between items-center text-gray-600">
                                <dt>Biaya Layanan</dt>
                                <dd class="font-bold">Rp{{ number_format($transaction->other_charges, 0, ',', '.') }}</dd>
                            </div>
                        @endif
                        @if ($transaction->tax_total > 0)
                            <div class="flex justify-between items-center text-gray-600">
                                <dt>Pajak Total</dt>
                                <dd class="font-bold">Rp{{ number_format($transaction->tax_total, 0, ',', '.') }}</dd>
                            </div>
                        @endif
                    </dl>


                    <div class="flex justify-between items-center pt-5 text-xl sm:text-2xl font-extrabold">
                        <dt>Total Bayar</dt>
                        <dd class="text-primary-dark" aria-label="Total Pembayaran">Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</dd>
                    </div>
                    <p class="text-xs text-right text-gray-500 mb-6 mt-1 font-medium">Detail sudah termasuk semua biaya dan pajak.</p>

                    {{-- Tombol Aksi (Dinamis Berdasarkan Status) --}}
                    <div class="space-y-3">
                        @if ($status == 'pending')
                            <button type="button" class="w-full py-3 sm:py-4 rounded-xl bg-red-600 text-white font-extrabold text-base sm:text-lg hover:bg-red-700 transition duration-150 shadow-lg shadow-red-500/30">
                                <i class="fas fa-credit-card mr-2"></i> Lanjutkan Pembayaran
                            </button>
                            <button type="button" class="w-full py-2.5 sm:py-3 rounded-xl border border-gray-300 text-gray-700 font-bold text-sm sm:text-md hover:bg-gray-100 transition duration-150">
                                Batalkan Transaksi
                            </button>
                        @elseif ($status == 'shipped')
                            <a href="{{ $transaction->tracking_url ?? '#' }}" target="_blank" rel="noopener noreferrer"
                               class="block w-full text-center py-3 sm:py-4 rounded-xl bg-indigo-600 text-white font-extrabold text-base sm:text-lg hover:bg-indigo-700 transition duration-150 shadow-lg shadow-indigo-500/30">
                                <i class="fas fa-truck mr-2"></i> Lacak Pengiriman
                            </a>
                            <button type="button" class="w-full py-2.5 sm:py-3 rounded-xl border border-green-500 text-green-700 font-extrabold text-sm sm:text-md hover:bg-green-50 transition duration-150">
                                <i class="fas fa-box-open mr-1"></i> Konfirmasi Pesanan Diterima
                            </button>
                        @elseif ($status == 'complete')
                            <button type="button" class="w-full py-3 sm:py-4 rounded-xl bg-primary text-white font-extrabold text-base sm:text-lg hover:opacity-90 transition duration-150 shadow-lg shadow-primary/30">
                                <i class="fas fa-star mr-2"></i> Beri Ulasan & Nilai
                            </button>
                            <button type="button" class="w-full py-2.5 sm:py-3 rounded-xl border border-gray-300 text-gray-700 font-bold text-sm sm:text-md hover:bg-gray-100 transition duration-150">
                                Pesan Lagi Item Ini
                            </button>
                        @elseif (in_array($status, ['cancelled', 'return']))
                             <div class="bg-gray-100 p-4 rounded-xl text-center border border-gray-300">
                                <p class="text-base font-bold text-gray-700"><i class="fas fa-exclamation-circle mr-1"></i> Tidak ada aksi yang tersedia.</p>
                                <p class="text-sm text-gray-500 mt-1">Status order: **{{ $currentStatus['text'] }}**</p>
                            </div>
                        @else
                             <div class="bg-gray-100 p-4 rounded-xl text-center border border-gray-300">
                                <p class="text-base font-bold text-gray-700">Tidak ada aksi yang tersedia.</p>
                                <p class="text-sm text-gray-500">Status saat ini: **{{ $currentStatus['text'] }}**</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>
@endsection
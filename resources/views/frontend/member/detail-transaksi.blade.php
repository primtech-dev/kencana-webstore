@extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-12">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header & Order Number --}}
        <div class="flex items-center mb-6 pb-3">
            <a href="{{ route('history.transactions.index') }}" class="text-primary hover:text-primary-dark mr-4 p-2 rounded-full bg-primary-light/10">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900">Detail Transaksi</h1>
            <span class="ml-auto text-xl font-extrabold text-primary-dark tracking-wider">#{{ $transaction->order_no }}</span>
        </div>
        
        @php
            // Hitung total kuantitas produk untuk rincian pembayaran
            $totalQuantity = $transaction->items->sum('line_quantity');
            $status = strtolower($transaction->status); 
            $paymentStatus = strtolower($transaction->payment_status ?? 'pending');
            
            // Definisikan urutan langkah dan status saat ini
            $orderSteps = ['pending', 'paid', 'processing', 'shipped', 'complete'];
            $currentStepIndex = array_search($status, $orderSteps);

            $statusText = [
                'pending' => 'Menunggu Pembayaran',
                'paid' => 'Pembayaran Diterima', 
                'processing' => 'Pesanan Diproses Penjual',
                'shipped' => 'Dalam Pengiriman Kurir',
                'complete' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                'return' => 'Dikembalikan',
            ][$status] ?? 'Status Tidak Dikenal';

            // Logika kelas CSS
            $statusColor = [
                'pending' => 'bg-red-50 text-red-600 border-red-300',
                'paid' => 'bg-green-50 text-green-600 border-green-300',
                'processing' => 'bg-blue-50 text-blue-600 border-blue-300',
                'shipped' => 'bg-indigo-50 text-indigo-600 border-indigo-300', // Warna beda untuk Shipped
                'complete' => 'bg-green-50 text-green-600 border-green-300',
                'cancelled' => 'bg-gray-100 text-gray-700 border-gray-300',
                'return' => 'bg-yellow-50 text-yellow-600 border-yellow-300',
            ][$status] ?? 'bg-gray-100 text-gray-700 border-gray-300';
            
            // Icon untuk status
            $statusIcon = [
                'pending' => 'fas fa-hourglass-half',
                'paid' => 'fas fa-check-circle', 
                'processing' => 'fas fa-box-open',
                'shipped' => 'fas fa-truck-moving',
                'complete' => 'fas fa-medal',
                'cancelled' => 'fas fa-times-circle',
                'return' => 'fas fa-undo',
            ][$status] ?? 'fas fa-info-circle';
        @endphp

        {{-- GRID UTAMA: Detail Transaksi --}}
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            {{-- KOLOM KIRI: Detail Produk & Pengiriman (lg:col-span-7) --}}
            <div class="lg:col-span-7 space-y-6">
                
                {{-- Status dan Info Transaksi (DIREFINEMENT) --}}
                <div class="p-5 rounded-xl shadow-lg border {{ $statusColor }} flex items-center justify-between">
                    <p class="text-base font-extrabold flex items-center">
                        <i class="{{ $statusIcon }} mr-3 text-xl"></i>
                        Status Saat Ini: **{{ $statusText }}**
                    </p>
                    @if ($status == 'pending')
                        <p class="text-sm font-semibold text-right">Batas Bayar: <span class="text-red-700">**{{ \Carbon\Carbon::parse($transaction->placed_at)->addHours(24)->format('d M Y Pukul H:i') }} WIB**</span></p>
                    @elseif ($status == 'shipped')
                        <p class="text-sm font-semibold text-right">Estimasi Tiba: **{{ $transaction->estimated_delivery_date ?? 'Cek resi' }}**</p>
                    @endif
                </div>

                {{-- Visualisasi Status/Progress Bar (DIREFINEMENT) --}}
                @if (!in_array($status, ['cancelled', 'return']))
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Perkembangan Order</h2>
                        <div class="flex justify-between items-start relative py-4">
                            
                            {{-- Line Progress Bar --}}
                            <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 transform -translate-y-1/2 mx-8">
                                @php
                                    $progressWidth = ($currentStepIndex / (count($orderSteps) - 1)) * 100;
                                @endphp
                                <div class="h-1 bg-primary transition-all duration-500 rounded-full" style="width: {{ $progressWidth }}%"></div>
                            </div>

                            @foreach ($orderSteps as $i => $step)
                                @php
                                    $stepName = [
                                        'pending' => 'Dipesan', 'paid' => 'Dibayar', 'processing' => 'Diproses',
                                        'shipped' => 'Dikirim', 'complete' => 'Selesai',
                                    ][$step] ?? $step;

                                    $isActive = $i <= $currentStepIndex;
                                    $isCurrent = $i == $currentStepIndex;
                                    
                                    $circleClass = $isActive ? 'bg-primary text-white shadow-primary/50 shadow-md' : 'bg-gray-100 text-gray-500 border-2 border-gray-300';
                                    $iconStep = $isCurrent ? 'fas fa-dot-circle animate-pulse' : ($isActive ? 'fas fa-check' : 'fas fa-circle');
                                @endphp

                                {{-- Circle Status --}}
                                <div class="flex flex-col items-center flex-1 z-20 px-1">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300 {{ $circleClass }}">
                                        @if($isCurrent)
                                            <i class="fas fa-truck-loading text-lg"></i>
                                        @elseif($isActive)
                                            <i class="fas fa-check text-sm"></i>
                                        @else
                                            <i class="fas fa-minus text-xs"></i>
                                        @endif
                                    </div>
                                    <span class="text-xs mt-2 text-center {{ $isCurrent ? 'font-bold text-primary' : ($isActive ? 'text-gray-700 font-semibold' : 'text-gray-500') }}">{{ $stepName }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <hr class="border-t border-gray-200 lg:hidden">

                {{-- Informasi Dasar Transaksi --}}
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-3"><i class="fas fa-receipt text-primary mr-2"></i> Info Pembayaran & Order</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal Order</span>
                            <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($transaction->placed_at)->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">ID Order Publik</span>
                            <span class="font-bold text-gray-800 tracking-wider">{{ $transaction->public_id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Metode Pembayaran</span>
                            <span class="font-bold text-gray-800">{{ $transaction->paymentMethod->name ?? 'Belum Dipilih' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status Pembayaran</span>
                            <span class="font-extrabold text-white px-3 py-1 rounded-full text-xs uppercase {{ $paymentStatus == 'paid' ? 'bg-green-500' : 'bg-red-500' }}">{{ $transaction->payment_status }}</span>
                        </div>
                    </div>
                </div>

                {{-- Detail Produk (Looping Dinamis) --}}
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-3"><i class="fas fa-shopping-basket text-primary mr-2"></i> Produk yang Dibeli (<span class="text-primary">{{ $totalQuantity }}</span> item)</h2>
                    
                    @forelse ($transaction->items as $item)
                    @php
                        $imgUrl = env('APP_URL_BE') . $item->product->images->where('is_main', true)->first()->url?: 'https://via.placeholder.com/50?text=No+Image';
                        $unitPrice = $item->unit_price; 
                        $quantity = $item->line_quantity;
                        $lineTotalBeforeDiscount = $item->line_total_before_discount;
                        $lineDiscount = $item->line_discount;
                        $lineTotalAfterDiscount = $item->line_total_after_discount;
                        
                        $discountPercentage = ($lineTotalBeforeDiscount > 0) ? round(($lineDiscount / $lineTotalBeforeDiscount) * 100, 0) : 0;
                    @endphp
                    
                    <div class="flex space-x-4 items-start border-b last:border-b-0 py-4 last:pb-0">
                        <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                            <img src="{{ $imgUrl }}" alt="{{ $item->product_name }}" class="object-cover w-full h-full">
                        </div>

                        {{-- Konten Produk (Nama, Varian, Harga) --}}
                        <div class="flex-grow min-w-0">
                            <p class="text-base font-bold text-gray-900 mb-1 leading-snug line-clamp-2">
                                {{ $item->product_name }}
                            </p>
                            @if ($item->variant_name)
                                <p class="text-xs text-gray-500 mb-1">Varian: **{{ $item->variant_name }}**</p>
                            @endif
                            <p class="text-sm text-gray-600 mb-1 font-semibold">{{ $quantity }} x Rp{{ number_format($unitPrice, 0, ',', '.') }}</p>
                            
                            <div class="flex items-center space-x-2 mt-2">
                                {{-- Harga setelah diskon line item --}}
                                <span class="text-lg font-extrabold text-primary">Rp{{ number_format($lineTotalAfterDiscount, 0, ',', '.') }}</span>
                                
                                @if ($lineDiscount > 0)
                                    <span class="text-xs text-gray-400 line-through">Rp{{ number_format($lineTotalBeforeDiscount, 0, ',', '.') }}</span>
                                    <span class="text-xs font-extrabold text-red-600 bg-red-100 rounded-full px-2 py-0.5">{{ $discountPercentage }}% OFF</span>
                                @endif
                            </div>
                            
                            @if (!empty($item->notes))
                                <div class="text-xs text-gray-700 mt-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                    <p class="font-bold text-yellow-700">Catatan Item:</p>
                                    <p class="italic">{{ $item->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @empty
                        <p class="text-center py-6 text-gray-500 italic">Tidak ada detail produk untuk transaksi ini.</p>
                    @endforelse

                    @if (!empty($transaction->notes))
                        <div class="text-sm text-gray-700 pt-4 border-t mt-4 bg-gray-50 p-4 rounded-lg">
                            <p class="font-bold text-gray-800">Catatan Umum Order:</p>
                            <p class="italic">{{ $transaction->notes }}</p>
                        </div>
                    @endif
                </div>
                
                {{-- INFORMASI TOKO ASAL PENGIRIMAN (Tambahan Baru) --}}
                @if ($transaction->branch)
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-3"><i class="fas fa-store text-primary mr-2"></i> Info Toko Asal Pengiriman</h2>
                        <div class="space-y-3 text-sm">
                            <div class="text-gray-800">
                                <p class="font-bold text-base mb-1">{{ $transaction->branch->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    {{ $transaction->branch->street ?? 'Alamat tidak tersedia' }}
                                </p>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    {{ $transaction->branch->city ?? 'N/A' }}{{ $transaction->branch->city && $transaction->branch->province ? ', ' : '' }}{{ $transaction->branch->province ?? 'N/A' }}
                                </p>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    Telp: {{ $transaction->branch->phone ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif


                {{-- Detail Pengiriman --}}
                @if ($transaction->shipping_cost > 0 || in_array($status, ['processing', 'shipped', 'complete']))
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-3"><i class="fas fa-shipping-fast text-primary mr-2"></i> Detail Pengiriman</h2>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Layanan Kurir</span>
                                <span class="font-bold text-gray-800">{{ $transaction->shipping_courier ?? 'N/A' }} ({{ $transaction->shipping_service ?? 'N/A' }})</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Nomor Resi</span>
                                <span class="font-extrabold text-gray-800 tracking-wide">{{ $transaction->tracking_number ?? '-' }}</span>
                            </div>
                            @if ($transaction->tracking_number)
                                <div class="pt-2 text-right">
                                    <a href="{{ $transaction->tracking_url ?? '#' }}" target="_blank" class="text-sm text-primary hover:text-primary-dark font-extrabold flex items-center justify-end">
                                        Lacak Sekarang <i class="fas fa-external-link-alt ml-2 text-xs"></i>
                                    </a>
                                </div>
                            @endif

                            <div class="text-gray-800 mt-4 border-t pt-3">
                                <p class="font-bold text-base mb-1">Alamat Penerima:</p>
                                <p class="text-sm text-gray-700 font-semibold mb-1">
                                    **{{ $transaction->customer->full_name }}** ({{ $transaction->address->phone }})
                                </p>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    {{ $transaction->address->street }}, {{ $transaction->address->city }}, {{ $transaction->address->province }} - {{ $transaction->address->postal_code }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            {{-- KOLOM KANAN: Rincian Pembayaran & Aksi (lg:col-span-5) --}}
            <div class="lg:col-span-5 mt-8 lg:mt-0">
                <div class="p-6 bg-white rounded-xl shadow-2xl border border-gray-100 lg:sticky lg:top-8">
                    
                    <h2 class="text-xl font-extrabold text-gray-900 mb-5 border-b pb-3"><i class="fas fa-wallet text-primary mr-2"></i> Rincian Pembayaran</h2>
                    
                    {{-- Detail Harga --}}
                    <div class="space-y-3 pb-4 border-b border-gray-200 text-sm">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Harga Barang ({{ $totalQuantity }} item)</span>
                            <span class="font-bold">Rp{{ number_format($transaction->subtotal_before_discount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Diskon Produk & Voucher</span>
                            <span class="font-extrabold text-red-600">-Rp{{ number_format($transaction->discount_total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    {{-- Subtotal Akhir Produk (setelah diskon) --}}
                    <div class="flex justify-between items-center py-3 border-b border-gray-200 text-md font-extrabold text-gray-800">
                        <span>Subtotal Produk Bersih</span>
                        <span class="font-extrabold">Rp{{ number_format($transaction->subtotal_after_discount, 0, ',', '.') }}</span>
                    </div>

                    {{-- Biaya Tambahan --}}
                    <div class="space-y-3 py-3 border-b border-gray-200 text-sm">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Ongkos Kirim</span>
                            <span class="font-bold">Rp{{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        @if ($transaction->other_charges > 0)
                            <div class="flex justify-between items-center text-gray-600">
                                <span>Biaya Layanan</span>
                                <span class="font-bold">Rp{{ number_format($transaction->other_charges, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        @if ($transaction->tax_total > 0)
                            <div class="flex justify-between items-center text-gray-600">
                                <span>Pajak Total</span>
                                <span class="font-bold">Rp{{ number_format($transaction->tax_total, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>


                    <div class="flex justify-between items-center pt-5 text-2xl font-extrabold">
                        <span>Total Bayar</span>
                        <span class="text-primary-dark">Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-xs text-right text-gray-500 mb-6 mt-1 font-medium">Detail sudah termasuk semua biaya dan pajak.</p>
                    
                    {{-- Tombol Aksi (Dinamis Berdasarkan Status) --}}
                    <div class="space-y-3">
                        @if ($status == 'pending')
                            <button class="w-full py-4 rounded-xl bg-red-600 text-white font-extrabold text-lg hover:bg-red-700 transition duration-150 shadow-lg shadow-red-500/30">
                                <i class="fas fa-credit-card mr-2"></i> Lanjutkan Pembayaran
                            </button>
                            <button class="w-full py-3 rounded-xl border border-gray-300 text-gray-700 font-bold text-md hover:bg-gray-100 transition duration-150">
                                Batalkan Transaksi
                            </button>
                        @elseif ($status == 'shipped')
                            <a href="{{ $transaction->tracking_url ?? '#' }}" target="_blank" class="block w-full text-center py-4 rounded-xl bg-indigo-600 text-white font-extrabold text-lg hover:bg-indigo-700 transition duration-150 shadow-lg shadow-indigo-500/30">
                                <i class="fas fa-truck mr-2"></i> Lacak Pengiriman
                            </a>
                            <button class="w-full py-3 rounded-xl border border-green-500 text-green-700 font-extrabold text-md hover:bg-green-50 transition duration-150">
                                <i class="fas fa-box-open mr-1"></i> Konfirmasi Pesanan Diterima
                            </button>
                        @elseif ($status == 'complete')
                            <button class="w-full py-4 rounded-xl bg-primary text-white font-extrabold text-lg hover:opacity-90 transition duration-150 shadow-lg shadow-primary/30">
                                <i class="fas fa-star mr-2"></i> Beri Ulasan & Nilai
                            </button>
                            <button class="w-full py-3 rounded-xl border border-gray-300 text-gray-700 font-bold text-md hover:bg-gray-100 transition duration-150">
                                Pesan Lagi Item Ini
                            </button>
                        @elseif (in_array($status, ['cancelled', 'return']))
                             <div class="bg-gray-100 p-4 rounded-xl text-center">
                                <p class="text-lg font-bold text-gray-700">Tidak ada aksi yang tersedia.</p>
                                <p class="text-sm text-gray-500">Status order: **{{ $statusText }}**</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>
@endsection
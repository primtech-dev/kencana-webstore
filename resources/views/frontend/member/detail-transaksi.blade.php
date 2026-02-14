@extends('frontend.components.layout')
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    /* Efek Mewarnai semua bintang sebelumnya saat di-check */
    .rating-group input:checked~label {
        color: #fbbf24;
        /* Warna kuning (text-yellow-400) */
    }

    /* Efek Mewarnai semua bintang sebelumnya saat di-hover */
    .rating-group label:hover~label,
    .rating-group label:hover {
        color: #fcd34d;
        /* Warna kuning terang (text-yellow-300) */
    }
</style>

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-6 sm:mt-10 mb-10 sm:mb-16">
    <div class="max-w-7xl mx-auto">

        {{-- Header & Order Number --}}
        <div class="flex items-center mb-6 sm:mb-8 pb-3 border-b border-gray-100">
            <a href="{{ route('history.transactions.index') }}" title="Kembali ke Daftar Transaksi"
                class="text-primary hover:text-primary-dark mr-3 p-2 rounded-full bg-primary-light/10 transition duration-150 flex-shrink-0">
                <i class="fas fa-arrow-left text-base sm:text-lg"></i>
            </a>
            <h1 class="text-xl sm:text-3xl font-extrabold text-gray-900 truncate mr-4">Detail Transaksi</h1>
            <span class="ml-auto text-base sm:text-xl font-extrabold text-primary-dark tracking-wider flex-shrink-0">
                #{{ $transaction->order_no }}
            </span>
        </div>

        @php
        $totalQuantity = $transaction->items->sum('line_quantity');
        $status = strtolower($transaction->status);
        $paymentStatus = strtolower($transaction->payment_status ?? 'pending');

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
        $orderSteps = ['pending' => 'Dipesan', 'paid' => 'Dibayar', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'complete' => 'Selesai'];
        $orderStepKeys = array_keys($orderSteps);
        $currentStepIndex = array_search($status, $orderStepKeys);
        $progressWidth = ($currentStepIndex !== false) ? ($currentStepIndex / (count($orderStepKeys) - 1)) * 100 : 0;
        $paymentDeadline = $transaction->placed_at ? \Carbon\Carbon::parse($transaction->placed_at)->addHours(24) : null;
        @endphp

        <div class="flex flex-col lg:grid lg:grid-cols-12 lg:gap-8">

            {{-- KOLOM KIRI --}}
            <div class="lg:col-span-7 space-y-6 order-1">

                {{-- Status Alert --}}
                <div class="p-4 sm:p-5 rounded-xl shadow-lg border {{ $currentStatus['color'] }} flex flex-col sm:flex-row items-start sm:items-center justify-between">
                    <p class="text-sm sm:text-base font-extrabold flex items-center">
                        <i class="{{ $currentStatus['icon'] }} mr-3 text-xl"></i>
                        Status: {{ $currentStatus['text'] }}
                    </p>
                    @if ($status == 'pending' && $paymentDeadline)
                    <p class="text-xs sm:text-sm font-semibold mt-2 sm:mt-0">
                        Batas Bayar: <span class="text-red-700 font-bold">{{ $paymentDeadline->translatedFormat('d M Y, H:i') }} WIB</span>
                    </p>
                    @endif
                </div>

                {{-- Progress Bar --}}
                @if (!in_array($status, ['cancelled', 'return']))
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-gray-100">
                    <div class="flex justify-between items-start relative py-4">
                        <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 transform -translate-y-1/2 mx-2 sm:mx-8">
                            <div class="h-1 bg-primary transition-all duration-500 rounded-full" style="width: {{ $progressWidth }}%"></div>
                        </div>
                        @foreach ($orderSteps as $stepKey => $stepName)
                        @php
                        $i = array_search($stepKey, $orderStepKeys);
                        $isActive = $i <= $currentStepIndex;
                            $isCurrent=$i==$currentStepIndex;
                            @endphp
                            <div class="flex flex-col items-center flex-1 z-1">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center transition-all {{ $isActive ? 'bg-primary text-white shadow-lg ring-2 ring-primary' : 'bg-gray-100 text-gray-400 ring-2 ring-gray-200' }}">
                                <i class="fas {{ $isCurrent ? 'fa-dot-circle' : ($isActive ? 'fa-check' : 'fa-circle text-[8px]') }}"></i>
                            </div>
                            <span class="text-[10px] sm:text-xs mt-2 text-center {{ $isCurrent ? 'font-bold text-primary' : 'text-gray-500' }}">{{ $stepName }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Produk --}}
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-3"><i class="fas fa-shopping-basket text-primary mr-2"></i> Produk yang Dibeli</h2>
                @foreach ($transaction->items as $item)
                @php
                $imgUrl = $item->product->images->where('is_main', true)->first()->url ?? 'https://via.placeholder.com/80';
                $fullImgUrl = str_starts_with($imgUrl, 'http') ? $imgUrl : env('APP_URL_BE') . $imgUrl;
                @endphp
                <div class="flex space-x-3 items-start border-b last:border-0 py-4">
                    <img src="{{ $fullImgUrl }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg object-cover border" alt="{{ $item->product_name }}">
                    <div class="flex-grow">
                        <p class="text-sm sm:text-base font-bold text-gray-900 leading-snug">{{ $item->product_name }}</p>
                        <p class="text-xs text-gray-500">Qty: {{ $item->line_quantity }} x Rp{{ number_format($item->unit_price, 0, ',', '.') }}</p>
                        <p class="text-primary font-extrabold mt-1">Rp{{ number_format($item->line_total_after_discount, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- INFORMASI TOKO ASAL (CABANG) --}}
            @if ($transaction->branch)
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-3"><i class="fas fa-store text-primary mr-2"></i> Info Toko Asal Pengiriman</h2>
                <p class="text-sm font-bold text-gray-800">{{ $transaction->branch->name }}</p>
                <p class="text-sm text-gray-600 mt-1 italic leading-relaxed">
                    {{ $transaction->branch->address }}, {{ $transaction->branch->city }}, {{ $transaction->branch->province }}
                </p>
            </div>
            @endif

            {{-- ALAMAT TUJUAN PENGIRIMAN --}}
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-3"><i class="fas fa-map-marker-alt text-primary mr-2"></i> Alamat Tujuan</h2>
                <p class="text-sm font-bold text-gray-800">{{ $transaction->customer->full_name }} ({{ $transaction->address->phone }})</p>
                <p class="text-sm text-gray-600 mt-1 italic leading-relaxed">
                    {{ $transaction->address->street }}, {{ $transaction->address->city }}, {{ $transaction->address->province }} - {{ $transaction->address->postal_code }}
                </p>
            </div>

        </div>

        {{-- KOLOM KANAN --}}
        <div class="lg:col-span-5 mt-6 lg:mt-0 order-2">
            <div class="p-6 bg-white rounded-xl shadow-2xl border border-gray-100 sticky top-24">
                <h2 class="text-xl font-extrabold text-gray-900 mb-5 border-b pb-3">Rincian Pembayaran</h2>
                <div class="space-y-3 text-sm border-b pb-4 text-gray-600">
                    <div class="flex justify-between"><span>Subtotal Produk</span><span class="font-bold text-gray-800">Rp{{ number_format($transaction->subtotal_before_discount, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between text-red-600 font-medium"><span>Diskon</span><span>-Rp{{ number_format($transaction->discount_total, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Ongkos Kirim</span><span class="font-bold text-gray-800">Rp{{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span></div>
                </div>
                <div class="flex justify-between items-center pt-5 text-2xl font-extrabold text-primary-dark">
                    <span>Total Bayar</span>
                    <span>Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-8 space-y-3">
                    @if ($status == 'pending')
                    <button class="w-full py-4 rounded-xl bg-red-600 text-white font-extrabold hover:bg-red-700 shadow-lg transition">Lanjutkan Pembayaran</button>
                    @elseif ($status == 'shipped')
                    <button onclick="toggleModal('modalConfirm')" class="w-full py-4 rounded-xl bg-indigo-600 text-white font-extrabold hover:bg-indigo-700 shadow-lg transition">Konfirmasi Selesai</button>
                    @elseif ($status == 'complete')
                    <button onclick="toggleModal('modalReview')" class="w-full py-4 rounded-xl bg-primary text-white font-extrabold hover:opacity-90 shadow-lg transition">
                        <i class="fas fa-star mr-2"></i> Beri Ulasan
                    </button>
                    @else
                    <div class="bg-gray-50 p-4 rounded-xl text-center border text-gray-500 text-sm italic">Tidak ada aksi tersedia.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<div id="modalConfirm" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl">
        <div class="text-center">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check-double text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Pesanan Diterima?</h3>
            <p class="text-sm text-gray-500 mt-2">Pastikan produk sudah sesuai sebelum menyelesaikan transaksi.</p>
        </div>
        <div class="flex flex-col gap-2 mt-6">
            <form action="{{ route('history.transactions.complete', $transaction->order_no) }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-3 bg-green-600 text-white rounded-xl font-bold">Ya, Selesai</button>
            </form>
            <button onclick="toggleModal('modalConfirm')" class="w-full py-3 bg-gray-100 text-gray-700 rounded-xl font-bold">Batal</button>
        </div>
    </div>
</div>

<div id="modalReview" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl my-auto">
        <div class="flex justify-between items-center mb-6 border-b pb-3">
            <h3 class="text-xl font-bold text-gray-900">Ulas Produk</h3>
            <button onclick="toggleModal('modalReview')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
        </div>

        <form action="{{ route('history.transactions.review', $transaction->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                @foreach ($transaction->items as $index => $item)
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ env('APP_URL_BE') .'/' . $item->product->images->where('is_main', true)->first()->url ?? 'https://via.placeholder.com/80' }}" class="w-10 h-10 rounded-lg object-cover border">
                        <p class="text-sm font-bold text-gray-800 line-clamp-1">{{ $item->product_name }}</p>
                    </div>

                    <input type="hidden" name="reviews[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                    <input type="hidden" name="reviews[{{ $index }}][order_item_id]" value="{{ $item->id }}">
                    <input type="hidden" name="reviews[{{ $index }}][variant_id]" value="{{ $item->variant_id }}">

                    {{-- Bintang Rating --}}
                    {{-- Bintang Rating --}}
                    <div class="flex flex-row-reverse justify-end gap-1 mb-3 rating-group">
                        @for ($i = 5; $i >= 1; $i--)
                        <input type="radio"
                            name="reviews[{{ $index }}][rating]"
                            id="star-{{ $index }}-{{ $i }}"
                            value="{{ $i }}"
                            class="hidden peer"
                            required>
                        <label for="star-{{ $index }}-{{ $i }}"
                            class="cursor-pointer text-2xl text-gray-300 peer-hover:text-yellow-400 peer-checked:text-yellow-400 peer-hover:~peer-hover:text-yellow-400 transition-colors">
                            <i class="fas fa-star"></i>
                        </label>
                        @endfor
                    </div>

                    {{-- Input Teks --}}
                    <textarea name="reviews[{{ $index }}][body]" rows="2" class="w-full border border-gray-200 rounded-xl p-3 text-sm outline-none mb-3" placeholder="Tulis ulasan Anda..." required></textarea>

                    {{-- Input Upload Gambar --}}
                    <div class="mt-2">
                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Tambahkan Foto (Max 3)</label>
                        <input type="file" name="reviews[{{ $index }}][images][]" multiple accept="image/*"
                            class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-dark cursor-pointer">
                        <p class="text-[10px] text-gray-400 mt-1">*Anda bisa memilih lebih dari 1 foto sekaligus.</p>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="submit" class="w-full mt-6 py-4 bg-primary text-white rounded-xl font-extrabold shadow-lg">Kirim Ulasan & Foto</button>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }
</script>


@endsection
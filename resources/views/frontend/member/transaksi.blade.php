@extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto py-10">
    <div class="max-w-7xl mx-auto">
        
        {{-- Judul Halaman --}}
        <h1 class="text-2xl font-extrabold text-gray-900 mb-6 pb-3 flex items-center">
            <i class="fas fa-history text-primary text-2xl mr-3"></i> Riwayat Transaksi Anda
        </h1>

        {{-- GRID UTAMA: Navigasi Sidebar dan Konten Utama --}}
        {{-- Menggunakan flex-col pada mobile dan grid pada lg (desktop) --}}
        <div class="flex flex-col lg:grid lg:grid-cols-12 lg:gap-8 mt-6">
            
            {{-- KOLOM KIRI: Sidebar Navigasi --}}
            {{-- Order-2 pada mobile agar sidebar di bawah konten utama, Order-1 pada desktop --}}
            <div class="lg:col-span-3 mb-6 lg:mb-0 order-1 lg:order-2">
                @include('frontend.components.member-sidebar', ['activeMenu' => 'transaksi'])
            </div>

            {{-- KOLOM KANAN: Konten Utama (Daftar Transaksi) --}}
            {{-- Order-1 pada mobile, Order-2 pada desktop --}}
            <div class="lg:col-span-9 order-1 lg:order-2">

                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-xl border border-gray-100">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6 pb-3 border-b">Semua Pesanan</h2>
                    
                    {{-- Filter Status Transaksi --}}
                    {{-- Menggunakan overflow-x-auto untuk horizontal scroll pada mobile --}}
                    <div class="overflow-x-auto mb-6 pb-2 whitespace-nowrap scrollbar-hide">
                        <div class="inline-flex space-x-2 sm:space-x-3 text-sm p-1">
                            
                            @foreach ($statusFilters as $key => $filter)
                                @php
                                    // Tentukan class aktif
                                    $baseClass = 'py-1.5 px-3 sm:px-4 rounded-full font-semibold transition duration-200 flex-shrink-0 text-xs sm:text-sm'; // Kecilkan font dan padding di mobile
                                    if ($key == $activeStatus) {
                                        $currentClass = 'bg-primary text-white shadow-lg transform scale-105';
                                    } else {
                                        $currentClass = $filter['class'] . ' hover:shadow-md border border-gray-200';
                                    }
                                    
                                    $count = $statusCounts[$key] ?? 0;
                                    $routeParams = $key === 'all' ? [] : ['status' => $key];
                                @endphp


                                {{-- PERBAIKAN DI SINI: Menggunakan route 'history.transactions.index' --}}
                                <a href="{{ route('history.transactions.index', $routeParams) }}" 
                                    class="{{ $baseClass }} {{ $currentClass }}">
                                    {{ $filter['label'] }} <span class="ml-1 font-bold">({{ $count }})</span>
                                </a>
                            @endforeach
                            
                        </div>
                    </div>

                    {{-- Daftar Transaksi (Looping Dinamis) --}}
                    <div class="space-y-6">
                        
                        @forelse ($transactions as $transaction)
                            @php
                                $statusKey = strtolower($transaction->status);
                                
                                // Mapping Status & Aksi (Ditingkatkan)
                                $statusMapping = [
                                    'pending' => ['label' => 'Menunggu Bayar', 'color' => 'bg-red-100 text-red-600 border-red-300', 'action_label' => 'Bayar Sekarang', 'action_icon' => 'fas fa-credit-card', 'action_class' => 'bg-red-600 hover:bg-red-700'],
                                    'paid' => ['label' => 'Pembayaran Diterima', 'color' => 'bg-orange-100 text-orange-600 border-orange-300', 'action_label' => 'Lanjut Proses', 'action_icon' => 'fas fa-arrow-right', 'action_class' => 'bg-orange-600 hover:bg-orange-700'],
                                    'processing' => ['label' => 'Pesanan Diproses', 'color' => 'bg-blue-100 text-blue-600 border-blue-300', 'action_label' => 'Lihat Detail', 'action_icon' => 'fas fa-eye', 'action_class' => 'bg-primary hover:bg-primary-dark'],
                                    'shipped' => ['label' => 'Sedang Dikirim', 'color' => 'bg-indigo-100 text-indigo-600 border-indigo-300', 'action_label' => 'Lacak Pengiriman', 'action_icon' => 'fas fa-truck', 'action_class' => 'bg-indigo-600 hover:bg-indigo-700'],
                                    'complete' => ['label' => 'Selesai', 'color' => 'bg-green-100 text-green-600 border-green-300', 'action_label' => 'Beri Ulasan', 'action_icon' => 'fas fa-star', 'action_class' => 'bg-green-600 hover:bg-green-700'],
                                    'cancelled' => ['label' => 'Dibatalkan', 'color' => 'bg-gray-200 text-gray-700 border-gray-400', 'action_label' => 'Lihat Detail', 'action_icon' => 'fas fa-times-circle', 'action_class' => 'bg-gray-500 hover:bg-gray-600'],
                                ];
                                
                                $currentStatus = $statusMapping[$statusKey] ?? [
                                    'label' => 'Status Tidak Dikenal', 
                                    'color' => 'bg-gray-100 text-gray-500 border-gray-300', 
                                    'action_label' => 'Lihat Detail', 
                                    'action_icon' => 'fas fa-eye', 
                                    'action_class' => 'bg-primary hover:bg-primary-dark'
                                ];
                                
                                $firstItem = $transaction->items->first();
                                $otherItemsCount = $transaction->items->count() - 1;

                                // Rute detail menggunakan route yang benar: history.transactions.show
                                $detailRoute = route('history.transactions.show', $transaction->order_no);
                            @endphp

                            <div class="p-4 sm:p-5 border border-gray-200 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 bg-white">
                                
                                {{-- Header Transaksi: ID, Tanggal & Status --}}
                                <div class="flex justify-between items-start sm:items-center pb-3 mb-4 border-b border-gray-100">
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium tracking-wider">ORDER ID</p>
                                        <p class="font-bold text-sm sm:text-base text-gray-900">{{ $transaction->order_no }}</p>
                                    </div>
                                    <div class="text-right flex flex-col items-end">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $currentStatus['color'] }} shadow-sm">
                                            {{ $currentStatus['label'] }}
                                        </span>
                                        <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($transaction->placed_at)->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                
                                {{-- Ringkasan Produk --}}
                                <div class="flex items-start space-x-3 sm:space-x-4 mb-4 sm:mb-5">
                                    @if($firstItem)
                                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white rounded-lg overflow-hidden flex-shrink-0 border border-gray-300 shadow-inner">
                                            <img src="{{ env('APP_URL_BE') . $firstItem->product->images->where('is_main', true)->first()->url ?? 'https://via.placeholder.com/80?text=Produk' }}" 
                                                    alt="{{ $firstItem->product_name }}" 
                                                    class="object-cover w-full h-full">
                                        </div>
                                        <div class="min-w-0 flex-grow pt-1">
                                            <p class="text-sm font-extrabold text-gray-900 leading-snug">{{ $firstItem->product_name }}</p>
                                            @if($otherItemsCount > 0)
                                                <p class="text-xs text-gray-500 mt-0.5 italic">+ {{ $otherItemsCount }} produk lainnya</p>
                                            @else
                                                <p class="text-xs text-gray-500 mt-0.5">({{ $firstItem->line_quantity }} item)</p>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 italic py-3">Tidak ada produk dalam transaksi ini.</p>
                                    @endif
                                </div>

                                {{-- Total & Aksi --}}
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pt-3 sm:pt-4 border-t border-gray-200 space-y-3 sm:space-y-0">
                                    <div class="text-left">
                                        <p class="text-xs text-gray-500">Total Pembayaran</p>
                                        <p class="text-lg sm:text-xl text-red-600 font-extrabold tracking-tight">Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                    
                                    <div class="flex space-x-2 sm:space-x-3">
                                        {{-- Tombol Lihat Detail Selalu Ada --}}
                                        <a href="{{ $detailRoute }}" 
                                            class="py-2 px-3 sm:px-4 rounded-xl text-primary font-bold text-xs sm:text-sm border border-primary hover:bg-primary/10 transition duration-150">
                                            <i class="fas fa-search-plus mr-1"></i> Detail
                                        </a>

                                        {{-- Tombol Aksi Utama --}}
                                        <a href="{{ $currentStatus['action_url'] ?? $detailRoute }}" 
                                            class="py-2 px-4 sm:px-5 rounded-xl text-white font-bold text-xs sm:text-sm transition duration-150 shadow-md {{ $currentStatus['action_class'] }}">
                                            <i class="{{ $currentStatus['action_icon'] }} mr-1"></i> {{ $currentStatus['action_label'] }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- Jika tidak ada transaksi --}}
                            <div class="text-center py-8 sm:py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300 px-4">
                                <i class="fas fa-box-open text-6xl sm:text-7xl text-gray-400 mb-4"></i>
                                <p class="text-xl sm:text-2xl font-semibold text-gray-700 mb-2">Riwayat Kosong</p>
                                <p class="text-gray-500 text-sm max-w-sm mx-auto">Anda belum memiliki pesanan pada filter **{{ $statusFilters[$activeStatus]['label'] ?? 'ini' }}**. Mari mulai berbelanja!</p>
                                <a href="{{ url('/') }}" class="mt-5 inline-block py-2 px-6 bg-primary text-white font-bold rounded-lg hover:bg-primary-dark transition shadow-lg text-sm">
                                    <i class="fas fa-shopping-bag mr-2"></i> Belanja Sekarang
                                </a>
                            </div>
                        @endforelse

                    </div>

                    {{-- Pagination --}}
                    @if(isset($transactions) && method_exists($transactions, 'links'))
                        <div class="mt-8 flex justify-center">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
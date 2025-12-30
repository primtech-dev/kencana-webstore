<!-- @extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto">
        
        <h1 class="text-2xl font-extrabold text-gray-800 mb-6">Keranjang Belanja</h1>

        {{-- GRID UTAMA: Di mobile, ini akan menumpuk (default Tailwind). Baru di desktop (lg:), ia menjadi 2 kolom. --}}
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            {{-- KOLOM KIRI: Daftar Produk (akan mengisi lebar penuh di mobile) --}}
            <div class="lg:col-span-8 space-y-4">

                {{-- Opsi Pilih Semua dan Hapus Produk --}}
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-100 flex justify-between items-center">
                    <label class="flex items-center space-x-3 text-lg font-bold cursor-pointer">
                        <input type="checkbox" class="
                            appearance-none h-6 w-6 border-2 border-gray-300 rounded-md bg-white 
                            checked:bg-primary checked:border-primary transition relative flex items-center justify-center
                        " checked>
                        <span class="text-gray-800">Pilih Semua</span>
                    </label>

                    {{-- Perbaikan Mobile: Ganti teks penuh dengan ikon untuk menghemat ruang jika diperlukan --}}
                    <button class="text-primary font-bold hover:underline text-sm sm:text-base">
                        <span class="hidden sm:inline">Hapus Produk</span>
                        <i class="fas fa-trash-alt sm:hidden text-lg"></i>
                    </button>
                </div>

                {{-- KARTU TOKO / GUDANG --}}
                <div class="bg-white rounded-lg shadow-md border border-gray-100">
                    
                    {{-- Header Toko --}}
                    <div class="p-4 border-b border-gray-100 flex items-center space-x-3 text-sm font-semibold">
                        <label class="flex items-center cursor-pointer flex-shrink-0">
                            <input type="checkbox" class="appearance-none h-5 w-5 border-2 border-gray-300 rounded-md bg-white checked:bg-primary-500 checked:border-primary-500 transition relative flex items-center justify-center" checked>
                        </label>
                        {{-- FIX: truncate agar tidak memanjang di mobile --}}
                        <span class="text-gray-800 truncate">Diproses dari **Toko Terdekat**</span>
                        <i class="fas fa-info-circle text-gray-400 text-xs cursor-pointer flex-shrink-0" title="Info Toko"></i>
                    </div>

                    {{-- Detail Produk --}}
                    {{-- FIX: flex items-start agar konten tetap di baris awal --}}
                    <div class="p-4 flex space-x-4 items-start">
                        
                        <label class="flex-shrink-0 pt-1 cursor-pointer">
                            <input type="checkbox" class="appearance-none h-5 w-5 border-2 border-gray-300 rounded-md bg-white checked:bg-primary-500 checked:border-primary-500 transition relative flex items-center justify-center" checked>
                        </label>

                        <div class="flex-shrink-0 w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-md overflow-hidden">
                            <img src="https://image1ws.indotrading.com/s3/productimages/webp/co228746/p778217/w600-h600/385b7c34-ae39-462c-b059-a3f2b9122566.png" alt="INFORMA CARSON SOFA" class="object-cover w-full h-full">
                        </div>

                        {{-- Konten Produk (Nama & Harga) --}}
                        <div class="flex-grow min-w-0">
                            {{-- FIX: line-clamp-2 atau truncate untuk membatasi panjang nama produk --}}
                            <p class="text-sm font-semibold text-gray-800 mb-1 leading-snug line-clamp-2">
                                Kedai Steel Door Motif Kayu
                            </p>
                            {{-- FIX: flex-wrap agar elemen harga/diskon melompat ke baris baru jika sempit --}}
                            <div class="flex items-center space-x-2 mb-2 flex-wrap">
                                <span class="text-base font-extrabold text-primary sm:text-lg">Rp350.000</span>
                                <span class="text-xs text-gray-400 line-through">Rp450.000</span>
                                <span class="text-xs font-bold text-red-600 border border-red-600 rounded px-1 mt-1 sm:mt-0">22.22%</span>
                            </div>
                            <span class="text-xs text-red-600 font-semibold bg-red-100 px-2 py-0.5 rounded-full inline-block">Stok Terbatas</span>
                        </div>
                        
                        {{-- Opsi Aksi & Kuantitas --}}
                        <div class="flex flex-col items-end space-y-3 flex-shrink-0">
                            <button class="text-gray-400 hover:text-primary transition hidden sm:block">
                                <i class="fas fa-trash-alt text-lg"></i>
                            </button>
                            
                            {{-- Kontrol Kuantitas --}}
                            <div class="flex items-center border border-gray-300 rounded-md overflow-hidden text-base">
                                <button class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-200 transition">-</button>
                                <span class="w-8 h-8 flex items-center justify-center font-bold border-l border-r border-gray-300">1</span>
                                <button class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-200 transition">+</button>
                            </div>

                            <button class="text-gray-400 hover:text-primary transition sm:hidden text-sm">
                                Hapus
                            </button>
                        </div>
                    </div>

                    {{-- Tambah Catatan --}}
                    <div class="px-4 pb-4 text-sm">
                        <a href="#" class="text-primary hover:underline">Tambah Catatan</a>
                    </div>

                </div>
                
                <div class="text-sm text-gray-500 text-center py-4">
                    Jika ada produk lain dari toko/gudang yang berbeda, akan tampil di kartu terpisah.
                </div>
            </div>

            {{-- KOLOM KANAN: Detail Rincian Pembayaran --}}
            <div class="lg:col-span-4 mt-8 lg:mt-0">
                <div class="p-6 bg-white rounded-lg shadow-md border border-gray-100 lg:sticky lg:top-8">
                    
                    <h2 class="text-lg font-extrabold text-gray-800 mb-4">Detail Rincian Pembayaran</h2>
                    
                    <div class="space-y-3 pb-4 border-b border-gray-100 text-sm">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Subtotal Harga (1 produk)</span>
                            <span class="font-bold">Rp450.000</span>
                        </div>
                        {{-- FIX: items-start untuk mencegah teks panjang promo menimpa harga --}}
                        <div class="flex justify-between items-start text-gray-600 pt-1">
                            <div class="pr-2">
                                <p>Promo Produk</p>
                                <p class="text-xs text-gray-400 mt-0.5">Harga di atas belum termasuk potongan promo apapun</p>
                            </div>
                            <span class="font-bold text-red-600 flex-shrink-0">-Rp100.000</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 text-lg font-extrabold">
                        <span>Total Pembayaran</span>
                        <span class="text-gray-800">Rp350.000</span>
                    </div>
                    <p class="text-xs text-right text-gray-600 mb-6">Belum termasuk ongkos kirim</p>
                    
                    {{-- Tombol Lanjut Bayar --}}
                    <button class="w-full py-3 rounded-lg bg-primary text-white font-bold text-lg hover:bg-primary-dark transition duration-150 shadow-md shadow-primary-500/50">
                        <a href="{{url('checkout')}}" class="block">
                            Lanjut Bayar
                        </a>
                    </button>

                </div>
            </div>
        </div>

    </div>
</section>
@endsection -->

@extends('frontend.components.layout')

@section('content')

<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
<div class="max-w-7xl mx-auto">

<h1 class="text-2xl font-extrabold text-gray-800 mb-6">Keranjang Belanja</h1>

@if ($keranjang->isEmpty())
    {{-- TAMPILAN JIKA KERANJANG KOSONG --}}
    <div class="p-12 bg-white rounded-lg shadow-lg text-center border-4 border-dashed border-gray-200">
        <i class="fas fa-shopping-cart text-5xl text-gray-400 mb-4"></i>
        <p class="text-xl font-semibold text-gray-600">Keranjang Anda Kosong</p>
        <p class="text-gray-500 mt-2">Ayo, temukan barang-barang menarik yang Anda inginkan!</p>
        <a href="{{ url('/') }}" class="mt-6 inline-block py-2 px-6 bg-primary text-white font-bold rounded-lg hover:bg-primary-dark transition duration-150">
            Mulai Belanja
        </a>
    </div>
@else
    {{-- GRID UTAMA: Daftar Produk dan Rincian Pembayaran --}}
    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        
        {{-- KOLOM KIRI: Daftar Produk --}}
        <div class="lg:col-span-8 space-y-4">

            {{-- Opsi Pilih Semua dan Hapus Produk (Placeholder Interaktif) --}}
            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-100 flex justify-between items-center">
                <label class="flex items-center space-x-3 text-lg font-bold cursor-pointer">
                    <input type="checkbox" class="
                        appearance-none h-6 w-6 border-2 border-gray-300 rounded-md bg-white 
                        checked:bg-primary checked:border-primary transition relative flex items-center justify-center
                    " checked>
                    <span class="text-gray-800">Pilih Semua ({{ $keranjang->sum(fn($c) => $c->items->count()) }} Produk)</span>
                </label>

                <button class="text-primary font-bold hover:underline text-sm sm:text-base">
                    <span class="hidden sm:inline">Hapus Produk Terpilih</span>
                    <i class="fas fa-trash-alt sm:hidden text-lg"></i>
                </button>
            </div>

            {{-- LOOP LUAR: ITERASI PER KARTU TOKO / GUDANG --}}
            @foreach ($keranjang as $cart_per_branch)
                @php
                    $branch_name = 'Cabang ID ' . $cart_per_branch->branch_id; // Ganti dengan relasi ke Branch jika ada
                    $branch_subtotal = $cart_per_branch->items->sum('subtotal');
                @endphp
                <div class="bg-white rounded-lg shadow-md border border-gray-100">
                    
                    {{-- Header Toko --}}
                    <div class="p-4 border-b border-gray-100 flex items-center space-x-3 text-sm font-semibold">
                        <label class="flex items-center cursor-pointer flex-shrink-0">
                            <input type="checkbox" class="appearance-none h-5 w-5 border-2 border-gray-300 rounded-md bg-white checked:bg-primary checked:border-primary transition relative flex items-center justify-center" checked>
                        </label>
                        <span class="text-gray-800 truncate">Diproses dari **{{ $branch_name }}**</span>
                        <i class="fas fa-store text-primary text-xs cursor-pointer flex-shrink-0" title="Info Toko"></i>
                    </div>

                    {{-- LOOP DALAM: ITERASI PER ITEM PRODUK DALAM SATU KERANJANG --}}
                    @foreach ($cart_per_branch->items as $item)
                        @php
                            // Ambil data produk melalui relasi
                            $product = $item->product; // Asumsi relasi product() ada di model Cart_Items
                            $unit_price_rp = $item->price_cents / 100;
                            $subtotal_rp = $item->subtotal / 100;
                        @endphp
                        <div class="p-4 flex space-x-4 items-start border-t border-gray-100 first:border-t-0">
                            
                            <label class="flex-shrink-0 pt-1 cursor-pointer">
                                <input type="checkbox" class="appearance-none h-5 w-5 border-2 border-gray-300 rounded-md bg-white checked:bg-primary checked:border-primary transition relative flex items-center justify-center" checked>
                            </label>

                            {{-- Image (Gunakan placeholder jika product_image kosong) --}}
                            <div class="flex-shrink-0 w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-md overflow-hidden">
                                <img src="{{ $product->main_image_url ?? 'https://placehold.co/100x100/eeeeee/333333?text=Product' }}" 
                                     alt="{{ $product->nama_produk ?? 'Produk Tidak Ditemukan' }}" 
                                     class="object-cover w-full h-full"
                                     onerror="this.onerror=null;this.src='https://placehold.co/100x100/eeeeee/333333?text=No+Image';">
                            </div>

                            {{-- Konten Produk (Nama & Harga) --}}
                            <div class="flex-grow min-w-0">
                                <p class="text-sm font-semibold text-gray-800 mb-1 leading-snug line-clamp-2">
                                    {{ $product->nama_produk ?? 'Produk Dihapus' }}
                                </p>
                                {{-- Varian --}}
                                @if ($item->variant)
                                    <span class="text-xs text-gray-500 block mb-1">Varian: {{ $item->variant->name ?? '' }}</span>
                                @endif

                                <div class="flex items-center space-x-2 mb-2 flex-wrap">
                                    {{-- Tampilkan Harga Akhir Item --}}
                                    <span class="text-base font-extrabold text-primary sm:text-lg">
                                        Rp{{ number_format($unit_price_rp, 0, ',', '.') }}
                                    </span>
                                    
                                    {{-- Tambahkan logika Diskon di sini jika ada harga_normal --}}
                                    {{-- <span class="text-xs text-gray-400 line-through">Rp450.000</span>
                                    <span class="text-xs font-bold text-red-600 border border-red-600 rounded px-1 mt-1 sm:mt-0">22.22%</span> --}}
                                </div>
                            </div>
                            
                            {{-- Opsi Aksi & Kuantitas --}}
                            <div class="flex flex-col items-end space-y-3 flex-shrink-0">
                                {{-- Tombol Hapus (Desktop) --}}
                                <button data-item-id="{{ $item->id }}" class="text-gray-400 hover:text-red-500 transition hidden sm:block delete-btn">
                                    <i class="fas fa-trash-alt text-lg"></i>
                                </button>
                                
                                {{-- Kontrol Kuantitas --}}
                                <div class="flex items-center border border-gray-300 rounded-md overflow-hidden text-base">
                                    <button class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-200 transition">-</button>
                                    <span class="w-8 h-8 flex items-center justify-center font-bold border-l border-r border-gray-300">{{ $item->quantity }}</span>
                                    <button class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-200 transition">+</button>
                                </div>

                                {{-- Tombol Hapus (Mobile) --}}
                                <button data-item-id="{{ $item->id }}" class="text-gray-400 hover:text-red-500 transition sm:hidden text-sm delete-btn">
                                    Hapus
                                </button>
                            </div>
                        </div>

                        {{-- Tambah Catatan (Contoh) --}}
                        <div class="px-4 pb-4 text-sm">
                            <a href="#" class="text-primary hover:underline">Tambah Catatan</a>
                        </div>
                    @endforeach
                    {{-- Divider untuk memisahkan antar keranjang/toko --}}
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
            @php
                // price_cents/100
                $subtotal_price = $total_harga_global / 100; 
                $discount = 0; // Asumsi belum ada diskon
                $shipping = 0; // Asumsi ongkos kirim belum dihitung
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
                
                {{-- Tombol Lanjut Bayar --}}
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
@extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="flex items-center mb-6">
            <a href="{{ url('/transaksi') }}" class="text-primary hover:text-primary-dark mr-3">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <h1 class="text-2xl font-extrabold text-gray-800">Detail Transaksi</h1>
        </div>

        {{-- GRID UTAMA: Detail Transaksi --}}
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            {{-- KOLOM KIRI: Detail Produk & Pengiriman (lg:col-span-7) --}}
            <div class="lg:col-span-7 space-y-6">

                {{-- Status dan Info Transaksi --}}
                <div class="bg-red-50 p-4 rounded-lg shadow-sm border border-red-200">
                    <p class="text-sm font-bold text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Menunggu Pembayaran
                    </p>
                    <p class="text-xs text-red-500 mt-1">Selesaikan pembayaran sebelum **06 November 2025 Pukul 12:00 WIB**.</p>
                </div>

                {{-- Informasi Dasar Transaksi --}}
                <div class="bg-white p-6 rounded-lg shadow-md border border-light-grey">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Transaksi</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">ID Transaksi</span>
                            <span class="font-bold text-gray-800">TRX-20251105-001</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal Transaksi</span>
                            <span class="font-bold text-gray-800">05 Nov 2025, 11:30 WIB</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Metode Pembayaran</span>
                            <span class="font-bold text-gray-800">Bank Transfer (BCA)</span>
                        </div>
                    </div>
                </div>

                {{-- Detail Produk --}}
                <div class="bg-white p-6 rounded-lg shadow-md border border-light-grey">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Produk yang Dibeli</h2>
                    
                    {{-- KARTU PRODUK (Menggunakan data dari keranjang belanja Anda) --}}
                    <div class="flex space-x-4 items-start border-b pb-4 mb-4">
                        <div class="flex-shrink-0 w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-md overflow-hidden">
                            <img src="https://image1ws.indotrading.com/s3/productimages/webp/co228746/p778217/w600-h600/385b7c34-ae39-462c-b059-a3f2b9122566.png" alt="INFORMA CARSON SOFA" class="object-cover w-full h-full">
                        </div>

                        {{-- Konten Produk (Nama & Harga) --}}
                        <div class="flex-grow min-w-0">
                            <p class="text-sm font-semibold text-gray-800 mb-1 leading-snug line-clamp-2">
                                Kedai Steel Door Motif Kayu
                            </p>
                            <p class="text-xs text-gray-500 mb-1">1 x Rp450.000</p>
                            <div class="flex items-center space-x-2">
                                <span class="text-base font-extrabold text-primary sm:text-lg">Rp350.000</span>
                                <span class="text-xs text-gray-400 line-through">Rp450.000</span>
                                <span class="text-xs font-bold text-red-600 border border-red-600 rounded px-1">22.22%</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-sm text-gray-600">
                        <p class="font-bold">Catatan:</p>
                        <p class="italic">Tidak ada catatan dari pembeli.</p>
                    </div>
                </div>

                {{-- Detail Pengiriman --}}
                <div class="bg-white p-6 rounded-lg shadow-md border border-light-grey">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Pengiriman</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Kurir</span>
                            <span class="font-bold text-gray-800">JNE Reguler</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nomor Resi</span>
                            <span class="font-bold text-gray-800">-</span>
                        </div>
                        <div class="text-gray-800 mt-3 border-t pt-2">
                            <p class="font-bold">Alamat Pengiriman:</p>
                            <p class="text-sm text-gray-600">Budi Setiawan (0812xxxxxx) - Jln. Mawar No. 12, Kel. Sukamaju, Kec. Cikupa, Tangerang, Banten 15710</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: Rincian Pembayaran & Aksi (lg:col-span-5) --}}
            <div class="lg:col-span-5 mt-8 lg:mt-0">
                <div class="p-6 bg-white rounded-lg shadow-md border border-light-grey lg:sticky lg:top-8">
                    
                    <h2 class="text-lg font-extrabold text-gray-800 mb-4">Rincian Pembayaran</h2>
                    
                    <div class="space-y-3 pb-4 border-b border-light-grey text-sm">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Subtotal Harga (1 produk)</span>
                            <span class="font-bold">Rp450.000</span>
                        </div>
                         <div class="flex justify-between items-center text-gray-600">
                            <span>Potongan Promo Produk</span>
                            <span class="font-bold text-red-600">-Rp100.000</span>
                        </div>
                         <div class="flex justify-between items-center text-gray-600">
                            <span>Ongkos Kirim</span>
                            <span class="font-bold">Rp25.000</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 text-xl font-extrabold">
                        <span>Total Pembayaran</span>
                        <span class="text-primary">Rp375.000</span>
                    </div>
                    <p class="text-xs text-right text-gray-600 mb-6 font-semibold">Termasuk Ongkos Kirim</p>
                    
                    {{-- Tombol Aksi (Sesuai Status) --}}
                    <button class="w-full py-3 rounded-lg bg-red-600 text-white font-bold text-lg hover:bg-red-700 transition duration-150 shadow-md shadow-red-500/50">
                        <i class="fas fa-credit-card mr-2"></i> Lanjutkan Pembayaran
                    </button>
                    <button class="w-full py-2 mt-3 rounded-lg border border-gray-300 text-gray-700 font-bold text-md hover:bg-gray-50 transition duration-150">
                        Batalkan Transaksi
                    </button>

                </div>
            </div>
        </div>

    </div>
</section>
@endsection
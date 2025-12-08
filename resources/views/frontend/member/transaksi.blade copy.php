@extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto">
        
        <h1 class="text-2xl font-extrabold text-gray-800 mb-6">Riwayat Transaksi</h1>

        {{-- GRID UTAMA: Navigasi Sidebar dan Konten Utama --}}
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            {{-- KOLOM KIRI: Sidebar Navigasi --}}
            <div class="lg:col-span-3 mb-6 lg:mb-0">
                {{-- Panggil komponen, dan kirim 'transaksi' sebagai menu aktif --}}
                @include('frontend.components.member-sidebar', ['activeMenu' => 'transaksi'])
            </div>

            {{-- KOLOM KANAN: Konten Utama (Daftar Transaksi) --}}
            <div class="lg:col-span-9">

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-extrabold text-gray-800 mb-6 border-b border-light-grey pb-3">Daftar Semua Transaksi Anda</h2>
                    
                    {{-- Filter Status Transaksi --}}
                    <div class="overflow-x-auto mb-4 pb-2 whitespace-nowrap">
                        <div class="inline-flex space-x-3 text-sm">
                            <button class="py-1 px-4 bg-primary text-white rounded-full font-semibold flex-shrink-0">Semua (10)</button>
                            <button class="py-1 px-4 bg-gray-100 text-gray-700 rounded-full font-semibold hover:bg-gray-200 flex-shrink-0">Menunggu Bayar (2)</button>
                            <button class="py-1 px-4 bg-gray-100 text-gray-700 rounded-full font-semibold hover:bg-gray-200 flex-shrink-0">Diproses (1)</button>
                            <button class="py-1 px-4 bg-gray-100 text-gray-700 rounded-full font-semibold hover:bg-gray-200 flex-shrink-0">Dikirim (1)</button>
                            <button class="py-1 px-4 bg-gray-100 text-gray-700 rounded-full font-semibold hover:bg-gray-200 flex-shrink-0">Selesai (6)</button>
                        </div>
                    </div>

                    {{-- Daftar Transaksi (Cards) --}}
                    <div class="space-y-4">

                        {{-- Kartu Transaksi 1: Menggunakan Produk Contoh Anda --}}
                        <div class="p-4 border border-gray-200 rounded-lg shadow-sm">
                            <div class="flex justify-between items-start border-b border-light-grey pb-2 mb-3">
                                <div>
                                    <p class="text-xs text-gray-500">ID Transaksi & Tanggal</p>
                                    <p class="font-bold text-sm text-gray-800">TRX-20251105-001 <span class="text-gray-400 font-normal">| 05 Nov 2025</span></p>
                                </div>
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 flex-shrink-0">Menunggu Pembayaran</span>
                            </div>
                            
                            {{-- Ringkasan Produk --}}
                            <div class="flex items-center space-x-3 mb-3">
                                <img src="https://image1ws.indotrading.com/s3/productimages/webp/co228746/p778217/w600-h600/385b7c34-ae39-462c-b059-a3f2b9122566.png" alt="Produk" class="w-12 h-12 rounded object-cover flex-shrink-0">
                                <p class="text-sm text-gray-700 truncate">Kedai Steel Door Motif Kayu (1x)</p>
                            </div>

                            {{-- Total & Aksi --}}
                            <div class="flex justify-between items-center pt-2 border-t border-light-grey">
                                <p class="text-sm font-semibold">Total: <span class="text-lg text-primary font-extrabold">Rp350.000</span></p>
                                <a href="{{ url('/detail-transaksi/TRX-20251105-001') }}" class="py-1 px-4 rounded-lg bg-red-600 text-white font-bold text-sm hover:bg-red-700 transition">
                                    Bayar Sekarang
                                </a>
                            </div>
                        </div>

                        {{-- Kartu Transaksi 2: Selesai --}}
                        <div class="p-4 border border-gray-200 rounded-lg shadow-sm">
                            <div class="flex justify-between items-start border-b border-light-grey pb-2 mb-3">
                                <div>
                                    <p class="text-xs text-gray-500">ID Transaksi & Tanggal</p>
                                    <p class="font-bold text-sm text-gray-800">TRX-20251020-015 <span class="text-gray-400 font-normal">| 20 Okt 2025</span></p>
                                </div>
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 flex-shrink-0">Selesai</span>
                            </div>
                            
                            <div class="flex items-center space-x-3 mb-3">
                                <p class="text-sm text-gray-700">3 Produk lainnya...</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 border-t border-light-grey">
                                <p class="text-sm font-semibold">Total: <span class="text-lg text-primary font-extrabold">Rp1.875.000</span></p>
                                <a href="{{ url('member/transactions/TRX-20251020-015') }}" class="py-1 px-4 rounded-lg bg-primary text-white font-bold text-sm hover:bg-primary-dark transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>

                        {{-- Kartu Transaksi 3: Dikirim --}}
                        <div class="p-4 border border-gray-200 rounded-lg shadow-sm">
                            <div class="flex justify-between items-start border-b border-light-grey pb-2 mb-3">
                                <div>
                                    <p class="text-xs text-gray-500">ID Transaksi & Tanggal</p>
                                    <p class="font-bold text-sm text-gray-800">TRX-20251001-088 <span class="text-gray-400 font-normal">| 01 Okt 2025</span></p>
                                </div>
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 flex-shrink-0">Dikirim</span>
                            </div>
                            
                            <div class="flex items-center space-x-3 mb-3">
                                <p class="text-sm text-gray-700">1 Produk</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 border-t border-light-grey">
                                <p class="text-sm font-semibold">Total: <span class="text-lg text-primary font-extrabold">Rp78.000</span></p>
                                <a href="{{ url('member/transactions/TRX-20251001-088') }}" class="py-1 px-4 rounded-lg bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition">
                                    Lacak <i class="fas fa-truck ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6 flex justify-center">
                        {{-- Logika pagination di sini --}}
                        <p class="text-sm text-gray-500">Halaman 1 dari 5</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
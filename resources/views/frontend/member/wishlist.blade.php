@extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto">
        
        <h1 class="text-2xl font-extrabold text-dark-grey mb-6">Wishlist Saya</h1>

        {{-- GRID UTAMA: Navigasi Sidebar dan Konten Utama --}}
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            {{-- KOLOM KIRI: Sidebar Navigasi (Asumsi 'wishlist' adalah menu aktif) --}}
            <div class="lg:col-span-3 mb-6 lg:mb-0">
                @include('frontend.components.member-sidebar', ['activeMenu' => 'wishlist'])
            </div>

            {{-- KOLOM KANAN: Konten Utama (Daftar Wishlist) --}}
            <div class="lg:col-span-9">

                <div class="bg-white p-6 rounded-lg shadow-md border border-light-grey">
                    <div class="flex justify-between items-center mb-6 border-b pb-3">
                        <h2 class="text-xl font-extrabold text-dark-grey">Daftar Produk Favorit (3 Item)</h2>
                        <button class="py-1 px-3 text-sm text-red-600 font-bold rounded-lg border border-red-200 hover:bg-red-50 transition">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus Semua
                        </button>
                    </div>
                    
                    {{-- Daftar Produk dalam Grid, menggunakan struktur kartu Anda --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        {{-- 1. Panel Ceiling A (DEKORATIF) --}}
                        <div
                            class="bg-light-grey border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer flex flex-col">
                            <div class="relative">
                                <img src="https://id.pvcpanelchina.com/uploads/202334835/white-pvc-ceiling-panelsc71d0f4e-4fed-441a-88b3-144a09284153.jpg"
                                    alt="Panel Ceiling A"
                                    onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                    class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                                <div
                                    class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded">
                                    Stok Tersedia</div>
                                <button class="absolute top-2 left-2 text-white hover:text-red-500 transition" title="Hapus dari Wishlist">
                                    <i class="fas fa-heart text-red-500 text-xl drop-shadow-md"></i> 
                                </button>
                            </div>
                            <div class="p-3 md:p-4 flex flex-col flex-grow">
                                <p class="text-xs text-dark-grey mb-1 line-clamp-1">Dekoratif / Arsitektural</p>
                                <p
                                    class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem] flex-grow">
                                    Panel Ceiling A</p>
                                <p class="text-base md:text-lg font-bold text-discount mt-2">Rp120.000</p>
                                <div class="flex items-center text-xs text-dark-grey mt-2">
                                    <span class="text-primary">★</span><span class="ml-1">4.8</span><span
                                        class="ml-2 text-dark-grey">| 10 (ulasan)</span>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <button class="w-full py-2 rounded-lg bg-red-600 text-white font-bold text-sm hover:bg-red-700 transition">
                                        <i class="fas fa-shopping-cart mr-1"></i> Pindah ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Louvre Vent 100 (DEKORATIF) --}}
                        <div
                            class="bg-light-grey border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer flex flex-col">
                            <div class="relative">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnfxIEAPNi00H1vA5Ydp5Duz6AsTjxdfxu_g&s"
                                    alt="Louvre Vent 100"
                                    onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                    class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                                <div
                                    class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded">
                                    Stok Tersedia</div>
                                <button class="absolute top-2 left-2 text-white hover:text-red-500 transition" title="Hapus dari Wishlist">
                                    <i class="fas fa-heart text-red-500 text-xl drop-shadow-md"></i> 
                                </button>
                            </div>
                            <div class="p-3 md:p-4 flex flex-col flex-grow">
                                <p class="text-xs text-dark-grey mb-1 line-clamp-1">Dekoratif / Arsitektural</p>
                                <p
                                    class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem] flex-grow">
                                    Louvre Vent 100</p>
                                <p class="text-base md:text-lg font-bold text-discount mt-2">Rp85.000</p>
                                <div class="flex items-center text-xs text-dark-grey mt-2">
                                    <span class="text-primary">★</span><span class="ml-1">4.5</span><span
                                        class="ml-2 text-dark-grey">| 15 (ulasan)</span>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <button class="w-full py-2 rounded-lg bg-red-600 text-white font-bold text-sm hover:bg-red-700 transition">
                                        <i class="fas fa-shopping-cart mr-1"></i> Pindah ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Kedai Steel Door Motif Kayu (Contoh dari Keranjang) --}}
                        <div
                            class="bg-light-grey border border-light-grey rounded-lg shadow-sm hover:shadow-lg transition duration-200 cursor-pointer flex flex-col">
                            <div class="relative">
                                <img src="https://image1ws.indotrading.com/s3/productimages/webp/co228746/p778217/w600-h600/385b7c34-ae39-462c-b059-a3f2b9122566.png"
                                    alt="Kedai Steel Door Motif Kayu"
                                    onerror="this.onerror=null;this.src='https://placehold.co/600x400/000/ffffff?text=Product+Image';"
                                    class="h-32 sm:h-40 md:h-48 w-full object-cover rounded-t-lg">
                                <div
                                    class="absolute top-2 right-2 bg-yellow-600 text-white text-xs font-bold px-2 py-1 rounded">
                                    Stok Terbatas</div>
                                <button class="absolute top-2 left-2 text-white hover:text-red-500 transition" title="Hapus dari Wishlist">
                                    <i class="fas fa-heart text-red-500 text-xl drop-shadow-md"></i> 
                                </button>
                            </div>
                            <div class="p-3 md:p-4 flex flex-col flex-grow">
                                <p class="text-xs text-dark-grey mb-1 line-clamp-1">Pintu / Hardware</p>
                                <p
                                    class="text-xs md:text-sm font-semibold text-dark-grey line-clamp-2 min-h-[1.5rem] flex-grow">
                                    Kedai Steel Door Motif Kayu</p>
                                
                                <!-- <p class="text-xs text-light-grey line-through mt-2">Rp450.000</p> -->
                                <p class="text-base md:text-lg font-bold text-discount">Rp350.000</p>
                                
                                <div class="flex items-center text-xs text-dark-grey mt-2">
                                    <span class="text-primary">★</span><span class="ml-1">4.7</span><span
                                        class="ml-2 text-dark-grey">| 50 (ulasan)</span>
                                </div>

                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <button class="w-full py-2 rounded-lg bg-red-600 text-white font-bold text-sm hover:bg-red-700 transition">
                                        <i class="fas fa-shopping-cart mr-1"></i> Pindah ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    
                    {{-- Placeholder jika Wishlist Kosong --}}
                    {{-- 
                    <div class="text-center py-10 text-dark-grey/70">
                        <i class="fas fa-heart text-4xl mb-3"></i>
                        <p>Wishlist Anda masih kosong. Ayo, mulai tambahkan produk favorit Anda!</p>
                        <a href="{{ url('/') }}" class="mt-4 inline-block text-primary font-semibold hover:underline">Jelajahi Produk</a>
                    </div>
                    --}}
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
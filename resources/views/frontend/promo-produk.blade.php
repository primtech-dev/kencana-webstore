@extends('frontend.components.layout')
@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-12">
    <div class="max-w-7xl mx-auto mb-10">
        <div class="relative rounded-2xl overflow-hidden shadow-lg h-[250px] md:h-[400px]">
            <img src="https://d12grbvu52tm8q.cloudfront.net/AHI/Compro/2a61e3ae-7df6-4bf0-99b5-005b1e32dfe2.jpg" 
                 class="w-full h-full object-cover" alt="Banner Promo Produk">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent flex items-center p-8 md:p-16">
                <div class="text-white max-w-lg">
                    <h1 class="text-3xl md:text-5xl font-black mb-4 uppercase">Promo Bahan Konstruksi</h1>
                    <p class="text-lg opacity-90 mb-6">Dapatkan harga spesial untuk kebutuhan atap dan rangka bangunan Anda.</p>
                    <div class="bg-yellow-400 text-black font-bold py-2 px-6 rounded-full inline-block">
                        Berlaku s/d 31 Des 2025
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8 border-b pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Produk Promo</h2>
            <p class="text-gray-500 text-sm">Menampilkan 3 Produk</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition p-4">
                <div class="relative mb-4">
                    <span class="absolute top-2 right-2 bg-green-800 text-white text-[10px] px-2 py-1 rounded font-bold uppercase">Stok Tersedia</span>
                    <img src="https://i.ibb.co/hR0Wn8F/genteng.png" alt="Genteng Rocky" class="w-full h-48 object-contain">
                </div>
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">ROOFING AND WAILING</p>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Genteng Rocky</h3>
                <div class="mb-3">
                    <p class="text-xl font-black text-gray-900">Rp45.000</p>
                    <p class="text-xs text-gray-400 line-through">Rp60.000</p>
                </div>
                <div class="flex items-center text-xs text-gray-500 mb-4">
                    <i class="fas fa-star text-yellow-400 mr-1"></i> 0 <span class="mx-2">|</span> 0 (ulasan)
                </div>
                <p class="text-red-500 font-bold text-sm mb-4 tracking-tight">Stok: 100</p>
                <button class="w-full border border-red-600 text-red-600 hover:bg-red-600 hover:text-white py-2 rounded-lg font-bold transition">
                    Tambah ke Keranjang
                </button>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition p-4">
                <div class="relative mb-4">
                    <span class="absolute top-2 right-2 bg-green-800 text-white text-[10px] px-2 py-1 rounded font-bold uppercase">Stok Tersedia</span>
                    <img src="https://i.ibb.co/L5XmX4L/upvc.png" alt="UPVC" class="w-full h-48 object-contain">
                </div>
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">ROOFING AND WAILING</p>
                <h3 class="text-lg font-bold text-gray-800 mb-2 leading-tight">Unplasticized Polyvinyl Chloride</h3>
                <div class="mb-3">
                    <p class="text-xl font-black text-gray-900">Rp70.000</p>
                    <p class="text-xs text-gray-400 line-through">Rp95.000</p>
                </div>
                <div class="flex items-center text-xs text-gray-500 mb-4">
                    <i class="fas fa-star text-yellow-400 mr-1"></i> 5.0 <span class="mx-2">|</span> 2 (ulasan)
                </div>
                <p class="text-red-500 font-bold text-sm mb-4 tracking-tight">Stok: 50</p>
                <button class="w-full border border-red-600 text-red-600 hover:bg-red-600 hover:text-white py-2 rounded-lg font-bold transition">
                    Tambah ke Keranjang
                </button>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition p-4">
                <div class="relative mb-4">
                    <span class="absolute top-2 right-2 bg-green-800 text-white text-[10px] px-2 py-1 rounded font-bold uppercase">Stok Tersedia</span>
                    <img src="https://i.ibb.co/KzZgZtW/hollow.png" alt="Hollow" class="w-full h-48 object-contain">
                </div>
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">ROOFING AND WAILING</p>
                <h3 class="text-lg font-bold text-gray-800 mb-2 leading-tight uppercase">Hollow 40x40 Kencana T=0.25MM</h3>
                <div class="mb-3">
                    <p class="text-xl font-black text-gray-900">Rp11.000</p>
                    <p class="text-xs text-gray-400 line-through">Rp15.000</p>
                </div>
                <div class="flex items-center text-xs text-gray-500 mb-4">
                    <i class="fas fa-star text-yellow-400 mr-1"></i> 0 <span class="mx-2">|</span> 0 (ulasan)
                </div>
                <p class="text-red-500 font-bold text-sm mb-4 tracking-tight">Stok: 10</p>
                <button class="w-full border border-red-600 text-red-600 hover:bg-red-600 hover:text-white py-2 rounded-lg font-bold transition">
                    Tambah ke Keranjang
                </button>
            </div>

        </div>
    </div>
</section>
@endsection
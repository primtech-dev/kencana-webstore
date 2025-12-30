@extends('frontend.components.layout')
@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-extrabold text-[#333333]">Promo</h1>
            <div class="flex items-center text-sm">
                <span class="text-gray-500 mr-2 hidden sm:block">Urutkan:</span>
                <select class="border border-gray-300 rounded-md p-2 text-sm focus:ring-red-500 focus:border-red-500">
                    <option>Terbaru</option>
                    <option>Terpopuler</option>
                    <option>Segera Berakhir</option>
                </select>
            </div>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="lg:col-span-3 mb-8 lg:mb-0">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 lg:sticky lg:top-8">
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Cari Promo</label>
                        <div class="relative">
                            <input type="text" id="search-promo" placeholder="Masukan kata kunci..."
                                class="w-full border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-red-500 focus:border-red-500">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <h3 class="text-md font-bold text-gray-800 mb-4 border-b pb-2">Jenis Promo</h3>
                    <div class="space-y-3 text-sm">
                        @foreach(['Online', 'Offline', 'Membership', 'Kupon'] as $jenis)
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" class="h-4 w-4 text-red-600 rounded border-gray-300 focus:ring-red-500">
                            <span class="text-gray-600 group-hover:text-red-600">{{ $jenis }}</span>
                        </label>
                        @endforeach
                        <a href="#" class="text-red-600 text-xs font-semibold hover:underline mt-4 inline-block">Reset Filter</a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-9">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col hover:shadow-lg transition-shadow duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://d12grbvu52tm8q.cloudfront.net/AHI/Compro/da8966f2-fd4d-417b-b7e8-079dfdceb70e.jpg" alt="Promo 1" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 flex-grow">
                            <h3 class="font-bold text-gray-800 text-[15px] leading-snug min-h-[40px] line-clamp-2">
                                DISKON 10% Kategori Bahan Kimia, Lem (Perekat) & Pengelasan
                            </h3>
                            <p class="text-xs text-gray-500 mt-3">Berlaku 15-19 Desember 2025</p>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="{{url('/promo-produk')}}" class="block w-full bg-[#E30613] hover:bg-red-700 text-white text-center py-2.5 rounded-lg font-bold text-sm transition-colors">
                                Cek Sekarang
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col hover:shadow-lg transition-shadow duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://d12grbvu52tm8q.cloudfront.net/AHI/Compro/a101700b-d7f9-4200-9a70-d207d48405db.jpg" alt="Promo 2" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 flex-grow">
                            <h3 class="font-bold text-gray-800 text-[15px] leading-snug min-h-[40px] line-clamp-2">
                                DISKON 10% Kategori Alat AC & Pipa
                            </h3>
                            <p class="text-xs text-gray-500 mt-3">Berlaku 15-19 Desember 2025</p>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="{{url('/promo-voucher')}}" class="block w-full bg-[#E30613] hover:bg-red-700 text-white text-center py-2.5 rounded-lg font-bold text-sm transition-colors">
                                Cek Sekarang
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col hover:shadow-lg transition-shadow duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://d12grbvu52tm8q.cloudfront.net/AHI/Compro/2a61e3ae-7df6-4bf0-99b5-005b1e32dfe2.jpg" alt="Promo 3" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 flex-grow">
                            <h3 class="font-bold text-gray-800 text-[15px] leading-snug min-h-[40px] line-clamp-2">
                                Harga Spesial Specialist Contact Cleaner 450ml Mulai Rp63.000,-
                            </h3>
                            <p class="text-xs text-gray-500 mt-3">Berlaku s/d 31 Desember 2025</p>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="#" class="block w-full bg-[#E30613] hover:bg-red-700 text-white text-center py-2.5 rounded-lg font-bold text-sm transition-colors">
                                Cek Sekarang
                            </a>
                        </div>
                    </div>

                </div>

               
            </div>
        </div>
    </div>
</section>
@endsection
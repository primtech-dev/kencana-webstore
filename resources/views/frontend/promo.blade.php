@extends('frontend.components.layout')
@section('content')
<section class="container px-1 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- <div class="text-sm text-light-grey mb-2">
            <a href="{{url('beranda')}}" class="hover:text-primary">Beranda</a> / 
            <span class="font-semibold text-dark-grey">Promo</span>
        </div> -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-extrabold text-dark-grey">Promo</h1>
            <div class="flex items-center text-sm">
                <span class="text-dark-grey/80 mr-2 hidden sm:block">Urutkan:</span>
                <select class="border border-light-grey rounded-md p-2 text-dark-grey focus:ring-primary focus:border-primary">
                    <option>Pilih</option>
                    <option>Terbaru</option>
                    <option>Terpopuler</option>
                    <option>Segera Berakhir</option>
                </select>
            </div>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            <div class="lg:col-span-3 mb-8 lg:mb-0">
                <div class="bg-white p-4 rounded-lg shadow-soft border border-light-grey/50 lg:sticky lg:top-8">
                    
                    <div class="mb-6">
                        <label for="search-promo" class="sr-only">Cari promo</label>
                        <div class="relative">
                            <input type="text" id="search-promo" placeholder="Cari promo..."
                                class="w-full border border-light-grey rounded-lg py-2 pl-10 pr-4 text-dark-grey focus:ring-primary focus:border-primary">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-light-grey/70"></i>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-dark-grey mb-3 border-b border-light-grey/50 pb-2">Jenis Promo</h3>
                    <div class="space-y-3 text-sm">
                        <label class="flex items-center space-x-2 cursor-pointer text-dark-grey hover:text-primary">
                            <input type="checkbox" class="h-4 w-4 text-primary rounded border-light-grey focus:ring-primary">
                            <span>Online</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer text-dark-grey hover:text-primary">
                            <input type="checkbox" class="h-4 w-4 text-primary rounded border-light-grey focus:ring-primary">
                            <span>Offline</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer text-dark-grey hover:text-primary">
                            <input type="checkbox" class="h-4 w-4 text-primary rounded border-light-grey focus:ring-primary">
                            <span>Membership</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer text-dark-grey hover:text-primary">
                            <input type="checkbox" class="h-4 w-4 text-primary rounded border-light-grey focus:ring-primary">
                            <span>Kupon</span>
                        </label>
                        <a href="#" class="text-primary text-xs font-semibold hover:underline mt-2 inline-block">Muat Ulang</a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-9 space-y-4">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <a href="{{url('detail-promo/me-time')}}" class="block relative rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                        <img src="https://d12grbvu52tm8q.cloudfront.net/AHI/Compro/da8966f2-fd4d-417b-b7e8-079dfdceb70e.jpg" alt="Me-time di rumah makin hemat" class="w-full h-auto object-cover md:h-64">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-4 text-white">
                            <p class="text-xs font-medium text-yellow-300">Hemat hingga 60%</p>
                            <h3 class="text-lg font-bold leading-tight mt-1">Me-time di rumah makin hemat</h3>
                            <p class="text-xs opacity-80 mt-1">Hingga 9 November 2025</p>
                        </div>
                    </a>

                    <a href="{{url('detail-promo/voucher-potongan')}}" class="block relative rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                        <img src="https://d12grbvu52tm8q.cloudfront.net/AHI/Compro/a101700b-d7f9-4200-9a70-d207d48405db.jpg" alt="Ragam inovasi" class="w-full h-auto object-cover md:h-64">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-4 text-white">
                            <p class="text-xs font-medium bg-orange-action px-2 py-0.5 rounded inline-block">Voucher Rp15 Ribu</p>
                            <h3 class="text-lg font-bold leading-tight mt-1">Ragam inovasi untuk kebutuhan sehari-hari</h3>
                            <p class="text-xs opacity-80 mt-1">Hingga 25 November 2025</p>
                        </div>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <a href="{{url('detail-promo/cashback')}}" class="block relative rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                        <img src="https://d12grbvu52tm8q.cloudfront.net/AHI/Compro/2a61e3ae-7df6-4bf0-99b5-005b1e32dfe2.jpg" alt="Garansi tukar baru" class="w-full h-auto object-cover md:h-64">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-4 text-white">
                            <p class="text-xs font-medium bg-red-600 px-2 py-0.5 rounded inline-block">Cashback Rp3 Juta</p>
                            <h3 class="text-lg font-bold leading-tight mt-1">Garansi tukar baru & Cashback besar</h3>
                            <p class="text-xs opacity-80 mt-1">Periode Terbatas</p>
                        </div>
                    </a>

                    <a href="{{url('detail-promo/potongan-harga')}}" class="block relative rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                        <img src="https://d12grbvu52tm8q.cloudfront.net/AHI/Compro/5f1880af-50f0-4a75-89a1-f0c650383282.jpg" alt="Potongan harga" class="w-full h-auto object-cover md:h-64">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-4 text-white">
                            <p class="text-xs font-medium text-green-400">Hemat hingga 70%</p>
                            <h3 class="text-lg font-bold leading-tight mt-1">Potongan harga untuk semua perlengkapan dapur</h3>
                            <p class="text-xs opacity-80 mt-1">Minggu ini</p>
                        </div>
                    </a>
                </div>
                
                </div>
        </div>

        <div class="flex justify-center mt-8">
            <nav class="flex items-center space-x-1" aria-label="Pagination">
                <a href="#" class="px-3 py-1 text-dark-grey border border-light-grey rounded-lg hover:bg-light-grey/50">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <a href="#" class="px-3 py-1 bg-primary text-white font-bold rounded-lg">1</a>
                <a href="#" class="px-3 py-1 text-dark-grey border border-light-grey rounded-lg hover:bg-light-grey/50">2</a>
                <a href="#" class="px-3 py-1 text-dark-grey border border-light-grey rounded-lg hover:bg-light-grey/50">3</a>
                <a href="#" class="px-3 py-1 text-dark-grey border border-light-grey rounded-lg hover:bg-light-grey/50">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </nav>
        </div>
        
    </div>
</section>
@endsection

@section('scripts')
    @endsection
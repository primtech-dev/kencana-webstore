@extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto">
        
        <h1 class="text-2xl font-extrabold text-dark-grey mb-6">Poin & Rewards</h1>

        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            <div class="lg:col-span-3 mb-6 lg:mb-0">
                @include('frontend.components.member-sidebar', ['activeMenu' => 'points'])
            </div>

            <div class="lg:col-span-9 space-y-8">

                {{-- KARTU RINGKASAN POIN --}}
                <div class="bg-primary-50 p-6 rounded-lg shadow-md border-2 border-primary">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-dark-grey">Total Poin Anda</h2>
                        <a href="#riwayat-poin" class="text-sm font-semibold text-primary hover:underline">Lihat Riwayat</a>
                    </div>
                    <p class="text-4xl font-extrabold text-primary mt-2">1.450</p>
                    <p class="text-sm text-dark-grey/80 mt-1">Poin akan hangus pada 31 Desember 2025</p>
                </div>

                {{-- RIWAYAT POIN --}}
                <div id="riwayat-poin" class="bg-white p-6 rounded-lg shadow-md border border-light-grey">
                    <h2 class="text-xl font-extrabold text-dark-grey mb-4 border-b pb-3">Riwayat Transaksi Poin</h2>
                    
                    <div class="space-y-3">
                        
                        {{-- Contoh Transaksi 1 (Masuk) --}}
                        <div class="flex justify-between items-center p-3 rounded-lg bg-green-50">
                            <div>
                                <p class="font-semibold text-green-700">Poin dari Pembelian #INV-0021</p>
                                <p class="text-xs text-dark-grey/70">6 November 2025</p>
                            </div>
                            <p class="text-lg font-bold text-green-600">+250</p>
                        </div>

                        {{-- Contoh Transaksi 2 (Keluar) --}}
                        <div class="flex justify-between items-center p-3 rounded-lg bg-red-50">
                            <div>
                                <p class="font-semibold text-red-700">Penukaran Voucher Diskon Rp50.000</p>
                                <p class="text-xs text-dark-grey/70">20 Oktober 2025</p>
                            </div>
                            <p class="text-lg font-bold text-red-600">-500</p>
                        </div>

                        {{-- Contoh Transaksi 3 (Masuk) --}}
                        <div class="flex justify-between items-center p-3 rounded-lg bg-green-50">
                            <div>
                                <p class="font-semibold text-green-700">Poin Selamat Datang</p>
                                <p class="text-xs text-dark-grey/70">1 September 2025</p>
                            </div>
                            <p class="text-lg font-bold text-green-600">+1.700</p>
                        </div>

                        <div class="text-center pt-2">
                            <button class="text-primary text-sm font-semibold hover:underline">Lihat Lebih Banyak</button>
                        </div>
                    </div>
                </div>

                {{-- DAFTAR REWARDS YANG DAPAT DITUKAR --}}
                <div class="bg-white p-6 rounded-lg shadow-md border border-light-grey">
                    <h2 class="text-xl font-extrabold text-dark-grey mb-4 border-b pb-3">Tukarkan Poin Anda</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        {{-- Reward 1: Voucher Rp50.000 --}}
                        <div class="p-4 border border-gray-200 rounded-lg flex items-center justify-between bg-white hover:shadow-md transition">
                            <div>
                                <p class="font-bold text-dark-grey">Voucher Diskon Rp50.000</p>
                                <p class="text-sm text-dark-grey/70">Minimal belanja Rp500.000</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-extrabold text-primary">500 Poin</p>
                                <button class="mt-1 px-3 py-1 text-sm rounded-full bg-primary text-white font-semibold hover:bg-primary-dark transition">
                                    Tukar
                                </button>
                            </div>
                        </div>

                        {{-- Reward 2: Gratis Ongkir --}}
                        <div class="p-4 border border-gray-200 rounded-lg flex items-center justify-between bg-white hover:shadow-md transition">
                            <div>
                                <p class="font-bold text-dark-grey">Gratis Ongkir (Maks. Rp20.000)</p>
                                <p class="text-sm text-dark-grey/70">Berlaku untuk semua wilayah</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-extrabold text-primary">800 Poin</p>
                                <button class="mt-1 px-3 py-1 text-sm rounded-full bg-primary text-white font-semibold hover:bg-primary-dark transition">
                                    Tukar
                                </button>
                            </div>
                        </div>

                        {{-- Reward 3: Merchandise Eksklusif (Tidak Cukup Poin) --}}
                        <div class="p-4 border border-gray-200 rounded-lg flex items-center justify-between bg-white opacity-60">
                            <div>
                                <p class="font-bold text-dark-grey">Merchandise Eksklusif</p>
                                <p class="text-sm text-dark-grey/70">Kaos edisi terbatas</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-extrabold text-primary">2.500 Poin</p>
                                <button disabled class="mt-1 px-3 py-1 text-sm rounded-full bg-gray-400 text-white font-semibold cursor-not-allowed">
                                    Poin Kurang
                                </button>
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection
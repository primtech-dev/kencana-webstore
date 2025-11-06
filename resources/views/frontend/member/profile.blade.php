@extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto">
        
        <h1 class="text-2xl font-extrabold text-gray-800 mb-6">Akun Saya</h1>

        {{-- GRID UTAMA: Navigasi Sidebar dan Konten Utama --}}
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            {{-- KOLOM KIRI: Sidebar Navigasi --}}
            <div class="lg:col-span-3 mb-6 lg:mb-0">
                {{-- Panggil komponen, dan kirim 'profile' sebagai menu aktif --}}
                @include('frontend.components.member-sidebar', ['activeMenu' => 'profile'])
            </div>

            {{-- KOLOM KANAN: Konten Utama --}}
            <div class="lg:col-span-9">

                {{-- INFORMASI REWARD/LEVEL --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    
                    {{-- Kategori Member --}}
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-100 flex items-center space-x-3">
                        <i class="fas fa-gem text-xl text-gray-500 flex-shrink-0"></i>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Kategori Member</p>
                            <p class="text-lg font-extrabold text-gray-700">SILVER</p> 
                        </div>
                    </div>

                    {{-- Total Poin --}}
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-100 flex items-center space-x-3">
                        <i class="fas fa-star text-xl text-yellow-500 flex-shrink-0"></i>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Total Poin Saat Ini</p>
                            <p class="text-lg font-extrabold text-gray-800">1.250 <span class="text-sm font-normal text-gray-500">Poin</span></p>
                        </div>
                    </div>

                    {{-- Voucher Klaim --}}
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-100 flex items-center space-x-3">
                        <i class="fas fa-ticket-alt text-xl text-primary flex-shrink-0"></i>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Voucher Siap Klaim</p>
                            <p class="text-lg font-extrabold text-gray-800">3 <span class="text-sm font-normal text-gray-500">Voucher</span></p>
                        </div>
                    </div>
                </div>


                {{-- KONTEN UTAMA: DETAIL PROFIL --}}
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100 mb-6">
                    <h2 class="text-xl font-extrabold text-gray-800 mb-6 border-b pb-3">Detail Profil</h2>

                    {{-- Data Profil (Sama seperti sebelumnya) --}}
                    <div class="flex flex-col sm:flex-row sm:space-x-8">
                        {{-- Foto Profil --}}
                        <div class="flex-shrink-0 mb-4 sm:mb-0 flex flex-col items-center">
                            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-gray-200 overflow-hidden border-4 border-gray-100 shadow-inner">
                                <img src="https://ui-avatars.com/api/?name=Hairul+Bahri&background=E53E3E&color=fff&size=256&rounded=true&bold=true" alt="Foto Profil" class="object-cover w-full h-full">
                            </div>
                            <button class="text-primary text-sm font-semibold mt-2 hover:underline">Ubah Foto</button>
                        </div>
                        
                        {{-- Informasi Dasar --}}
                        <div class="flex-grow space-y-4">
                            
                            {{-- Baris Nama --}}
                            <div class="flex flex-col">
                                <label for="name" class="text-sm font-semibold text-gray-500">Nama Lengkap</label>
                                <p class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-1">Hairul Bahri</p>
                            </div>

                            {{-- Baris Email --}}
                            <div class="flex flex-col">
                                <label for="email" class="text-sm font-semibold text-gray-500">Alamat Email</label>
                                <p class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-1">hairul.bahri@example.com</p>
                            </div>

                            {{-- Baris Telepon --}}
                            <div class="flex flex-col">
                                <label for="phone" class="text-sm font-semibold text-gray-500">Nomor Telepon</label>
                                <p class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-1">0812-3456-7890</p>
                            </div>

                            {{-- Tombol Edit --}}
                            <div class="pt-4">
                                <button class="py-2 px-6 rounded-lg bg-primary text-white font-bold hover:bg-primary-dark transition duration-150 text-sm">
                                    <i class="fas fa-edit mr-2"></i> Edit Profil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KONTEN RIWAYAT TRANSAKSI TERAKHIR (MINIMAL 3 DATA) --}}
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    <h2 class="text-xl font-extrabold text-gray-800 mb-6 border-b pb-3">Riwayat Transaksi Terakhir</h2>
                    
                    <div class="space-y-4">

                        {{-- Kartu Transaksi 1: Selesai --}}
                        <div class="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                            <div class="flex justify-between items-start border-b pb-2 mb-2">
                                <div>
                                    <p class="text-xs text-gray-500">ID Transaksi & Tanggal</p>
                                    <p class="font-bold text-sm">TRX-20251101-001 <span class="text-gray-400 font-normal">| 01 Nov 2025</span></p>
                                </div>
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 flex-shrink-0">Selesai</span>
                            </div>
                            <p class="text-sm font-semibold mb-1">Total Pembayaran: <span class="text-lg text-primary">Rp1.250.000</span></p>
                            <div class="flex justify-between items-center text-sm">
                                <p class="text-gray-500">2 Produk (Sofa dan Meja)</p>
                                <a href="{{ url('member/transactions/TRX-20251101-001') }}" class="text-primary hover:underline font-semibold">Lihat Detail <i class="fas fa-chevron-right ml-1 text-xs"></i></a>
                            </div>
                        </div>

                        {{-- Kartu Transaksi 2: Menunggu Pembayaran --}}
                         <div class="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                            <div class="flex justify-between items-start border-b pb-2 mb-2">
                                <div>
                                    <p class="text-xs text-gray-500">ID Transaksi & Tanggal</p>
                                    <p class="font-bold text-sm">TRX-20251025-045 <span class="text-gray-400 font-normal">| 25 Okt 2025</span></p>
                                </div>
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 flex-shrink-0">Menunggu Pembayaran</span>
                            </div>
                            <p class="text-sm font-semibold mb-1">Total Pembayaran: <span class="text-lg text-red-600">Rp350.000</span></p>
                            <div class="flex justify-between items-center text-sm">
                                <p class="text-gray-500">1 Produk (Pintu Baja)</p>
                                <a href="{{ url('member/transactions/TRX-20251025-045') }}" class="text-red-600 hover:underline font-semibold">Bayar Sekarang <i class="fas fa-chevron-right ml-1 text-xs"></i></a>
                            </div>
                        </div>

                        {{-- Kartu Transaksi 3: Dikirim --}}
                         <div class="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                            <div class="flex justify-between items-start border-b pb-2 mb-2">
                                <div>
                                    <p class="text-xs text-gray-500">ID Transaksi & Tanggal</p>
                                    <p class="font-bold text-sm">TRX-20250915-112 <span class="text-gray-400 font-normal">| 15 Sep 2025</span></p>
                                </div>
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 flex-shrink-0">Sedang Dikirim</span>
                            </div>
                            <p class="text-sm font-semibold mb-1">Total Pembayaran: <span class="text-lg text-primary">Rp78.000</span></p>
                            <div class="flex justify-between items-center text-sm">
                                <p class="text-gray-500">3 Produk (Sekrup & Baut)</p>
                                <a href="{{ url('member/transactions/TRX-20250915-112') }}" class="text-blue-600 hover:underline font-semibold">Lacak Pengiriman <i class="fas fa-chevron-right ml-1 text-xs"></i></a>
                            </div>
                        </div>

                    </div>
                    
                    <div class="mt-6 text-center">
                        <a href="{{ url('member/transactions') }}" class="text-primary font-semibold hover:underline">Lihat Semua Riwayat Transaksi <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
</section>
@endsection
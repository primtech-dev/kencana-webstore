@extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto">
        
        <h1 class="text-2xl font-extrabold text-gray-800 mb-6">Akun Saya</h1>

        {{-- GRID UTAMA: Navigasi Sidebar dan Konten Utama --}}
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            {{-- KOLOM KIRI: Sidebar Navigasi --}}
            {{-- Navigasi akan selalu tampil di atas konten utama di mobile, dan menjadi sidebar di desktop --}}
            <div class="lg:col-span-3 mb-6 lg:mb-0">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-100 lg:sticky lg:top-8">
                    <h2 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">Menu Akun</h2>
                    
                    <nav class="space-y-1">
                        {{-- Link Aktif --}}
                        <a href="{{ url('member/profile') }}" class="
                            flex items-center p-3 text-primary font-bold bg-primary-50 rounded-lg transition 
                            hover:bg-primary-100/70
                        ">
                            <i class="fas fa-user-circle w-5 mr-3"></i>
                            <span>Profil Saya</span>
                        </a>
                        
                        {{-- Link Lain --}}
                        <a href="{{ url('member/transactions') }}" class="
                            flex items-center p-3 text-gray-600 font-semibold rounded-lg transition 
                            hover:bg-gray-50 hover:text-primary
                        ">
                            <i class="fas fa-history w-5 mr-3"></i>
                            <span>Riwayat Transaksi</span>
                        </a>

                        <a href="{{ url('member/addresses') }}" class="
                            flex items-center p-3 text-gray-600 font-semibold rounded-lg transition 
                            hover:bg-gray-50 hover:text-primary
                        ">
                            <i class="fas fa-map-marked-alt w-5 mr-3"></i>
                            <span>Daftar Alamat</span>
                        </a>

                         <a href="{{ url('member/wishlist') }}" class="
                            flex items-center p-3 text-gray-600 font-semibold rounded-lg transition 
                            hover:bg-gray-50 hover:text-primary
                        ">
                            <i class="fas fa-heart w-5 mr-3"></i>
                            <span>Wishlist</span>
                        </a>
                        
                        <div class="pt-2 border-t mt-2">
                             <a href="{{ url('logout') }}" class="
                                flex items-center p-3 text-red-600 font-semibold rounded-lg transition 
                                hover:bg-red-50 hover:text-red-700
                            ">
                                <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                <span>Keluar</span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>

            {{-- KOLOM KANAN: Konten Utama (Profil, Riwayat, dll.) --}}
            <div class="lg:col-span-9">

                {{-- KONTEN UTAMA: PROFIL SAYA --}}
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    <h2 class="text-xl font-extrabold text-gray-800 mb-6 border-b pb-3">Detail Profil</h2>

                    {{-- Data Profil --}}
                    <div class="flex flex-col sm:flex-row sm:space-x-8">
                        {{-- Foto Profil --}}
                        <div class="flex-shrink-0 mb-4 sm:mb-0 flex flex-col items-center">
                            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-gray-200 overflow-hidden border-4 border-gray-100 shadow-inner">
                                {{-- Ganti dengan foto profil user --}}
                                <img src="https://ui-avatars.com/api/?name=User+Demo&background=E53E3E&color=fff&size=256&rounded=true&bold=true" alt="Foto Profil" class="object-cover w-full h-full">
                            </div>
                            <button class="text-primary text-sm font-semibold mt-2 hover:underline">Ubah Foto</button>
                        </div>
                        
                        {{-- Informasi Dasar --}}
                        <div class="flex-grow space-y-4">
                            
                            {{-- Baris Nama --}}
                            <div class="flex flex-col">
                                <label for="name" class="text-sm font-semibold text-gray-500">Nama Lengkap</label>
                                <p class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-1">Budi Setiawan</p>
                            </div>

                            {{-- Baris Email --}}
                            <div class="flex flex-col">
                                <label for="email" class="text-sm font-semibold text-gray-500">Alamat Email</label>
                                <p class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-1">budi.setiawan@example.com</p>
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

                {{-- KONTEN RIWAYAT TRANSAKSI (Contoh Bagian Lain) --}}
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100 mt-6">
                    <h2 class="text-xl font-extrabold text-gray-800 mb-6 border-b pb-3">5 Riwayat Transaksi Terakhir</h2>
                    
                    {{-- Tabel Riwayat Transaksi --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Transaksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- Baris Data 1 --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TRX-20251101-001</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">01 Nov 2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">Rp1.250.000</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-primary hover:text-primary-dark">Detail</a>
                                    </td>
                                </tr>
                                {{-- Baris Data 2 --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TRX-20251025-045</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25 Okt 2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">Rp350.000</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Pembayaran</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-primary hover:text-primary-dark">Bayar</a>
                                    </td>
                                </tr>
                                {{-- Tambahkan data lain sesuai kebutuhan --}}
                            </tbody>
                        </table>
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
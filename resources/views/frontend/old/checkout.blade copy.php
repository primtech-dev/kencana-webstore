@extends('frontend.components.layout')

@section('content')

<div class="fixed inset-0 bg-light-grey bg-opacity-75 flex items-start justify-center p-4 z-50 opacity-0 pointer-events-none transition-opacity duration-300 max-h-screen overflow-y-auto" id="address-modal">
    <div class="bg-white rounded-lg w-full max-w-lg mt-8 mb-8 shadow-2xl overflow-hidden transform translate-y-[-20px] transition-transform duration-300" id="modal-content">
        
        <div class="p-5 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white z-10">
            <h2 class="text-xl font-extrabold text-gray-800">Tambah Alamat Baru</h2>
            
            <button class="text-gray-400 hover:text-primary transition" onclick="closeModal()">
                 <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form action="#" method="POST" class="p-5 space-y-5">
            
            <div class="space-y-3">
                <label class="block text-sm font-bold text-gray-800">Simpan Alamat Sebagai</label>
                
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="tag-alamat bg-primary text-white text-sm font-semibold px-4 py-2 rounded-full border border-primary transition" data-label="Rumah">
                        Rumah
                    </button>
                    <button type="button" class="tag-alamat text-gray-700 text-sm font-semibold px-4 py-2 rounded-full border border-gray-300 hover:border-primary transition" data-label="Apartemen">
                        Apartemen
                    </button>
                    <button type="button" class="tag-alamat text-gray-700 text-sm font-semibold px-4 py-2 rounded-full border border-gray-300 hover:border-primary transition" data-label="Kantor">
                        Kantor
                    </button>
                    <button type="button" class="tag-alamat text-gray-700 text-sm font-semibold px-4 py-2 rounded-full border border-gray-300 hover:border-primary transition" data-label="Kost">
                        Kost
                    </button>
                </div>
            </div>

            <div class="space-y-1">
                <label for="label_alamat" class="block text-sm text-gray-700">Cth: Rumah, Kantor, Apartemen, Kost</label>
                <div class="relative">
                    <input type="text" id="label_alamat" value="Rumah" class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-800 font-semibold">
                    <span class="absolute right-3 top-3 text-xs text-gray-400">5/35</span>
                </div>
            </div>

            <div class="space-y-1">
                <label for="nama_penerima" class="block text-sm text-gray-700">Nama Penerima</label>
                <div class="relative">
                    <input type="text" id="nama_penerima" value="Hairul Bahri" class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-800 font-semibold">
                    <span class="absolute right-3 top-3 text-xs text-gray-400">12/60</span>
                </div>
            </div>

            <div class="space-y-1">
                <label for="nomor_hp" class="block text-sm text-gray-700">Nomor Handphone Penerima</label>
                <div class="relative flex">
                    <span class="bg-gray-50 text-gray-700 px-3 py-3 border border-r-0 border-gray-300 rounded-l-lg font-semibold">+62</span>
                    <input type="text" id="nomor_hp" value="8584740671" class="flex-grow p-3 border border-gray-300 rounded-r-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-800 font-semibold">
                </div>
                <p class="text-xs text-gray-400">Hanya menerima nomor handphone negara Indonesia</p>
            </div>
            
            <div class="space-y-1">
                <label for="alamat_lengkap" class="block text-sm text-gray-700">Alamat Lengkap dan Catatan untuk Kurir</label>
                <textarea id="alamat_lengkap" rows="4" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 font-semibold resize-none" placeholder="Cantumkan Nama jalan, No. Rumah, & No. RT/RW">LAOK BINDUNG DESA LANDANGAN RT 01 RW 03 KECAMATAN KAPONGAN KABUPATEN SITUBONDO</textarea>
                <p class="text-xs text-gray-400">Cantumkan **Nama jalan, No. Rumah, & No. RT/RW**</p>
            </div>
            
            <div class="pt-5">
                <button type="submit" class="w-full py-3 rounded-lg bg-primary text-white font-bold text-lg hover:bg-orange-600 transition duration-150 shadow-md shadow-orange-500/50">
                    Simpan Alamat
                </button>
            </div>

        </form>
    </div>
</div>


<section class="min-h-screen pt-8 pb-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-2xl font-extrabold text-gray-800 mb-6">Checkout</h1>

        
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            <div class="lg:col-span-8 space-y-6">

                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800">Alamat Pengiriman</h2>
                        <button class="text-primary font-bold text-sm hover:underline" onclick="openModal()">
                            Pilih Alamat Lain
                        </button>
                    </div>

                    <div class="pt-4 space-y-4">
                        <div class="relative border-2 border-primary rounded-lg p-4 bg-gray-50/50">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-home text-gray-700 mt-1 flex-shrink-0"></i>
                                <div>
                                    <p class="font-bold text-gray-800">Rumah</p>
                                    <p class="text-sm text-gray-700">Hairul Bahri (0898174089)</p>
                                    <p class="text-sm text-gray-800">KECAMATAN KAPONGAN KABUPATEN SITUBONDO, Landangan, Kapongan, Kab. Situbondo, Jawa Timur, 68362</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 bg-yellow-100 border border-yellow-300 rounded-lg text-sm flex items-start space-x-2">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5 flex-shrink-0"></i>
                            <p class="text-gray-700">
                                Informasi **nama jalan dan nomor rumah belum terisi**. <a href="#" class="text-primary font-semibold hover:underline">Lengkapi Alamat</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-4">Dikirim ke Alamat (1 Toko)</h2>
                    
                    <div class="flex items-start sm:items-center flex-wrap gap-x-3 text-sm font-semibold mb-4">
                        <i class="fas fa-truck text-primary pt-1 sm:pt-0 flex-shrink-0"></i>
                        <span class="text-gray-800">Pengiriman 1</span>
                        <span class="text-primary block sm:inline">Banjarbaru - INFORMA QMall Banjarbaru</span>
                        <span class="text-gray-700 text-xs w-full sm:w-auto block mt-1 sm:mt-0">(Stok dari DC Warehouse Informa Banjarbaru - HCI)</span>
                    </div>

                    <div class="flex flex-col sm:flex-row space-x-0 sm:space-x-4 space-y-4 sm:space-y-0 items-start pb-4 border-b border-gray-100">
                        <div class="flex space-x-4 items-start w-full sm:w-auto">
                            <div class="flex-shrink-0 w-20 h-20 bg-gray-50 rounded-md overflow-hidden">
                                <img src="https://image1ws.indotrading.com/s3/productimages/webp/co228746/p778217/w600-h600/385b7c34-ae39-462c-b059-a3f2b9122566.png" alt="Ashley Alessio Sofa L" class="object-cover w-full h-full">
                            </div>
                            
                            <div class="flex-grow space-y-1 sm:space-y-2 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 line-clamp-2">Kedai Steel Door Motif Kayu</p>
                                <p class="text-xs text-gray-700">Kedai, Kedai Steel Door</p>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="font-bold text-primary">Rp450.000</span>
                                    <span class="text-gray-700">x 1</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-3 w-full sm:w-60 flex-shrink-0">
                            <div class="relative">
                                <select class="w-full p-3 border border-gray-300 rounded-lg bg-white text-sm font-semibold text-gray-700 appearance-none focus:border-primary">
                                    <option>Dikirim ke Alamat</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400 text-xs pointer-events-none"></i>
                            </div>
                             <div class="relative">
                                <select class="w-full p-3 border border-gray-300 rounded-lg bg-white text-sm font-semibold text-gray-700 appearance-none focus:border-primary">
                                    <option>Pilih Jenis Pengiriman</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400 text-xs pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-start pt-4 text-sm flex-wrap">
                        <div class="flex items-center space-x-2 mb-2 sm:mb-0">
                            <i class="fas fa-shield-alt text-blue-500"></i>
                            <span class="text-gray-800 font-semibold">Tambah Proteksi Kerusakan</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-800">Rp159.000</span>
                            <div class="border border-gray-300 rounded-md overflow-hidden flex">
                                <span class="px-2 py-0.5 bg-gray-50 text-gray-800">x 1</span>
                                <button class="px-2 py-0.5 text-primary hover:bg-gray-50 transition">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="text-xs text-gray-700 mt-1 pl-6">
                        Proteksi kerusakan hingga **1 Tahun** | <a href="#" class="text-primary hover:underline">Ubah Periode</a>
                    </div>

                </div>

            </div>

            <div class="lg:col-span-4 mt-8 lg:mt-0">
                <div class="space-y-4">
                    
                    <div class="bg-white p-5 rounded-lg shadow-md border border-gray-100">
                        <div class="flex justify-between items-center text-sm pt-3 cursor-pointer hover:bg-gray-50/50 p-2 -m-2 rounded-lg transition">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-ticket-alt text-gray-700"></i>
                                <span class="font-semibold text-gray-800">Pakai voucher atau kode promo biar tambah hemat</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                        </div>
                    </div>

                    <div class="p-6 bg-white rounded-lg shadow-md border border-gray-100 lg:sticky lg:top-8">
                        <h2 class="text-lg font-extrabold text-gray-800 mb-4">Detail Rincian Pembayaran</h2>
                        
                        <div class="space-y-3 pb-4 border-b border-gray-100 text-sm">
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Subtotal Harga (1 produk)</span>
                                <span class="font-bold">Rp450.000</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Harga Proteksi</span>
                                <span class="font-bold">Rp159.000</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Total Ongkir</span>
                                <span class="font-bold">Rp0</span>
                            </div>
                        </div>

                        <div class="text-sm font-semibold py-3 border-b border-gray-100 cursor-pointer hover:bg-gray-50/50 p-2 -m-2 rounded-lg transition flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-file-invoice text-gray-700"></i>
                                <span>Ajukan Faktur Pajak</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                        </div>

                        <div class="flex justify-between items-center pt-4 text-xl font-extrabold">
                            <span>Total Pembayaran</span>
                            <span class="text-gray-800">-</span>
                        </div>
                        
                        <button class="w-full py-3 mt-6 rounded-lg bg-primary text-white font-bold text-lg hover:bg-orange-600 transition duration-150 shadow-md shadow-primary/50">
                            Pilih Jenis Pengiriman
                        </button>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('address-modal');
        const modalContent = document.getElementById('modal-content');

        if (!modal || !modalContent) {
            
            return; 
        }

        
        window.openModal = function() {
            modal.classList.remove('pointer-events-none', 'opacity-0');
            modal.classList.add('opacity-100');
            modalContent.classList.remove('translate-y-[-20px]');
            modalContent.classList.add('translate-y-0');
            document.body.style.overflow = 'hidden';
        }

        window.closeModal = function() {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            modalContent.classList.remove('translate-y-0');
            modalContent.classList.add('translate-y-[-20px]');
            
            setTimeout(() => {
                modal.classList.add('pointer-events-none');
                document.body.style.overflow = '';
            }, 300); 
        }

        
        document.querySelectorAll('.tag-alamat').forEach(button => {
            button.addEventListener('click', function() {
                
                document.querySelectorAll('.tag-alamat').forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white', 'border-primary');
                    btn.classList.add('text-gray-700', 'border-gray-300', 'hover:border-primary');
                });
                
                this.classList.add('bg-primary', 'text-white', 'border-primary');
                this.classList.remove('text-gray-700', 'border-gray-300', 'hover:border-primary');

                
                document.getElementById('label_alamat').value = this.getAttribute('data-label');
            });
        });

        
        modal.addEventListener('click', function(e) {
            if (e.target.id === 'address-modal') {
                closeModal();
            }
        });

        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('opacity-100')) {
                closeModal();
            }
        });
    });
</script>
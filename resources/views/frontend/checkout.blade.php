@extends('frontend.components.layout')
@section('content')

<div class="modal fixed inset-0 bg-black bg-opacity-50 flex items-start justify-center p-4 z-50 opacity-0 pointer-events-none" id="address-modal">
    <div class="bg-white rounded-lg w-full max-w-lg mt-8 shadow-2xl overflow-hidden transform translate-y-[-20px] transition-transform duration-300">
        
        <div class="p-5 border-b border-light-grey/50 flex justify-between items-center">
            <h2 class="text-xl font-extrabold text-dark-grey">Tambah Alamat Baru</h2>
            <button class="text-dark-grey/50 hover:text-primary" onclick="closeModal()">
                 <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form action="#" method="POST" class="p-5 space-y-5">
            
            <div class="space-y-3">
                <label class="block text-sm font-bold text-dark-grey">Simpan Alamat Sebagai</label>
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="tag-alamat bg-primary text-white text-sm font-semibold px-4 py-2 rounded-full border border-primary transition" data-label="Rumah">
                        Rumah
                    </button>
                    <button type="button" class="tag-alamat text-dark-grey/80 text-sm font-semibold px-4 py-2 rounded-full border border-light-grey hover:border-primary transition" data-label="Apartemen">
                        Apartemen
                    </button>
                    <button type="button" class="tag-alamat text-dark-grey/80 text-sm font-semibold px-4 py-2 rounded-full border border-light-grey hover:border-primary transition" data-label="Kantor">
                        Kantor
                    </button>
                    <button type="button" class="tag-alamat text-dark-grey/80 text-sm font-semibold px-4 py-2 rounded-full border border-light-grey hover:border-primary transition" data-label="Kost">
                        Kost
                    </button>
                </div>
            </div>

            <div class="space-y-1">
                <label for="label_alamat" class="block text-sm text-dark-grey/80">Cth: Rumah, Kantor, Apartemen, Kost</label>
                <div class="relative">
                    <input type="text" id="label_alamat" value="Rumah" class="w-full p-3 border border-light-grey rounded-lg focus:border-primary focus:ring-primary text-dark-grey font-semibold">
                    <span class="absolute right-3 top-3 text-xs text-light-grey">5/35</span>
                </div>
            </div>

            <div class="space-y-1">
                <label for="nama_penerima" class="block text-sm text-dark-grey/80">Nama Penerima</label>
                <div class="relative">
                    <input type="text" id="nama_penerima" value="Hairul Bahri" class="w-full p-3 border border-light-grey rounded-lg focus:border-primary focus:ring-primary text-dark-grey font-semibold">
                    <span class="absolute right-3 top-3 text-xs text-light-grey">12/60</span>
                </div>
            </div>

            <div class="space-y-1">
                <label for="nomor_hp" class="block text-sm text-dark-grey/80">Nomor Handphone Penerima</label>
                <div class="relative flex">
                    <span class="bg-light-bg text-dark-grey/80 px-3 py-3 border border-r-0 border-light-grey rounded-l-lg font-semibold">+62</span>
                    <input type="text" id="nomor_hp" value="8584740671" class="flex-grow p-3 border border-light-grey rounded-r-lg focus:border-primary focus:ring-primary text-dark-grey font-semibold">
                </div>
                <p class="text-xs text-light-grey">Hanya menerima nomor handphone negara Indonesia</p>
            </div>
            
            <div class="space-y-1">
                <label for="alamat_lengkap" class="block text-sm text-dark-grey/80">Alamat Lengkap dan Catatan untuk Kurir</label>
                <textarea id="alamat_lengkap" rows="4" class="w-full p-3 border border-light-grey rounded-lg bg-light-bg text-dark-grey font-semibold resize-none" placeholder="Cantumkan Nama jalan, No. Rumah, & No. RT/RW">LAOK BINDUNG DESA LANDANGAN RT 01 RW 03 KECAMATAN KAPONGAN KABUPATEN SITUBONDO</textarea>
                <p class="text-xs text-light-grey">Cantumkan **Nama jalan, No. Rumah, & No. RT/RW**</p>
            </div>
            
            <div class="pt-5">
                <button type="submit" class="w-full py-3 rounded-lg bg-orange-action text-white font-bold text-lg hover:bg-orange-dark transition duration-150 shadow-md shadow-orange-action/50">
                    Simpan Alamat
                </button>
            </div>

        </form>
    </div>
</div>

<section class="min-h-screen pt-8 pb-16 bg-light-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-2xl font-extrabold text-dark-grey mb-6">Checkout</h1>

        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            <div class="lg:col-span-8 space-y-6">

                <div class="bg-white p-6 rounded-lg shadow-soft border border-light-grey/50">
                    <div class="flex justify-between items-center pb-4 border-b border-light-grey/50">
                        <h2 class="text-lg font-bold text-dark-grey">Alamat Pengiriman</h2>
                        {{-- Tombol untuk menampilkan modal --}}
                        <button class="text-primary font-bold text-sm hover:underline" onclick="openModal()">
                            Pilih Alamat Lain
                        </button>
                    </div>

                    <div class="pt-4 space-y-4">
                        <div class="relative border-2 border-primary rounded-lg p-4 bg-light-bg/50">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-home text-dark-grey/80 mt-1"></i>
                                <div>
                                    <p class="font-bold text-dark-grey">Rumah</p>
                                    <p class="text-sm text-dark-grey/80">Hairul Bahri (0898174089)</p>
                                    <p class="text-sm text-dark-grey">KECAMATAN KAPONGAN KABUPATEN SITUBONDO, Landangan, Kapongan, Kab. Situbondo, Jawa Timur, 68362</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 bg-yellow-100 border border-yellow-300 rounded-lg text-sm flex items-start space-x-2">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                            <p class="text-dark-grey/80">
                                Informasi **nama jalan dan nomor rumah belum terisi**. <a href="#" class="text-primary font-semibold hover:underline">Lengkapi Alamat</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-soft border border-light-grey/50">
                    <h2 class="text-lg font-bold text-dark-grey mb-4 border-b border-light-grey/50 pb-4">Dikirim ke Alamat (1 Toko)</h2>
                    
                    {{-- Detail Toko Pengirim --}}
                    <div class="flex items-center space-x-3 text-sm font-semibold mb-4">
                        <i class="fas fa-truck text-primary"></i>
                        <span class="text-dark-grey">Pengiriman 1</span>
                        <span class="text-primary">Banjarbaru - INFORMA QMall Banjarbaru</span>
                        <span class="text-dark-grey/80 text-xs">(Stok dari DC Warehouse Informa Banjarbaru - HCI)</span>
                    </div>

                    {{-- Produk Dalam Pengiriman Ini --}}
                    <div class="flex space-x-4 items-start pb-4 border-b border-light-grey/50">
                        <div class="flex-shrink-0 w-20 h-20 bg-light-bg rounded-md overflow-hidden">
                            <img src="https://cdn.ruparupa.io/fit-in/400x400/filters:format(webp)/filters:quality(90)/ruparupa-com/image/upload/Products/10578759_1.jpg" alt="Ashley Alessio Sofa L" class="object-cover w-full h-full">
                        </div>
                        
                        <div class="flex-grow space-y-2">
                            <p class="text-sm font-semibold text-dark-grey">Ashley Alessio Sofa L Sectional Fabric - Abu-Abu Tua</p>
                            <p class="text-xs text-dark-grey/80">Abu-abu, Sofa Sectional</p>
                            <div class="flex justify-between items-center text-sm">
                                <span class="font-bold text-primary">Rp5.499.000</span>
                                <span class="text-dark-grey/80">x 1</span>
                            </div>
                            <!-- <p class="text-xs text-dark-grey/80">Perbedaan harga zona: <span class="text-discount-red font-semibold">+Rp600.000</span></p> -->
                        </div>

                        {{-- Dropdown Pengiriman --}}
                        <div class="flex flex-col space-y-3 w-60 flex-shrink-0">
                            <div class="relative">
                                <select class="w-full p-3 border border-light-grey rounded-lg bg-white text-sm font-semibold text-dark-grey/80 appearance-none focus:border-primary">
                                    <option>Dikirim ke Alamat</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-3.5 text-light-grey text-xs"></i>
                            </div>
                             <div class="relative">
                                <select class="w-full p-3 border border-light-grey rounded-lg bg-white text-sm font-semibold text-dark-grey/80 appearance-none focus:border-primary">
                                    <option>Pilih Jenis Pengiriman</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-3.5 text-light-grey text-xs"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Tambah Proteksi Kerusakan --}}
                    <div class="flex justify-between items-center pt-4 text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-shield-alt text-blue-500"></i>
                            <span class="text-dark-grey font-semibold">Tambah Proteksi Kerusakan</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-dark-grey">Rp159.000</span>
                            <div class="border border-light-grey rounded-md overflow-hidden flex">
                                <span class="px-2 py-0.5 bg-light-bg text-dark-grey">x 1</span>
                                <button class="px-2 py-0.5 text-primary hover:bg-light-bg transition">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="text-xs text-dark-grey/80 mt-1 pl-6">
                        Proteksi kerusakan hingga **1 Tahun** | <a href="#" class="text-primary hover:underline">Ubah Periode</a>
                    </div>

                </div>

            </div>

            <div class="lg:col-span-4 mt-8 lg:mt-0">
                <div class="space-y-4">
                    
                    <div class="bg-white p-5 rounded-lg shadow-soft border border-light-grey/50">
                        

                        

                        <div class="flex justify-between items-center text-sm pt-3 cursor-pointer hover:bg-light-bg/50">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-ticket-alt text-dark-grey/80"></i>
                                <span class="font-semibold text-dark-grey">Pakai voucher atau kode promo biar tambah hemat</span>
                            </div>
                            <i class="fas fa-chevron-right text-light-grey text-xs"></i>
                        </div>
                    </div>

                    <div class="p-6 bg-white rounded-lg shadow-soft border border-light-grey/50 lg:sticky lg:top-8">
                        <h2 class="text-lg font-extrabold text-dark-grey mb-4">Detail Rincian Pembayaran</h2>
                        
                        <div class="space-y-3 pb-4 border-b border-light-grey/50 text-sm">
                            <div class="flex justify-between items-center text-dark-grey/80">
                                <span>Subtotal Harga (1 produk)</span>
                                <span class="font-bold">Rp5.499.000</span>
                            </div>
                            <div class="flex justify-between items-center text-dark-grey/80">
                                <span>Harga Proteksi</span>
                                <span class="font-bold">Rp159.000</span>
                            </div>
                            <!-- <div class="flex justify-between items-center text-dark-grey/80">
                                <span>Perbedaan Harga Zona <i class="fas fa-question-circle text-xs text-light-grey"></i></span>
                                <span class="font-bold">Rp600.000</span>
                            </div> -->
                            <div class="flex justify-between items-center text-dark-grey/80">
                                <span>Total Ongkir</span>
                                <span class="font-bold">Rp0</span>
                            </div>
                        </div>

                        <div class="text-sm font-semibold py-3 border-b border-light-grey/50 cursor-pointer hover:bg-light-bg/50 flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-file-invoice text-dark-grey/80"></i>
                                <span>Ajukan Faktur Pajak</span>
                            </div>
                            <i class="fas fa-chevron-right text-light-grey text-xs"></i>
                        </div>

                        <div class="flex justify-between items-center pt-4 text-xl font-extrabold">
                            <span>Total Pembayaran</span>
                            <span class="text-dark-grey">-</span>
                        </div>
                        
                        <button class="w-full py-3 mt-6 rounded-lg bg-primary text-white font-bold text-lg hover:bg-primary-dark transition duration-150 shadow-md shadow-orange-action/50">
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
    const modal = document.getElementById('address-modal');
    const modalContent = modal.querySelector('div');

    function openModal() {
        modal.classList.remove('pointer-events-none', 'opacity-0');
        modal.classList.add('opacity-100');
        modalContent.classList.remove('translate-y-[-20px]');
        modalContent.classList.add('translate-y-0');
        document.body.style.overflow = 'hidden'; // Mencegah scroll di background
    }

    function closeModal() {
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        modalContent.classList.remove('translate-y-0');
        modalContent.classList.add('translate-y-[-20px]');
        
        // Tunggu transisi selesai sebelum menghilangkan pointer-events
        setTimeout(() => {
            modal.classList.add('pointer-events-none');
            document.body.style.overflow = '';
        }, 300); 
    }

    // Skrip untuk simulasi memilih tag alamat di dalam modal
    document.querySelectorAll('.tag-alamat').forEach(button => {
        button.addEventListener('click', function() {
            // Hapus style aktif dari semua tag
            document.querySelectorAll('.tag-alamat').forEach(btn => {
                btn.classList.remove('bg-primary', 'text-white', 'border-primary');
                btn.classList.add('text-dark-grey/80', 'border-light-grey', 'hover:border-primary');
            });
            // Terapkan style aktif pada tag yang diklik
            this.classList.add('bg-primary', 'text-white', 'border-primary');
            this.classList.remove('text-dark-grey/80', 'border-light-grey', 'hover:border-primary');

            // Perbarui input label
            document.getElementById('label_alamat').value = this.getAttribute('data-label');
        });
    });

    // Menutup modal jika klik di luar area modal
    modal.addEventListener('click', function(e) {
        if (e.target.id === 'address-modal') {
            closeModal();
        }
    });

    // Menutup modal jika tombol 'Esc' ditekan
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('opacity-100')) {
            closeModal();
        }
    });
</script>
@extends('frontend.components.layout')
@section('content')
<section class="container px-1 lg:px-[7%] mx-auto mt-8 mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-2xl font-extrabold text-dark-grey mb-6">Keranjang Belanja</h1>

        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            <div class="lg:col-span-8 space-y-4">

                <div class="bg-white p-4 rounded-lg shadow-soft border border-light-grey/50 flex justify-between items-center">
                    <label class="custom-checkbox flex items-center space-x-3 text-lg font-bold cursor-pointer">
                        <input type="checkbox" class="hidden" checked>
                        <div class="checkmark flex items-center justify-center">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span>Pilih Semua</span>
                    </label>
                    <button class="text-primary font-bold hover:underline">
                        Hapus Produk
                    </button>
                </div>

                <div class="bg-white rounded-lg shadow-soft border border-light-grey/50">
                    
                    {{-- Header Toko --}}
                    <div class="p-4 border-b border-light-grey/50 flex items-center space-x-3 text-sm font-semibold">
                        <label class="custom-checkbox flex items-center cursor-pointer">
                            <input type="checkbox" class="hidden" checked>
                            <div class="checkmark flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                        </label>
                        <span class="text-dark-grey">Diproses dari **Toko Terdekat**</span>
                        <i class="fas fa-info-circle text-light-grey text-xs cursor-pointer" title="Info Toko"></i>
                    </div>

                    {{-- Detail Produk --}}
                    <div class="p-4 flex space-x-4 items-start">
                        
                        <label class="custom-checkbox flex-shrink-0 pt-1 cursor-pointer">
                            <input type="checkbox" class="hidden" checked>
                            <div class="checkmark flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                        </label>

                        <div class="flex-shrink-0 w-24 h-24 bg-light-bg rounded-md overflow-hidden">
                            <img src="https://cdn.ruparupa.io/fit-in/400x400/filters:format(webp)/filters:quality(90)/ruparupa-com/image/upload/Products/10578759_1.jpg" alt="INFORMA CARSON SOFA" class="object-cover w-full h-full">
                        </div>

                        <div class="flex-grow">
                            <p class="text-sm font-semibold text-dark-grey mb-1 leading-snug">
                                INFORMA CARSON SOFA BED MODULAR SUDUT FABRIC KIRI - ABU-ABU
                            </p>
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="text-lg font-extrabold text-primary">Rp11.999.000</span>
                                <span class="text-xs text-light-grey line-through">Rp13.999.000</span>
                                <span class="text-xs font-bold text-discount-red border border-discount-red rounded px-1">14%</span>
                            </div>
                            <span class="text-xs text-discount-red font-semibold bg-red-100 px-2 py-0.5 rounded-full inline-block">Stok Terbatas</span>
                        </div>
                        
                        {{-- Opsi Aksi & Kuantitas --}}
                        <div class="flex flex-col items-end space-y-3">
                            <button class="text-dark-grey/50 hover:text-primary transition">
                                <i class="fas fa-trash-alt text-lg"></i>
                            </button>
                            
                            {{-- Kontrol Kuantitas --}}
                            <div class="flex items-center border border-light-grey rounded-md overflow-hidden text-base">
                                <button class="w-8 h-8 flex items-center justify-center bg-light-bg hover:bg-light-grey/50 transition">-</button>
                                <span class="w-8 h-8 flex items-center justify-center font-bold">1</span>
                                <button class="w-8 h-8 flex items-center justify-center bg-light-bg hover:bg-light-grey/50 transition">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 pb-4 text-sm">
                        <a href="#" class="text-primary hover:underline">Tambah Catatan</a>
                    </div>

                </div>
                
                {{-- Placeholder untuk produk lain di masa depan --}}
                <div class="text-sm text-dark-grey/80 text-center py-4">
                    Jika ada produk lain dari toko/gudang yang berbeda, akan tampil di kartu terpisah.
                </div>
            </div>

            <div class="lg:col-span-4 mt-8 lg:mt-0">
                <div class="p-6 bg-white rounded-lg shadow-soft border border-light-grey/50 lg:sticky lg:top-8">
                    
                    <h2 class="text-lg font-extrabold text-dark-grey mb-4">Detail Rincian Pembayaran</h2>
                    
                    <div class="space-y-3 pb-4 border-b border-light-grey/50 text-sm">
                        <div class="flex justify-between items-center text-dark-grey/80">
                            <span>Subtotal Harga (1 produk)</span>
                            <span class="font-bold">Rp13.999.000</span>
                        </div>
                        <div class="flex justify-between items-center text-dark-grey/80 pt-1">
                            <div>
                                <p>Promo Produk</p>
                                <p class="text-xs text-light-grey">Harga di atas belum termasuk potongan promo apapun</p>
                            </div>
                            <span class="font-bold text-discount-red">-Rp2.000.000</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 text-lg font-extrabold">
                        <span>Total Pembayaran</span>
                        <span class="text-dark-grey">Rp11.999.000</span>
                    </div>
                    <p class="text-xs text-right text-dark-grey/80 mb-6">Belum termasuk ongkos kirim</p>
                    
                    <button class="w-full py-3 rounded-lg bg-primary text-white font-bold text-lg hover:bg-primary-dark transition duration-150 shadow-md shadow-orange-action/50">
                        <a href="{{url('checkout')}}">
                        Lanjut Bayar
                        </a>
                    </button>

                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Skrip untuk simulasi Checkbox (Memastikan ikon check muncul)
            const checkboxes = document.querySelectorAll('.custom-checkbox input');
            checkboxes.forEach(input => {
                const checkmark = input.nextElementSibling.querySelector('.fa-check');
                if (input.checked) {
                    checkmark.style.display = 'inline';
                } else {
                    checkmark.style.display = 'none';
                }

                input.addEventListener('change', function() {
                    if (this.checked) {
                        checkmark.style.display = 'inline';
                    } else {
                        checkmark.style.display = 'none';
                    }
                    // Tambahkan logika untuk "Pilih Semua" di sini jika diperlukan
                });
            });
            
            // Catatan: Untuk fungsi kuantitas (+/-) dan penghitungan total harga,
            // diperlukan logika server-side atau kerangka kerja frontend yang lebih kompleks.
            // Saat ini, tampilannya sudah dibuat sesuai gambar.
        });
    </script>
@endsection
@extends('frontend.components.layout')

@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-16">
    <div class="max-w-4xl mx-auto">
        
        <header class="text-center mb-10 py-6 bg-light-grey rounded-lg">
            <h1 class="text-3xl font-extrabold text-dark-grey">Pusat Bantuan & FAQ</h1>
            <p class="text-dark-grey/80 mt-1">Temukan jawaban cepat untuk pertanyaan yang sering diajukan.</p>
        </header>

        <div class="space-y-4" id="faq-accordion">
            
            <h2 class="text-xl font-bold text-primary border-b pb-2">Akun & Informasi Umum</h2>
            
            <div class="border border-light-grey rounded-lg shadow-sm">
                <button 
                    class="faq-toggle w-full flex justify-between items-center p-4 text-left font-semibold text-dark-grey hover:bg-gray-50 transition"
                    data-target="faq-content-1">
                    Bagaimana cara membuat akun di website ini?
                    <i class="fas fa-plus text-primary transition-transform duration-300 transform"></i>
                </button>
                <div id="faq-content-1" class="faq-content hidden p-0 text-dark-grey/80 border-t border-light-grey bg-white">
                    <div class="p-4 pt-0">
                        Anda dapat membuat akun dengan mengklik tombol "Daftar" di pojok kanan atas halaman. Isi formulir pendaftaran dengan nama, alamat email, dan kata sandi Anda. Setelah selesai, konfirmasi akun Anda melalui email yang kami kirimkan untuk aktivasi.
                    </div>
                </div>
            </div>

            <div class="border border-light-grey rounded-lg shadow-sm">
                <button 
                    class="faq-toggle w-full flex justify-between items-center p-4 text-left font-semibold text-dark-grey hover:bg-gray-50 transition"
                    data-target="faq-content-2">
                    Apakah semua produk yang dijual memiliki garansi?
                    <i class="fas fa-plus text-primary transition-transform duration-300 transform"></i>
                </button>
                <div id="faq-content-2" class="faq-content hidden p-0 text-dark-grey/80 border-t border-light-grey bg-white">
                    <div class="p-4 pt-0">
                        Sebagian besar produk kami dilengkapi dengan garansi resmi dari produsen. Detail dan durasi garansi spesifik (misalnya, garansi 1 tahun untuk pintu baja) tercantum di halaman detail masing-masing produk. Kami menjamin keaslian 100% produk yang dijual.
                    </div>
                </div>
            </div>
            
            <div class="border border-light-grey rounded-lg shadow-sm">
                <button 
                    class="faq-toggle w-full flex justify-between items-center p-4 text-left font-semibold text-dark-grey hover:bg-gray-50 transition"
                    data-target="faq-content-7">
                    Bagaimana cara mengetahui ketersediaan stok produk?
                    <i class="fas fa-plus text-primary transition-transform duration-300 transform"></i>
                </button>
                <div id="faq-content-7" class="faq-content hidden p-0 text-dark-grey/80 border-t border-light-grey bg-white">
                    <div class="p-4 pt-0">
                        Status stok ditampilkan secara *real-time* di halaman detail produk. Jika stok menunjukkan "Terbatas" atau "Habis", silakan hubungi CS kami untuk perkiraan waktu restock.
                    </div>
                </div>
            </div>

            <h2 class="text-xl font-bold text-primary border-b pb-2 pt-4">Pemesanan & Pembayaran</h2>
            
            <div class="border border-light-grey rounded-lg shadow-sm">
                <button 
                    class="faq-toggle w-full flex justify-between items-center p-4 text-left font-semibold text-dark-grey hover:bg-gray-50 transition"
                    data-target="faq-content-3">
                    Metode pembayaran apa saja yang tersedia?
                    <i class="fas fa-plus text-primary transition-transform duration-300 transform"></i>
                </button>
                <div id="faq-content-3" class="faq-content hidden p-0 text-dark-grey/80 border-t border-light-grey bg-white">
                    <div class="p-4 pt-0">
                        Kami menerima berbagai metode pembayaran:
                        <ul class="list-disc list-inside mt-2 ml-4 space-y-1">
                            <li>Transfer Bank (Virtual Account BCA, Mandiri, BNI)</li>
                            <li>Kartu Kredit/Debit (Visa, Mastercard)</li>
                            <li>Dompet Digital (GoPay, OVO, ShopeePay)</li>
                        </ul>
                        Semua transaksi diproses melalui *payment gateway* terpercaya dan aman.
                    </div>
                </div>
            </div>
            
            <div class="border border-light-grey rounded-lg shadow-sm">
                <button 
                    class="faq-toggle w-full flex justify-between items-center p-4 text-left font-semibold text-dark-grey hover:bg-gray-50 transition"
                    data-target="faq-content-8">
                    Bisakah saya mendapatkan harga khusus untuk pembelian dalam jumlah besar (Grosir)?
                    <i class="fas fa-plus text-primary transition-transform duration-300 transform"></i>
                </button>
                <div id="faq-content-8" class="faq-content hidden p-0 text-dark-grey/80 border-t border-light-grey bg-white">
                    <div class="p-4 pt-0">
                        Ya, kami menawarkan harga khusus (diskon proyek/grosir) untuk pembelian dengan kuantitas tertentu. Silakan hubungi tim penjualan kami secara langsung melalui WhatsApp dengan menyertakan daftar produk dan kuantitas yang Anda butuhkan.
                    </div>
                </div>
            </div>

            <h2 class="text-xl font-bold text-primary border-b pb-2 pt-4">Pengiriman & Retur</h2>
            
            <div class="border border-light-grey rounded-lg shadow-sm">
                <button 
                    class="faq-toggle w-full flex justify-between items-center p-4 text-left font-semibold text-dark-grey hover:bg-gray-50 transition"
                    data-target="faq-content-4">
                    Berapa biaya pengiriman ke lokasi saya?
                    <i class="fas fa-plus text-primary transition-transform duration-300 transform"></i>
                </button>
                <div id="faq-content-4" class="faq-content hidden p-0 text-dark-grey/80 border-t border-light-grey bg-white">
                    <div class="p-4 pt-0">
                        Biaya pengiriman dihitung secara otomatis saat Anda memasukkan alamat lengkap di halaman *checkout*. Biaya dihitung berdasarkan berat/volume produk, jarak, dan jenis layanan kurir yang Anda pilih.
                    </div>
                </div>
            </div>

            <div class="border border-light-grey rounded-lg shadow-sm">
                <button 
                    class="faq-toggle w-full flex justify-between items-center p-4 text-left font-semibold text-dark-grey hover:bg-gray-50 transition"
                    data-target="faq-content-6">
                    Bagaimana prosedur untuk pengembalian barang (retur)?
                    <i class="fas fa-plus text-primary transition-transform duration-300 transform"></i>
                </button>
                <div id="faq-content-6" class="faq-content hidden p-0 text-dark-grey/80 border-t border-light-grey bg-white">
                    <div class="p-4 pt-0">
                        Pengembalian dapat dilakukan dalam waktu **7 hari** setelah barang diterima, dengan syarat:
                        <ul class="list-disc list-inside mt-2 ml-4 space-y-1">
                            <li>Barang rusak saat pengiriman (mohon sertakan bukti foto/video unboxing).</li>
                            <li>Barang yang diterima tidak sesuai dengan pesanan.</li>
                            <li>Kemasan utuh dan tidak terpakai.</li>
                        </ul>
                        Untuk mengajukan retur, silakan hubungi CS kami dengan nomor pesanan Anda.
                    </div>
                </div>
            </div>

        </div>
        
        <div class="text-center mt-12 p-6 bg-green-50 border border-green-300 rounded-lg">
            <h3 class="text-xl font-bold text-dark-grey">Tidak menemukan jawaban Anda?</h3>
            <p class="text-dark-grey/80 mt-1 mb-4">Hubungi Customer Service kami melalui WhatsApp:</p>
            
            @php
                $waNumber = '6281234567890';
                $waMessage = urlencode('Halo CS, saya memiliki pertanyaan mengenai bantuan di website. Nomor Pesanan saya: [ISI NOMOR PESANAN]');
                $waLink = "https://wa.me/{$waNumber}?text={$waMessage}";
            @endphp
            
            <a href="{{ $waLink }}" target="_blank" class="inline-block py-2 px-6 rounded-full bg-green-500 text-white font-semibold shadow-md hover:bg-green-600 transition duration-150">
                <i class="fab fa-whatsapp mr-2"></i> Chat CS Kami ({{ $waNumber }})
            </a>
        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.faq-toggle');

        toggleButtons.forEach(button => {
            button.addEventListener('click', () => {
                const content = document.getElementById(button.getAttribute('data-target'));
                const icon = button.querySelector('i');
                const isHidden = content.classList.contains('hidden');

                document.querySelectorAll('.faq-content').forEach(item => {
                    if (item !== content && !item.classList.contains('hidden')) {
                        item.classList.add('hidden');
                        const otherButton = document.querySelector(`[data-target="${item.id}"]`);
                        if (otherButton) {
                            otherButton.querySelector('i').classList.remove('rotate-45');
                        }
                    }
                });

                content.classList.toggle('hidden');
                
                if (isHidden) {
                    icon.classList.add('rotate-45');
                } else {
                    icon.classList.remove('rotate-45');
                }
            });
        });
    });
</script>

@endsection
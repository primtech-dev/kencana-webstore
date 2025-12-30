@extends('frontend.components.layout')
@section('content')
<section class="container px-4 lg:px-[7%] mx-auto mt-8 mb-12">
    <div class="max-w-7xl mx-auto">
        <div class="relative rounded-3xl overflow-hidden shadow-xl mb-8">
            <img src="https://d12grbvu52tm8q.cloudfront.net/AHI/Compro/a101700b-d7f9-4200-9a70-d207d48405db.jpg" 
                 class="w-full h-64 md:h-80 object-cover" alt="Banner Voucher">
            <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                <h1 class="text-white text-3xl md:text-4xl font-black text-center px-4">VOUCHER POTONGAN Rp15.000</h1>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Syarat & Ketentuan</h2>
                    <ul class="list-disc list-inside space-y-3 text-gray-600 text-sm leading-relaxed">
                        <li>Voucher berlaku hingga 25 November 2025.</li>
                        <li>Minimal transaksi Rp150.000 untuk kategori perlengkapan rumah.</li>
                        <li>Berlaku untuk 1 (satu) kali transaksi per user.</li>
                        <li>Dapat digunakan untuk pembelian melalui aplikasi dan website.</li>
                        <li>Tidak dapat digabungkan dengan promo bank atau voucher lainnya.</li>
                    </ul>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-8 text-center">
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-4">Salin Kode Voucher</p>
                    <div class="bg-dashed border-2 border-dashed border-red-300 rounded-xl p-4 mb-6">
                        <span id="voucherCode" class="text-2xl font-black text-red-600">HEMAT15K</span>
                    </div>
                    <button onclick="copyVoucher()" class="w-full bg-gray-900 hover:bg-black text-white py-3 rounded-lg font-bold transition flex items-center justify-center">
                        <i class="fas fa-copy mr-2"></i> Salin Kode
                    </button>
                    <p class="text-[10px] text-gray-400 mt-4 italic">*Gunakan saat checkout di halaman pembayaran</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function copyVoucher() {
    const code = document.getElementById('voucherCode').innerText;
    navigator.clipboard.writeText(code);
    alert('Kode Voucher Berhasil Disalin!');
}
</script>
@endsection
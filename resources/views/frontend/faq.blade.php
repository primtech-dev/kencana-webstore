@extends('frontend.components.layout')

@section('content')
<style>
    /* Transisi halus untuk akordeon */
    .faq-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out, padding 0.3s ease;
    }
    .faq-item.active .faq-content {
        max-height: 500px; /* Sesuaikan dengan panjang konten */
        padding-bottom: 1.25rem;
    }
    .faq-item.active .faq-icon {
        transform: rotate(180deg);
        color: #eb4d25ff; /* Warna primary */
    }
</style>

<main class="container px-4 lg:px-[15%] mx-auto mt-12 mb-20">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-black text-dark-grey uppercase mb-4">Pertanyaan Populer (FAQ)</h1>
        <p class="text-gray-500 max-w-2xl mx-auto">
            Punya pertanyaan mengenai layanan kami? Temukan jawaban cepat untuk kendala dan informasi umum yang sering ditanyakan pelanggan.
        </p>
    </div>

    <div class="space-y-4">
        
        <div class="faq-item bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden transition-all duration-300">
            <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleFaq(this)">
                <span class="font-bold text-gray-800 pr-4 uppercase">Bagaimana cara menemukan cabang Kencana Store terdekat?</span>
                <i class="fas fa-chevron-down faq-icon text-gray-400 transition-transform duration-300"></i>
            </button>
            <div class="faq-content px-5 text-gray-600 text-sm leading-relaxed">
                Anda dapat mengunjungi halaman <a href="/branches" class="text-primary font-medium underline">Daftar Cabang</a> kami. Di sana terdapat peta interaktif yang akan menampilkan toko-toko kami di seluruh Indonesia berdasarkan lokasi Anda saat ini.
            </div>
        </div>

        <div class="faq-item bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden transition-all duration-300">
            <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleFaq(this)">
                <span class="font-bold text-gray-800 pr-4 uppercase">Apakah stok barang di setiap cabang selalu sama?</span>
                <i class="fas fa-chevron-down faq-icon text-gray-400 transition-transform duration-300"></i>
            </button>
            <div class="faq-content px-5 text-gray-600 text-sm leading-relaxed">
                Stok barang dapat bervariasi antar cabang. Kami menyarankan Anda untuk menghubungi nomor telepon cabang terkait (tertera pada daftar cabang) untuk memastikan ketersediaan barang sebelum berkunjung.
            </div>
        </div>

        <div class="faq-item bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden transition-all duration-300">
            <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleFaq(this)">
                <span class="font-bold text-gray-800 pr-4 uppercase">Jam berapa operasional toko Kencana Store?</span>
                <i class="fas fa-chevron-down faq-icon text-gray-400 transition-transform duration-300"></i>
            </button>
            <div class="faq-content px-5 text-gray-600 text-sm leading-relaxed">
                Umumnya cabang kami beroperasi mulai pukul 08.00 hingga 17.00 waktu setempat. Namun, beberapa cabang mungkin memiliki waktu operasional yang berbeda terutama pada hari libur nasional.
            </div>
        </div>

        <div class="faq-item bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden transition-all duration-300">
            <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleFaq(this)">
                <span class="font-bold text-gray-800 pr-4 uppercase">Apakah bisa melakukan pemesanan secara online?</span>
                <i class="fas fa-chevron-down faq-icon text-gray-400 transition-transform duration-300"></i>
            </button>
            <div class="faq-content px-5 text-gray-600 text-sm leading-relaxed">
                Ya, Anda dapat menghubungi admin pusat atau langsung ke nomor WhatsApp cabang yang tersedia di detail informasi cabang untuk melakukan konsultasi produk dan pemesanan jarak jauh.
            </div>
        </div>

    </div>

    <div class="mt-16 bg-primary/5 rounded-3xl p-8 text-center border border-primary/10">
        <h3 class="font-bold text-dark-grey text-lg uppercase mb-2">Masih bingung?</h3>
        <p class="text-gray-500 text-sm mb-6">Jika pertanyaan Anda tidak terjawab di atas, jangan ragu untuk menghubungi layanan pelanggan kami.</p>
        <a href="https://wa.me/628xxxx" class="inline-flex items-center gap-2 bg-primary text-white px-8 py-3 rounded-full font-bold hover:bg-blue-700 transition shadow-lg shadow-primary/20">
            <i class="fab fa-whatsapp text-lg"></i> HUBUNGI KAMI
        </a>
    </div>
</main>

<script>
    function toggleFaq(element) {
        const item = element.parentElement;
        
        // Menutup item FAQ lain (Opsional: hapus loop ini jika ingin bisa buka banyak sekaligus)
        document.querySelectorAll('.faq-item').forEach(otherItem => {
            if (otherItem !== item) {
                otherItem.classList.remove('active');
            }
        });

        // Toggle item yang diklik
        item.classList.toggle('active');
    }
</script>
@endsection
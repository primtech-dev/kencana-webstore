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

                {{-- INFORMASI REWARD/LEVEL (Tidak Berubah) --}}
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
                        {{-- Asumsi Anda memiliki warna Tailwind 'primary' yang sesuai --}}
                        <i class="fas fa-ticket-alt text-xl text-primary flex-shrink-0"></i>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Voucher Siap Klaim</p>
                            <p class="text-lg font-extrabold text-gray-800">3 <span class="text-sm font-normal text-gray-500">Voucher</span></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100 mb-6">
                    <h2 class="text-xl font-extrabold text-gray-800 mb-6 border-b pb-3">Detail Profile</h2>
                    {{-- Pesan Status dan Logic Profile (Dihilangkan untuk brevity, asumsikan sama) --}}
                    {{-- ... Konten Profile ... --}}
                    @if (session('status'))
                    <div class="mt-4 p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        <span class="font-medium">Berhasil!</span> {{ session('status') }}
                    </div>
                    @endif

                    @php
                    $customer = Auth::guard('customer')->user();
                    $avatarName = urlencode($customer->full_name ?: $customer->email);
                    $avatarUrl = "https://ui-avatars.com/api/?name={$avatarName}&background=ee0d0d&color=fff&size=256&rounded=true&bold=true";
                    @endphp

                    <div id="profileDetails" class="@if($errors->any()) hidden @endif">
                        <div class="flex flex-col sm:flex-row sm:space-x-8">
                            <div class="flex-shrink-0 mb-4 sm:mb-0 flex flex-col items-center">
                                <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-gray-200 overflow-hidden border-4 border-gray-100 shadow-inner">
                                    <img src="{{ $avatarUrl }}" alt="Foto Profil {{ $customer->full_name }}" class="object-cover w-full h-full">
                                </div>
                            </div>
                            <div class="flex-grow space-y-4">
                                <div class="flex flex-col">
                                    <label class="text-sm font-semibold text-gray-500">Nama Lengkap</label>
                                    <p class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-1">{{ $customer->full_name }}</p>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-semibold text-gray-500">Alamat Email</label>
                                    <p class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-1">{{ $customer->email }}</p>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-semibold text-gray-500">Nomor Telepon</label>
                                    <p class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-1">{{ $customer->phone ?: '-' }}</p>
                                </div>
                                <div class="pt-4">
                                    <button id="showEditFormBtn" type="button" class="py-2 px-6 rounded-lg bg-gray-200 text-gray-700 font-bold hover:bg-gray-300 transition duration-150 text-sm">
                                        <i class="fas fa-edit mr-2"></i> Edit Profil
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="editProfileForm" class="@unless($errors->any()) hidden @endunless">
                        {{-- ... Konten Form Edit (Tidak Berubah) ... --}}
                        <form method="POST" action="{{ route('member.update-profile') }}" id="profileUpdateForm">
                            @csrf

                            <div class="flex flex-col sm:flex-row sm:space-x-8">
                                <div class="flex-shrink-0 mb-4 sm:mb-0 w-24 sm:w-32">
                                    <div class="flex-shrink-0 mb-4 sm:mb-0 flex flex-col items-center">
                                        <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-gray-200 overflow-hidden border-4 border-gray-100 shadow-inner">
                                            <img src="{{ $avatarUrl }}" alt="Foto Profil {{ $customer->full_name }}" class="object-cover w-full h-full">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-grow space-y-4">
                                    <div class="mb-4">
                                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                        <input type="text" id="full_name" name="full_name"
                                            value="{{ old('full_name', $customer->full_name) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('full_name') border-red-500 @enderror"
                                            required>
                                        @error('full_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                                        <input type="email" id="email" name="email"
                                            value="{{ old('email', $customer->email) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                            required>
                                        @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                        <input type="tel" id="phone" name="phone"
                                            value="{{ old('phone', $customer->phone) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror">
                                        @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                        <input type="password" id="password" name="password"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                                        @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-start space-x-3 pt-4 border-t border-gray-100">
                                        <button type="submit"
                                            class="py-2 px-6 text-white bg-primary rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                            Simpan Perubahan
                                        </button>
                                        <button type="button" id="cancelEditFormBtn"
                                            class="py-2 px-6 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-150">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    <h2 class="text-xl font-extrabold text-gray-800 mb-6 border-b pb-3">Riwayat Transaksi Terakhir (3) 🛒</h2>

                    <div class="space-y-4">
                        @forelse ($latestOrders as $order)
                        @php
                        $itemCount = $order->items->count();
                        $visibleItems = $order->items->take(3);
                        $hiddenItemCount = $itemCount > 3 ? $itemCount - 3 : 0;

                        $statusClass = [
                        'completed' => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'shipped' => 'bg-blue-100 text-blue-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        'failed' => 'bg-red-100 text-red-800',
                        ];
                        $statusText = ucfirst($order->status);
                        $actionLink = route('member.transactions.show', $order->id);
                        $actionText = 'Lihat Detail';
                        $actionClass = 'text-primary hover:underline';

                        if ($order->status == 'pending') {
                        $actionText = 'Bayar Sekarang';
                        $actionClass = 'text-red-600 hover:underline';
                        } elseif ($order->status == 'shipped') {
                        $actionText = 'Lacak Pengiriman';
                        $actionClass = 'text-blue-600 hover:underline';
                        }
                        @endphp

                        <div class="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">

                            <div class="flex justify-between items-start border-b pb-2 mb-3">
                                <div>
                                    <p class="text-xs text-gray-500">ID Transaksi & Tanggal</p>
                                    <p class="font-bold text-sm text-gray-800">{{ $order->order_no }} <span class="text-gray-400 font-normal">| {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</span></p>
                                </div>
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass[$order->status] ?? 'bg-gray-100 text-gray-800' }} flex-shrink-0">{{ $statusText }}</span>
                            </div>

                            <div class="flex space-x-4">

                                <div class="flex-shrink-0 flex items-center space-x-1">
                                    @foreach ($visibleItems as $index => $item)
                                    @php
                                    $imgUrl = env('APP_URL_BE') . $item->product->images->where('is_main', true)->first()->url?: 'https://via.placeholder.com/50?text=No+Image';
                                    @endphp
                                    <div class="w-12 h-12 rounded-md overflow-hidden bg-gray-100 border border-gray-200">
                                        <img src="{{ $imgUrl }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                    </div>
                                    @endforeach

                                    @if ($hiddenItemCount > 0)
                                    <div class="w-12 h-12 rounded-md bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 border border-gray-300">
                                        +{{ $hiddenItemCount }}
                                    </div>
                                    @endif

                                    @if ($itemCount == 0)
                                    <div class="w-12 h-12 rounded-md bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 border border-gray-300">
                                        Kosong
                                    </div>
                                    @endif
                                </div>

                                <div class="flex-grow space-y-1">
                                    @forelse ($order->items->take(2) as $index => $item)
                                    <p class="text-sm font-bold text-gray-800">
                                        {{ $item->product_name }}
                                        @if ($item->variant_name)
                                        <span class="text-xs font-medium text-gray-500">({{ $item->variant_name }})</span>
                                        @endif
                                    </p>
                                    @empty
                                    <p class="text-sm text-gray-500 italic">Tidak ada detail produk.</p>
                                    @endforelse

                                    @if ($itemCount > 2)
                                    <p class="text-xs text-gray-600 font-semibold pt-1 border-t border-gray-100">
                                        dan **{{ $itemCount - 2 }} produk** lainnya.
                                    </p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                                <p class="text-sm font-bold text-gray-700">Total: <span class="text-lg text-primary">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span></p>

                                <a href="{{ $actionLink }}" class="{{ $actionClass }} font-semibold text-sm">
                                    {{ $actionText }} <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5 text-gray-500">
                            <i class="fas fa-box-open text-3xl mb-2"></i>
                            <p>Belum ada riwayat transaksi.</p>
                        </div>
                        @endforelse

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

@push('scripts')
<script>
    // Pastikan jQuery sudah dimuat sebelum kode ini berjalan
    $(document).ready(function() {
        const detailsDiv = $('#profileDetails');
        const formDiv = $('#editProfileForm');
        const showBtn = $('#showEditFormBtn');
        const cancelBtn = $('#cancelEditFormBtn');

        // Fungsi untuk menampilkan form dan menyembunyikan detail (dengan animasi slide)
        function showEditForm() {
            detailsDiv.slideUp(300, function() {
                formDiv.slideDown(300);
            });
        }

        // Fungsi untuk menampilkan detail dan menyembunyikan form (dengan animasi slide)
        function showDetails() {
            formDiv.slideUp(300, function() {
                detailsDiv.slideDown(300);
            });
        }

        // Event saat tombol 'Edit Profil' diklik
        showBtn.on('click', function() {
            showEditForm();
        });

        // Event saat tombol 'Batal' diklik
        cancelBtn.on('click', function() {
            showDetails();
        });

        // Penanganan Error Laravel: Buka Form Secara Otomatis
        // Jika formDiv terlihat saat DOMContentLoaded (karena ada error validasi),
        // pastikan detailsDiv disembunyikan.
        if (formDiv.is(':visible')) {
            detailsDiv.hide();
        }
    });
</script>
@endpush
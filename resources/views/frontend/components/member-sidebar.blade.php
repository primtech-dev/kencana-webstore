@props(['activeMenu'])

@php
    // Definisikan fungsi helper untuk menentukan apakah link ini aktif
    $isActive = function($menuKey) use ($activeMenu) {
        return $menuKey === $activeMenu;
    };
    // --- Styling untuk Sidebar Vertikal (Desktop) ---
    $baseSidebarClass = 'flex items-center p-3 font-semibold rounded-lg transition ';
    $activeSidebarClass = $baseSidebarClass . 'text-primary font-bold bg-primary-50 hover:bg-primary-100/70';
    $inactiveSidebarClass = $baseSidebarClass . 'text-gray-600 hover:bg-gray-50 hover:text-primary';
    $logoutSidebarClass = $baseSidebarClass . 'text-red-600 hover:bg-red-50 hover:text-red-700';

    // --- Styling untuk Tab Horizontal (Mobile) ---
    $baseTabClass = 'flex items-center justify-center whitespace-nowrap px-4 py-3 border-b-2 font-bold transition duration-300 ';
    $activeTabClass = $baseTabClass . 'text-primary border-primary';
    $inactiveTabClass = $baseTabClass . 'text-gray-600 border-transparent hover:border-gray-300 hover:text-primary';
@endphp

{{-- ========================================================== --}}
{{-- 1. DESKTOP SIDEBAR (Tampil di lg ke atas) --}}
{{-- ========================================================== --}}
<div class="hidden lg:block bg-white p-4 rounded-lg shadow-md lg:sticky lg:top-8">
    <h2 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">Menu Member</h2>
    
    <nav class="space-y-1">
        
        <a href="{{ route('member.index') }}" class="{{ $isActive('profile') ? $activeSidebarClass : $inactiveSidebarClass }}">
            <i class="fas fa-user-circle w-5 mr-3"></i> <span>Profil Saya</span>
        </a>
        <a href="{{route('member.addresses.index')}}" class="{{ $isActive('daftar-alamat') ? $activeSidebarClass : $inactiveSidebarClass }}">
            <i class="fas fa-map-marked-alt w-5 mr-3"></i> <span>Daftar Alamat</span>
        </a>
        <a href="{{ route('history.transactions.index') }}" class="{{ $isActive('transaksi') ? $activeSidebarClass : $inactiveSidebarClass }}">
            <i class="fas fa-history w-5 mr-3"></i> <span>Riwayat Transaksi</span>
        </a>
        <a href="{{ url('/wishlist') }}" class="{{ $isActive('wishlist') ? $activeSidebarClass : $inactiveSidebarClass }}">
            <i class="fas fa-heart w-5 mr-3"></i> <span>Wishlist</span>
        </a>
        <a href="{{ url('/point-rewards') }}" class="{{ $isActive('point-rewards') ? $activeSidebarClass : $inactiveSidebarClass }}">
            <i class="fas fa-medal w-5 mr-3"></i> <span>Poin & Rewards</span>
        </a>

        <form action="{{ route('customer.logout') }}" method="POST" class="mt-2 block">
            @csrf
            <button type="submit" aria-label="Keluar dari Akun" class="{{ $logoutSidebarClass }} w-full text-left">
                <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                <span>Keluar</span>
            </button>
        </form>
    </nav>
</div>


{{-- ========================================================== --}}
{{-- 2. MOBILE TAB MENU (Tampil di mobile, disembunyikan di lg ke atas) --}}
{{-- ========================================================== --}}
{{-- Tambahkan w-full dan overflow-hidden di wrapper untuk mencegah scroll halaman --}}
<div class="block lg:hidden bg-white shadow-md rounded-lg p-0 w-full overflow-hidden">
    {{-- Tambahkan class 'no-scrollbar' untuk menyembunyikan scrollbar pada nav --}}
    <nav class="flex overflow-x-auto overflow-y-hidden text-sm no-scrollbar">
        
        {{-- Link: Profil Saya --}}
        <a href="{{ route('member.index') }}" class="{{ $isActive('profile') ? $activeTabClass : $inactiveTabClass }}">
            <i class="fas fa-user-circle mr-2"></i> <span>Profil</span>
        </a>
        
        {{-- Link: Daftar Alamat --}}
        <a href="{{route('member.addresses.index')}}" class="{{ $isActive('daftar-alamat') ? $activeTabClass : $inactiveTabClass }}">
            <i class="fas fa-map-marked-alt mr-2"></i> <span>Alamat</span>
        </a>

        {{-- Link: Riwayat Transaksi --}}
        <a href="{{ route('history.transactions.index') }}" class="{{ $isActive('transaksi') ? $activeTabClass : $inactiveTabClass }}">
            <i class="fas fa-history mr-2"></i> <span>Transaksi</span>
        </a>

        {{-- Link: Wishlist --}}
        <a href="{{ url('/wishlist') }}" class="{{ $isActive('wishlist') ? $activeTabClass : $inactiveTabClass }}">
            <i class="fas fa-heart mr-2"></i> <span>Wishlist</span>
        </a>
        
        {{-- Link: Poin & Rewards --}}
        <a href="{{ url('/point-rewards') }}" class="{{ $isActive('point-rewards') ? $activeTabClass : $inactiveTabClass }}">
            <i class="fas fa-medal mr-2"></i> <span>Rewards</span>
        </a>

        {{-- Logout di Mobile (sebagai Tab) --}}
        <form action="{{ route('customer.logout') }}" method="POST" class="flex items-center">
            @csrf
            <button type="submit" class="text-red-600 px-4 py-3 font-bold flex items-center whitespace-nowrap hover:bg-red-50 transition">
                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
            </button>
        </form>
    </nav>
</div>

<style>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}

.no-scrollbar {
    -ms-overflow-style: none; /* IE and Edge legacy */
    scrollbar-width: none; /* Firefox */
}
</style>
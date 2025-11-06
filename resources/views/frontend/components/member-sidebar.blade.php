
@props(['activeMenu'])

@php
    // Definisikan fungsi helper untuk menentukan apakah link ini aktif
    $isActive = function($menuKey) use ($activeMenu) {
        return $menuKey === $activeMenu;
    };

    // Kelas dasar untuk semua link
    $baseClass = 'flex items-center p-3 font-semibold rounded-lg transition ';

    // Kelas untuk link aktif
    $activeClass = $baseClass . 'text-primary font-bold bg-primary-50 hover:bg-primary-100/70';

    // Kelas untuk link tidak aktif
    $inactiveClass = $baseClass . 'text-gray-600 hover:bg-gray-50 hover:text-primary';
@endphp

<div class="bg-white p-4 rounded-lg shadow-md  lg:sticky lg:top-8">
    <h2 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">Menu Member</h2>
    
    <nav class="space-y-1">
        
        {{-- Link: Profil Saya --}}
        <a href="{{ url('/profile') }}" class="{{ $isActive('profile') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-user-circle w-5 mr-3"></i>
            <span>Profil Saya</span>
        </a>
        
        {{-- Link: Riwayat Transaksi --}}
        <a href="{{ url('/transaksi') }}" class="{{ $isActive('transaksi') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-history w-5 mr-3"></i>
            <span>Riwayat Transaksi</span>
        </a>

        {{-- Link: Daftar Alamat --}}
        <a href="{{ url('/daftar-alamat') }}" class="{{ $isActive('daftar-alamat') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-map-marked-alt w-5 mr-3"></i>
            <span>Daftar Alamat</span>
        </a>

        {{-- Link: Wishlist --}}
        <a href="{{ url('/wishlist') }}" class="{{ $isActive('wishlist') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-heart w-5 mr-3"></i>
            <span>Wishlist</span>
        </a>
        
        {{-- Link: Poin & Rewards (Baru Ditambahkan) --}}
        <a href="{{ url('/point-rewards') }}" class="{{ $isActive('point-rewards') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-medal w-5 mr-3"></i>
            <span>Poin & Rewards</span>
        </a>

        <div class="pt-2 border-t mt-2">
             {{-- Link: Keluar --}}
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
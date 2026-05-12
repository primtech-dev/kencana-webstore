@extends('frontend.components.layout')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Utility & Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e2e2;
        border-radius: 10px;
    }

    #storeMap {
        height: 400px;
        width: 100%;
        border-radius: 1.5rem;
        z-index: 1;
    }

    /* Custom Marker Styling */
    .custom-marker-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pin-container {
        width: 50px;
        height: 50px;
        background: #EF4444;
        /* Tailwind Red-500 */
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        border: 2px solid white;
    }

    .pin-container img {
        width: 30px;
        height: 30px;
        object-fit: contain;
        transform: rotate(45deg);
        border-radius: 50%;
    }

    @media (min-width: 1024px) {
        #storeMap {
            height: 600px;
        }
    }

    @media (max-width: 1023px) {
        .mobile-slider {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap: 1rem;
            padding-bottom: 1rem;
        }

        .branch-card {
            min-width: 85%;
            scroll-snap-align: center;
        }
    }
</style>

<main class="container px-4 lg:px-[7%] mx-auto mt-8 mb-12">
    <div class="mb-8 ms-2">
        <h1 class="text-2xl font-black text-dark-grey uppercase">Daftar Cabang Kami</h1>
        <!-- <p class="text-gray-500 text-sm">Terdeteksi <b>{{ count($branches) }}</b> lokasi aktif.</p> -->
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Map Container --}}
        <div class="lg:col-span-2 order-1 lg:order-2">
            <div id="storeMap" class="shadow-lg border border-gray-100"></div>
        </div>

        {{-- Sidebar List --}}
        <div class="lg:col-span-1 order-2 lg:order-1">
            <div class="mobile-slider lg:space-y-4 lg:max-h-[600px] lg:overflow-y-auto lg:block pr-2 custom-scrollbar">
                @forelse($AllBranchesData as $branch)
                <div class="branch-card bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-red-500 transition cursor-pointer group"
                    onclick="focusStore({{ $branch->latitude }}, {{ $branch->longitude }}, '{{ $branch->id }}')">

                    <div class="flex justify-between items-start mb-2">
                        <span class="text-[10px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded uppercase">
                            {{ $branch->code }}
                        </span>
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $branch->latitude }},{{ $branch->longitude }}"
                            target="_blank"
                            class="text-gray-400 hover:text-blue-600"
                            onclick="event.stopPropagation();">
                            <i class="fas fa-directions text-lg"></i>
                        </a>
                    </div>

                    <h3 class="font-bold text-gray-800 group-hover:text-red-600 transition uppercase">{{ $branch->name }}</h3>

                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                        <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                        {{ $branch->address }}, {{ $branch->city }}
                    </p>

                    <div class="flex items-center mt-3 pt-3 border-t border-gray-50">
                        <i class="fas fa-phone-alt text-[10px] text-gray-400 mr-2"></i>
                        <span class="text-xs text-gray-600 font-medium">{{ $branch->phone ?? '-' }}</span>
                    </div>
                </div>
                @empty
                <div class="w-full text-center py-10 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-400">Toko tidak ditemukan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</main>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    let map;
    let markers = {};

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Map
        map = L.map('storeMap', {
            scrollWheelZoom: false,
            zoomControl: true
        }).setView([-2.5489, 118.0149], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const storeIcon = L.divIcon({
            className: 'custom-marker-wrapper',
            html: `<div class="pin-container"><img src="{{ asset('asset/Kencana Store Putih.png') }}" alt="logo"></div>`,
            iconSize: [50, 50],
            iconAnchor: [25, 50],
            popupAnchor: [0, -50]
        });

        const branchMarkers = [];

        // Data Injection from Laravel
        const branches = @json($branches);

        branches.forEach(branch => {
            if (branch.latitude && branch.longitude) {
                const marker = L.marker([branch.latitude, branch.longitude], {
                        icon: storeIcon
                    })
                    .addTo(map)
                    .bindPopup(`
                        <div style="min-width:180px; padding:5px;">
                            <b style="color:#DC2626; text-transform:uppercase; font-size:14px;">${branch.name}</b><br>
                            <p style="font-size:12px; color:#4B5563; margin: 8px 0;">${branch.address}</p>
                            <a href="https://www.google.com/maps/dir/?api=1&destination=${branch.latitude},${branch.longitude}" 
                               target="_blank" 
                               style="display:inline-block; background:#DC2626; color:white; padding:5px 10px; border-radius:5px; font-size:10px; text-decoration:none; font-weight:bold;">
                                PETUNJUK ARAH
                            </a>
                        </div>
                    `);

                markers[branch.id] = marker;
                branchMarkers.push(marker);
            }
        });

        // Auto Zoom to fit all markers
        if (branchMarkers.length > 0) {
            const group = new L.featureGroup(branchMarkers);
            map.fitBounds(group.getBounds().pad(0.2));
        }

        // Fix Leaflet rendering bug in hidden containers
        setTimeout(() => map.invalidateSize(), 500);
    });

    function focusStore(lat, lng, id) {
        map.flyTo([lat, lng], 16, {
            animate: true,
            duration: 1.5
        });

        if (markers[id]) {
            setTimeout(() => markers[id].openPopup(), 1200);
        }

        if (window.innerWidth < 1024) {
            document.getElementById('storeMap').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
</script>
@endsection
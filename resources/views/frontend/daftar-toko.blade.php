@extends('frontend.components.layout')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e2e2; border-radius: 10px; }
    
    #storeMap {
        height: 400px; /* Ukuran lebih kecil untuk mobile */
        width: 100%;
        border-radius: 1.5rem;
        z-index: 1;
    }

    @media (min-width: 1024px) {
        #storeMap { height: 600px; }
    }

    /* Styling khusus Slider Mobile */
    @media (max-width: 1023px) {
        .mobile-slider {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap: 1rem;
            padding-bottom: 1rem;
            -webkit-overflow-scrolling: touch;
        }
        .branch-card {
            min-width: 85%; /* Supaya kartu berikutnya terlihat sedikit */
            scroll-snap-align: center;
        }
    }
</style>

<main class="container px-4 lg:px-[7%] mx-auto mt-8 mb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-black text-dark-grey uppercase">Daftar Cabang Kami</h1>
            <p class="text-gray-500 text-sm">Temukan toko terdekat di kota Anda.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 order-1 lg:order-2 relative">
            <div id="storeMap" class="shadow-lg border border-gray-100"></div>
        </div>

        <div class="lg:col-span-1 order-2 lg:order-1">
            <div class="mobile-slider lg:space-y-4 lg:max-h-[600px] lg:overflow-y-auto lg:block pr-2 custom-scrollbar">
                @forelse($branches as $branch)
                <div class="branch-card bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-primary transition cursor-pointer group"
                     onclick="focusStore({{ $branch->latitude }}, {{ $branch->longitude }}, '{{ $branch->id }}')">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded uppercase">
                            {{ $branch->code }}
                        </span>
                        <a href="https://www.google.com/maps?q={{ $branch->latitude }},{{ $branch->longitude }}" 
                           target="_blank" class="text-gray-400 hover:text-blue-500" onclick="event.stopPropagation();">
                            <i class="fas fa-directions text-lg"></i>
                        </a>
                    </div>
                    <h3 class="font-bold text-gray-800 group-hover:text-primary transition uppercase">{{ $branch->name }}</h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                        <i class="fas fa-map-marker-alt text-red-500 mr-1"></i> {{ $branch->address }}, {{ $branch->city }}
                    </p>
                    <div class="flex items-center mt-3 pt-3 border-t border-gray-50">
                        <i class="fas fa-phone-alt text-[10px] text-gray-400 mr-2"></i>
                        <span class="text-xs text-gray-600 font-medium">{{ $branch->phone }}</span>
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
        map = L.map('storeMap', {
            scrollWheelZoom: false
        }).setView([-2.5489, 118.0149], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const storeIcon = L.icon({
            iconUrl: '{{asset("asset/Kencana Store.png")}}', 
            iconSize: [45, 38],
            iconAnchor: [19, 38],
            popupAnchor: [0, -38]
        });

        const branchMarkers = [];

        @foreach($branches as $branch)
            @if($branch->latitude && $branch->longitude)
                (function() {
                    const lat = {{ $branch->latitude }};
                    const lng = {{ $branch->longitude }};
                    const id = '{{ $branch->id }}';
                    const name = '{{ $branch->name }}';

                    const marker = L.marker([lat, lng], { icon: storeIcon })
                        .addTo(map)
                        .bindPopup(`
                            <div style="min-width:150px">
                                <b style="color:#2563eb; text-transform:uppercase;">${name}</b><br>
                                <p style="font-size:11px; color:#4b5563; margin: 5px 0;">{{ $branch->address }}</p>
                                <a href="https://www.google.com/maps?q=${lat},${lng}" target="_blank" 
                                   style="color:#2563eb; font-weight:bold; font-size:10px; text-decoration:none;">
                                   PETUNJUK ARAH →
                                </a>
                            </div>
                        `);
                    
                    markers[id] = marker;
                    branchMarkers.push(marker);
                })();
            @endif
        @endforeach

        if (branchMarkers.length > 0) {
            const group = new L.featureGroup(branchMarkers);
            map.fitBounds(group.getBounds().pad(0.1));
        }

        setTimeout(() => {
            map.invalidateSize();
        }, 500);
    });

    function focusStore(lat, lng, id) {
        map.flyTo([lat, lng], 16, {
            animate: true,
            duration: 1.5
        });

        if (markers[id]) {
            setTimeout(() => {
                markers[id].openPopup();
            }, 1200);
        }

        // Scroll ke atas (peta) saat kartu diklik di mobile
        if (window.innerWidth < 1024) {
            window.scrollTo({
                top: document.getElementById('storeMap').offsetTop - 20,
                behavior: 'smooth'
            });
        }
    }
</script>
@endsection
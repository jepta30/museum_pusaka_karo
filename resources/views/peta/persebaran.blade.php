@extends('layouts.public')

@section('title', 'Peta Persebaran')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    .page-hero {
        position: relative;
        overflow: hidden;
        padding: 64px 0 56px;
        background: linear-gradient(135deg, rgba(122,27,27,0.95) 0%, rgba(236,139,95,0.95) 100%);
        color: white;
    }

    .page-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top left, rgba(255,255,255,0.18), transparent 34%),
                    radial-gradient(circle at bottom right, rgba(255,255,255,0.12), transparent 28%);
        pointer-events: none;
    }

    .hero-card {
        position: relative;
        z-index: 1;
        max-width: 860px;
        margin: 0 auto;
        text-align: center;
    }

    .hero-card h1 {
        font-size: clamp(2.75rem, 4vw, 4rem);
        line-height: 1.05;
        letter-spacing: -0.04em;
    }

    .hero-card p {
        max-width: 720px;
        margin: 24px auto 0;
        color: rgba(255,255,255,0.9);
        font-size: 1rem;
        line-height: 1.8;
    }

    #mapPersebaran {
        width: 100%;
        min-height: 520px;
    }

    .glass-panel {
        background: rgba(255, 255, 255, 0.82);
        backdrop-filter: blur(18px);
        border: 1px solid rgba(255, 255, 255, 0.64);
        box-shadow: 0 30px 80px rgba(15, 23, 42, 0.12);
    }

    .info-headline {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(250, 215, 127, 0.18);
        color: #7a1b1b;
        padding: 8px 14px;
        border-radius: 999px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .stat-grid {
        display: grid;
        gap: 16px;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .stat-card {
        border-radius: 24px;
        background: #ffffff;
        padding: 22px 24px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
    }

    .stat-card h3 {
        font-size: 2rem;
        color: #7a1b1b;
        margin-bottom: 6px;
    }

    .stat-card span {
        display: block;
        color: #475569;
        font-size: 0.95rem;
    }

    .detail-card {
        border-radius: 32px;
        padding: 32px;
    }

    .detail-card h3 {
        margin-bottom: 18px;
    }

    .detail-card ul {
        display: grid;
        gap: 14px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .detail-card li {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        padding: 16px;
        background: rgba(247, 247, 247, 0.9);
        border-radius: 18px;
        color: #334155;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .detail-card li:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
    }

    .detail-card li::before {
        content: '•';
        color: #d97706;
        font-size: 1.5rem;
        line-height: 1;
        margin-top: 2px;
    }

    .map-item-content {
        flex: 1;
    }

    .btn-direction {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 14px;
        border-radius: 999px;
        background: #7a1b1b;
        color: #fff;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .btn-direction:hover {
        background: #5c1010;
        transform: translateY(-1px);
    }

    .map-caption {
        color: #64748b;
        margin-top: 10px;
        font-size: 0.95rem;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 22px;
        border-radius: 999px;
        background: #7a1b1b;
        color: white;
        font-weight: 700;
        transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
        text-decoration: none;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 18px 40px rgba(122, 27, 27, 0.22);
        background: #5c1010;
    }

    @media (max-width: 992px) {
        .page-hero {
            padding: 44px 0 40px;
        }

        .stat-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .glass-panel {
            border-radius: 28px;
        }

        .detail-card {
            padding: 24px;
        }
    }
</style>
@endpush

@section('content')
<section class="page-hero">
    <div class="container mx-auto px-6 lg:px-20">
        <div class="hero-card">
            <div class="info-headline">Peta Persebaran</div>
            <h1>Temukan lokasi museum dan warisan budaya Karo secara visual.</h1>
            <p>Jelajahi peta interaktif kami untuk melihat titik persebaran museum, lokasi budaya, dan informasi penting dalam satu tampilan modern.</p>
        </div>
    </div>
</section>

<section class="py-16 bg-slate-50">
    <div class="container mx-auto px-6 lg:px-20">
        <div class="grid gap-10 lg:grid-cols-[1.45fr_0.95fr]">
            <div class="glass-panel overflow-hidden">
                <div class="relative">
                    <div class="absolute top-6 left-6 rounded-full bg-white/90 px-4 py-3 text-sm font-semibold text-slate-900 shadow-lg backdrop-blur-sm">
                        Museum Pusaka Karo
                    </div>
                    <div id="mapPersebaran"></div>
                </div>
                <div class="px-8 py-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.24em] text-orange-600">Interaktif & Real-time</p>
                            <h2 class="mt-3 text-3xl font-semibold text-slate-900">Peta lokasi dan budaya.</h2>
                        </div>
                        <div class="text-sm text-slate-500">Klik marker untuk detail lokasi.</div>
                    </div>
                    <p class="map-caption">Peta ini dibuat untuk membantu pengunjung memahami sebaran lokasi museum dan tempat penting warisan budaya Karo.</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="glass-panel detail-card">
                    <h3 class="text-2xl font-semibold text-slate-900">Informasi Lokasi</h3>
                    <p class="text-slate-600 mb-6">Museum Pusaka Karo berada di pusat Berastagi dengan akses mudah menuju objek budaya terdekat.</p>
                    <div class="stat-grid">
                        <div class="stat-card">
                            <h3>3.12095</h3>
                            <span>Latitude Museum</span>
                        </div>
                        <div class="stat-card">
                            <h3>98.42346</h3>
                            <span>Longitude Museum</span>
                        </div>
                        <div class="stat-card">
                            <h3>Berastagi</h3>
                            <span>Kabupaten Karo</span>
                        </div>
                        <div class="stat-card">
                            <h3>{{ $warisans->count() }}</h3>
                            <span>Titik Warisan Budaya</span>
                        </div>
                    </div>
                </div>
                <div class="glass-panel detail-card">
                    <h3 class="text-2xl font-semibold text-slate-900">Titik Warisan Budaya</h3>
                    <ul>
                        @forelse($markerPoints as $point)
                            <li class="map-item" data-index="{{ $loop->index }}" data-coords="{{ implode(',', $point['coords']) }}">
                                <div class="map-item-content">
                                    <h4 class="text-lg font-semibold text-slate-900">{{ $point['judul'] }}</h4>
                                    <p class="text-slate-600">{{ $point['lokasi'] }}</p>
                                </div>
                                <a href="https://www.google.com/maps/dir/?api=1&origin=3.12095,98.42346&destination={{ implode(',', $point['coords']) }}&travelmode=driving" target="_blank" rel="noopener" class="btn-direction" onclick="event.stopPropagation()">
                                    Arahkan
                                </a>
                            </li>
                        @empty
                            <li>
                                <div>
                                    <p class="text-slate-600">Belum ada data warisan budaya untuk ditampilkan.</p>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="glass-panel detail-card text-center">
                    <a href="{{ route('home') }}" class="btn-primary">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const center = [3.12095, 98.42346];
        const map = L.map('mapPersebaran', {
            zoomControl: true,
            attributionControl: false,
        }).setView(center, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        const museumMarker = L.marker(center).addTo(map);
        museumMarker.bindPopup(`
            <div style="font-weight:700; margin-bottom: 6px;">Museum Pusaka Karo</div>
            <div style="font-size:0.95rem; color:#475569;">Jl. Perwira No. 3, Gundaling I, Berastagi</div>
        `).openPopup();

        L.circle(center, {
            color: '#d97706',
            fillColor: '#fef3c7',
            fillOpacity: 0.35,
            radius: 550,
        }).addTo(map);

        const points = @json($markerPoints);
        const markers = [museumMarker];
        const pointMarkers = [];

        points.forEach(function(point) {
            const marker = L.marker(point.coords).addTo(map);
            marker.bindPopup(`
                <div style="font-weight:700; margin-bottom: 6px;">${point.judul}</div>
                <div style="font-size:0.95rem; color:#475569; margin-bottom: 10px;">${point.lokasi}</div>
                <a href="https://www.google.com/maps/dir/?api=1&origin=${center.join(',')}&destination=${point.coords.join(',')}&travelmode=driving" target="_blank" rel="noopener" style="display:inline-flex; padding:8px 12px; border-radius:999px; background:#7a1b1b; color:#fff; text-decoration:none; font-size:0.95rem; font-weight:700;">
                    Arahkan
                </a>
            `);
            markers.push(marker);
            pointMarkers.push(marker);
        });

        if (markers.length > 0) {
            const group = L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.18));
        }

        const mapItems = document.querySelectorAll('.map-item');
        mapItems.forEach(function(item, index) {
            item.addEventListener('click', function () {
                const marker = pointMarkers[index];
                if (!marker) return;
                marker.openPopup();
                map.setView(marker.getLatLng(), 14, {
                    animate: true,
                });
            });
        });
    });
</script>
@endpush

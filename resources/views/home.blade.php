@extends('layouts.public')

@section('title', 'Beranda')

@push('styles')
<style>
    /* HERO SECTION */
    .hero-section {
        background: linear-gradient(135deg, var(--dark-red) 0%, var(--primary-red) 100%);
        padding: 80px 5% 140px;
        position: relative;
        overflow: hidden;
    }
    
    /* Subtle geometric pattern for hero background */
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 40px;
        background-image: linear-gradient(45deg, rgba(255,255,255,0.05) 25%, transparent 25%), 
                          linear-gradient(-45deg, rgba(255,255,255,0.05) 25%, transparent 25%), 
                          linear-gradient(45deg, transparent 75%, rgba(255,255,255,0.05) 75%), 
                          linear-gradient(-45deg, transparent 75%, rgba(255,255,255,0.05) 75%);
        background-size: 20px 20px;
        background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
    }
    
    .hero-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 50px;
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }
    
    .hero-content {
        flex: 1;
        color: white;
    }
    
    .hero-badge {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--gold);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .hero-badge::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--gold);
    }
    
    .hero-title {
        font-size: 46px;
        line-height: 1.1;
        margin-bottom: 25px;
        color: var(--cream);
    }
    
    .hero-desc {
        font-size: 15px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 40px;
        max-width: 480px;
    }
    
    /* Search Bar in Hero (from Image 1 concept) */
    .hero-search {
        display: flex;
        background: white;
        border-radius: 4px;
        overflow: hidden;
        max-width: 480px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    
    .hero-search input {
        flex: 1;
        padding: 15px 20px;
        border: none;
        outline: none;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
    }
    
    .hero-search button {
        background-color: #000;
        color: white;
        border: none;
        padding: 0 35px;
        font-weight: 600;
        font-size: 14px;
        letter-spacing: 1px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .hero-search button:hover {
        background-color: #222;
    }
    
    .hero-image {
        flex: 1;
        display: flex;
        justify-content: flex-end;
    }
    
    .hero-image-frame {
        width: 100%;
        max-width: 500px;
        height: 380px;
        background-color: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.5);
        font-size: 14px;
        letter-spacing: 1px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }
    
    .hero-image-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* STATS CARD (Floating over hero) */
    .stats-wrapper {
        max-width: 1100px;
        margin: -80px auto 60px;
        position: relative;
        z-index: 10;
        padding: 0 20px;
    }
    
    .stats-card {
        background-color: var(--cream);
        border-radius: 12px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        display: flex;
        justify-content: space-between;
        padding: 40px 0;
    }
    
    .stat-item {
        flex: 1;
        text-align: center;
        border-right: 1px solid rgba(0,0,0,0.05);
    }
    
    .stat-item:last-child {
        border-right: none;
    }
    
    .stat-number {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        font-weight: 700;
        color: var(--primary-red);
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 11px;
        font-weight: 500;
        color: var(--text-gray);
    }

    /* KATEGORI BUDAYA SECTION */
    .section {
        padding: 40px 5% 60px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 700;
        color: var(--text-dark);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .link-all {
        font-size: 13px;
        color: var(--text-gray);
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .link-all:hover {
        color: var(--primary-red);
    }
    
    .category-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
    }
    
    .category-card {
        background-color: white;
        border: 1px solid #e2e8f0;
        padding: 30px 15px;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        color: var(--text-dark);
    }
    
    .category-card:hover {
        border-color: var(--primary-red);
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    
    .category-icon {
        font-size: 32px;
        margin-bottom: 15px;
        color: var(--text-dark);
    }
    
    .category-name {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* MAP SECTION */
    .map-section {
        display: flex;
        gap: 50px;
        align-items: center;
        padding-top: 40px;
        border-top: 1px solid #e2e8f0;
        margin-top: 40px;
    }
    
    .map-content {
        flex: 1;
    }
    
    .map-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .map-desc {
        font-size: 14px;
        color: var(--text-gray);
        margin-bottom: 30px;
        line-height: 1.6;
    }
    
    .btn-map {
        display: inline-block;
        padding: 12px 25px;
        border: 2px solid var(--text-dark);
        background: transparent;
        color: var(--text-dark);
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .btn-map:hover {
        background-color: var(--text-dark);
        color: white;
    }
    
    .map-image {
        flex: 1.5;
        background-color: #f1f5f9;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }
    
    .map-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.8;
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-content">
            <div class="hero-badge">MUSEUM PUSAKA KARO • KABANJAHE</div>
            <h1 class="hero-title">Menjaga jejak leluhur Karo, agar tak lekang oleh zaman.</h1>
            <p class="hero-desc">Mengenal, melestarikan, dan mendokumentasikan warisan budaya Karo untuk generasi mendatang secara digital.</p>
            
            <form action="{{ route('katalog.index') }}" method="GET" class="hero-search">
                <input type="text" name="q" placeholder="Cari koleksi atau budaya...">
                <button type="submit">CARI</button>
            </form>
        </div>
        
        <div class="hero-image">
            <div class="hero-image-frame">
                <!-- Using a placeholder matching the requested color scheme -->
                <img src="https://via.placeholder.com/600x400/5C1010/FFFFFF?text=Ilustrasi+Koleksi+Unggulan" alt="Hero Image">
            </div>
        </div>
    </div>
</section>

<!-- Floating Stats Card -->
<div class="stats-wrapper">
    <div class="stats-card">
        <div class="stat-item">
            <div class="stat-number">{{ $totalWarisan }}</div>
            <div class="stat-label">Warisan Terdokumentasi</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $totalKategori }}</div>
            <div class="stat-label">Kategori Budaya</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $totalTitik }}</div>
            <div class="stat-label">Titik Persebaran</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $totalKabupaten }}</div>
            <div class="stat-label">Kabupaten/Kota</div>
        </div>
    </div>
</div>

<!-- Category Section -->
<section class="section">
    <div class="section-header">
        <h2 class="section-title">Kategori Budaya</h2>
        <a href="{{ route('katalog.index') }}" class="link-all">Lihat Semua ></a>
    </div>
    
    <div class="category-grid">
        @php
            // Fallback icons if not set in DB
            $iconMap = [
                'Rumah Adat' => 'fa-house-chimney',
                'Pakaian Adat' => 'fa-shirt',
                'Alat Musik' => 'fa-music',
                'Kuliner' => 'fa-utensils',
                'Tari Tradisional' => 'fa-users'
            ];
        @endphp
        
        @forelse($kategoris as $kat)
            @php
                // Try to find a matching icon based on name, default to fa-box
                $defaultIcon = 'fa-box';
                foreach($iconMap as $key => $iconClass) {
                    if(stripos($kat->nama, $key) !== false) {
                        $defaultIcon = $iconClass;
                        break;
                    }
                }
            @endphp
            <a href="{{ route('katalog.index', ['kategori_id' => $kat->kategori_id]) }}" class="category-card">
                <div class="category-icon">
                    <i class="fa-solid {{ $defaultIcon }}"></i>
                </div>
                <div class="category-name">{{ $kat->nama }}</div>
            </a>
        @empty
            <!-- Demo Categories matching the wireframe -->
            <a href="#" class="category-card">
                <div class="category-icon"><i class="fa-solid fa-house-chimney"></i></div>
                <div class="category-name">RUMAH ADAT</div>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon"><i class="fa-solid fa-shirt"></i></div>
                <div class="category-name">PAKAIAN ADAT</div>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon"><i class="fa-solid fa-music"></i></div>
                <div class="category-name">ALAT MUSIK</div>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon"><i class="fa-solid fa-utensils"></i></div>
                <div class="category-name">KULINER</div>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon"><i class="fa-solid fa-users"></i></div>
                <div class="category-name">TARI TRADISIONAL</div>
            </a>
        @endforelse
    </div>
    
    <!-- Map Section -->
    <div class="map-section">
        <div class="map-content">
            <h2 class="map-title">Peta Museum</h2>
            <p class="map-desc">Temukan lokasi museum kami dan jelajahi tata letak galeri secara virtual sebelum Anda berkunjung.</p>
            <a href="#" class="btn-map">Buka Peta Interaktif</a>
        </div>
        <div class="map-image">
            <img src="https://via.placeholder.com/800x400/f1f5f9/64748b?text=MUSEUM+PUSAKA+KARO+-+SITE+PLAN" alt="Peta Museum">
        </div>
    </div>
</section>

@endsection

@extends('layouts.public')

@section('title', 'Katalog Warisan Budaya')

@push('styles')
<style>
    /* PAGE HEADER */
    .page-banner {
        background-color: var(--primary-red);
        background-image: linear-gradient(135deg, var(--dark-red) 0%, var(--primary-red) 100%);
        padding: 60px 5%;
        text-align: center;
        color: white;
        margin-bottom: 40px;
    }
    
    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .page-subtitle {
        font-size: 15px;
        color: rgba(255,255,255,0.8);
        max-width: 600px;
        margin: 0 auto;
    }

    /* FILTER SECTION */
    .filter-section {
        max-width: 1200px;
        margin: 0 auto 40px;
        padding: 0 5%;
    }
    
    .filter-card {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 20px;
        border-radius: 8px;
        display: flex;
        gap: 15px;
        align-items: flex-end;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .form-group.search { flex: 2; }
    .form-group.category { flex: 1; }
    
    .form-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-gray);
        letter-spacing: 0.5px;
    }
    
    .form-control {
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        outline: none;
    }
    
    .form-control:focus {
        border-color: var(--primary-red);
    }
    
    .btn-filter {
        background-color: var(--text-dark);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .btn-filter:hover {
        background-color: #000;
    }

    /* CATALOG GRID */
    .catalog-container {
        max-width: 1200px;
        margin: 0 auto 80px;
        padding: 0 5%;
    }
    
    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-bottom: 50px;
    }
    
    .cultural-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    
    .cultural-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: #cbd5e1;
    }
    
    .card-image {
        width: 100%;
        height: 220px;
        background-color: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .cultural-card:hover .card-image img {
        transform: scale(1.05);
    }
    
    .card-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-category {
        font-size: 11px;
        font-weight: 600;
        color: var(--primary-red);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }
    
    .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 15px;
        line-height: 1.3;
    }
    
    .card-desc {
        font-size: 14px;
        color: var(--text-gray);
        margin-bottom: 25px;
        line-height: 1.6;
        flex: 1;
    }
    
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f1f5f9;
        padding-top: 15px;
    }
    
    .card-location {
        font-size: 12px;
        color: var(--text-gray);
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .btn-read {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: color 0.2s;
    }
    
    .btn-read:hover {
        color: var(--primary-red);
    }
    
    /* PAGINATION */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    
    .pagination {
        display: flex;
        list-style: none;
        gap: 5px;
    }
    
    .page-item {
        width: 40px;
        height: 40px;
    }
    
    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background-color: white;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        color: var(--text-dark);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .page-link:hover {
        background-color: #f8fafc;
    }
    
    .page-item.active .page-link {
        background-color: var(--primary-red);
        color: white;
        border-color: var(--primary-red);
    }
    
    .page-item.disabled .page-link {
        color: #cbd5e1;
        background-color: #f8fafc;
        cursor: not-allowed;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 8px;
        border: 1px dashed #cbd5e1;
    }
    
    .empty-state i {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 15px;
    }
</style>
@endpush

@section('content')
<!-- Banner -->
<div class="page-banner">
    <h1 class="page-title">Katalog Warisan Budaya</h1>
    <p class="page-subtitle">Jelajahi dan pelajari arsip digital kebudayaan Karo secara lengkap, mulai dari situs bersejarah, tradisi lisan, hingga mahakarya seni.</p>
</div>

<!-- Filter Section -->
<div class="filter-section">
    <form action="{{ route('katalog.index') }}" method="GET" class="filter-card">
        <div class="form-group search">
            <label class="form-label">Cari Nama/Kata Kunci</label>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama warisan...">
        </div>
        
        <div class="form-group category">
            <label class="form-label">Kategori Budaya</label>
            <select name="kategori_id" class="form-control">
                <option value="all">Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->kategori_id }}" {{ request('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn-filter">Terapkan Filter</button>
        </div>
    </form>
</div>

<!-- Catalog Grid -->
<div class="catalog-container">
    <div class="catalog-grid">
        @forelse($warisans as $warisan)
            <article class="cultural-card">
                <div class="card-image">
                    @if($warisan->gambar && Storage::disk('public')->exists($warisan->gambar))
                        <img src="{{ Storage::url($warisan->gambar) }}" alt="{{ $warisan->judul }}">
                    @else
                        <!-- Placeholder -->
                        <img src="https://via.placeholder.com/400x300/f8fafc/9ca3af?text=Tidak+Ada+Gambar" alt="Placeholder">
                    @endif
                </div>
                
                <div class="card-content">
                    <div class="card-category">{{ $warisan->kategori->nama ?? 'Umum' }}</div>
                    <h3 class="card-title">{{ $warisan->judul }}</h3>
                    <p class="card-desc">{{ Str::limit(strip_tags($warisan->deskripsi), 110) }}</p>
                    
                    <div class="card-footer">
                        <div class="card-location">
                            <i class="fa-solid fa-location-dot"></i> {{ $warisan->lokasi }}
                        </div>
                        <a href="{{ route('katalog.show', $warisan->warisan_budaya_id) }}" class="btn-read">Baca <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <i class="fa-regular fa-folder-open"></i>
                <h3>Pencarian Tidak Ditemukan</h3>
                <p style="color: var(--text-gray); margin-top: 10px;">Maaf, tidak ada warisan budaya yang cocok dengan filter pencarian Anda.</p>
                <a href="{{ route('katalog.index') }}" style="display: inline-block; margin-top: 20px; color: var(--primary-red); text-decoration: none; font-weight: 600;">Lihat Semua Koleksi</a>
            </div>
        @endforelse
    </div>
    
    <!-- Custom Pagination Logic -->
    <div class="pagination-wrapper">
        @if ($warisans->hasPages())
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($warisans->onFirstPage())
                    <li class="page-item disabled"><span class="page-link"><i class="fa-solid fa-chevron-left"></i></span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $warisans->previousPageUrl() }}"><i class="fa-solid fa-chevron-left"></i></a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($warisans->links()->elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $warisans->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($warisans->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $warisans->nextPageUrl() }}"><i class="fa-solid fa-chevron-right"></i></a></li>
                @else
                    <li class="page-item disabled"><span class="page-link"><i class="fa-solid fa-chevron-right"></i></span></li>
                @endif
            </ul>
        @endif
    </div>
</div>
@endsection

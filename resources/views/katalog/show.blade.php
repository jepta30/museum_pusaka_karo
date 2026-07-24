@extends('layouts.public')

@section('title', $warisan->judul . ' - Katalog Budaya')

@push('styles')
<style>
    /* HERO DETAIL SECTION */
    .detail-hero {
        position: relative;
        width: 100%;
        height: 50vh;
        min-height: 400px;
        background-color: #1a202c;
        display: flex;
        align-items: flex-end;
        overflow: hidden;
    }
    
    .detail-hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.6;
    }
    
    .detail-hero-content {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 5% 50px;
        color: white;
    }
    
    .detail-category {
        display: inline-block;
        background-color: var(--primary-red);
        color: white;
        padding: 5px 15px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 4px;
        margin-bottom: 15px;
    }
    
    .detail-title {
        font-family: 'Playfair Display', serif;
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 10px;
        line-height: 1.2;
    }
    
    .detail-location {
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255,255,255,0.8);
    }

    /* MAIN CONTENT */
    .detail-container {
        max-width: 1200px;
        margin: -40px auto 60px;
        padding: 0 5%;
        position: relative;
        z-index: 20;
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }
    
    .main-content {
        flex: 2;
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    /* CKEditor Content Styling */
    .article-body {
        font-size: 15px;
        line-height: 1.8;
        color: var(--text-dark);
    }
    
    .article-body p { margin-bottom: 20px; }
    .article-body h2, .article-body h3 {
        font-family: 'Playfair Display', serif;
        margin: 30px 0 15px;
        color: var(--primary-red);
    }
    .article-body img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        margin: 20px 0;
    }
    .article-body ul, .article-body ol { margin: 0 0 20px 20px; }
    
    /* SIDEBAR */
    .sidebar {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    
    .sidebar-widget {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        border: 1px solid #f1f5f9;
    }
    
    .widget-title {
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text-dark);
        border-bottom: 2px solid var(--primary-red);
        padding-bottom: 10px;
        display: inline-block;
    }
    
    .meta-list {
        list-style: none;
    }
    
    .meta-item {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .meta-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .meta-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-gray);
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        display: block;
    }
    
    .meta-value {
        font-size: 14px;
        font-weight: 500;
        color: var(--text-dark);
    }
    
    /* GALLERY GRID */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    
    .gallery-item {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 4px;
        overflow: hidden;
        cursor: pointer;
        position: relative;
    }
    
    .gallery-item img, .gallery-item video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    
    .gallery-item:hover img { transform: scale(1.1); }
    
    .play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 24px;
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    /* COMMENTS SECTION */
    .comments-section {
        margin-top: 50px;
        border-top: 1px solid #e2e8f0;
        padding-top: 40px;
    }
    
    .comments-title {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        margin-bottom: 30px;
    }
    
    .comment-list {
        margin-bottom: 40px;
    }
    
    .comment-item {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
        padding-bottom: 25px;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .comment-avatar {
        width: 50px;
        height: 50px;
        background-color: var(--primary-red);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        flex-shrink: 0;
    }
    
    .comment-content { flex: 1; }
    
    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    
    .comment-author {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 15px;
    }
    
    .comment-date {
        font-size: 12px;
        color: var(--text-gray);
    }
    
    .comment-text {
        font-size: 14px;
        line-height: 1.6;
        color: var(--text-dark);
    }
    
    /* COMMENT FORM */
    .comment-form-wrapper {
        background: #f8fafc;
        padding: 30px;
        border-radius: 8px;
    }
    
    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .form-group {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .form-control {
        padding: 12px 15px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
    }
    
    .form-control:focus { border-color: var(--primary-red); }
    
    textarea.form-control { resize: vertical; min-height: 120px; }
    
    .btn-submit {
        background-color: var(--primary-red);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .btn-submit:hover { background-color: var(--dark-red); }

    /* Alert Message */
    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        border-left: 4px solid #22c55e;
    }
    
    /* RESPONSIVE */
    @media (max-width: 768px) {
        .detail-container { flex-direction: column; }
        .sidebar { width: 100%; }
        .form-row { flex-direction: column; gap: 15px; }
    }
</style>
@endpush

@section('content')

<!-- HERO SECTION -->
<div class="detail-hero">
    @if($warisan->gambar && Storage::disk('public')->exists($warisan->gambar))
        <img src="{{ Storage::url($warisan->gambar) }}" class="detail-hero-bg" alt="{{ $warisan->judul }}">
    @else
        <img src="https://via.placeholder.com/1200x600/5C1010/ffffff?text={{ urlencode($warisan->judul) }}" class="detail-hero-bg" alt="Placeholder">
    @endif
    
    <div class="detail-hero-content">
        <div class="detail-category">{{ $warisan->kategori->nama ?? 'Umum' }}</div>
        <h1 class="detail-title">{{ $warisan->judul }}</h1>
        <div class="detail-location">
            <i class="fa-solid fa-location-dot"></i> {{ $warisan->lokasi }}
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="detail-container">
    
    <!-- Left Column: Article -->
    <div class="main-content">
        <div class="article-body">
            <!-- Render HTML from CKEditor safely -->
            {!! $warisan->deskripsi !!}
        </div>
        
        <!-- Comments Section -->
        <div class="comments-section">
            <h3 class="comments-title">Komentar Pengunjung ({{ $warisan->komentars->count() }})</h3>
            
            @if(session('success'))
                <div class="alert-success">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            
            <div class="comment-list">
                @forelse($warisan->komentars as $komentar)
                    <div class="comment-item">
                        <div class="comment-avatar">
                            {{ strtoupper(substr($komentar->nama, 0, 1)) }}
                        </div>
                        <div class="comment-content">
                            <div class="comment-header">
                                <span class="comment-author">{{ $komentar->nama }}</span>
                                <span class="comment-date">{{ $komentar->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="comment-text">
                                {{ $komentar->isi_komentar }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: var(--text-gray); font-style: italic;">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                @endforelse
            </div>
            
            <div class="comment-form-wrapper">
                <h4 style="margin-bottom: 20px; font-family: 'Playfair Display', serif;">Tinggalkan Jejak / Pertanyaan</h4>
                <form action="{{ route('katalog.komentar', $warisan->warisan_budaya_id) }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Anda *</label>
                            <input type="text" name="nama" class="form-control" required placeholder="Cth: Budi Tarigan">
                        </div>
                        <div class="form-group">
                            <label>Email (Opsional)</label>
                            <input type="email" name="email" class="form-control" placeholder="Tidak akan dipublikasikan">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label>Isi Komentar *</label>
                        <textarea name="isi_komentar" class="form-control" required placeholder="Tulis pendapat atau kenangan Anda tentang budaya ini..."></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Kirim Komentar</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Right Column: Sidebar -->
    <div class="sidebar">
        
        <!-- Meta Info -->
        <div class="sidebar-widget">
            <h4 class="widget-title">Informasi Data</h4>
            <ul class="meta-list">
                <li class="meta-item">
                    <span class="meta-label">Tahun Ditemukan</span>
                    <span class="meta-value">{{ $warisan->tahun_ditemukan ?? 'Tidak diketahui' }}</span>
                </li>
                <li class="meta-item">
                    <span class="meta-label">Kondisi Saat Ini</span>
                    <span class="meta-value">
                        @if($warisan->kondisi == 'Baik')
                            <span style="color: #16a34a;"><i class="fa-solid fa-circle-check"></i> Terawat Baik</span>
                        @elseif($warisan->kondisi == 'Rusak Ringan')
                            <span style="color: #ca8a04;"><i class="fa-solid fa-circle-exclamation"></i> Rusak Ringan</span>
                        @else
                            <span style="color: #dc2626;"><i class="fa-solid fa-triangle-exclamation"></i> Rusak Berat</span>
                        @endif
                    </span>
                </li>
                <li class="meta-item">
                    <span class="meta-label">Terakhir Diperbarui</span>
                    <span class="meta-value">{{ $warisan->updated_at->format('d M Y') }}</span>
                </li>
            </ul>
        </div>
        
        <!-- Media Gallery -->
        @if($warisan->medias && $warisan->medias->count() > 0)
        <div class="sidebar-widget">
            <h4 class="widget-title">Galeri Media</h4>
            <div class="gallery-grid">
                @foreach($warisan->medias as $media)
                    @if($media->jenis_media == 'gambar')
                        <div class="gallery-item">
                            <img src="{{ Storage::url($media->file_path) }}" alt="Galeri">
                        </div>
                    @elseif($media->jenis_media == 'video')
                        <div class="gallery-item">
                            <!-- Show video frame or thumbnail -->
                            <video src="{{ Storage::url($media->file_path) }}" muted style="object-fit: cover; width: 100%; height: 100%;"></video>
                            <i class="fa-solid fa-play play-icon"></i>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Related Items -->
        @if($relatedWarisans->count() > 0)
        <div class="sidebar-widget">
            <h4 class="widget-title">Budaya Serupa</h4>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                @foreach($relatedWarisans as $related)
                <a href="{{ route('katalog.show', $related->warisan_budaya_id) }}" style="display: flex; gap: 15px; text-decoration: none; align-items: center;">
                    <div style="width: 70px; height: 70px; background: #eee; border-radius: 4px; overflow: hidden; flex-shrink: 0;">
                        @if($related->gambar && Storage::disk('public')->exists($related->gambar))
                            <img src="{{ Storage::url($related->gambar) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="">
                        @endif
                    </div>
                    <div>
                        <h5 style="color: var(--text-dark); font-size: 14px; margin-bottom: 5px; line-height: 1.3;">{{ $related->judul }}</h5>
                        <span style="font-size: 11px; color: var(--primary-red); font-weight: 600;">{{ $related->kategori->nama ?? 'Umum' }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
        
    </div>
</div>

@endsection

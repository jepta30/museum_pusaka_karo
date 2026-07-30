@extends('layouts.public')

@section('title', $warisan->judul . ' - Katalog Budaya')

@push('styles')
<style>
    /* PAGE CONTAINER */
    .detail-page-container {
        max-width: 1200px;
        margin: 40px auto 60px;
        padding: 0 5%;
        color: var(--text-dark);
    }
    
    /* HEADER SECTION */
    .detail-header {
        margin-bottom: 30px;
    }
    
    .detail-title {
        font-family: 'Playfair Display', serif;
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 10px;
        line-height: 1.2;
        color: #000;
    }
    
    .detail-location {
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-gray);
    }

    /* TOP SPLIT SECTION */
    .detail-top-split {
        display: flex;
        gap: 30px;
        margin-bottom: 40px;
    }
    
    .detail-media-container {
        flex: 2;
        background-color: #f1f5f9;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        aspect-ratio: 16/10;
    }
    
    .detail-media-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .detail-info-card {
        flex: 1;
        background: white;
        border: 1px solid #e2e8f0;
        padding: 30px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
    }
    
    .info-card-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
        color: #000;
    }
    
    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
        flex: 1;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #e2e8f0;
        font-size: 14px;
    }
    
    .info-label {
        color: var(--text-gray);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
    }
    
    .info-value {
        font-weight: 600;
        color: #000;
        text-align: right;
    }
    
    .status-badge {
        background-color: #f1f5f9;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .btn-plan-visit {
        background-color: #000;
        color: white;
        text-align: center;
        padding: 15px;
        font-weight: 600;
        font-size: 13px;
        letter-spacing: 1px;
        margin-top: 20px;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    
    .btn-plan-visit:hover {
        background-color: var(--primary-red);
        color: white;
    }

    /* TABS SECTION */
    .tabs-nav {
        display: flex;
        gap: 30px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 30px;
    }
    
    .tab-btn {
        background: none;
        border: none;
        padding: 15px 0;
        font-size: 13px;
        font-weight: 700;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        position: relative;
    }
    
    .tab-btn.active {
        color: #000;
    }
    
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--primary-red);
    }
    
    .tab-content {
        display: none;
        background: white;
        border: 1px solid #e2e8f0;
        padding: 40px;
        border-radius: 8px;
        min-height: 200px;
        line-height: 1.8;
        font-size: 15px;
    }
    
    .tab-content.active {
        display: block;
    }
    
    /* HTML CONTENT (CKEditor) inside tabs */
    .tab-content h2, .tab-content h3 {
        font-family: 'Playfair Display', serif;
        margin: 20px 0 15px;
        color: var(--primary-red);
    }
    
    .tab-content p {
        margin-bottom: 20px;
    }

    /* GALLERY GRID in Tab */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    
    .gallery-item {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 8px;
        overflow: hidden;
        background-color: #f1f5f9;
        position: relative;
    }
    
    .gallery-item img, .gallery-item video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 30px;
        color: white;
        text-shadow: 0 2px 5px rgba(0,0,0,0.5);
    }

    /* COMMENTS SECTION in Tab */
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
    
    .comment-content-box { flex: 1; }
    
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
    
    /* COMMENT FORM */
    .comment-form-wrapper {
        background: #f8fafc;
        padding: 30px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
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
    }
    
    .btn-submit {
        background-color: var(--primary-red);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
    }

    /* RELATED SECTION */
    .related-section {
        margin-top: 60px;
        border-top: 1px solid #e2e8f0;
        padding-top: 40px;
    }
    
    .related-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .related-title {
        font-size: 18px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .btn-view-all {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-gray);
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .related-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    
    .related-card {
        text-decoration: none;
        color: inherit;
    }
    
    .related-image {
        width: 100%;
        aspect-ratio: 16/10;
        background-color: #e2e8f0;
        border-radius: 8px;
        margin-bottom: 15px;
        overflow: hidden;
    }
    
    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .related-card-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .related-card-cat {
        font-size: 12px;
        color: var(--text-gray);
    }
    
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
    @media (max-width: 900px) {
        .detail-top-split { flex-direction: column; }
        .related-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .form-row { flex-direction: column; }
        .tabs-nav { overflow-x: auto; white-space: nowrap; }
        .gallery-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')
<div class="detail-page-container">
    
    <!-- HEADER -->
    <div class="detail-header">
        <h1 class="detail-title">{{ $warisan->judul }}</h1>
        <div class="detail-location">
            <i class="fa-solid fa-location-dot"></i> {{ $warisan->lokasi }}
        </div>
    </div>

    <!-- TOP SPLIT (Image & Info) -->
    <div class="detail-top-split">
        <div class="detail-media-container">
            @if($warisan->gambar && Storage::disk('public')->exists($warisan->gambar))
                <img src="{{ Storage::url($warisan->gambar) }}" alt="{{ $warisan->judul }}">
            @else
                <div style="text-align:center; color:#94a3b8;">
                    <i class="fa-regular fa-image" style="font-size:40px; margin-bottom:10px;"></i><br>
                    TAMPAK DEPAN {{ strtoupper($warisan->judul) }}
                </div>
            @endif
        </div>
        
        <div class="detail-info-card">
            <div class="info-card-title">Informasi Utama</div>
            <ul class="info-list">
                <li class="info-item">
                    <span class="info-label">Kategori</span>
                    <span class="info-value">{{ $warisan->kategori->nama ?? 'Umum' }}</span>
                </li>
                <li class="info-item">
                    <span class="info-label">Lokasi</span>
                    <span class="info-value">{{ $warisan->lokasi }}</span>
                </li>
                <li class="info-item">
                    <span class="info-label">Asal</span>
                    <span class="info-value">{{ $warisan->asal ?? '-' }}</span>
                </li>
                <li class="info-item">
                    <span class="info-label">Status</span>
                    <span class="info-value"><span class="status-badge">{{ $warisan->kondisi ?? 'TIDAK DIKETAHUI' }}</span></span>
                </li>
            </ul>
            <a href="{{ route('home') }}#buku-tamu-section" class="btn-plan-visit">RENCANAKAN KUNJUNGAN</a>
        </div>
    </div>

    <!-- TABS -->
    <div class="tabs-nav">
        <button class="tab-btn active" onclick="openTab(event, 'tab-deskripsi')">DESKRIPSI</button>
        <button class="tab-btn" onclick="openTab(event, 'tab-sejarah')">SEJARAH</button>
        <button class="tab-btn" onclick="openTab(event, 'tab-galeri')">GALERI</button>
        <button class="tab-btn" onclick="openTab(event, 'tab-komentar')">KOMENTAR</button>
    </div>

    <!-- TAB: DESKRIPSI -->
    <div id="tab-deskripsi" class="tab-content active">
        {!! $warisan->deskripsi !!}
    </div>

    <!-- TAB: SEJARAH -->
    <div id="tab-sejarah" class="tab-content">
        @if($warisan->sejarah)
            {!! $warisan->sejarah !!}
        @else
            <p style="color: var(--text-gray); font-style: italic; text-align: center; padding: 40px 0;">Belum ada informasi sejarah yang ditambahkan.</p>
        @endif
    </div>

    <!-- TAB: GALERI -->
    <div id="tab-galeri" class="tab-content">
        @if($warisan->medias && $warisan->medias->count() > 0)
            <div class="gallery-grid">
                @foreach($warisan->medias as $media)
                    @if($media->jenis_media == 'foto')
                        <div class="gallery-item">
                            <img src="{{ Storage::url($media->file_media) }}" alt="{{ $media->keterangan }}">
                        </div>
                    @elseif($media->jenis_media == 'video')
                        <div class="gallery-item">
                            <video src="{{ Storage::url($media->file_media) }}" muted></video>
                            <i class="fa-solid fa-play play-icon"></i>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <p style="color: var(--text-gray); font-style: italic; text-align: center; padding: 40px 0;">Belum ada media galeri yang ditambahkan.</p>
        @endif
    </div>

    <!-- TAB: KOMENTAR -->
    <div id="tab-komentar" class="tab-content">
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
                    <div class="comment-content-box">
                        <div class="comment-header">
                            <span class="comment-author">{{ $komentar->nama }}</span>
                            <span class="comment-date">{{ $komentar->created_at->diffForHumans() }}</span>
                        </div>
                        <div style="font-size: 14px; color: var(--text-dark);">
                            {{ $komentar->isi_komentar }}
                        </div>
                    </div>
                </div>
            @empty
                <p style="color: var(--text-gray); font-style: italic;">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
            @endforelse
        </div>
        
        <div class="comment-form-wrapper">
            <h4 style="margin-bottom: 20px; font-family: 'Playfair Display', serif; font-size: 20px;">Tinggalkan Jejak / Pertanyaan</h4>
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
                    <textarea name="isi_komentar" class="form-control" required style="min-height: 100px; resize:vertical;" placeholder="Tulis pendapat atau kenangan Anda tentang budaya ini..."></textarea>
                </div>
                <button type="submit" class="btn-submit">Kirim Komentar</button>
            </form>
        </div>
    </div>

    <!-- EKSPLORASI LAINNYA -->
    <div class="related-section">
        <div class="related-header">
            <h3 class="related-title">EKSPLORASI LAINNYA</h3>
            <a href="{{ route('katalog.index') }}" class="btn-view-all">LIHAT SEMUA &rarr;</a>
        </div>
        
        <div class="related-grid">
            @forelse($relatedWarisans as $related)
                <a href="{{ route('katalog.show', $related->warisan_budaya_id) }}" class="related-card">
                    <div class="related-image">
                        @if($related->gambar && Storage::disk('public')->exists($related->gambar))
                            <img src="{{ Storage::url($related->gambar) }}" alt="{{ $related->judul }}">
                        @else
                            <div style="display:flex; height:100%; align-items:center; justify-content:center; color:#cbd5e1;">
                                <i class="fa-solid fa-image" style="font-size:30px;"></i>
                            </div>
                        @endif
                    </div>
                    <h4 class="related-card-title">{{ $related->judul }}</h4>
                    <div class="related-card-cat">{{ $related->kategori->nama ?? 'Umum' }}</div>
                </a>
            @empty
                <p style="grid-column: span 4; color: var(--text-gray); font-style: italic;">Tidak ada budaya serupa saat ini.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        
        // Hide all tab content
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
            tabcontent[i].classList.remove("active");
        }
        
        // Remove active class from all tab buttons
        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }
        
        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabName).style.display = "block";
        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.classList.add("active");
    }
</script>
@endpush

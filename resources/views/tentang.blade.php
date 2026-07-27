@extends('layouts.public')

@section('title', 'Tentang Kami')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    .tentang-hero {
        background: linear-gradient(135deg, var(--dark-red) 0%, var(--primary-red) 100%);
        padding: 70px 5% 90px;
        color: white;
        text-align: center;
    }
    .tentang-hero .badge-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--gold);
        margin-bottom: 15px;
    }
    .tentang-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        margin-bottom: 15px;
    }
    .tentang-hero p {
        max-width: 640px;
        margin: 0 auto;
        opacity: 0.9;
        line-height: 1.7;
        font-size: 15px;
    }

    .tentang-container {
        max-width: 1100px;
        margin: -50px auto 0;
        padding: 0 5% 80px;
        position: relative;
        z-index: 2;
    }

    .profil-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 45px;
        margin-bottom: 40px;
    }
    .profil-card h2 {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        color: var(--text-dark);
        margin-bottom: 18px;
    }
    .profil-card p {
        color: var(--text-gray);
        line-height: 1.8;
        font-size: 14.5px;
        margin-bottom: 14px;
    }

    .profil-section h3 {
        font-size: 18px;
        color: var(--primary-red);
        margin-top: 28px;
        margin-bottom: 16px;
    }

    .profil-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-top: 24px;
    }

    .profil-box {
        background: #f8f4ed;
        border: 1px solid rgba(122, 27, 27, 0.08);
        border-radius: 16px;
        padding: 22px;
    }

    .profil-box h4 {
        font-size: 15px;
        color: var(--primary-red);
        margin-bottom: 10px;
        font-weight: 700;
    }

    .profil-box p {
        font-size: 14px;
        color: var(--text-gray);
        line-height: 1.75;
        margin-bottom: 0;
    }

    .stats-row {
        display: flex;
        gap: 20px;
        margin-top: 25px;
        flex-wrap: wrap;
    }
    .stat-box {
        flex: 1;
        min-width: 140px;
        background: var(--cream);
        border: 1px solid #eee0c8;
        border-radius: 6px;
        padding: 20px;
        text-align: center;
    }
    .stat-box .num {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        color: var(--primary-red);
        font-weight: 700;
    }
    .stat-box .label {
        font-size: 12px;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 5px;
    }

    .story-section {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        padding: 40px 45px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        margin-bottom: 40px;
    }

    .story-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .story-section p {
        color: var(--text-gray);
        line-height: 1.8;
        font-size: 14.5px;
        margin-bottom: 30px;
    }

    .story-grid {
        display: grid;
        gap: 20px;
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .story-card {
        background: #f8f4ed;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid rgba(122, 27, 27, 0.08);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .story-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 28px rgba(15, 23, 42, 0.08);
    }

    .story-number {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--primary-red);
        color: white;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .story-card h4 {
        font-size: 16px;
        margin-bottom: 12px;
        color: var(--text-dark);
    }

    .story-card p {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.75;
        margin-bottom: 0;
    }

    .story-highlight {
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(122, 27, 27, 0.08), rgba(236, 139, 95, 0.08));
        border: 1px solid rgba(236, 139, 95, 0.15);
        padding: 32px;
        display: grid;
        gap: 16px;
    }

    .story-highlight h3 {
        font-size: 20px;
        margin-bottom: 12px;
    }

    .story-highlight p {
        margin-bottom: 0;
    }

    .feature-section,
    .timeline-section,
    .faq-section {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        padding: 40px 45px;
        margin-bottom: 45px;
    }

    .feature-section h2,
    .timeline-section h2,
    .faq-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: var(--text-dark);
        margin-bottom: 18px;
    }

    .feature-grid,
    .timeline-grid {
        display: grid;
        gap: 20px;
    }

    .feature-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .feature-box,
    .timeline-card,
    .faq-card {
        background: #f8f4ed;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid rgba(122, 27, 27, 0.08);
    }

    .feature-box h4,
    .timeline-card h4,
    .faq-card h4 {
        font-size: 17px;
        margin-bottom: 12px;
        color: var(--text-dark);
    }

    .feature-box p,
    .timeline-card p,
    .faq-card p {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.75;
        margin-bottom: 0;
    }

    .timeline-card {
        display: grid;
        gap: 16px;
    }

    .timeline-label {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--primary-red);
    }

    .faq-grid {
        display: grid;
        gap: 20px;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .faq-card h4 {
        font-size: 16px;
    }

    .program-section,
    .location-section {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        padding: 40px 45px;
        margin-bottom: 45px;
    }

    .program-section h2,
    .location-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: var(--text-dark);
        margin-bottom: 18px;
    }

    .program-grid {
        display: grid;
        gap: 20px;
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .program-card {
        background: #f8f4ed;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid rgba(122, 27, 27, 0.08);
    }

    .program-card h4 {
        font-size: 17px;
        margin-bottom: 12px;
        color: var(--text-dark);
    }

    .program-card p {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.75;
        margin-bottom: 0;
    }

    .location-card {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 24px;
        align-items: stretch;
    }

    .location-info {
        display: grid;
        gap: 18px;
    }

    .location-info p,
    .location-info li {
        color: var(--text-gray);
        line-height: 1.75;
        font-size: 14px;
    }

    .location-info ul {
        padding: 0;
        margin: 0;
        list-style: none;
        display: grid;
        gap: 12px;
    }

    .location-info li i {
        color: var(--primary-red);
        margin-right: 10px;
    }

    .location-map {
        min-height: 300px;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
        border: 1px solid rgba(15, 23, 42, 0.08);
        position: relative;
    }

    .location-map #locationMap {
        width: 100%;
        height: 100%;
        min-height: 300px;
    }

    @media (max-width: 980px) {
        .feature-grid,
        .faq-grid,
        .timeline-grid {
            grid-template-columns: 1fr;
        }
        .program-grid {
            grid-template-columns: 1fr;
        }
        .location-card {
            grid-template-columns: 1fr;
        }
    }

    .gallery-section {
        margin-bottom: 45px;
    }

    .gallery-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: var(--text-dark);
        margin-bottom: 18px;
        text-align: center;
    }

    .gallery-grid {
        display: grid;
        gap: 20px;
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .gallery-card {
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        border: 1px solid rgba(15, 23, 42, 0.06);
    }

    .gallery-card .gallery-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
        background: linear-gradient(135deg, rgba(122, 27, 27, 0.55), rgba(236, 139, 95, 0.55));
    }

    .gallery-card-content {
        padding: 24px;
    }

    .gallery-card-title {
        font-size: 18px;
        color: var(--text-dark);
        margin-bottom: 10px;
        font-weight: 700;
    }

    .gallery-card-desc {
        color: var(--text-gray);
        line-height: 1.75;
        font-size: 14px;
    }

    .gallery-cta {
        display: flex;
        justify-content: center;
        margin-top: 24px;
    }

    .gallery-cta a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 22px;
        border-radius: 999px;
        background: #7a1b1b;
        color: white;
        text-decoration: none;
        font-weight: 700;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .gallery-cta a:hover {
        transform: translateY(-1px);
        box-shadow: 0 18px 35px rgba(122, 27, 27, 0.22);
    }

    .visit-section {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 24px;
        margin-bottom: 45px;
        align-items: stretch;
    }

    .photo-card {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
        min-height: 380px;
        position: relative;
    }

    .photo-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .visit-info {
        background: #fff;
        border-radius: 24px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        padding: 38px 36px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06);
    }

    .visit-info h3 {
        font-size: 26px;
        margin-bottom: 18px;
    }

    .visit-info p {
        color: var(--text-gray);
        line-height: 1.8;
        margin-bottom: 28px;
    }

    .visit-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        gap: 18px;
    }

    .visit-list li {
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }

    .visit-list li i {
        color: var(--primary-red);
        margin-top: 4px;
    }

    .visit-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px 24px;
        border-radius: 999px;
        background: var(--primary-red);
        color: white;
        font-weight: 700;
        border: none;
        text-decoration: none;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .visit-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 18px 35px rgba(122, 27, 27, 0.2);
    }

    @media (max-width: 980px) {
        .visit-section {
            grid-template-columns: 1fr;
        }
    }

    .pilar-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: var(--text-dark);
        text-align: center;
        margin-bottom: 10px;
    }
    .pilar-section > p {
        text-align: center;
        color: var(--text-gray);
        max-width: 560px;
        margin: 0 auto 35px;
        font-size: 14px;
    }

    .pilar-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 50px;
    }
    .pilar-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 35px 25px;
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .pilar-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.07);
    }
    .pilar-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--primary-red);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin: 0 auto 18px;
    }
    .pilar-card h3 {
        font-size: 16px;
        color: var(--text-dark);
        margin-bottom: 10px;
        font-weight: 700;
    }
    .pilar-card p {
        font-size: 13.5px;
        color: var(--text-gray);
        line-height: 1.7;
    }

    .kontak-card {
        background: var(--dark-red);
        border-radius: 8px;
        padding: 40px;
        color: white;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
    }
    .kontak-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .kontak-item i {
        color: var(--gold);
        font-size: 18px;
        margin-bottom: 4px;
    }
    .kontak-item .k-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255,255,255,0.6);
    }
    .kontak-item .k-value {
        font-size: 14px;
        line-height: 1.5;
    }

    @media (max-width: 900px) {
        .pilar-grid { grid-template-columns: 1fr; }
        .kontak-card { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

@section('content')

<div class="tentang-hero">
    <div class="badge-label">TENTANG KAMI</div>
    <h1>Museum Pusaka Karo</h1>
    <p>Lembaga pelestari budaya yang mengumpulkan, merawat, dan mendokumentasikan artefak serta pengetahuan tradisional masyarakat Karo melalui sistem informasi digital.</p>
</div>

<div class="tentang-container">

    <div class="profil-card">
        <h2>Profil Museum</h2>
        <p>
            Museum Pusaka Karo hadir sebagai ruang pelestarian warisan budaya masyarakat Karo,
            mulai dari arsitektur rumah adat, kain tradisional, alat musik, hingga tradisi dan
            kearifan lokal yang diwariskan turun-temurun. Melalui Sistem Informasi Warisan Budaya
            Karo, seluruh koleksi dan dokumentasi budaya ini disajikan secara digital agar dapat
            diakses, dipelajari, dan dilestarikan oleh masyarakat luas maupun generasi muda Karo.
        </p>
        <p>
            Sistem ini dikembangkan untuk mendukung tugas kurator dalam mendokumentasikan warisan
            budaya, sekaligus menjadi jembatan informasi antara Museum Pusaka Karo dengan
            masyarakat, peneliti, dan wisatawan yang ingin mengenal lebih dekat kebudayaan Karo.
        </p>

        <div class="profil-section">
            <h3>Visi & Misi</h3>
            <div class="profil-grid">
                <div class="profil-box">
                    <h4>Visi</h4>
                    <p>Mewujudkan Museum Pusaka Karo sebagai pusat dokumentasi dan pelestarian budaya Karo yang dipercaya serta mudah diakses.</p>
                </div>
                <div class="profil-box">
                    <h4>Misi</h4>
                    <p>Mengumpulkan, merawat, dan menyebarluaskan informasi warisan budaya Karo melalui pengelolaan koleksi yang profesional dan digital.</p>
                </div>
                <div class="profil-box">
                    <h4>Nilai</h4>
                    <p>Asli, terjaga, akuntabel, dan edukatif — sebagai pijakan dalam setiap aktivitas pelestarian budaya.</p>
                </div>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-box">
                <div class="num">{{ $totalWarisan }}</div>
                <div class="label">Warisan Budaya</div>
            </div>
            <div class="stat-box">
                <div class="num">{{ $totalKategori }}</div>
                <div class="label">Kategori Budaya</div>
            </div>
            <div class="stat-box">
                <div class="num">14</div>
                <div class="label">Kabupaten / Kota</div>
            </div>
        </div>
    </div>

    <div class="story-section">
        <h2>Sejarah Singkat Museum</h2>
        <p>Museum Pusaka Karo dibangun sebagai jawaban atas kebutuhan pelestarian budaya Karo di era modern. Berawal dari inisiatif para budayawan lokal dan pemerintah daerah, museum ini menjadi pusat dokumentasi dan penyajian koleksi budaya dalam bentuk yang mudah diakses oleh generasi sekarang.</p>
        <p>Melalui perpaduan digitalisasi dan konservasi fisik, museum ini berupaya menghadirkan pengalaman edukatif tidak hanya untuk masyarakat Karo, tetapi juga bagi wisatawan dan peneliti dari seluruh Indonesia.</p>

        <div class="story-grid">
            <div class="story-card">
                <div class="story-number">1</div>
                <h4>Awal Berdiri</h4>
                <p>Didirikan untuk melestarikan ragam artefak Karo yang terancam hilang akibat modernisasi dan perubahan sosial.</p>
            </div>
            <div class="story-card">
                <div class="story-number">2</div>
                <h4>Digitalisasi</h4>
                <p>Menerapkan sistem informasi digital untuk menyimpan, mengelola, dan menampilkan data koleksi kepada publik secara interaktif.</p>
            </div>
            <div class="story-card">
                <div class="story-number">3</div>
                <h4>Komunitas</h4>
                <p>Menjadi pusat aktivitas budaya, pelatihan, dan pameran yang melibatkan generasi muda dalam upaya pelestarian budaya Karo.</p>
            </div>
        </div>

        <div class="story-highlight">
            <h3>Wawasan Museum</h3>
            <p>Museum Pusaka Karo percaya bahwa pemahaman budaya adalah pondasi untuk menjaga jati diri dan meningkatkan kebanggaan lokal. Museum ini berubah dari sekadar penyimpanan artefak menjadi wahana edukasi dan inspirasi.</p>
        </div>
    </div>

    <div class="feature-section">
        <h2>Apa yang Bisa Anda Temukan</h2>
        <div class="feature-grid">
            <div class="feature-box">
                <h4>Koleksi Artefak Lengkap</h4>
                <p>Ragam benda bersejarah, mulai dari pakaian adat hingga peralatan rumah tradisional, disajikan sebagai warisan hidup masyarakat Karo.</p>
            </div>
            <div class="feature-box">
                <h4>Informasi Interaktif</h4>
                <p>Setiap koleksi dilengkapi deskripsi dan latar belakang budaya sehingga pengunjung dapat memahami nilai historis dan maknanya.</p>
            </div>
            <div class="feature-box">
                <h4>Program Edukasi</h4>
                <p>Workshop, diskusi, dan kegiatan pembelajaran bagi pelajar dan komunitas untuk menjaga warisan Karo tetap relevan.</p>
            </div>
        </div>
    </div>

    <div class="timeline-section">
        <h2>Timeline Perjalanan Museum</h2>
        <div class="timeline-grid">
            <div class="timeline-card">
                <div class="timeline-label">2008</div>
                <h4>Awal Inspirasi</h4>
                <p>Konsep museum digagas oleh pemangku budaya dan sejarawan Karo sebagai media pelestarian dan edukasi.</p>
            </div>
            <div class="timeline-card">
                <div class="timeline-label">2014</div>
                <h4>Pengumpulan Koleksi</h4>
                <p>Mulai mengumpulkan artefak dan dokumentasi dari berbagai daerah untuk membangun koleksi representatif budaya Karo.</p>
            </div>
            <div class="timeline-card">
                <div class="timeline-label">2019</div>
                <h4>Pembukaan Publik</h4>
                <p>Museum resmi dibuka untuk umum, menawarkan ruang pameran dan informasi yang dapat dijangkau oleh masyarakat lokal dan wisatawan.</p>
            </div>
            <div class="timeline-card">
                <div class="timeline-label">2026</div>
                <h4>Digitalisasi</h4>
                <p>Meluncurkan situs dan sistem informasi digital untuk memperluas akses ke koleksi dan informasi budaya secara online.</p>
            </div>
        </div>
    </div>

    <div class="faq-section">
        <h2>Pertanyaan Umum</h2>
        <div class="faq-grid">
            <div class="faq-card">
                <h4>Apa tujuan utama museum ini?</h4>
                <p>Menjaga, mendokumentasikan, dan menyebarkan pengetahuan tentang kebudayaan Karo agar generasi kini dan mendatang dapat mempelajari dan menghargainya.</p>
            </div>
            <div class="faq-card">
                <h4>Apakah ada tur edukasi?</h4>
                <p>Ya, museum menyediakan kegiatan edukatif dan kunjungan terarah bagi sekolah, komunitas, dan pengunjung umum.</p>
            </div>
            <div class="faq-card">
                <h4>Apakah koleksi dapat diakses secara online?</h4>
                <p>Informasi umum tentang koleksi tersedia di situs, sedangkan pameran dan katalog lengkap dapat dilihat pada halaman katalog.</p>
            </div>
            <div class="faq-card">
                <h4>Bagaimana cara mengunjungi museum?</h4>
                <p>Pengunjung dapat datang langsung pada jam operasional atau merencanakan kunjungan sebelumnya melalui informasi kontak yang tersedia.</p>
            </div>
        </div>
    </div>

    <div class="gallery-section">
        <h2>Galeri Koleksi Unggulan</h2>
        <div class="gallery-grid">
            <div class="gallery-card">
                <div class="gallery-image" style="background-image: url('{{ asset('images/logo.png') }}');"></div>
                <div class="gallery-card-content">
                    <div class="gallery-card-title">Rumah Adat</div>
                    <div class="gallery-card-desc">Koleksi arsitektur tradisional Karo yang menjadi warisan budaya dan identitas komunitas.</div>
                </div>
            </div>
            <div class="gallery-card">
                <div class="gallery-image" style="background-image: url('{{ asset('images/logo.png') }}');"></div>
                <div class="gallery-card-content">
                    <div class="gallery-card-title">Alat Musik Tradisional</div>
                    <div class="gallery-card-desc">Pelestarian bunyi dan teknik pembuatan alat musik khas Karo yang kaya makna.</div>
                </div>
            </div>
            <div class="gallery-card">
                <div class="gallery-image" style="background-image: url('{{ asset('images/logo.png') }}');"></div>
                <div class="gallery-card-content">
                    <div class="gallery-card-title">Pakaian Adat</div>
                    <div class="gallery-card-desc">Koleksi pakaian upacara dan tradisi yang menceritakan nilai-nilai budaya Karo.</div>
                </div>
            </div>
        </div>
        <div class="gallery-cta">
            <a href="{{ route('katalog.index') }}"><i class="fa-solid fa-arrow-right"></i>Lihat Seluruh Koleksi</a>
        </div>
    </div>

    <div class="visit-section">
        <div class="photo-card">
            <img src="{{ asset('images/logo.png') }}" alt="Museum Pusaka Karo">
        </div>
        <div class="visit-info">
            <div>
                <h3>Rencanakan kunjungan Anda</h3>
                <p>Bersiaplah untuk menjelajahi kebudayaan Karo secara lebih mendalam. Dapatkan informasi praktis dan rincian kunjungan yang memudahkan perjalanan Anda ke Museum Pusaka Karo.</p>
                <ul class="visit-list">
                    <li><i class="fa-solid fa-clock"></i><span>Jam buka: Selasa - Minggu, 09.00 - 16.00 WIB</span></li>
                    <li><i class="fa-solid fa-location-dot"></i><span>Lokasi: Jl. Perwira No. 3, Gundaling I, Berastagi</span></li>
                    <li><i class="fa-solid fa-phone"></i><span>Telepon: (0628) 9123456</span></li>
                    <li><i class="fa-solid fa-envelope"></i><span>Email: info@museumpusaka.karo.go.id</span></li>
                </ul>
            </div>
            <a href="{{ route('peta.persebaran') }}" class="visit-button">
                <i class="fa-solid fa-map-location-dot"></i>
                Lihat Peta Museum
            </a>
        </div>
    </div>

    <div class="location-section">
        <h2>Lokasi Museum</h2>
        <div class="location-card">
            <div class="location-info">
                <p>Terletak di pusat kecamatan Berastagi, Museum Pusaka Karo mudah dijangkau dari pusat kota dan menawarkan akses langsung ke pengalaman budaya Karo yang otentik.</p>
                <ul>
                    <li><i class="fa-solid fa-map-pin"></i>Alamat lengkap: Jl. Perwira No. 3, Gundaling I, Berastagi</li>
                    <li><i class="fa-solid fa-location-dot"></i>Koordinat: 3.13220° N, 98.46650° E</li>
                    <li><i class="fa-solid fa-car"></i>Akses: Dekat dengan jalan utama dan jalur wisata menuju Danau Toba</li>
                    <li><i class="fa-solid fa-route"></i>Parkir: Tersedia area parkir tamu di sekitar museum</li>
                </ul>
            </div>
            <div class="location-map">
                <div id="locationMap"></div>
            </div>
        </div>
    </div>

    <div class="pilar-section">
        <h2>Tiga Pilar Utama</h2>
        <p>Landasan kerja Museum Pusaka Karo dalam menjaga dan menghidupkan warisan budaya Karo.</p>

        <div class="pilar-grid">
            <div class="pilar-card">
                <div class="pilar-icon"><i class="fa-solid fa-landmark"></i></div>
                <h3>Pelestarian</h3>
                <p>Pengembangan dan penjagaan nilai-nilai budaya Karo secara sistematis, agar warisan leluhur tetap terjaga keasliannya.</p>
            </div>
            <div class="pilar-card">
                <div class="pilar-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                <h3>Akuntabilitas</h3>
                <p>Penyajian informasi budaya yang berbasis kajian sejarah dan data yang dapat dipertanggungjawabkan.</p>
            </div>
            <div class="pilar-card">
                <div class="pilar-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                <h3>Edukasi</h3>
                <p>Menjadi sumber belajar bagi generasi muda Karo dan masyarakat umum untuk mengenal budaya leluhurnya.</p>
            </div>
        </div>
    </div>

    <div class="kontak-card">
        <div class="kontak-item">
            <i class="fa-solid fa-location-dot"></i>
            <span class="k-label">Alamat</span>
            <span class="k-value">Jl. Perwira No. 3, Gundaling I,<br>Berastagi, Kabupaten Karo,<br>Sumatera Utara</span>
        </div>
        <div class="kontak-item">
            <i class="fa-solid fa-phone"></i>
            <span class="k-label">Telepon</span>
            <span class="k-value">(0628) 9123456</span>
        </div>
        <div class="kontak-item">
            <i class="fa-solid fa-envelope"></i>
            <span class="k-label">Email</span>
            <span class="k-value">info@museumpusaka.karo.go.id</span>
        </div>
        <div class="kontak-item">
            <i class="fa-solid fa-clock"></i>
            <span class="k-label">Jam Kunjungan</span>
            <span class="k-value">Selasa &ndash; Minggu<br>09.00 &ndash; 16.00 WIB</span>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const locationMap = document.getElementById('locationMap');
        if (!locationMap) {
            return;
        }

        const map = L.map('locationMap', {
            scrollWheelZoom: false,
            attributionControl: false,
        }).setView([3.13220, 98.46650], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        L.marker([3.13220, 98.46650]).addTo(map)
            .bindPopup('<strong>Museum Pusaka Karo</strong><br>Jl. Perwira No. 3, Berastagi')
            .openPopup();
    });
</script>
@endpush

@endsection

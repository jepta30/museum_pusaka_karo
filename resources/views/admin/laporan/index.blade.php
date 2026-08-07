@extends('layouts.admin')

@section('header_title', 'Laporan')

@section('content')
<style>
    .laporan-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    .laporan-card {
        background: var(--card-bg); border: 1px solid rgba(216, 224, 235, 0.9); border-radius: 24px;
        padding: 28px; display: flex; gap: 18px; align-items: flex-start;
        text-decoration: none; transition: box-shadow 0.25s ease, transform 0.25s ease;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.05);
    }
    .laporan-card:hover { box-shadow: 0 24px 55px rgba(15, 23, 42, 0.1); transform: translateY(-2px); }
    .laporan-icon {
        width: 56px; height: 56px; border-radius: 18px; background: var(--primary-red, #7A1B1B);
        color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;
    }
    .laporan-text h4 { font-size: 16px; color: var(--text-dark); margin-bottom: 8px; font-weight: 700; }
    .laporan-text p { font-size: 13px; color: var(--text-gray); line-height: 1.75; }

    @media (max-width: 900px) { .laporan-grid { grid-template-columns: 1fr; } }
</style>

<div class="page-header">
    <div class="page-title">
        <h3>Pusat Laporan</h3>
        <p>Rekapitulasi dan statistik sistem, dapat difilter per periode dan diunduh dalam format CSV.</p>
    </div>
</div>

<div class="laporan-grid">
    <a href="{{ route('laporan.warisan') }}" class="laporan-card">
        <div class="laporan-icon"><i class="fa-solid fa-book-open"></i></div>
        <div class="laporan-text">
            <h4>Laporan Koleksi Budaya</h4>
            <p>Rekap data koleksi budaya yang ditambahkan, dapat difilter per periode (harian/mingguan/bulanan).</p>
        </div>
    </a>

    <a href="{{ route('pengunjung.index') }}" class="laporan-card">
        <div class="laporan-icon"><i class="fa-solid fa-address-book"></i></div>
        <div class="laporan-text">
            <h4>Laporan Data Pengunjung</h4>
            <p>Buku tamu digital museum — data pengunjung fisik yang datang langsung.</p>
        </div>
    </a>

    <a href="{{ route('koleksi.index') }}" class="laporan-card">
        <div class="laporan-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
        <div class="laporan-text">
            <h4>Buku Induk Koleksi Museum</h4>
            <p>Inventaris koleksi fisik yang dimiliki museum beserta asal-usulnya.</p>
        </div>
    </a>

    <a href="{{ route('laporan.rekapitulasi') }}" class="laporan-card">
        <div class="laporan-icon"><i class="fa-solid fa-chart-pie"></i></div>
        <div class="laporan-text">
            <h4>Rekapitulasi & Statistik</h4>
            <p>Ringkasan agregat: jumlah warisan per kategori, media, dan rasio komentar disetujui.</p>
        </div>
    </a>

    <a href="{{ route('laporan.komentar') }}" class="laporan-card">
        <div class="laporan-icon"><i class="fa-solid fa-comments"></i></div>
        <div class="laporan-text">
            <h4>Laporan Aktivitas Komentar</h4>
            <p>Rekap moderasi komentar (disetujui/menunggu/ditolak) per periode.</p>
        </div>
    </a>

    <a href="{{ route('laporan.kunjungan') }}" class="laporan-card">
        <div class="laporan-icon"><i class="fa-solid fa-chart-line"></i></div>
        <div class="laporan-text">
            <h4>Statistik Kunjungan Website</h4>
            <p>Tren kunjungan situs, halaman terpopuler, dan jenis perangkat pengunjung.</p>
        </div>
    </a>
</div>
@endsection

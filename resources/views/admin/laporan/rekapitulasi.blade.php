@extends('layouts.admin')

@section('header_title', 'Rekapitulasi & Statistik')

@section('content')
<style>
    .summary-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 28px; }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .panel {
        background: var(--card-bg);
        border: 1px solid rgba(216, 224, 235, 0.55);
        border-radius: 20px;
        padding: 26px;
        margin-bottom: 20px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
    }
    .panel h4 { font-size: 15px; margin-bottom: 18px; color: var(--text-dark); }

    .komentar-stats { display: flex; gap: 15px; margin-bottom: 15px; }
    .kstat { flex: 1; text-align: center; padding: 15px; border-radius: 6px; }
    .kstat.approved { background: #d1fae5; }
    .kstat.pending { background: #fef3c7; }
    .kstat.rejected { background: #fee2e2; }
    .kstat .n { font-size: 20px; font-weight: 700; }
    .kstat .l { font-size: 11px; text-transform: uppercase; margin-top: 3px; }

    @media (max-width: 900px) { .summary-grid, .grid-2 { grid-template-columns: 1fr 1fr; } }
</style>

<a href="{{ route('laporan.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali ke Pusat Laporan</a>

<div class="page-header">
    <div class="page-title">
        <h3>Rekapitulasi & Statistik</h3>
        <p>Ringkasan agregat seluruh data sistem.</p>
    </div>
    <a href="{{ route('laporan.rekapitulasi.csv') }}" class="btn-outline"><i class="fa-solid fa-file-csv"></i> Unduh CSV</a>
</div>

<div class="summary-grid">
    <div class="summary-box"><div class="num">{{ $totalWarisan }}</div><div class="label">Total Warisan Budaya</div></div>
    <div class="summary-box"><div class="num">{{ $totalKategori }}</div><div class="label">Total Kategori</div></div>
    <div class="summary-box"><div class="num">{{ $totalMedia }}</div><div class="label">Total Media</div></div>
    <div class="summary-box"><div class="num">{{ $totalKomentar }}</div><div class="label">Total Komentar</div></div>
</div>

<div class="grid-2">
    <div class="panel">
        <h4>Warisan Budaya per Kategori</h4>
        @php $maxTotal = $perKategori->max('total') ?: 1; @endphp
        @forelse($perKategori as $pk)
        <div class="bar-row">
            <div class="bar-label">{{ $pk->nama }}</div>
            <div class="bar-track"><div class="bar-fill" style="width: {{ $pk->total > 0 ? ($pk->total / $maxTotal * 100) : 0 }}%;"></div></div>
            <div class="bar-value">{{ $pk->total }}</div>
        </div>
        @empty
        <p style="color: var(--text-gray); font-size: 13px;">Belum ada data kategori.</p>
        @endforelse
    </div>

    <div class="panel">
        <h4>Status Moderasi Komentar</h4>
        <div class="komentar-stats">
            <div class="kstat approved"><div class="n">{{ $komentarApproved }}</div><div class="l">Disetujui</div></div>
            <div class="kstat pending"><div class="n">{{ $komentarPending }}</div><div class="l">Menunggu</div></div>
            <div class="kstat rejected"><div class="n">{{ $komentarRejected }}</div><div class="l">Ditolak</div></div>
        </div>
        <p style="font-size: 13px; color: var(--text-gray);">Rasio komentar disetujui: <strong style="color: var(--text-dark);">{{ $rasioApproved }}%</strong> dari total {{ $totalKomentar }} komentar.</p>

        <h4 style="margin-top: 25px;">Media Dokumentasi</h4>
        <div class="bar-row">
            <div class="bar-label">Foto</div>
            <div class="bar-track"><div class="bar-fill" style="width: {{ $totalMedia > 0 ? ($mediaFoto / $totalMedia * 100) : 0 }}%;"></div></div>
            <div class="bar-value">{{ $mediaFoto }}</div>
        </div>
        <div class="bar-row">
            <div class="bar-label">Video</div>
            <div class="bar-track"><div class="bar-fill" style="width: {{ $totalMedia > 0 ? ($mediaVideo / $totalMedia * 100) : 0 }}%;"></div></div>
            <div class="bar-value">{{ $mediaVideo }}</div>
        </div>
    </div>
</div>
@endsection

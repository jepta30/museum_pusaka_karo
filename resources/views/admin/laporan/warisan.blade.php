@extends('layouts.admin')

@section('header_title', 'Laporan Warisan Budaya')

@section('content')
<style>
    .summary-row { display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; }
    .badge-aktif { background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; }
    .badge-nonaktif { background: #f3f4f6; color: #4b5563; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; }
</style>

<a href="{{ route('laporan.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali ke Pusat Laporan</a>

<div class="page-header">
    <div class="page-title">
        <h3>Laporan Warisan Budaya</h3>
        <p>Rekap data warisan budaya yang ditambahkan pada periode terpilih.</p>
    </div>
    <a href="{{ route('laporan.warisan.csv', request()->query()) }}" class="btn-outline"><i class="fa-solid fa-file-csv"></i> Unduh CSV</a>
</div>

<form method="GET" class="filter-bar">
    <select name="periode" onchange="this.form.submit()">
        <option value="harian" {{ $periode == 'harian' ? 'selected' : '' }}>Harian</option>
        <option value="mingguan" {{ $periode == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
        <option value="bulanan" {{ $periode == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
    </select>
    <select name="kategori_id" onchange="this.form.submit()">
        <option value="all">Semua Kategori</option>
        @foreach($kategoris as $kat)
            <option value="{{ $kat->kategori_id }}" {{ request('kategori_id') == $kat->kategori_id ? 'selected' : '' }}>{{ $kat->nama }}</option>
        @endforeach
    </select>
</form>

<div class="periode-info">
    Menampilkan data dari <strong>{{ $dari->translatedFormat('d M Y') }}</strong> sampai <strong>{{ $sampai->translatedFormat('d M Y') }}</strong>
</div>

<div class="summary-row">
    <div class="summary-box">
        <div class="num">{{ $warisans->total() }}</div>
        <div class="label">Total Warisan (periode ini)</div>
    </div>
    @foreach($totalPerKategori as $tk)
    <div class="summary-box">
        <div class="num">{{ $tk->total }}</div>
        <div class="label">{{ $tk->nama }}</div>
    </div>
    @endforeach
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>JUDUL</th>
                <th>KATEGORI</th>
                <th>LOKASI</th>
                <th>STATUS</th>
                <th>DILIHAT</th>
                <th>DITAMBAHKAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warisans as $w)
            <tr>
                <td><strong>{{ $w->judul }}</strong></td>
                <td style="color: var(--text-gray);">{{ $w->kategori->nama ?? '-' }}</td>
                <td style="color: var(--text-gray);">{{ $w->lokasi }}</td>
                <td><span class="badge {{ $w->status == 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">{{ ucfirst($w->status) }}</span></td>
                <td style="color: var(--text-gray);">{{ $w->jumlah_dilihat }}</td>
                <td style="color: var(--text-gray);">{{ $w->created_at->translatedFormat('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; color: var(--text-gray); padding: 40px;">Tidak ada data warisan budaya pada periode ini.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="table-footer">
        <div>Menampilkan {{ $warisans->firstItem() ?? 0 }} - {{ $warisans->lastItem() ?? 0 }} dari {{ $warisans->total() }} data</div>
        @if($warisans->hasPages())
        <div class="pagination-controls">
            @if($warisans->onFirstPage())
                <span class="page-btn" style="color:#ccc;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $warisans->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif
            <span class="page-btn active">{{ $warisans->currentPage() }}</span>
            @if($warisans->hasMorePages())
                <a href="{{ $warisans->nextPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="page-btn" style="color:#ccc;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

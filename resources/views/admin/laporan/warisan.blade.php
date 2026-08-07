@extends('layouts.admin')

@section('header_title', 'Laporan Koleksi Budaya')

@section('content')
<style>
    :root {
        --primary-red: #7a1b1b;
        --text-dark: #1a1a2e;
        --text-gray: #43536a;
        --success-green: #2e7d32;
        --danger-red: #c62828;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-gray);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 20px;
        transition: color 0.2s;
    }
    .btn-back:hover {
        color: var(--primary-red);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 24px;
    }
    .page-title h3 {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 4px 0;
    }
    .page-title p {
        color: var(--text-gray);
        font-size: 14px;
        margin: 0;
    }
    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        border: 1.5px solid var(--primary-red);
        border-radius: 8px;
        color: var(--primary-red);
        background: transparent;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-outline:hover {
        background: var(--primary-red);
        color: white;
    }

    .filter-bar {
        display: flex;
        gap: 12px;
        margin: 0 0 16px 0;
        flex-wrap: wrap;
    }
    .filter-bar select {
        padding: 10px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        font-size: 14px;
        cursor: pointer;
        outline: none;
        min-width: 150px;
        transition: border-color 0.2s;
        color: var(--text-dark);
    }
    .filter-bar select:focus {
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(122, 27, 27, 0.1);
    }
    .filter-bar select:hover {
        border-color: var(--primary-red);
    }

    .periode-info {
        background: #f8f4ed;
        padding: 12px 18px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
        color: var(--text-gray);
        border-left: 4px solid var(--primary-red);
    }
    .periode-info strong {
        color: var(--text-dark);
    }

    .summary-row {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .summary-box {
        flex: 1;
        min-width: 150px;
        background: #fff;
        border-radius: 12px;
        padding: 20px 24px;
        text-align: center;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .summary-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }
    .summary-box .num {
        font-size: 28px;
        font-weight: 700;
        color: var(--primary-red);
        font-family: 'Playfair Display', serif;
        line-height: 1.2;
    }
    .summary-box .label {
        font-size: 12px;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 4px;
        font-weight: 600;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    .data-table thead {
        background: #f8f4ed;
        border-bottom: 2px solid rgba(122, 27, 27, 0.08);
    }
    .data-table thead th {
        padding: 14px 18px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-gray);
        white-space: nowrap;
    }
    .data-table tbody tr {
        border-bottom: 1px solid rgba(15, 23, 42, 0.05);
        transition: background 0.2s;
    }
    .data-table tbody tr:hover {
        background: #faf8f6;
    }
    .data-table tbody tr:last-child {
        border-bottom: none;
    }
    .data-table tbody td {
        padding: 14px 18px;
        color: var(--text-dark);
        vertical-align: middle;
    }
    .data-table tbody td .judul-text {
        font-weight: 600;
        color: var(--text-dark);
    }

    .status-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        min-width: 60px;
    }
    .status-badge.aktif {
        background: #e8f5e9;
        color: var(--success-green);
    }
    .status-badge.nonaktif {
        background: #f3f4f6;
        color: var(--text-gray);
    }

    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 16px 18px;
        border-top: 1px solid rgba(15, 23, 42, 0.06);
        font-size: 13px;
        color: var(--text-gray);
        background: #faf8f6;
    }
    .pagination-controls {
        display: flex;
        gap: 6px;
        align-items: center;
    }
    .page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: white;
        color: var(--text-dark);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
        cursor: pointer;
    }
    .page-btn:hover:not(.active) {
        background: #f8f4ed;
        border-color: var(--primary-red);
    }
    .page-btn.active {
        background: var(--primary-red);
        color: white;
        border-color: var(--primary-red);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-gray);
    }
    .empty-state i {
        font-size: 48px;
        color: #d1d5db;
        margin-bottom: 16px;
        display: block;
    }
    .empty-state h4 {
        font-size: 18px;
        color: var(--text-dark);
        margin-bottom: 8px;
    }
    .empty-state p {
        font-size: 14px;
        margin: 0;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
        }
        .filter-bar {
            flex-direction: column;
        }
        .filter-bar select {
            width: 100%;
        }
        .summary-row {
            flex-direction: column;
        }
        .summary-box {
            min-width: 100%;
        }
        .data-table {
            font-size: 13px;
        }
        .data-table thead th,
        .data-table tbody td {
            padding: 10px 12px;
        }
        .table-footer {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .table-container {
            overflow-x: auto;
        }
        .data-table {
            min-width: 600px;
        }
    }

    @media (max-width: 480px) {
        .summary-box {
            padding: 16px;
        }
        .summary-box .num {
            font-size: 22px;
        }
    }
</style>

<a href="{{ route('laporan.index') }}" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i> Kembali ke Pusat Laporan
</a>

<div class="page-header">
    <div class="page-title">
        <h3>Laporan Koleksi Budaya</h3>
        <p>Rekap data koleksi budaya yang ditambahkan pada periode terpilih.</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('laporan.warisan.csv', request()->query()) }}" class="btn-outline">
            <i class="fa-solid fa-file-csv"></i> Unduh CSV
        </a>
        <a href="{{ route('laporan.warisan.pdf', request()->query()) }}" class="btn-outline">
            <i class="fa-solid fa-file-pdf"></i> Unduh PDF
        </a>
    </div>
</div>

<form method="GET" class="filter-bar">
    <select name="periode" onchange="this.form.submit()">
        <option value="harian" {{ $periode == 'harian' ? 'selected' : '' }}>Harian</option>
        <option value="mingguan" {{ $periode == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
        <option value="bulanan" {{ $periode == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
    </select>
    <select name="kategori_id" onchange="this.form.submit()">
        <option value="all" {{ request('kategori_id') == 'all' || !request('kategori_id') ? 'selected' : '' }}>Semua Kategori</option>
        @foreach($kategoris as $kat)
            <option value="{{ $kat->kategori_id }}" {{ request('kategori_id') == $kat->kategori_id ? 'selected' : '' }}>
                {{ $kat->nama }}
            </option>
        @endforeach
    </select>
</form>

<div class="periode-info">
    <i class="fa-regular fa-calendar"></i> 
    Menampilkan data dari <strong>{{ $dari->translatedFormat('d M Y') }}</strong> sampai <strong>{{ $sampai->translatedFormat('d M Y') }}</strong>
</div>

<div class="summary-row">
    <div class="summary-box">
        <div class="num">{{ $warisans->total() }}</div>
        <div class="label">Total Koleksi (Periode Ini)</div>
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
                <th>Judul</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Dilihat</th>
                <th>Ditambahkan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warisans as $w)
            <tr>
                <td><span class="judul-text">{{ $w->judul }}</span></td>
                <td style="color: var(--text-gray);">{{ $w->kategori->nama ?? '-' }}</td>
                <td style="color: var(--text-gray);">{{ $w->lokasi }}</td>
                <td>
                    <span class="status-badge {{ $w->status == 'aktif' ? 'aktif' : 'nonaktif' }}">
                        {{ ucfirst($w->status) }}
                    </span>
                </td>
                <td style="color: var(--text-gray); text-align: center;">{{ $w->jumlah_dilihat }}</td>
                <td style="color: var(--text-gray); font-size: 13px;">
                    {{ $w->created_at->translatedFormat('d M Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="fa-regular fa-box-open"></i>
                        <h4>Tidak Ada Data</h4>
                        <p>Belum ada koleksi budaya yang ditambahkan pada periode ini.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($warisans->total() > 0)
    <div class="table-footer">
        <div>
            Menampilkan {{ $warisans->firstItem() ?? 0 }} - {{ $warisans->lastItem() ?? 0 }} 
            dari {{ $warisans->total() }} data
        </div>
        @if($warisans->hasPages())
        <div class="pagination-controls">
            @if($warisans->onFirstPage())
                <span class="page-btn" style="color:#ccc; cursor:not-allowed;">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $warisans->previousPageUrl() }}" class="page-btn">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            @php
                $currentPage = $warisans->currentPage();
                $lastPage = $warisans->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
            @endphp

            @if($start > 1)
                <a href="{{ $warisans->url(1) }}" class="page-btn">1</a>
                @if($start > 2)
                    <span class="page-btn" style="border:none;">...</span>
                @endif
            @endif

            @for($i = $start; $i <= $end; $i++)
                <a href="{{ $warisans->url($i) }}" class="page-btn {{ $i == $currentPage ? 'active' : '' }}">
                    {{ $i }}
                </a>
            @endfor

            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <span class="page-btn" style="border:none;">...</span>
                @endif
                <a href="{{ $warisans->url($lastPage) }}" class="page-btn">{{ $lastPage }}</a>
            @endif

            @if($warisans->hasMorePages())
                <a href="{{ $warisans->nextPageUrl() }}" class="page-btn">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @else
                <span class="page-btn" style="color:#ccc; cursor:not-allowed;">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            @endif
        </div>
        @endif
    </div>
    @endif
</div>

@endsection
@extends('layouts.admin')

@section('header_title', 'Laporan Aktivitas Komentar')

@section('content')
<style>
    :root {
        --primary-red: #7a1b1b;
        --text-dark: #1a1a2e;
        --text-gray: #43536a;
        --success-green: #2e7d32;
        --warning-yellow: #f59e0b;
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

    /* ===== SUMMARY STATS - SEPERTI GAMBAR 1 ===== */
    .summary-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .summary-box {
        background: #fff;
        border-radius: 12px;
        padding: 24px 20px;
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
        font-size: 32px;
        font-weight: 700;
        color: var(--text-dark);
        font-family: 'Playfair Display', serif;
        line-height: 1.2;
    }
    .summary-box .num.total {
        color: var(--primary-red);
    }
    .summary-box .num.approved {
        color: var(--success-green);
    }
    .summary-box .num.pending {
        color: var(--warning-yellow);
    }
    .summary-box .num.rejected {
        color: var(--danger-red);
    }
    .summary-box .label {
        font-size: 13px;
        color: var(--text-gray);
        margin-top: 6px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
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
    .data-table tbody td .warisan-title {
        font-weight: 600;
        color: var(--text-dark);
    }
    .data-table tbody td .komentar-text {
        max-width: 250px;
        display: block;
        color: var(--text-gray);
        line-height: 1.5;
    }
    .data-table tbody td .nama-pengunjung {
        font-weight: 500;
        color: var(--text-dark);
    }

    /* ===== STATUS BADGE TANPA EMOJI ===== */
    .status-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        min-width: 80px;
    }
    .status-badge.approved {
        background: #e8f5e9;
        color: var(--success-green);
    }
    .status-badge.pending {
        background: #fef3c7;
        color: #d97706;
    }
    .status-badge.rejected {
        background: #ffebee;
        color: var(--danger-red);
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
            grid-template-columns: repeat(2, 1fr);
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
        .summary-row {
            grid-template-columns: 1fr;
        }
        .summary-box {
            padding: 16px;
        }
        .summary-box .num {
            font-size: 24px;
        }
    }
</style>

<a href="{{ route('laporan.index') }}" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i> Kembali ke Pusat Laporan
</a>

<div class="page-header">
    <div class="page-title">
        <h3>Laporan Aktivitas Komentar</h3>
        <p>Rekap moderasi komentar pengunjung pada periode terpilih.</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('laporan.komentar.csv', request()->query()) }}" class="btn-outline">
            <i class="fa-solid fa-file-csv"></i> Unduh CSV
        </a>
        <a href="{{ route('laporan.komentar.pdf', request()->query()) }}" class="btn-outline">
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
    <select name="status" onchange="this.form.submit()">
        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>Semua Status</option>
        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
    </select>
</form>

<div class="periode-info">
    <i class="fa-regular fa-calendar"></i> 
    Periode: <strong>{{ $dari->translatedFormat('d M Y') }}</strong> - <strong>{{ $sampai->translatedFormat('d M Y') }}</strong>
</div>

<div class="summary-row">
    <div class="summary-box">
        <div class="num total">{{ ($rekap['approved'] ?? 0) + ($rekap['pending'] ?? 0) + ($rekap['rejected'] ?? 0) }}</div>
        <div class="label">Total Komentar</div>
    </div>
    <div class="summary-box">
        <div class="num approved">{{ $rekap['approved'] ?? 0 }}</div>
        <div class="label">Disetujui</div>
    </div>
    <div class="summary-box">
        <div class="num pending">{{ $rekap['pending'] ?? 0 }}</div>
        <div class="label">Menunggu</div>
    </div>
    <div class="summary-box">
        <div class="num rejected">{{ $rekap['rejected'] ?? 0 }}</div>
        <div class="label">Ditolak</div>
    </div>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Koleksi Budaya</th>
                <th>Nama</th>
                <th>Isi Komentar</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($komentars as $k)
            <tr>
                <td>
                    <span class="warisan-title">{{ $k->warisanBudaya->judul ?? 'Koleksi Dihapus' }}</span>
                </td>
                <td>
                    <span class="nama-pengunjung">{{ $k->nama ?? 'Anonim' }}</span>
                </td>
                <td>
                    <span class="komentar-text" title="{{ $k->isi_komentar ?? '' }}">
                        {{ Str::limit($k->isi_komentar ?? '', 80) }}
                    </span>
                </td>
                <td>
                    <span class="status-badge {{ $k->status ?? 'pending' }}">
                        {{ ucfirst($k->status ?? 'Pending') }}
                    </span>
                </td>
                <td style="color: var(--text-gray); font-size: 13px;">
                    {{ $k->created_at ? $k->created_at->translatedFormat('d M Y H:i') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <i class="fa-regular fa-comment-slash"></i>
                        <h4>Tidak Ada Komentar</h4>
                        <p>Belum ada komentar yang masuk pada periode ini.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($komentars->total() > 0)
    <div class="table-footer">
        <div>
            Menampilkan {{ $komentars->firstItem() ?? 0 }} - {{ $komentars->lastItem() ?? 0 }} 
            dari {{ $komentars->total() }} komentar
        </div>
        @if($komentars->hasPages())
        <div class="pagination-controls">
            @if($komentars->onFirstPage())
                <span class="page-btn" style="color:#ccc; cursor:not-allowed;">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $komentars->previousPageUrl() }}" class="page-btn">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            @php
                $currentPage = $komentars->currentPage();
                $lastPage = $komentars->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
            @endphp

            @if($start > 1)
                <a href="{{ $komentars->url(1) }}" class="page-btn">1</a>
                @if($start > 2)
                    <span class="page-btn" style="border:none;">...</span>
                @endif
            @endif

            @for($i = $start; $i <= $end; $i++)
                <a href="{{ $komentars->url($i) }}" class="page-btn {{ $i == $currentPage ? 'active' : '' }}">
                    {{ $i }}
                </a>
            @endfor

            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <span class="page-btn" style="border:none;">...</span>
                @endif
                <a href="{{ $komentars->url($lastPage) }}" class="page-btn">{{ $lastPage }}</a>
            @endif

            @if($komentars->hasMorePages())
                <a href="{{ $komentars->nextPageUrl() }}" class="page-btn">
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
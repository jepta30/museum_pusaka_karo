@extends('layouts.admin')

@section('header_title', 'Buku Tamu Pengunjung')

@section('content')
<style>
    :root {
        --primary-red: #7a1b1b;
        --text-dark: #1a1a2e;
        --text-gray: #43536a;
        --border-color: #e2e8f0;
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
        line-height: 1.6;
    }
    .page-title .description {
        margin-top: 8px;
        padding: 12px 16px;
        background: #f8f4ed;
        border-radius: 8px;
        border-left: 4px solid var(--primary-red);
        font-size: 13px;
        color: var(--text-gray);
        line-height: 1.7;
    }
    .page-title .description strong {
        color: var(--text-dark);
    }
    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
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
    .btn-success {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border: none;
        border-radius: 8px;
        color: white;
        background: #2e7d32;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
        white-space: nowrap;
        cursor: pointer;
    }
    .btn-success:hover {
        background: #1b5e20;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
    }

    .info-box {
        background: #f8f4ed;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
        border-left: 4px solid var(--primary-red);
        font-size: 14px;
        color: var(--text-gray);
        line-height: 1.7;
    }
    .info-box strong {
        color: var(--text-dark);
    }

    .summary-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .summary-box {
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
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-red);
        font-family: 'Playfair Display', serif;
        line-height: 1.2;
    }
    .summary-box .label {
        font-size: 13px;
        color: var(--text-gray);
        margin-top: 4px;
        font-weight: 500;
    }

    .filter-section {
        background: #f8f4ed;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
    }
    .filter-section .search-box {
        flex: 2;
        min-width: 200px;
        position: relative;
    }
    .filter-section .search-box input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
        background: white;
    }
    .filter-section .search-box input:focus {
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(122, 27, 27, 0.1);
    }
    .filter-section .search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-gray);
    }
    .filter-section .date-input {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .filter-section .date-input input {
        padding: 10px 14px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
        background: white;
        min-width: 130px;
    }
    .filter-section .date-input input:focus {
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(122, 27, 27, 0.1);
    }
    .filter-section .date-input span {
        color: var(--text-gray);
        font-weight: 500;
        font-size: 14px;
    }
    .filter-section .btn-filter {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        border: none;
        border-radius: 8px;
        background: var(--primary-red);
        color: white;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .filter-section .btn-filter:hover {
        background: #5a1414;
    }
    .filter-section .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: white;
        color: #666;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }
    .filter-section .btn-reset:hover {
        background: #f5f5f5;
        border-color: #999;
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
    .data-table tbody td .no-tamu {
        font-weight: 600;
        color: var(--primary-red);
        font-size: 13px;
    }
    .data-table tbody td .nama-tamu {
        font-weight: 600;
        color: var(--text-dark);
    }
    .data-table tbody td .alamat,
    .data-table tbody td .pekerjaan {
        color: var(--text-gray);
    }

    .action-buttons {
        display: flex;
        gap: 6px;
    }
    .action-buttons .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background: white;
        color: var(--text-gray);
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s;
        cursor: pointer;
    }
    .action-buttons .btn-action:hover {
        background: var(--primary-red);
        color: white;
        border-color: var(--primary-red);
    }
    .action-buttons .btn-action.delete:hover {
        background: #c62828;
        border-color: #c62828;
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
        border: 1px solid var(--border-color);
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
        .header-actions {
            width: 100%;
        }
        .header-actions .btn-outline,
        .header-actions .btn-success {
            flex: 1;
            justify-content: center;
            font-size: 12px;
            padding: 8px 12px;
        }
        .summary-row {
            grid-template-columns: 1fr;
        }
        .filter-section {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-section .search-box {
            min-width: 100%;
        }
        .filter-section .date-input {
            flex-wrap: wrap;
        }
        .filter-section .date-input input {
            flex: 1;
            min-width: 100px;
        }
        .filter-section .btn-filter,
        .filter-section .btn-reset {
            width: 100%;
            justify-content: center;
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
        .action-buttons .btn-action {
            width: 28px;
            height: 28px;
            font-size: 11px;
        }
    }
</style>

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="page-title">
        <h3>Buku Tamu Pengunjung</h3>
        <p>Catat, pantau, dan buat laporan kunjungan fisik pengunjung Museum Pusaka Karo. Semua entri disimpan di database dan bisa diekspor sebagai CSV.</p>
        <p class="description">
            <i class="fa-solid fa-info-circle" style="color: var(--primary-red);"></i>
            Gunakan tombol <strong>Catat Kunjungan</strong> untuk mencatat kunjungan manual, atau minta pengunjung membuka 
            <strong>Halaman Utama</strong> untuk mengisi otomatis.
        </p>
    </div>
    <div class="header-actions">
        <a href="{{ route('pengunjung.export') }}" class="btn-outline">
            <i class="fa-solid fa-file-csv"></i> Unduh CSV
        </a>
        <a href="{{ route('home') }}" class="btn-outline" target="_blank">
            <i class="fa-solid fa-globe"></i> Form Publik
        </a>
        <a href="{{ route('pengunjung.index') }}" class="btn-success">
            <i class="fa-solid fa-plus"></i> Catat Kunjungan
        </a>
    </div>
</div>

{{-- INFO --}}
<div class="info-box">
    <i class="fa-regular fa-circle-info"></i>
    Semua kunjungan yang masuk lewat Buku Tamu Publik dan entri admin dicatat di sini. 
    Gunakan filter untuk mencari nama, alamat, pekerjaan, atau periode tanggal tertentu.
</div>

{{-- SUMMARY --}}
<div class="summary-row">
    <div class="summary-box">
        <div class="num">{{ $totalPengunjung ?? 0 }}</div>
        <div class="label">Total Pengunjung</div>
    </div>
    <div class="summary-box">
        <div class="num">{{ $pengunjungHariIni ?? 0 }}</div>
        <div class="label">Pengunjung Hari Ini</div>
    </div>
    <div class="summary-box">
        <div class="num">{{ $pengunjungs->total() ?? 0 }}</div>
        <div class="label">Tampil di Halaman</div>
    </div>
</div>

{{-- INFO FOOTER --}}
<div class="info-box" style="margin-bottom: 24px;">
    <i class="fa-regular fa-file-lines"></i>
    Data kunjungan yang masuk di halaman ini menjadi sumber laporan buku tamu. 
    Pilih <strong>Unduh CSV</strong> untuk menghasilkan laporan yang dapat dicetak atau dibagikan.
</div>

{{-- FILTER --}}
<form method="GET" class="filter-section">
    <div class="search-box">
        <i class="fa-solid fa-search"></i>
        <input type="text" name="search" placeholder="Cari nama / alamat / pekerjaan..." value="{{ request('search') }}">
    </div>
    <div class="date-input">
        <input type="date" name="dari" value="{{ request('dari') }}">
        <span>s/d</span>
        <input type="date" name="sampai" value="{{ request('sampai') }}">
    </div>
    <button type="submit" class="btn-filter">
        <i class="fa-solid fa-filter"></i> Filter
    </button>
    @if(request()->has('search') || request()->has('dari') || request()->has('sampai'))
        <a href="{{ route('pengunjung.index') }}" class="btn-reset">
            <i class="fa-solid fa-times"></i> Reset
        </a>
    @endif
</form>

{{-- TABLE --}}
<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>No. Pengunjung</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Pekerjaan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengunjungs as $p)
            <tr>
                <td><span class="no-tamu">{{ $p->no_pengunjung }}</span></td>
                <td><span class="nama-tamu">{{ $p->nama }}</span></td>
                <td><span class="alamat">{{ $p->alamat ?? '-' }}</span></td>
                <td><span class="pekerjaan">{{ $p->pekerjaan ?? '-' }}</span></td>
                <td style="color: var(--text-gray); font-size: 13px;">
                    {{ $p->created_at ? $p->created_at->translatedFormat('d M Y') : '-' }}
                </td>
                <td>
                    <div class="action-buttons">
                        {{-- ===== PERBAIKAN: Hapus tombol edit karena route tidak ada ===== --}}
                        {{-- <a href="{{ route('pengunjung.edit', $p->pengunjung_id) }}" class="btn-action edit" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </a> --}}
                        <button class="btn-action delete" title="Hapus" onclick="confirmDelete({{ $p->pengunjung_id }})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    <form id="delete-form-{{ $p->pengunjung_id }}" 
                          action="{{ url('/pengunjung/' . $p->pengunjung_id) }}" 
                          method="POST" 
                          style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="fa-regular fa-address-book"></i>
                        <h4>Belum Ada Data Pengunjung</h4>
                        <p>Silakan catat kunjungan pertama dengan mengklik tombol "Catat Kunjungan".</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($pengunjungs->total() > 0)
    <div class="table-footer">
        <div>
            Menampilkan {{ $pengunjungs->firstItem() ?? 0 }} - {{ $pengunjungs->lastItem() ?? 0 }} 
            dari {{ $pengunjungs->total() }} pengunjung
        </div>
        @if($pengunjungs->hasPages())
        <div class="pagination-controls">
            @if($pengunjungs->onFirstPage())
                <span class="page-btn" style="color:#ccc; cursor:not-allowed;">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $pengunjungs->previousPageUrl() }}" class="page-btn">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            @php
                $currentPage = $pengunjungs->currentPage();
                $lastPage = $pengunjungs->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
            @endphp

            @if($start > 1)
                <a href="{{ $pengunjungs->url(1) }}" class="page-btn">1</a>
                @if($start > 2)
                    <span class="page-btn" style="border:none;">...</span>
                @endif
            @endif

            @for($i = $start; $i <= $end; $i++)
                <a href="{{ $pengunjungs->url($i) }}" class="page-btn {{ $i == $currentPage ? 'active' : '' }}">
                    {{ $i }}
                </a>
            @endfor

            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <span class="page-btn" style="border:none;">...</span>
                @endif
                <a href="{{ $pengunjungs->url($lastPage) }}" class="page-btn">{{ $lastPage }}</a>
            @endif

            @if($pengunjungs->hasMorePages())
                <a href="{{ $pengunjungs->nextPageUrl() }}" class="page-btn">
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

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data pengunjung ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>

@endsection
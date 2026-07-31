@extends('layouts.admin')

@section('header_title', 'Buku Induk Koleksi')

@section('content')
<style>
    :root {
        --primary-red: #7a1b1b;
        --text-dark: #1a1a2e;
        --text-gray: #43536a;
        --success-green: #2e7d32;
        --danger-red: #c62828;
        --border-color: #e2e8f0;
    }

    /* ===== PAGE HEADER ===== */
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
    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
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
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        border: none;
        border-radius: 8px;
        color: white;
        background: var(--primary-red);
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
        white-space: nowrap;
        cursor: pointer;
    }
    .btn-primary:hover {
        background: #5a1414;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(122, 27, 27, 0.3);
    }

    /* ===== FILTER SECTION ===== */
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
        flex: 1;
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
    .filter-section select {
        padding: 10px 16px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: white;
        font-size: 14px;
        cursor: pointer;
        outline: none;
        min-width: 150px;
        transition: border-color 0.2s;
        color: var(--text-dark);
    }
    .filter-section select:focus {
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(122, 27, 27, 0.1);
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

    /* ===== TABLE ===== */
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
    .data-table tbody td .kode-koleksi {
        font-weight: 600;
        color: var(--primary-red);
        font-size: 13px;
    }
    .data-table tbody td .nama-koleksi {
        font-weight: 600;
        color: var(--text-dark);
    }
    .data-table tbody td .pemilik {
        color: var(--text-gray);
    }

    /* ===== ACTION BUTTONS ===== */
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
    .action-buttons .btn-action.edit:hover {
        background: #2563eb;
        border-color: #2563eb;
    }
    .action-buttons .btn-action.delete:hover {
        background: var(--danger-red);
        border-color: var(--danger-red);
    }

    /* ===== TABLE FOOTER ===== */
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

    /* ===== EMPTY STATE ===== */
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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
        }
        .header-actions {
            width: 100%;
        }
        .header-actions .btn-outline,
        .header-actions .btn-primary {
            flex: 1;
            justify-content: center;
        }
        .filter-section {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-section .search-box {
            min-width: 100%;
        }
        .filter-section select {
            width: 100%;
        }
        .filter-section .btn-filter {
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
            min-width: 700px;
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
        <h3>Buku Induk Koleksi</h3>
        <p>Inventaris koleksi fisik yang dimiliki Museum Pusaka Karo.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('koleksi.export') }}" class="btn-outline">
            <i class="fa-solid fa-file-csv"></i> Unduh CSV
        </a>
        <a href="{{ route('koleksi.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Koleksi
        </a>
    </div>
</div>

{{-- FILTER --}}
<div class="filter-section">
    <div class="search-box">
        <i class="fa-solid fa-search"></i>
        <input type="text" placeholder="Cari nama koleksi / pemilik..." id="searchInput" onkeyup="filterTable()">
    </div>
    <select id="jenisFilter" onchange="filterTable()">
        <option value="all">Semua Jenis</option>
        <option value="Etnografi">Etnografi</option>
        <option value="Geografi">Geografi</option>
        <option value="Sejarah">Sejarah</option>
    </select>
    <button class="btn-filter" onclick="filterTable()">
        <i class="fa-solid fa-filter"></i> Filter
    </button>
</div>

{{-- TABLE --}}
<div class="table-container">
    <table class="data-table" id="koleksiTable">
        <thead>
            <tr>
                <th>No. Koleksi</th>
                <th>Nama Koleksi</th>
                <th>Jenis</th>
                <th>Pemilik</th>
                <th>Cara Perolehan</th>
                <th>Tgl Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($koleksis as $koleksi)
            <tr>
                <td><span class="kode-koleksi">{{ $koleksi->kode_koleksi ?? 'KK-001' }}</span></td>
                <td><span class="nama-koleksi">{{ $koleksi->nama_koleksi }}</span></td>
                <td><span class="jenis">{{ $koleksi->jenis ?? '-' }}</span></td>
                <td><span class="pemilik">{{ $koleksi->pemilik ?? '-' }}</span></td>
                <td>{{ $koleksi->cara_perolehan ?? '-' }}</td>
                <td style="color: var(--text-gray); font-size: 13px;">
                    {{ $koleksi->tanggal_masuk ? \Carbon\Carbon::parse($koleksi->tanggal_masuk)->translatedFormat('d M Y') : '-' }}
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('koleksi.edit', $koleksi->koleksi_id) }}" class="btn-action edit" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <a href="{{ route('koleksi.show', $koleksi->koleksi_id) }}" class="btn-action" title="Lihat">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <button class="btn-action delete" title="Hapus" onclick="confirmDelete({{ $koleksi->koleksi_id }})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    <form id="delete-form-{{ $koleksi->koleksi_id }}" 
                          action="{{ route('koleksi.destroy', $koleksi->koleksi_id) }}" 
                          method="POST" 
                          style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="fa-regular fa-box-open"></i>
                        <h4>Belum Ada Data Koleksi</h4>
                        <p>Silakan tambahkan koleksi baru dengan mengklik tombol "Tambah Koleksi".</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($koleksis->total() > 0)
    <div class="table-footer">
        <div>
            Menampilkan {{ $koleksis->firstItem() ?? 0 }} - {{ $koleksis->lastItem() ?? 0 }} 
            dari {{ $koleksis->total() }} koleksi
        </div>
        @if($koleksis->hasPages())
        <div class="pagination-controls">
            @if($koleksis->onFirstPage())
                <span class="page-btn" style="color:#ccc; cursor:not-allowed;">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $koleksis->previousPageUrl() }}" class="page-btn">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            @php
                $currentPage = $koleksis->currentPage();
                $lastPage = $koleksis->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
            @endphp

            @if($start > 1)
                <a href="{{ $koleksis->url(1) }}" class="page-btn">1</a>
                @if($start > 2)
                    <span class="page-btn" style="border:none;">...</span>
                @endif
            @endif

            @for($i = $start; $i <= $end; $i++)
                <a href="{{ $koleksis->url($i) }}" class="page-btn {{ $i == $currentPage ? 'active' : '' }}">
                    {{ $i }}
                </a>
            @endfor

            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <span class="page-btn" style="border:none;">...</span>
                @endif
                <a href="{{ $koleksis->url($lastPage) }}" class="page-btn">{{ $lastPage }}</a>
            @endif

            @if($koleksis->hasMorePages())
                <a href="{{ $koleksis->nextPageUrl() }}" class="page-btn">
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
function filterTable() {
    var input = document.getElementById('searchInput');
    var filter = input.value.toLowerCase();
    var jenisFilter = document.getElementById('jenisFilter').value;
    var table = document.getElementById('koleksiTable');
    var tr = table.getElementsByTagName('tr');

    for (var i = 1; i < tr.length; i++) {
        var tdNama = tr[i].getElementsByTagName('td')[1];
        var tdPemilik = tr[i].getElementsByTagName('td')[3];
        var tdJenis = tr[i].getElementsByTagName('td')[2];
        
        if (tdNama && tdPemilik && tdJenis) {
            var namaValue = tdNama.textContent || tdNama.innerText;
            var pemilikValue = tdPemilik.textContent || tdPemilik.innerText;
            var jenisValue = tdJenis.textContent || tdJenis.innerText;
            
            var matchSearch = namaValue.toLowerCase().indexOf(filter) > -1 || 
                            pemilikValue.toLowerCase().indexOf(filter) > -1;
            var matchJenis = jenisFilter === 'all' || jenisValue.toLowerCase() === jenisFilter;
            
            if (matchSearch && matchJenis) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus koleksi ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>

@endsection
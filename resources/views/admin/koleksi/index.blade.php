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
    
    /* ===== MODAL ===== */
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5); display: none;
        align-items: center; justify-content: center; z-index: 1000;
    }
    .modal-overlay.active { display: flex; }
    .modal-content {
        background: white; border-radius: 12px; width: 90%; max-width: 650px;
        max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;
    }
    .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 25px; border-bottom: 1px solid var(--border-color); }
    .modal-header h4 { margin: 0; font-size: 18px; color: var(--text-dark); }
    .btn-close { background: none; border: none; font-size: 18px; cursor: pointer; color: var(--text-gray); }
    
    .modal-body { padding: 25px; overflow-y: auto; }
    
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--text-gray); margin-bottom: 6px; }
    .form-group input, .form-group select, .form-group textarea {
        width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 14px;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
        border-color: var(--primary-red); outline: none; box-shadow: 0 0 0 3px rgba(122, 27, 27, 0.1);
    }
    .modal-footer { padding: 15px 25px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 10px; background: #faf8f6; }
    .modal-footer button { padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; border: none; font-size: 14px; }
    .btn-cancel { background: #e2e8f0; color: var(--text-dark); }
    .btn-save { background: var(--primary-red); color: white; }
</style>

{{-- ALERT MESSAGE --}}
@if(session('success'))
<div style="background-color: #d1fae5; color: #065f46; padding: 14px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #34d399;">
    <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}
</div>
@endif

@if($errors->any())
<div style="background-color: #fee2e2; color: #991b1b; padding: 14px; border-radius: 8px; margin-bottom: 20px; font-size: 13px;">
    <strong>Terjadi Kesalahan:</strong>
    <ul style="margin: 5px 0 0 20px;">
        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
</div>
@endif

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="page-title">
        <h3>Buku Induk Koleksi</h3>
        <p>Inventaris koleksi fisik yang dimiliki Museum Pusaka Karo.</p>
    </div>
    <div class="header-actions">
        <div class="dropdown-export" style="display: inline-block; margin-right: 10px;">
            <a href="{{ route('koleksi.export.pdf') }}" class="btn-outline" style="color: #b91c1c; border-color: #b91c1c;"><i class="fa-solid fa-file-pdf"></i> Unduh PDF</a>
            <a href="{{ route('koleksi.export') }}" class="btn-outline"><i class="fa-solid fa-file-csv"></i> Unduh CSV</a>
        </div>
        <button type="button" class="btn-add" onclick="openModal('add')"><i class="fa-solid fa-plus"></i> Tambah Koleksi</button>
    </div>
</div>

{{-- FILTER --}}
<div class="filter-section">
    <form action="{{ route('koleksi.index') }}" method="GET" style="display: flex; gap: 10px; width: 100%;" id="filterForm">
        <div class="search-box" style="flex: 1;">
            <i class="fa-solid fa-search"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor / nama koleksi..." id="searchInput">
        </div>
        <select name="jenis" id="jenisFilter" onchange="document.getElementById('filterForm').submit()">
            <option value="all">Semua Jenis</option>
            @if(isset($jenisKoleksiOptions))
                @foreach($jenisKoleksiOptions as $jenis)
                    <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                @endforeach
            @endif
        </select>
        <button type="submit" class="btn-filter">
            <i class="fa-solid fa-filter"></i> Cari
        </button>
    </form>
</div>

{{-- TABLE --}}
<div class="table-container">
    <table class="data-table" id="koleksiTable">
        <thead>
            <tr>
                <th>Nomor Koleksi</th>
                <th>Nama Koleksi</th>
                <th>Jenis Koleksi</th>
                <th>Nama Pemilik/Penitip</th>
                <th>Cara Perolehan</th>
                <th>Tempat Perolehan</th>
                <th>Tanggal Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($koleksis as $koleksi)
            <tr>
                <td><span class="kode-koleksi">{{ $koleksi->nomor_koleksi ?? '11.02.01' }}</span></td>
                <td><span class="nama-koleksi">{{ $koleksi->nama_koleksi }}</span></td>
                <td><span class="jenis">{{ $koleksi->jenis_koleksi ?? '-' }}</span></td>
                <td><span class="pemilik">{{ $koleksi->nama_pemilik ?? '-' }}</span></td>
                <td>{{ $koleksi->cara_perolehan ?? '-' }}</td>
                <td>{{ $koleksi->tempat_perolehan ?? '-' }}</td>
                <td style="color: var(--text-gray); font-size: 13px;">
                    {{ $koleksi->tanggal_masuk ?? '-' }}
                </td>
                <td>
                    <div class="action-buttons">
                        <button type="button" data-koleksi="{{ json_encode($koleksi) }}" onclick="openEditModal(this)" class="btn-action edit" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button type="button" class="btn-action delete" title="Hapus" onclick="confirmDelete('{{ $koleksi->nomor_koleksi }}')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    <form id="delete-form-{{ $koleksi->nomor_koleksi }}" 
                          action="{{ route('koleksi.destroy', $koleksi->nomor_koleksi) }}" 
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

<!-- Modal Dialog -->
<div class="modal-overlay" id="koleksiModal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 id="modalTitle">Tambah Koleksi</h4>
            <button type="button" class="btn-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="koleksiForm" action="{{ route('koleksi.store') }}" method="POST" style="display: flex; flex-direction: column; flex: 1; overflow: hidden;">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="modal-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label>Nomor Koleksi</label>
                        <input type="text" name="nomor_koleksi" id="nomor_koleksi" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Koleksi</label>
                        <input type="text" name="nama_koleksi" id="nama_koleksi" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Koleksi</label>
                        <input type="text" name="jenis_koleksi" id="jenis_koleksi" placeholder="Contoh: Alat Pertanian">
                    </div>
                    <div class="form-group">
                        <label>Nama Pemilik/Penitip</label>
                        <input type="text" name="nama_pemilik" id="nama_pemilik">
                    </div>
                    <div class="form-group">
                        <label>Cara Perolehan</label>
                        <input type="text" name="cara_perolehan" id="cara_perolehan">
                    </div>
                    <div class="form-group">
                        <label>Tempat Perolehan</label>
                        <input type="text" name="tempat_perolehan" id="tempat_perolehan">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Masuk</label>
                        <input type="text" name="tanggal_masuk" id="tanggal_masuk" placeholder="Contoh: 2011 atau 16/7/2013">
                    </div>
                </div>
                <div class="form-group" style="margin-top: 15px;">
                    <label>Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"></textarea>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-content" style="max-width: 400px; text-align: center; margin: 15vh auto; padding: 30px;">
        <i class="fa-solid fa-triangle-exclamation" style="font-size: 48px; color: var(--danger-red); margin-bottom: 15px;"></i>
        <h4 style="margin-bottom: 10px; font-size: 18px; color: var(--text-dark);">Hapus Koleksi?</h4>
        <p style="color: var(--text-gray); margin-bottom: 25px; font-size: 14px;">Data koleksi ini akan dihapus secara permanen dan tidak dapat dikembalikan.</p>
        <div style="display: flex; justify-content: center; gap: 10px;">
            <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <button class="btn-save" style="background: var(--danger-red);" onclick="submitDelete()">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
let deleteId = null;

function openEditModal(btn) {
    let data = JSON.parse(btn.getAttribute('data-koleksi'));
    openModal('edit', data);
}

function openModal(mode, data = null) {
    const modal = document.getElementById('koleksiModal');
    const form = document.getElementById('koleksiForm');
    const title = document.getElementById('modalTitle');
    const method = document.getElementById('formMethod');
    
    form.reset();
    
    if (mode === 'add') {
        title.textContent = 'Tambah Koleksi Baru';
        form.action = '{{ route("koleksi.store") }}';
        method.value = 'POST';
        document.getElementById('nomor_koleksi').value = '11.02.0' + Math.floor(Math.random() * 9 + 1);
    } else if (mode === 'edit') {
        title.textContent = 'Ubah Data Koleksi';
        form.action = '/koleksi/' + data.nomor_koleksi;
        method.value = 'PUT';
        
        document.getElementById('nomor_koleksi').value = data.nomor_koleksi || '';
        document.getElementById('nama_koleksi').value = data.nama_koleksi || '';
        document.getElementById('jenis_koleksi').value = data.jenis_koleksi || '';
        document.getElementById('nama_pemilik').value = data.nama_pemilik || '';
        document.getElementById('cara_perolehan').value = data.cara_perolehan || '';
        document.getElementById('tempat_perolehan').value = data.tempat_perolehan || '';
        document.getElementById('tanggal_masuk').value = data.tanggal_masuk || '';
        document.getElementById('keterangan').value = data.keterangan || '';
    }
    
    modal.classList.add('active');
}

function closeModal() {
    document.getElementById('koleksiModal').classList.remove('active');
}

function filterTable() {
    // Digantikan dengan pencarian backend (form submit)
    document.getElementById('filterForm').submit();
}

function confirmDelete(id) {
    deleteId = id;
    document.getElementById('deleteModal').classList.add('active');
}

function closeDeleteModal() {
    deleteId = null;
    document.getElementById('deleteModal').classList.remove('active');
}

function submitDelete() {
    if (deleteId) {
        document.getElementById('delete-form-' + deleteId).submit();
    }
}
</script>

@endsection
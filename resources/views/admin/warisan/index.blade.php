@extends('layouts.admin')

@section('header_title', 'Warisan Budaya')

@section('content')
<style>
    .page-header { margin-bottom: 25px; }
    .page-title h3 { font-family: 'Playfair Display', serif; font-size: 24px; color: var(--text-dark); margin-bottom: 8px; }
    .page-title p { font-size: 14px; color: var(--text-gray); }
    
    .filter-bar { display: flex; justify-content: space-between; align-items: center; margin-top: 30px; margin-bottom: 25px; }
    .filter-group { display: flex; gap: 15px; align-items: center; }
    .search-input, .select-input { padding: 10px 15px; border: 1px solid var(--border-color); border-radius: 4px; font-size: 13px; outline: none; }
    .search-input { width: 300px; }
    .select-input { background-color: white; min-width: 150px; }
    
    .btn-search { background-color: #1f2937; color: white; padding: 10px 20px; border-radius: 4px; border: none; font-size: 13px; font-weight: 500; cursor: pointer; }
    .btn-add { background-color: #f3f4f6; color: var(--text-dark); border: 1px solid var(--border-color); padding: 10px 18px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; }

    .table-container { background-color: #fff; border: 1px solid var(--border-color); border-radius: 6px; overflow: hidden; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background-color: #f6f5f3; text-align: left; padding: 15px 25px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #4b5563; border-bottom: 1px solid var(--border-color); letter-spacing: 0.5px; }
    .data-table td { padding: 20px 25px; font-size: 13px; color: var(--text-dark); border-bottom: 1px solid var(--border-color); vertical-align: middle; }
    
    .badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 500; background-color: #f3f4f6; color: #4b5563; }
    .badge.draft { background-color: #e5e7eb; }

    .action-icons { display: flex; gap: 8px; }
    .btn-action-square { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color); border-radius: 4px; color: var(--text-gray); background-color: #fff; cursor: pointer; text-decoration: none; font-size: 13px; }
    
    .table-footer { padding: 15px 25px; border-top: 1px solid var(--border-color); display: flex; justify-content: center; align-items: center; font-size: 13px; color: var(--text-gray); }
    .pagination-controls { display: flex; gap: 5px; }
    .page-btn { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color); background-color: #fff; color: var(--text-dark); text-decoration: none; border-radius: 4px; font-size: 13px; }
    .page-btn.active { background-color: #1f2937; color: #fff; border-color: #1f2937; }

    /* Modal Styles */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        display: none; justify-content: center; align-items: center;
        z-index: 1000;
    }
    .modal-overlay.active { display: flex; }
    
    .modal-content {
        background-color: #fff; width: 700px; max-width: 90%;
        border-radius: 4px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        display: flex; flex-direction: column;
        max-height: 90vh; overflow-y: auto;
    }
    
    .modal-header {
        display: flex; justify-content: space-between; align-items: center;
        padding: 20px 25px; border-bottom: 1px solid var(--border-color);
    }
    .modal-header h4 { font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .btn-close { background: none; border: none; font-size: 18px; color: var(--text-gray); cursor: pointer; }
    
    .modal-body { padding: 25px; }
    
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .form-group { display: flex; flex-direction: column; gap: 8px; }
    .form-label { font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-dark); }
    .form-control { padding: 12px 15px; border: 1px solid var(--border-color); border-radius: 4px; font-size: 13px; outline: none; font-family: 'Inter', sans-serif; }
    .form-control:focus { border-color: #1f2937; }
    
    .upload-area {
        border: 2px dashed #d1d5db; border-radius: 4px; padding: 40px 20px;
        text-align: center; cursor: pointer; background-color: #fafafa;
        transition: background-color 0.2s; position: relative;
    }
    .upload-area:hover { background-color: #f3f4f6; }
    .upload-icon { font-size: 24px; color: #4b5563; margin-bottom: 10px; }
    .upload-text { font-size: 13px; color: #4b5563; margin-bottom: 5px; }
    .upload-subtext { font-size: 11px; color: var(--text-gray); }
    .upload-input { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
    
    .modal-footer {
        padding: 20px 25px; border-top: 1px solid var(--border-color);
        display: flex; justify-content: flex-end; gap: 15px;
    }
    
    .btn-cancel { padding: 10px 25px; border: 1px solid var(--border-color); background: white; color: var(--text-dark); border-radius: 4px; font-size: 13px; font-weight: 500; cursor: pointer; }
    .btn-save { padding: 10px 25px; background: #0f172a; color: white; border: none; border-radius: 4px; font-size: 13px; font-weight: 500; cursor: pointer; }
</style>

<div class="page-header">
    <div class="page-title">
        <h3>Kelola Warisan Budaya</h3>
        <p>Manajemen data daftar warisan budaya Karo</p>
    </div>
</div>

@if(session('success'))
    <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; border: 1px solid #34d399;">
        <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 4px; margin-bottom: 20px; font-size: 13px;">
        <strong style="margin-bottom: 5px; display: block;">Terjadi Kesalahan:</strong>
        <ul style="margin-left: 20px; margin-top: 5px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="filter-bar">
    <div class="filter-group">
        <input type="text" class="search-input" placeholder="Cari judul budaya...">
        <select class="select-input">
            <option>Semua Kategori</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->kategori_id }}">{{ $kat->nama }}</option>
            @endforeach
        </select>
        <button class="btn-search">Cari</button>
    </div>
    
    <button type="button" class="btn-add" onclick="openModal('add')">
        <i class="fa-solid fa-plus"></i> Tambah Data
    </button>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="25%">NAMA</th>
                <th width="20%">KATEGORI</th>
                <th width="20%">LOKASI</th>
                <th width="15%">STATUS</th>
                <th width="15%">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warisans as $index => $warisan)
            <tr>
                <td>{{ $warisans->firstItem() + $index }}</td>
                <td><strong>{{ $warisan->judul }}</strong></td>
                <td>{{ $warisan->kategori->nama ?? 'Umum' }}</td>
                <td>{{ $warisan->lokasi }}</td>
                <td>
                    <span class="badge {{ $warisan->status == 'aktif' ? '' : 'draft' }}">
                        {{ $warisan->status == 'aktif' ? 'Publik' : 'Draf' }}
                    </span>
                </td>
                <td>
                    <div class="action-icons">
                        <button type="button" class="btn-action-square" title="Edit" onclick="openModal('edit', {{ json_encode($warisan) }})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('warisan.destroy', $warisan->warisan_budaya_id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-square" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: var(--text-gray); padding: 40px;">
                    Belum ada data warisan budaya.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="table-footer">
        <div style="font-size: 13px; color: var(--text-gray);">
            Menampilkan {{ $warisans->firstItem() ?? 0 }} sampai {{ $warisans->lastItem() ?? 0 }} dari {{ $warisans->total() }} data
        </div>
        
        @if ($warisans->hasPages())
        <div class="pagination-controls">
            {{-- Previous Page Link --}}
            @if ($warisans->onFirstPage())
                <span class="page-btn" style="color: #ccc; cursor: not-allowed;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $warisans->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($warisans->links()->elements as $element)
                @if (is_string($element))
                    <span class="page-btn" style="border: none;">{{ $element }}</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $warisans->currentPage())
                            <span class="page-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($warisans->hasMorePages())
                <a href="{{ $warisans->nextPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="page-btn" style="color: #ccc; cursor: not-allowed;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Modal Dialog -->
<div class="modal-overlay" id="warisanModal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 id="modalTitle">TAMBAH DATA BARU</h4>
            <button class="btn-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <form id="warisanForm" action="{{ route('warisan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">NAMA WARISAN BUDAYA</label>
                        <input type="text" name="judul" id="inputJudul" class="form-control" placeholder="mis. Uis Nipes" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">KATEGORI</label>
                        <select name="kategori_id" id="inputKategori" class="form-control" required>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->kategori_id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">ASAL DAERAH</label>
                        <input type="text" name="lokasi" id="inputLokasi" class="form-control" placeholder="mis. Kabanjahe, Tanah Karo" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">STATUS PUBLIKASI</label>
                        <select name="status" id="inputStatus" class="form-control" required>
                            <option value="aktif">Publik</option>
                            <option value="nonaktif">Draf</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label">DESKRIPSI</label>
                    <textarea name="deskripsi" id="inputDeskripsi" class="form-control" style="height: 120px; resize: vertical;" placeholder="Tuliskan deskripsi, sejarah, dan makna warisan budaya ini..." required></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">FOTO / GAMBAR</label>
                    <div class="upload-area">
                        <i class="fa-solid fa-arrow-up-from-bracket upload-icon"></i>
                        <div class="upload-text">Seret file ke sini atau klik untuk unggah</div>
                        <div class="upload-subtext">Format JPG/PNG, maksimal 5MB</div>
                        <input type="file" name="gambar" id="inputGambar" class="upload-input" accept="image/png, image/jpeg, image/jpg" onchange="previewFileName(this)">
                        <div id="fileNameDisplay" style="margin-top: 10px; font-weight: 600; color: #1f2937;"></div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-save">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(mode, data = null) {
        const modal = document.getElementById('warisanModal');
        const form = document.getElementById('warisanForm');
        const title = document.getElementById('modalTitle');
        const method = document.getElementById('formMethod');
        
        // Reset form
        form.reset();
        document.getElementById('fileNameDisplay').textContent = '';
        
        if (mode === 'add') {
            title.textContent = 'TAMBAH DATA BARU';
            form.action = '{{ route("warisan.store") }}';
            method.value = 'POST';
            document.getElementById('inputGambar').required = true;
        } else if (mode === 'edit') {
            title.textContent = 'UBAH DATA WARISAN';
            form.action = '/warisan/' + data.warisan_budaya_id;
            method.value = 'PUT';
            document.getElementById('inputGambar').required = false;
            
            // Populate data
            document.getElementById('inputJudul').value = data.judul;
            document.getElementById('inputKategori').value = data.kategori_id;
            document.getElementById('inputLokasi').value = data.lokasi;
            document.getElementById('inputStatus').value = data.status;
            document.getElementById('inputDeskripsi').value = data.deskripsi;
        }
        
        modal.classList.add('active');
    }
    
    function closeModal() {
        document.getElementById('warisanModal').classList.remove('active');
    }
    
    function previewFileName(input) {
        const display = document.getElementById('fileNameDisplay');
        if (input.files && input.files[0]) {
            display.textContent = "File terpilih: " + input.files[0].name;
        } else {
            display.textContent = "";
        }
    }
    
    // Check if there are validation errors, if so, reopen modal
    @if($errors->any())
        document.addEventListener("DOMContentLoaded", function() {
            openModal('add'); // Reopen to show errors
        });
    @endif
</script>
@endpush

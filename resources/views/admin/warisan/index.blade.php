@extends('layouts.admin')

@section('header_title', 'Warisan Budaya')

@section('content')
<style>
    .page-header { margin-bottom: 25px; }
    .search-input { width: 300px; }
    .action-icons { gap: 8px; }
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
            <span class="page-btn active">{{ $warisans->currentPage() }}</span>

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

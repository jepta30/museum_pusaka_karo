@extends('layouts.admin')

@section('header_title', 'Kategori Budaya')

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; }
    .page-title h3 { font-family: 'Playfair Display', serif; font-size: 24px; color: var(--text-dark); margin-bottom: 8px; }
    .page-title p { font-size: 14px; color: var(--text-gray); }

    .btn-add { background-color: #8fa0b5; color: white; padding: 10px 18px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: background-color 0.2s; cursor: pointer; border: none; }
    .btn-add:hover { background-color: #7a8a9e; }

    .table-container { background-color: #fff; border: 1px solid var(--border-color); border-radius: 6px; overflow: hidden; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background-color: #f6f5f3; text-align: left; padding: 15px 25px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #4b5563; border-bottom: 1px solid var(--border-color); letter-spacing: 0.5px; }
    .data-table td { padding: 20px 25px; font-size: 14px; color: var(--text-dark); border-bottom: 1px solid var(--border-color); vertical-align: middle; }
    .data-table tr:last-child td { border-bottom: none; }

    .table-footer { padding: 15px 25px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: var(--text-gray); }
    .pagination-controls { display: flex; gap: 5px; }
    .page-btn { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color); background-color: #fff; color: var(--text-dark); text-decoration: none; border-radius: 4px; font-size: 13px; transition: all 0.2s; }
    .page-btn.active { background-color: #4b5563; color: #fff; border-color: #4b5563; }
    .page-btn:hover:not(.active) { background-color: #f3f4f6; }

    .action-icons { display: flex; gap: 10px; }
    .btn-action-square { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color); border-radius: 4px; color: var(--text-dark); background-color: #fff; cursor: pointer; text-decoration: none; font-size: 14px; transition: all 0.2s; }
    .btn-action-square:hover { border-color: var(--primary-red); color: var(--primary-red); }

    /* Modal Styles (Meniru Gaya Halaman Warisan Budaya) */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        display: none; justify-content: center; align-items: center;
        z-index: 1000;
    }
    .modal-overlay.active { display: flex; }
    
    .modal-content {
        background-color: #fff; width: 600px; max-width: 90%;
        border-radius: 4px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        display: flex; flex-direction: column;
        max-height: 90vh; overflow-y: auto;
    }
    
    .modal-header {
        display: flex; justify-content: space-between; align-items: center;
        padding: 20px 25px; border-bottom: 1px solid var(--border-color);
    }
    .modal-header h4 { font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0; }
    .btn-close { background: none; border: none; font-size: 18px; color: var(--text-gray); cursor: pointer; }
    
    .modal-body { padding: 25px; }
    
    .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
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
        <h3>Daftar Kategori</h3>
        <p>Kelola pengelompokan jenis warisan budaya Karo.</p>
    </div>
    <button type="button" class="btn-add" onclick="openModal('add')">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
    </button>
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

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th width="10%">NO</th>
                <th width="50%">NAMA KATEGORI</th>
                <th width="25%">JUMLAH ITEM</th>
                <th width="15%">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $index => $kategori)
            <tr>
                <td>{{ ($kategoris->firstItem() ?? 1) + $index }}</td>
                <td><strong>{{ $kategori->nama }}</strong></td>
                <!-- Nanti akan dinamis dengan count() relasi -->
                <td style="color: var(--text-gray);">{{ $kategori->warisanBudayas ? $kategori->warisanBudayas->count() : 0 }}</td>
                <td>
                    <div class="action-icons">
                        <button type="button" class="btn-action-square" title="Edit" onclick="openModal('edit', {{ json_encode($kategori) }})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('kategori.destroy', $kategori->kategori_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-square" title="Hapus">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: var(--text-gray); padding: 40px;">
                    Belum ada data kategori budaya.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Footer / Pagination Area -->
    <div class="table-footer">
        <div>
            Menampilkan {{ $kategoris->firstItem() ?? 0 }} sampai {{ $kategoris->lastItem() ?? 0 }} dari {{ $kategoris->total() }} kategori
        </div>
        
        <!-- Minimalist Pagination -->
        @if ($kategoris->hasPages())
        <div class="pagination-controls">
            {{-- Previous Page Link --}}
            @if ($kategoris->onFirstPage())
                <span class="page-btn" style="color: #ccc; cursor: not-allowed;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $kategoris->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($kategoris->links()->elements as $element)
                @if (is_string($element))
                    <span class="page-btn" style="border: none;">{{ $element }}</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $kategoris->currentPage())
                            <span class="page-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($kategoris->hasMorePages())
                <a href="{{ $kategoris->nextPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="page-btn" style="color: #ccc; cursor: not-allowed;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Modal Dialog -->
<div class="modal-overlay" id="kategoriModal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 id="modalTitle">TAMBAH KATEGORI BARU</h4>
            <button class="btn-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <form id="kategoriForm" action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">NAMA KATEGORI</label>
                    <input type="text" name="nama" id="inputNama" class="form-control" placeholder="mis. Pakaian Adat" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">DESKRIPSI</label>
                    <textarea name="deskripsi" id="inputDeskripsi" class="form-control" style="height: 100px; resize: vertical;" placeholder="Tuliskan deskripsi kategori ini..." required></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">IKON / GAMBAR KATEGORI</label>
                    <div class="upload-area">
                        <i class="fa-solid fa-arrow-up-from-bracket upload-icon"></i>
                        <div class="upload-text">Seret file ke sini atau klik untuk unggah</div>
                        <div class="upload-subtext">Format JPG/PNG/SVG, maksimal 2MB</div>
                        <input type="file" name="icon" id="inputIcon" class="upload-input" accept="image/png, image/jpeg, image/jpg, image/svg+xml" onchange="previewFileName(this)">
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
        const modal = document.getElementById('kategoriModal');
        const form = document.getElementById('kategoriForm');
        const title = document.getElementById('modalTitle');
        const method = document.getElementById('formMethod');
        
        // Reset form
        form.reset();
        document.getElementById('fileNameDisplay').textContent = '';
        
        if (mode === 'add') {
            title.textContent = 'TAMBAH KATEGORI BARU';
            form.action = '{{ route("kategori.store") }}';
            method.value = 'POST';
            document.getElementById('inputIcon').required = true;
        } else if (mode === 'edit') {
            title.textContent = 'UBAH DATA KATEGORI';
            form.action = '/kategori/' + data.kategori_id;
            method.value = 'PUT';
            document.getElementById('inputIcon').required = false;
            
            // Populate data
            document.getElementById('inputNama').value = data.nama;
            document.getElementById('inputDeskripsi').value = data.deskripsi;
        }
        
        modal.classList.add('active');
    }
    
    function closeModal() {
        document.getElementById('kategoriModal').classList.remove('active');
    }
    
    function previewFileName(input) {
        const display = document.getElementById('fileNameDisplay');
        if (input.files && input.files[0]) {
            display.textContent = "File terpilih: " + input.files[0].name;
        } else {
            display.textContent = "";
        }
    }
    
    // Buka kembali modal jika ada error validasi
    @if($errors->any())
        document.addEventListener("DOMContentLoaded", function() {
            openModal('add');
        });
    @endif
</script>
@endpush

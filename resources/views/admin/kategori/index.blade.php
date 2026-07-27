@extends('layouts.admin')

@section('header_title', 'Kategori Budaya')

@section('content')

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
            <span class="page-btn active">{{ $kategoris->currentPage() }}</span>

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

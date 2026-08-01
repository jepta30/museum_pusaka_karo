@extends('layouts.admin')

@section('header_title', 'Media Dokumentasi')

@section('content')
<style>
    .filter-card { background-color: white; border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-bottom: 25px; display: flex; gap: 15px; align-items: flex-end; }
    .filter-item { display: flex; flex-direction: column; gap: 8px; }
    .filter-item.search { flex: 2; }
    .filter-item.select { flex: 1; }
    .filter-label { font-size: 11px; font-weight: 600; color: var(--text-gray); text-transform: uppercase; letter-spacing: 0.5px; }
    .input-group { position: relative; display: flex; align-items: center; }
    .input-group i { position: absolute; left: 15px; color: var(--text-gray); }
    .media-preview { width: 80px; height: 60px; background-color: #e5e7eb; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 20px; overflow: hidden; }
    .media-preview img { width: 100%; height: 100%; object-fit: cover; }
</style>

<div class="page-header">
    <div class="page-title">
        <h3>Media Dokumentasi</h3>
        <p>Kelola foto dan video warisan budaya Karo</p>
    </div>
    <div class="header-actions">
        <button type="button" class="btn-add" onclick="openModal('add')">
            <i class="fa-solid fa-plus"></i> Upload Media
        </button>
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

<form method="GET" class="filter-card">
    <div class="filter-item search">
        <label class="filter-label">CARI MEDIA</label>
        <div class="input-group">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="q" value="{{ request('q') }}" class="search-input" placeholder="Cari keterangan atau judul budaya...">
        </div>
    </div>
    <div class="filter-item select">
        <label class="filter-label">KATEGORI BUDAYA</label>
        <select class="select-input" disabled style="opacity:0.7;">
            <option>Semua Budaya</option>
        </select>
    </div>
    <div class="filter-item select">
        <label class="filter-label">JENIS MEDIA</label>
        <select class="select-input" disabled style="opacity:0.7;">
            <option>Semua Jenis</option>
        </select>
    </div>
    <div class="filter-item">
        <button type="submit" class="btn-search">Cari</button>
    </div>
</form>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="15%">PREVIEW</th>
                <th width="30%">JUDUL BUDAYA</th>
                <th width="15%">JENIS</th>
                <th width="20%">NAMA FILE</th>
                <th width="15%">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medias as $index => $media)
            <tr>
                <td>{{ ($medias->firstItem() ?? 1) + $index }}</td>
                <td>
                    @if($media->jenis_media == 'foto')
                        <div class="media-preview">
                            <img src="{{ Storage::url($media->file_media) }}" alt="Preview">
                        </div>
                    @else
                        <div class="media-preview" style="background-color: #6b7280; color: white;">
                            <i class="fa-solid fa-play"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $media->warisanBudaya->judul ?? 'Tidak diketahui' }}</strong><br>
                    <span style="font-size: 11px; color: var(--text-gray);">Ket: {{ Str::limit($media->keterangan, 30) }}</span>
                </td>
                <td>
                    <span class="badge" {!! $media->jenis_media == 'video' ? 'style="background-color: #e5e7eb;"' : '' !!}>
                        {{ ucfirst($media->jenis_media) }}
                    </span>
                </td>
                <td style="color: var(--text-gray);">{{ basename($media->file_media) }}</td>
                <td>
                    <div class="action-icons">
                        <button type="button" class="btn-action-square" title="Edit" onclick="openModal('edit', {{ json_encode($media) }})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('media.destroy', $media->media_id) }}" method="POST" onsubmit="return confirm('Hapus media ini?');" style="display: inline;">
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
                    Belum ada media dokumentasi yang diunggah.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="table-footer">
        <div>Menampilkan {{ $medias->firstItem() ?? 0 }} sampai {{ $medias->lastItem() ?? 0 }} dari {{ $medias->total() }} data</div>
        
        @if ($medias->hasPages())
        <div class="pagination-controls">
            @if ($medias->onFirstPage())
                <span class="page-btn" style="color: #ccc; cursor: not-allowed;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $medias->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif

            <span class="page-btn active">{{ $medias->currentPage() }}</span>

            @if ($medias->hasMorePages())
                <a href="{{ $medias->nextPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="page-btn" style="color: #ccc; cursor: not-allowed;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Modal Dialog -->
<div class="modal-overlay" id="mediaModal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 id="modalTitle">UPLOAD MEDIA BARU</h4>
            <button class="btn-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <form id="mediaForm" action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">WARISAN BUDAYA</label>
                        <select name="warisan_budaya_id" id="inputWarisan" class="form-control" required>
                            <option value="">-- Pilih Warisan Budaya --</option>
                            @foreach($warisans as $warisan)
                                <option value="{{ $warisan->warisan_budaya_id }}">{{ $warisan->judul }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">JENIS MEDIA</label>
                        <select name="jenis_media" id="inputJenis" class="form-control" required>
                            <option value="foto">Foto</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">KETERANGAN / JUDUL</label>
                    <input type="text" name="keterangan" id="inputKeterangan" class="form-control" placeholder="Tuliskan keterangan singkat terkait media ini..." required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">FILE MEDIA</label>
                    <div class="upload-area">
                        <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                        <div class="upload-text">Seret file media ke sini atau klik untuk memilih</div>
                        <div class="upload-subtext">Foto (JPG/PNG) atau Video (MP4/AVI), maks. 50MB</div>
                        <input type="file" name="file_media" id="inputFile" class="upload-input" accept="image/png, image/jpeg, image/jpg, video/mp4, video/avi, video/quicktime" onchange="previewFileName(this)">
                        <div id="fileNameDisplay" style="margin-top: 10px; font-weight: 600; color: #1f2937;"></div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-save">Upload Media</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(mode, data = null) {
        const modal = document.getElementById('mediaModal');
        const form = document.getElementById('mediaForm');
        const title = document.getElementById('modalTitle');
        const method = document.getElementById('formMethod');
        
        // Reset form
        form.reset();
        document.getElementById('fileNameDisplay').textContent = '';
        
        if (mode === 'add') {
            title.textContent = 'UPLOAD MEDIA BARU';
            form.action = '{{ route("media.store") }}';
            method.value = 'POST';
            document.getElementById('inputFile').required = true;
        } else if (mode === 'edit') {
            title.textContent = 'UBAH DATA MEDIA';
            form.action = '/media/' + data.media_id;
            method.value = 'PUT';
            document.getElementById('inputFile').required = false;
            
            // Populate data
            document.getElementById('inputWarisan').value = data.warisan_budaya_id;
            document.getElementById('inputJenis').value = data.jenis_media;
            document.getElementById('inputKeterangan').value = data.keterangan;
        }
        
        modal.classList.add('active');
    }
    
    function closeModal() {
        document.getElementById('mediaModal').classList.remove('active');
    }
    
    function previewFileName(input) {
        const display = document.getElementById('fileNameDisplay');
        if (input.files && input.files[0]) {
            display.textContent = "File terpilih: " + input.files[0].name;
        } else {
            display.textContent = "";
        }
    }
    
    @if($errors->any())
        document.addEventListener("DOMContentLoaded", function() {
            openModal('add');
        });
    @endif
</script>
@endpush

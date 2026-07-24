@extends('layouts.admin')

@section('header_title', 'Media Dokumentasi')

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; }
    .page-title h3 { font-family: 'Playfair Display', serif; font-size: 24px; color: var(--text-dark); margin-bottom: 8px; }
    .page-title p { font-size: 14px; color: var(--text-gray); }
    
    .btn-add { background-color: #0f172a; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; border: none; }

    .filter-card { background-color: white; border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-bottom: 25px; display: flex; gap: 15px; align-items: flex-end; }
    .filter-item { display: flex; flex-direction: column; gap: 8px; }
    .filter-item.search { flex: 2; }
    .filter-item.select { flex: 1; }
    
    .filter-label { font-size: 11px; font-weight: 600; color: var(--text-gray); text-transform: uppercase; letter-spacing: 0.5px; }
    .input-group { position: relative; display: flex; align-items: center; }
    .input-group i { position: absolute; left: 15px; color: var(--text-gray); }
    .search-input { width: 100%; padding: 12px 15px 12px 40px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 13px; outline: none; }
    .select-input { width: 100%; padding: 12px 15px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 13px; outline: none; background-color: white; }
    
    .btn-search { background-color: #f3f4f6; color: var(--text-dark); padding: 12px 25px; border-radius: 6px; border: 1px solid var(--border-color); font-size: 13px; font-weight: 600; cursor: pointer; }

    .table-container { background-color: #fff; border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background-color: #fff; text-align: left; padding: 20px 25px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #4b5563; border-bottom: 1px solid var(--border-color); letter-spacing: 0.5px; }
    .data-table td { padding: 20px 25px; font-size: 13px; color: var(--text-dark); border-bottom: 1px solid var(--border-color); vertical-align: middle; }
    
    .media-preview { width: 80px; height: 60px; background-color: #e5e7eb; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 20px; overflow: hidden; }
    .media-preview img { width: 100%; height: 100%; object-fit: cover; }
    
    .badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 500; background-color: #f3f4f6; color: #4b5563; }
    .action-icons { display: flex; gap: 8px; }
    .btn-action-square { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color); border-radius: 4px; color: var(--text-gray); background-color: #fff; cursor: pointer; text-decoration: none; font-size: 13px; transition: all 0.2s;}
    .btn-action-square:hover { color: #0f172a; border-color: #0f172a; }
    
    .table-footer { padding: 15px 25px; border-top: 1px solid var(--border-color); background-color: #f9fafb; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: var(--text-gray); }
    .pagination-controls { display: flex; gap: 5px; }
    .page-btn { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color); background-color: #fff; color: var(--text-dark); text-decoration: none; border-radius: 4px; font-size: 13px; transition: all 0.2s;}
    .page-btn.active { background-color: #0f172a; color: #fff; border-color: #0f172a; }

    /* Modal Styles */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4); display: none; justify-content: center; align-items: center; z-index: 1000; }
    .modal-overlay.active { display: flex; }
    .modal-content { background-color: #fff; width: 600px; max-width: 90%; border-radius: 4px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); display: flex; flex-direction: column; max-height: 90vh; overflow-y: auto; }
    .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 25px; border-bottom: 1px solid var(--border-color); }
    .modal-header h4 { font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0; }
    .btn-close { background: none; border: none; font-size: 18px; color: var(--text-gray); cursor: pointer; }
    .modal-body { padding: 25px; }
    .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .form-label { font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-dark); }
    .form-control { padding: 12px 15px; border: 1px solid var(--border-color); border-radius: 4px; font-size: 13px; outline: none; font-family: 'Inter', sans-serif; }
    .form-control:focus { border-color: #1f2937; }
    .upload-area { border: 2px dashed #d1d5db; border-radius: 4px; padding: 40px 20px; text-align: center; cursor: pointer; background-color: #fafafa; position: relative; }
    .upload-area:hover { background-color: #f3f4f6; }
    .upload-icon { font-size: 24px; color: #4b5563; margin-bottom: 10px; }
    .upload-text { font-size: 13px; color: #4b5563; margin-bottom: 5px; }
    .upload-subtext { font-size: 11px; color: var(--text-gray); }
    .upload-input { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
    .modal-footer { padding: 20px 25px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 15px; }
    .btn-cancel { padding: 10px 25px; border: 1px solid var(--border-color); background: white; color: var(--text-dark); border-radius: 4px; font-size: 13px; font-weight: 500; cursor: pointer; }
    .btn-save { padding: 10px 25px; background: #0f172a; color: white; border: none; border-radius: 4px; font-size: 13px; font-weight: 500; cursor: pointer; }
</style>

<div class="page-header">
    <div class="page-title">
        <h3>Media Dokumentasi</h3>
        <p>Kelola foto dan video warisan budaya Karo</p>
    </div>
    <button type="button" class="btn-add" onclick="openModal('add')">
        <i class="fa-solid fa-plus"></i> Upload Media
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

<div class="filter-card">
    <div class="filter-item search">
        <label class="filter-label">CARI MEDIA</label>
        <div class="input-group">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="search-input" placeholder="Cari judul atau file...">
        </div>
    </div>
    <div class="filter-item select">
        <label class="filter-label">KATEGORI BUDAYA</label>
        <select class="select-input">
            <option>Semua Budaya</option>
        </select>
    </div>
    <div class="filter-item select">
        <label class="filter-label">JENIS MEDIA</label>
        <select class="select-input">
            <option>Semua Jenis</option>
            <option>Foto</option>
            <option>Video</option>
        </select>
    </div>
    <div class="filter-item">
        <button class="btn-search">Cari</button>
    </div>
</div>

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

            @foreach ($medias->links()->elements as $element)
                @if (is_string($element))
                    <span class="page-btn" style="border: none;">{{ $element }}</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $medias->currentPage())
                            <span class="page-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

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

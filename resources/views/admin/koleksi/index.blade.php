@extends('layouts.admin')

@section('header_title', 'Buku Induk Koleksi')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>Buku Induk Koleksi Museum</h3>
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

@if(session('success'))
    <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; border: 1px solid #34d399;">
        <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}
    </div>
@endif

<form method="GET" class="filter-bar">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama koleksi / pemilik...">
    <select name="jenis">
        <option value="all">Semua Jenis</option>
        @foreach($jenisList as $jenis)
            <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
        @endforeach
    </select>
    <button type="submit"><i class="fa-solid fa-filter"></i> Filter</button>
</form>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>NO. KOLEKSI</th>
                <th>NAMA KOLEKSI</th>
                <th>JENIS</th>
                <th>PEMILIK</th>
                <th>CARA PEROLEHAN</th>
                <th>TGL MASUK</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($koleksis as $k)
            <tr>
                <td>{{ $k->nomor_koleksi }}</td>
                <td><strong>{{ $k->nama_koleksi }}</strong></td>
                <td style="color: var(--text-gray);">{{ $k->jenis_koleksi }}</td>
                <td style="color: var(--text-gray);">{{ $k->nama_pemilik }}</td>
                <td style="color: var(--text-gray);">{{ $k->cara_perolehan }}</td>
                <td style="color: var(--text-gray);">{{ $k->tanggal_masuk }}</td>
                <td>
                    <div class="action-icons">
                        <button type="button" class="btn-action-square" title="Edit" onclick="openModal('edit', {{ json_encode($k) }})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('koleksi.destroy', $k->nomor_koleksi) }}" method="POST" onsubmit="return confirm('Hapus data koleksi ini?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-square" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align: center; color: var(--text-gray); padding: 40px;">Belum ada data koleksi.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="table-footer">
        <div>Menampilkan {{ $koleksis->firstItem() ?? 0 }} sampai {{ $koleksis->lastItem() ?? 0 }} dari {{ $koleksis->total() }} koleksi</div>
        @if($koleksis->hasPages())
        <div class="pagination-controls">
            @if($koleksis->onFirstPage())
                <span class="page-btn" style="color:#ccc;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $koleksis->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif
            <span class="page-btn active">{{ $koleksis->currentPage() }}</span>
            @if($koleksis->hasMorePages())
                <a href="{{ $koleksis->nextPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="page-btn" style="color:#ccc;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </div>
        @endif
    </div>
</div>

<div class="modal-overlay" id="koleksiModal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 id="modalTitle">TAMBAH DATA KOLEKSI</h4>
            <button class="btn-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="koleksiForm" action="{{ route('koleksi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Koleksi</label>
                        <input type="text" name="nama_koleksi" id="inputNamaKoleksi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Koleksi</label>
                        <input type="text" name="jenis_koleksi" id="inputJenisKoleksi" class="form-control" placeholder="mis. Alat Musik" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" id="inputNamaPemilik" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cara Perolehan</label>
                        <input type="text" name="cara_perolehan" id="inputCaraPerolehan" class="form-control" placeholder="mis. Hibah, Pembelian" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Tempat Perolehan</label>
                        <input type="text" name="tempat_perolehan" id="inputTempatPerolehan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="text" name="tanggal_masuk" id="inputTanggalMasuk" class="form-control" placeholder="mis. 12 Januari 2025" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="inputKeterangan" class="form-control" style="height: 80px; resize: vertical;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-save">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal(mode, data = null) {
        const modal = document.getElementById('koleksiModal');
        const form = document.getElementById('koleksiForm');
        const title = document.getElementById('modalTitle');
        const method = document.getElementById('formMethod');
        form.reset();

        if (mode === 'add') {
            title.textContent = 'TAMBAH DATA KOLEKSI';
            form.action = '{{ route("koleksi.store") }}';
            method.value = 'POST';
        } else if (mode === 'edit') {
            title.textContent = 'UBAH DATA KOLEKSI';
            form.action = '/koleksi/' + data.nomor_koleksi;
            method.value = 'PUT';
            document.getElementById('inputNamaKoleksi').value = data.nama_koleksi;
            document.getElementById('inputJenisKoleksi').value = data.jenis_koleksi;
            document.getElementById('inputNamaPemilik').value = data.nama_pemilik;
            document.getElementById('inputCaraPerolehan').value = data.cara_perolehan;
            document.getElementById('inputTempatPerolehan').value = data.tempat_perolehan;
            document.getElementById('inputTanggalMasuk').value = data.tanggal_masuk;
            document.getElementById('inputKeterangan').value = data.keterangan;
        }
        modal.classList.add('active');
    }
    function closeModal() {
        document.getElementById('koleksiModal').classList.remove('active');
    }
</script>
@endpush

@extends('layouts.admin')

@section('header_title', 'Buku Tamu Pengunjung')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>Buku Tamu Pengunjung</h3>
        <p>Catat, pantau, dan buat laporan kunjungan fisik pengunjung Museum Pusaka Karo. Semua entri disimpan di database dan bisa diekspor sebagai CSV.</p>
        <p>Gunakan tombol <strong>Catat Kunjungan</strong> untuk mencatat kunjungan manual, atau arahkan pengunjung ke <a href="{{ route('buku-tamu') }}" target="_blank">Buku Tamu Publik</a> agar mereka dapat mengisi sendiri.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('pengunjung.export', request()->query()) }}" class="btn-outline"><i class="fa-solid fa-file-csv"></i> Unduh CSV</a>
        <a href="{{ route('pengunjung.export.pdf', request()->query()) }}" class="btn-outline"><i class="fa-solid fa-file-pdf"></i> Unduh PDF</a>
        <a href="{{ route('buku-tamu') }}" target="_blank" class="btn-outline"><i class="fa-solid fa-link"></i> Form Publik</a>
        <button type="button" class="btn-add" onclick="openModal('add')"><i class="fa-solid fa-plus"></i> Catat Kunjungan</button>
    </div>
</div>

<div class="info-box">
    Semua kunjungan yang masuk lewat Buku Tamu Publik dan entri admin dicatat di sini. Gunakan filter untuk mencari nama, alamat, pekerjaan, atau periode tanggal tertentu.
</div>

<div class="summary-cards">
        <div class="summary-card">
            <div class="summary-number">{{ $totalPengunjung }}</div>
            <div class="summary-label">Total Pengunjung</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">{{ $todayPengunjung }}</div>
            <div class="summary-label">Pengunjung Hari Ini</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">{{ $pengunjungs->count() }}</div>
            <div class="summary-label">Tampil di Halaman</div>
        </div>
    </div>
    <div class="page-note">Data kunjungan yang masuk di halaman ini menjadi sumber laporan buku tamu. Pilih <strong>Unduh CSV</strong> untuk menghasilkan laporan yang dapat dicetak atau dibagikan.</div>

@if(session('success'))
    <div class="alert-success">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<form method="GET" class="filter-bar">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / alamat / pekerjaan...">
    <input type="date" name="dari" value="{{ request('dari') }}">
    <span class="filter-separator">s/d</span>
    <input type="date" name="sampai" value="{{ request('sampai') }}">
    <button type="submit"><i class="fa-solid fa-filter"></i> Filter</button>
    @if(request()->anyFilled(['q','dari','sampai']))
        <a href="{{ route('pengunjung.index') }}" class="reset-link">Reset</a>
    @endif
</form>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th width="15%">NO. TAMU</th>
                <th width="25%">NAMA</th>
                <th width="25%">ALAMAT</th>
                <th width="15%">PEKERJAAN</th>
                <th width="10%">TANGGAL</th>
                <th width="10%">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengunjungs as $p)
            <tr>
                <td data-label="No. Tamu">{{ $p->no_pengunjung }}</td>
                <td data-label="Nama"><strong>{{ $p->nama }}</strong></td>
                <td data-label="Alamat" class="secondary-text">{{ $p->alamat }}</td>
                <td data-label="Pekerjaan" class="secondary-text">{{ $p->pekerjaan }}</td>
                <td data-label="Tanggal" class="secondary-text">{{ \Illuminate\Support\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}</td>
                <td data-label="Aksi">
                    <div class="action-icons">
                        <button type="button" class="btn-action-square" title="Edit" onclick="openModal('edit', {{ json_encode($p) }})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('pengunjung.destroy', $p->no_pengunjung) }}" method="POST" onsubmit="return confirm('Hapus data pengunjung ini?');" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-square" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="6">Belum ada data pengunjung.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="table-footer">
        <div>Menampilkan {{ $pengunjungs->firstItem() ?? 0 }} sampai {{ $pengunjungs->lastItem() ?? 0 }} dari {{ $pengunjungs->total() }} data</div>
        @if($pengunjungs->hasPages())
        <div class="pagination-controls">
            @if($pengunjungs->onFirstPage())
                <span class="page-btn disabled"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $pengunjungs->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif
            <span class="page-btn active">{{ $pengunjungs->currentPage() }}</span>
            @if($pengunjungs->hasMorePages())
                <a href="{{ $pengunjungs->nextPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="page-btn disabled"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </div>
        @endif
    </div>
</div>

<div class="modal-overlay" id="pengunjungModal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 id="modalTitle">TAMBAH DATA PENGUNJUNG</h4>
            <button class="btn-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="pengunjungForm" action="{{ route('pengunjung.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" id="inputNama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="inputAlamat" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="inputPekerjaan" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Kunjungan</label>
                    <input type="date" name="tanggal" id="inputTanggal" class="form-control" required>
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
        const modal = document.getElementById('pengunjungModal');
        const form = document.getElementById('pengunjungForm');
        const title = document.getElementById('modalTitle');
        const method = document.getElementById('formMethod');
        form.reset();

        if (mode === 'add') {
            title.textContent = 'TAMBAH DATA PENGUNJUNG';
            form.action = '{{ route("pengunjung.store") }}';
            method.value = 'POST';
            document.getElementById('inputTanggal').value = new Date().toISOString().split('T')[0];
        } else if (mode === 'edit') {
            title.textContent = 'UBAH DATA PENGUNJUNG';
            form.action = '/pengunjung/' + data.no_pengunjung;
            method.value = 'PUT';
            document.getElementById('inputNama').value = data.nama;
            document.getElementById('inputAlamat').value = data.alamat;
            document.getElementById('inputPekerjaan').value = data.pekerjaan;
            document.getElementById('inputTanggal').value = data.tanggal;
        }
        modal.classList.add('active');
    }
    function closeModal() {
        document.getElementById('pengunjungModal').classList.remove('active');
    }
</script>
@endpush

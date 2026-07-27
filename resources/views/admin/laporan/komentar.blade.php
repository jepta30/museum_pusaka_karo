@extends('layouts.admin')

@section('header_title', 'Laporan Aktivitas Komentar')

@section('content')

<a href="{{ route('laporan.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali ke Pusat Laporan</a>

<div class="page-header">
    <div class="page-title">
        <h3>Laporan Aktivitas Komentar</h3>
        <p>Rekap moderasi komentar pengunjung pada periode terpilih.</p>
    </div>
    <a href="{{ route('laporan.komentar.csv', request()->query()) }}" class="btn-outline"><i class="fa-solid fa-file-csv"></i> Unduh CSV</a>
</div>

<form method="GET" class="filter-bar">
    <select name="periode" onchange="this.form.submit()">
        <option value="harian" {{ $periode == 'harian' ? 'selected' : '' }}>Harian</option>
        <option value="mingguan" {{ $periode == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
        <option value="bulanan" {{ $periode == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
    </select>
    <select name="status" onchange="this.form.submit()">
        <option value="all">Semua Status</option>
        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
    </select>
</form>

<div class="periode-info">Periode: <strong>{{ $dari->translatedFormat('d M Y') }}</strong> - <strong>{{ $sampai->translatedFormat('d M Y') }}</strong></div>

<div class="summary-row">
    <div class="summary-box approved"><div class="num">{{ $rekap['approved'] ?? 0 }}</div><div class="label">Disetujui</div></div>
    <div class="summary-box pending"><div class="num">{{ $rekap['pending'] ?? 0 }}</div><div class="label">Menunggu</div></div>
    <div class="summary-box rejected"><div class="num">{{ $rekap['rejected'] ?? 0 }}</div><div class="label">Ditolak</div></div>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>WARISAN BUDAYA</th>
                <th>NAMA</th>
                <th>ISI KOMENTAR</th>
                <th>STATUS</th>
                <th>TANGGAL</th>
            </tr>
        </thead>
        <tbody>
            @forelse($komentars as $k)
            <tr>
                <td style="color: var(--text-gray);">{{ $k->warisanBudaya->judul ?? '-' }}</td>
                <td><strong>{{ $k->nama }}</strong></td>
                <td style="color: var(--text-gray); max-width: 300px;">{{ \Illuminate\Support\Str::limit($k->isi_komentar, 80) }}</td>
                <td><span class="badge badge-{{ $k->status }}">{{ ucfirst($k->status) }}</span></td>
                <td style="color: var(--text-gray);">{{ $k->created_at->translatedFormat('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; color: var(--text-gray); padding: 40px;">Tidak ada aktivitas komentar pada periode ini.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="table-footer">
        <div>Menampilkan {{ $komentars->firstItem() ?? 0 }} - {{ $komentars->lastItem() ?? 0 }} dari {{ $komentars->total() }} data</div>
        @if($komentars->hasPages())
        <div class="pagination-controls">
            @if($komentars->onFirstPage())
                <span class="page-btn" style="color:#ccc;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $komentars->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif
            <span class="page-btn active">{{ $komentars->currentPage() }}</span>
            @if($komentars->hasMorePages())
                <a href="{{ $komentars->nextPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="page-btn" style="color:#ccc;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

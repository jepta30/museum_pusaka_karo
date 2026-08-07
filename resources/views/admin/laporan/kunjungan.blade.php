@extends('layouts.admin')

@section('header_title', 'Statistik Kunjungan Website')

@section('content')
<style>
    .periode-info { font-size: 13px; color: var(--text-gray); margin-bottom: 20px; }
    .grid-2 { display: grid; grid-template-columns: 1.3fr 1fr; gap: 20px; }
    .panel { background: #fff; border: 1px solid var(--border-color); border-radius: 8px; padding: 25px; margin-bottom: 20px; }
    .panel h4 { font-size: 15px; margin-bottom: 18px; color: var(--text-dark); }
    .bar-label { width: 160px; font-size: 12.5px; color: var(--text-gray); flex-shrink: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    @media (max-width: 900px) { .grid-2 { grid-template-columns: 1fr; } }
</style>

<a href="{{ route('laporan.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali ke Pusat Laporan</a>

<div class="page-header">
    <div class="page-title">
        <h3>Statistik Kunjungan Website</h3>
        <p>Data kunjungan situs tercatat otomatis setiap ada pengunjung membuka halaman publik.</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('laporan.kunjungan.csv', request()->query()) }}" class="btn-outline"><i class="fa-solid fa-file-csv"></i> Unduh CSV</a>
        <a href="{{ route('laporan.kunjungan.pdf', request()->query()) }}" class="btn-outline"><i class="fa-solid fa-file-pdf"></i> Unduh PDF</a>
    </div>
</div>

<form method="GET" class="filter-bar">
    <select name="periode" onchange="this.form.submit()">
        <option value="harian" {{ $periode == 'harian' ? 'selected' : '' }}>Harian</option>
        <option value="mingguan" {{ $periode == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
        <option value="bulanan" {{ $periode == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
    </select>
</form>

<div class="periode-info">Periode: <strong>{{ $dari->translatedFormat('d M Y') }}</strong> - <strong>{{ $sampai->translatedFormat('d M Y') }}</strong></div>

<div class="summary-box">
    <div class="num">{{ $totalKunjungan }}</div>
    <div class="label">Total Kunjungan Halaman</div>
</div>

<div class="grid-2">
    <div class="panel">
        <h4>Tren Kunjungan Harian</h4>
        @php $maxTren = $trenHarian->max('total') ?: 1; @endphp
        @forelse($trenHarian as $t)
        <div class="bar-row">
            <div class="bar-label">{{ \Illuminate\Support\Carbon::parse($t->tanggal)->translatedFormat('d M Y') }}</div>
            <div class="bar-track"><div class="bar-fill" style="width: {{ $t->total / $maxTren * 100 }}%;"></div></div>
            <div class="bar-value">{{ $t->total }}</div>
        </div>
        @empty
        <p style="color: var(--text-gray); font-size: 13px;">Belum ada data kunjungan pada periode ini.</p>
        @endforelse

        <h4 style="margin-top: 25px;">Halaman Terbanyak Dikunjungi</h4>
        @php $maxHalaman = $halamanTerbanyak->max('total') ?: 1; @endphp
        @forelse($halamanTerbanyak as $h)
        <div class="bar-row">
            <div class="bar-label" title="{{ $h->halaman }}">{{ $h->halaman }}</div>
            <div class="bar-track"><div class="bar-fill" style="width: {{ $h->total / $maxHalaman * 100 }}%;"></div></div>
            <div class="bar-value">{{ $h->total }}</div>
        </div>
        @empty
        <p style="color: var(--text-gray); font-size: 13px;">Belum ada data.</p>
        @endforelse
    </div>

    <div class="panel">
        <h4>Jenis Perangkat</h4>
        @php $maxPerangkat = $perPerangkat->max('total') ?: 1; @endphp
        @forelse($perPerangkat as $p)
        <div class="bar-row">
            <div class="bar-label">{{ $p->perangkat }}</div>
            <div class="bar-track"><div class="bar-fill" style="width: {{ $p->total / $maxPerangkat * 100 }}%;"></div></div>
            <div class="bar-value">{{ $p->total }}</div>
        </div>
        @empty
        <p style="color: var(--text-gray); font-size: 13px;">Belum ada data.</p>
        @endforelse

        <h4 style="margin-top: 25px;">Koleksi Budaya Terpopuler</h4>
        @forelse($warisanTerpopuler as $wt)
        <div class="bar-row">
            <div class="bar-label">{{ $wt->warisanBudaya->judul ?? 'Tidak diketahui' }}</div>
            <div class="bar-value" style="width:auto;">{{ $wt->total }}x</div>
        </div>
        @empty
        <p style="color: var(--text-gray); font-size: 13px;">Belum ada data.</p>
        @endforelse

        <div class="catatan">
            <i class="fa-solid fa-circle-info"></i> Kolom "Kota" pada data mentah belum aktif — mendeteksi kota pengunjung
            butuh layanan geolokasi IP pihak ketiga yang hanya akurat saat situs sudah online di internet publik (tidak di localhost).
        </div>
    </div>
</div>
@endsection

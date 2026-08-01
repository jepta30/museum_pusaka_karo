@extends('layouts.admin')

@section('content')
<style>
    .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 25px; }
    .kpi-card { background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,1)); border: 1px solid rgba(216, 224, 235, 0.75); border-radius: 20px; padding: 28px 24px; text-align: center; transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06); }
    .kpi-card:hover { transform: translateY(-4px); box-shadow: 0 24px 50px rgba(15, 23, 42, 0.1); border-color: rgba(197, 50, 50, 0.9); }
    .kpi-title { font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--text-gray); letter-spacing: 0.2em; margin-bottom: 14px; }
    .kpi-value { font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 700; color: var(--text-dark); margin-bottom: 10px; }
    .kpi-desc { font-size: 13px; color: var(--text-gray); line-height: 1.7; }
    .chart-header { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; margin-bottom: 20px; color: var(--text-dark); border-bottom: 1px solid rgba(216, 224, 235, 0.85); padding-bottom: 16px; }
    .chart-container { height: 320px; width: 100%; background: linear-gradient(180deg, rgba(244,247,250,0.85), rgba(255,255,255,0.95)); border-radius: 18px; padding: 18px; box-shadow: inset 0 1px 0 rgba(255,255,255,0.8); }
    .table-title { font-family: 'Playfair Display', serif; font-size: 19px; font-weight: 700; color: var(--text-dark); }
    .table-link { font-size: 13px; font-weight: 500; color: var(--text-dark); text-decoration: none; }
    .table-link:hover { color: var(--primary-red); }
</style>

<!-- KPI Cards -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-title">KATEGORI BUDAYA</div>
        <div class="kpi-value">{{ $totalKategori ?? '0' }}</div>
        <div class="kpi-desc">Total Kategori</div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-title">WARISAN BUDAYA</div>
        <div class="kpi-value">{{ $totalWarisanBudaya ?? '0' }}</div>
        <div class="kpi-desc">Data Terarsip</div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-title">MEDIA DOKUMENTASI</div>
        <div class="kpi-value">{{ $totalMedia ?? '0' }}</div>
        <div class="kpi-desc">File Foto/Video</div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-title">KOMENTAR</div>
        <div class="kpi-value">{{ $totalKomentarPending ?? '0' }}</div>
        <div class="kpi-desc">Perlu Moderasi</div>
    </div>
</div>

<!-- Chart Section -->
<div class="card">
    <div class="chart-header">
        Statistik Pengunjung (14 Hari Terakhir)
    </div>
    <div class="chart-container">
        <canvas id="visitorChart"></canvas>
    </div>
</div>

<!-- Table Section -->
<div class="card">
    <div class="table-header">
        <div class="table-title">Moderasi Komentar</div>
        <a href="{{ route('komentar.index') }}" class="table-link">Lihat Semua Komentar</a>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th width="15%">NAMA</th>
                <th width="50%">KOMENTAR</th>
                <th width="20%">TANGGAL</th>
                <th width="15%">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($recentComments) && count($recentComments) > 0)
                @foreach($recentComments as $komentar)
                <tr>
                    <td>{{ $komentar->nama }}</td>
                    <td>{{ Str::limit($komentar->isi_komentar, 60) }}</td>
                    <td>
                        <div style="font-weight: 500;">{{ $komentar->created_at->format('d/m/Y') }}</div>
                        <div style="font-size: 11px; color: #9ca3af; margin-top: 4px;">{{ $komentar->created_at->format('H:i') }} WIB</div>
                    </td>
                    <td>
                        <div class="action-icons" style="display: flex; gap: 8px;">
                            @if($komentar->status == 'pending')
                                <form action="{{ route('komentar.update', $komentar->komentar_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn-action-square" title="Setujui" style="color: #059669; border-color: #34d399;"><i class="fa-solid fa-check"></i></button>
                                </form>
                            @else
                                <span class="badge {{ $komentar->status == 'approved' ? 'badge-approved' : 'badge-rejected' }}">
                                    {{ strtoupper($komentar->status) }}
                                </span>
                            @endif
                            
                            <form action="{{ route('komentar.destroy', $komentar->komentar_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus komentar ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-square" title="Hapus" style="color: #dc2626; border-color: #f87171;"><i class="fa-regular fa-trash-can"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
                <!-- Data Palsu untuk Demo UI Sesuai Wireframe -->
                <tr>
                    <td>Anonim</td>
                    <td>Koleksi museum ini sangat menarik dan tertata rapi. Sangat edukatif!</td>
                    <td>{{ date('d/m/Y') }}</td>
                    <td>
                        <div class="action-icons">
                            <a href="#"><i class="fa-solid fa-pen"></i></a>
                            <button type="button"><i class="fa-regular fa-trash-can"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Budi Santoso</td>
                    <td>Mohon diperbarui informasi mengenai sejarah pembuatan Piso Surit...</td>
                    <td>{{ date('d/m/Y', strtotime('-1 days')) }}</td>
                    <td>
                        <div class="action-icons">
                            <a href="#"><i class="fa-solid fa-pen"></i></a>
                            <button type="button"><i class="fa-regular fa-trash-can"></i></button>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('visitorChart').getContext('2d');
        
        // Data Real-time dari Database
        const labels = {!! json_encode($chartLabels) !!};
        const chartData = {!! json_encode($chartData) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: chartData,
                    borderColor: '#212529', // Garis hitam pekat (seperti wireframe)
                    borderWidth: 2,
                    pointBackgroundColor: '#212529',
                    pointRadius: 0, // Menyembunyikan titik agar mirip wireframe
                    pointHoverRadius: 6,
                    fill: true,
                    backgroundColor: 'rgba(243, 244, 246, 0.4)', // Warna latar tipis di bawah garis
                    tension: 0 // Garis lurus patah-patah (mirip wireframe)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Menyembunyikan legend
                    },
                    tooltip: {
                        backgroundColor: '#B91C1C', // Tooltip warna merah
                        padding: 10,
                        titleFont: { family: 'Inter', size: 13 },
                        bodyFont: { family: 'Inter', size: 13 },
                        displayColors: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false, // Menghilangkan garis vertikal
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 11,
                                weight: 'bold'
                            },
                            color: '#6b7280'
                        }
                    },
                    y: {
                        display: false, // Menyembunyikan sumbu Y
                        beginAtZero: true
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
</script>
@endpush

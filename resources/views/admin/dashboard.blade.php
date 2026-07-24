@extends('layouts.admin')

@section('content')
<style>
    /* KPI Cards Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .kpi-card {
        background-color: #fff;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 25px 20px;
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border-color: var(--primary-red);
    }

    .kpi-title {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-dark);
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .kpi-value {
        font-family: 'Playfair Display', serif;
        font-size: 34px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .kpi-desc {
        font-size: 12px;
        color: var(--text-gray);
    }

    /* Chart Section */
    .chart-header {
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text-dark);
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
    }

    .chart-container {
        height: 280px;
        width: 100%;
    }

    /* Table Section */
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
    }

    .table-title {
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .table-link {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-dark);
        text-decoration: none;
    }
    
    .table-link:hover {
        color: var(--primary-red);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        text-align: left;
        padding: 12px 15px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-gray);
        border-bottom: 1px solid var(--border-color);
    }

    .data-table td {
        padding: 15px;
        font-size: 13px;
        color: var(--text-dark);
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .action-icons {
        display: flex;
        gap: 15px;
    }

    .action-icons a, .action-icons button {
        color: var(--text-gray);
        background: none;
        border: none;
        cursor: pointer;
        font-size: 15px;
        transition: color 0.2s;
    }

    .action-icons a:hover, .action-icons button:hover {
        color: var(--primary-red);
    }
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
        Statistik Pengunjung (30 Hari Terakhir)
    </div>
    <div class="chart-container">
        <canvas id="visitorChart"></canvas>
    </div>
</div>

<!-- Table Section -->
<div class="card">
    <div class="table-header">
        <div class="table-title">Moderasi Komentar</div>
        <a href="#" class="table-link">Lihat Semua Komentar</a>
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
                    <td>{{ $komentar->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="action-icons">
                            <a href="#" title="Edit"><i class="fa-solid fa-pen"></i></a>
                            <button type="button" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
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
        
        // Data Dummy untuk grafik (Mirip dengan wireframe)
        const labels = ['01/05', '05/05', '08/05', '12/05', '15/05', '19/05', '22/05', '26/05', '29/05', '30/05'];
        const chartData = [50, 60, 40, 120, 80, 95, 85, 140, 110, 115];

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
                        display: false, // Menyembunyikan sumbu Y (seperti wireframe)
                        min: 0,
                        max: 200
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

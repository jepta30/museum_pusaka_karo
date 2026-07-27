<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Buku Tamu Pengunjung</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #1f2937;
            margin: 28px;
        }
        .letterhead {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 16px;
            margin-bottom: 20px;
        }
        .letterhead-logo {
            width: 72px;
            height: auto;
            display: block;
        }
        .letterhead-text {
            flex: 1;
            text-align: center;
        }
        .letterhead-title {
            margin: 0;
            font-size: 18px;
            letter-spacing: 0.2em;
            color: #111827;
        }
        .letterhead-subtitle {
            margin: 4px 0 0;
            font-size: 12px;
            color: #4b5563;
            line-height: 1.5;
        }
        .letterhead-address {
            margin-top: 5px;
            font-size: 11px;
            color: #4b5563;
            line-height: 1.4;
        }
        .line {
            border-top: 2px solid #1f2937;
            margin: 18px 0;
        }
        .subheader {
            display: flex;
            justify-content: space-between;
            margin-bottom: 14px;
        }
        .subheader div {
            font-size: 11px;
            color: #4b5563;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 9px 10px;
            text-align: left;
        }
        th {
            background: #f8fafc;
            font-size: 11px;
            text-transform: uppercase;
            color: #374151;
        }
        td {
            font-size: 10.5px;
            color: #1f2937;
        }
        .footer {
            margin-top: 18px;
            font-size: 10px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="letterhead">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo Museum Pusaka Karo" class="letterhead-logo">
        <div class="letterhead-text">
            <h1 class="letterhead-title">MUSEUM PUSAKA KARO</h1>
            <p class="letterhead-subtitle">Jl. Perwira No. 3, Gundaling I, Berastagi, Kabupaten Karo</p>
            <p class="letterhead-address">Telepon: (XXX) XXX-XXXX | Email: info@museumpusakakaro.id</p>
        </div>
    </div>
    <div class="line"></div>
    <div class="subheader">
        <div><strong>Laporan:</strong> Buku Tamu Pengunjung</div>
        <div><strong>Tanggal Cetak:</strong> {{ now()->translatedFormat('d F Y') }}</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>No. Tamu</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Pekerjaan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengunjungs as $p)
            <tr>
                <td>{{ $p->no_pengunjung }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->alamat }}</td>
                <td>{{ $p->pekerjaan }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; color:#6b7280;">Tidak ada data pengunjung.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">
        <p>Dokumen ini dihasilkan oleh Sistem Informasi Museum Pusaka Karo.</p>
    </div>
</body>
</html>

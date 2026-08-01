<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Buku Induk Koleksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            margin: 28px;
        }
        .kop-surat {
            width: 100%;
            height: auto;
            display: block;
            margin-bottom: 20px;
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
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #f8fafc;
            font-size: 10px;
            text-transform: uppercase;
            color: #374151;
        }
        td {
            font-size: 9.5px;
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
    <img src="{{ public_path('images/kop-surat.png') }}" class="kop-surat" alt="Kop Surat Yayasan Pusaka Karo">
    <div class="subheader">
        <div><strong>Laporan:</strong> Buku Induk Koleksi Museum</div>
        <div><strong>Tanggal Cetak:</strong> {{ now()->translatedFormat('d F Y') }}</div>
    </div>
    <table>
        <thead>
            <tr>
                <th width="10%">No. Koleksi</th>
                <th width="18%">Nama Koleksi</th>
                <th width="12%">Jenis</th>
                <th width="15%">Pemilik</th>
                <th width="15%">Cara Perolehan</th>
                <th width="15%">Tempat Perolehan</th>
                <th width="15%">Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            @forelse($koleksis as $k)
            <tr>
                <td>{{ $k->nomor_koleksi }}</td>
                <td><strong>{{ $k->nama_koleksi }}</strong></td>
                <td>{{ $k->jenis_koleksi }}</td>
                <td>{{ $k->nama_pemilik }}</td>
                <td>{{ $k->cara_perolehan }}</td>
                <td>{{ $k->tempat_perolehan }}</td>
                <td>{{ $k->tanggal_masuk }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; color:#6b7280;">Tidak ada data koleksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">
        <p>Dokumen ini dihasilkan oleh Sistem Informasi Museum Pusaka Karo.</p>
    </div>
</body>
</html>

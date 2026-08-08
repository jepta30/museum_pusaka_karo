<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Budaya</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1f2937; margin: 28px; }
        .kop-surat { width: 100%; height: auto; display: block; margin-bottom: 20px; }
        .subheader { display: flex; justify-content: space-between; margin-bottom: 14px; }
        .subheader div { font-size: 11px; color: #4b5563; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d1d5db; padding: 9px 10px; text-align: left; }
        th { background: #f8fafc; font-size: 11px; text-transform: uppercase; color: #374151; }
        td { font-size: 10.5px; color: #1f2937; }
        .footer { margin-top: 18px; font-size: 10px; color: #6b7280; }
    </style>
</head>
<body>
    <img src="{{ public_path('images/kop-surat.png') }}" class="kop-surat" alt="Kop Surat">
    <div class="subheader">
        <div><strong>Laporan:</strong> Rekapitulasi Data Budaya per Jenis Koleksi</div>
        <div><strong>Tanggal Cetak:</strong> {{ now()->translatedFormat('d F Y') }}</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Koleksi</th>
                <th>Jumlah Warisan Budaya</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perKategori as $index => $k)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $k->nama }}</td>
                <td>{{ $k->total }} item</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align:center; color:#6b7280;">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">
        <p>Dokumen ini dihasilkan oleh Sistem Informasi Museum Pusaka Karo.</p>
    </div>
</body>
</html>

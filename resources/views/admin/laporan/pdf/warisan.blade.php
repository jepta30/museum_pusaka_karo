<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Koleksi Budaya</title>
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
        <div><strong>Laporan:</strong> Koleksi Budaya ({{ $dari->translatedFormat('d M Y') }} - {{ $sampai->translatedFormat('d M Y') }})</div>
        <div><strong>Tanggal Cetak:</strong> {{ now()->translatedFormat('d F Y') }}</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Jenis Koleksi</th>
                <th>Lokasi</th>
                <th>Asal</th>
                <th>Kondisi</th>
                <th>Status</th>
                <th>Dilihat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warisans as $w)
            <tr>
                <td>{{ $w->warisan_budaya_id }}</td>
                <td>{{ $w->judul }}</td>
                <td>{{ $w->kategori->nama ?? '-' }}</td>
                <td>{{ $w->lokasi }}</td>
                <td>{{ $w->asal }}</td>
                <td>{{ $w->kondisi }}</td>
                <td>{{ $w->status }}</td>
                <td>{{ $w->jumlah_dilihat ?? 0 }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; color:#6b7280;">Tidak ada data pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">
        <p>Dokumen ini dihasilkan oleh Sistem Informasi Museum Pusaka Karo.</p>
    </div>
</body>
</html>

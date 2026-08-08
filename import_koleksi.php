<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Koleksi;

$json = file_get_contents(__DIR__ . '/koleksi_data.json');
$data = json_decode($json, true);

$inserted = 0;
$updated = 0;

foreach ($data as $item) {
    // Basic sanitization
    $nomor_koleksi = substr($item['nomor_koleksi'], 0, 50);
    $nama_koleksi = substr($item['nama_koleksi'], 0, 255);
    $jenis_koleksi = substr($item['jenis_koleksi'], 0, 100);
    $nama_pemilik = substr($item['nama_pemilik'], 0, 255);
    $cara_perolehan = substr($item['cara_perolehan'], 0, 100);
    $tempat_perolehan = substr($item['tempat_perolehan'], 0, 255);
    $tanggal_masuk = substr($item['tanggal_masuk'], 0, 50);
    
    $koleksi = Koleksi::find($nomor_koleksi);
    if ($koleksi) {
        $koleksi->update([
            'nama_koleksi' => $nama_koleksi,
            'jenis_koleksi' => $jenis_koleksi,
            'nama_pemilik' => $nama_pemilik,
            'cara_perolehan' => $cara_perolehan,
            'tempat_perolehan' => $tempat_perolehan,
            'tanggal_masuk' => $tanggal_masuk,
            'keterangan' => $item['keterangan']
        ]);
        $updated++;
    } else {
        Koleksi::create([
            'nomor_koleksi' => $nomor_koleksi,
            'nama_koleksi' => $nama_koleksi,
            'jenis_koleksi' => $jenis_koleksi,
            'nama_pemilik' => $nama_pemilik,
            'cara_perolehan' => $cara_perolehan,
            'tempat_perolehan' => $tempat_perolehan,
            'tanggal_masuk' => $tanggal_masuk,
            'keterangan' => $item['keterangan']
        ]);
        $inserted++;
    }
}

echo "Import complete! Inserted: $inserted, Updated: $updated\n";

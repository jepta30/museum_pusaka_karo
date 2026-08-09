<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Kategori;

$categories = [
    ['nama' => 'Numismatika / Heraldika', 'icon' => 'fa-solid fa-coins', 'deskripsi' => 'Koleksi uang kuno, koin, dan lambang'],
    ['nama' => 'Alat Rumah Tangga', 'icon' => 'fa-solid fa-house-chimney', 'deskripsi' => 'Perabotan dan alat keperluan rumah tangga tradisional'],
    ['nama' => 'Perhiasan', 'icon' => 'fa-solid fa-gem', 'deskripsi' => 'Cincin, kalung, anting, dan perhiasan tradisional lainnya'],
    ['nama' => 'Senjata / Pisau', 'icon' => 'fa-solid fa-khanda', 'deskripsi' => 'Senjata tradisional seperti tumbuk lada, pedang, dan pisau'],
    ['nama' => 'Patung / Gana-Gana', 'icon' => 'fa-solid fa-monument', 'deskripsi' => 'Patung kayu, batu, dan ornamen ukiran'],
    ['nama' => 'Seni Rupa / Kriya', 'icon' => 'fa-solid fa-palette', 'deskripsi' => 'Kain tenun (Uis Karo) dan kerajinan tangan lainnya'],
    ['nama' => 'Alat Musik', 'icon' => 'fa-solid fa-music', 'deskripsi' => 'Instrumen musik tradisional seperti gung, sarune, dll'],
    ['nama' => 'Alat Memakan Sirih', 'icon' => 'fa-solid fa-leaf', 'deskripsi' => 'Peralatan untuk tradisi makan sirih (kampil, kalakati, dll)'],
    ['nama' => 'Alat Pertanian', 'icon' => 'fa-solid fa-tractor', 'deskripsi' => 'Peralatan bertani tradisional'],
    ['nama' => 'Tongkat', 'icon' => 'fa-solid fa-cane-campbell', 'deskripsi' => 'Tongkat komando atau tongkat tradisional (ciken, tungkat)'],
    ['nama' => 'Alat Pertukangan', 'icon' => 'fa-solid fa-hammer', 'deskripsi' => 'Perkakas untuk bertukang dan membuat kerajinan'],
    ['nama' => 'Alat Berburu', 'icon' => 'fa-solid fa-crosshairs', 'deskripsi' => 'Peralatan yang digunakan untuk berburu hewan'],
];

$inserted = 0;
foreach ($categories as $cat) {
    if (!Kategori::where('nama', $cat['nama'])->exists()) {
        Kategori::create($cat);
        $inserted++;
    }
}

echo "Successfully seeded $inserted categories!\n";

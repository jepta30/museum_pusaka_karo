<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Koleksi;
use Barryvdh\DomPDF\Facade\Pdf;

echo "Fetching records...\n";
$koleksis = Koleksi::orderBy('nomor_koleksi')->get();
echo "Found " . $koleksis->count() . " records.\n";

set_time_limit(300);
ini_set('memory_limit', '1G');

echo "Generating PDF...\n";
$start = microtime(true);

$pdf = Pdf::loadView('admin.koleksi.pdf', compact('koleksis'))
            ->setPaper('a4', 'landscape');
$content = $pdf->output();
file_put_contents('test_output.pdf', $content);

$end = microtime(true);
echo "Done in " . ($end - $start) . " seconds.\n";

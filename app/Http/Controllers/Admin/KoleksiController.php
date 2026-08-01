<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Koleksi;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class KoleksiController extends Controller
{
    /**
     * Buku Induk Koleksi Museum (BAB IV.4 poin 8).
     */
    public function index(Request $request)
    {
        $query = Koleksi::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_koleksi', 'like', "%{$q}%")
                    ->orWhere('nama_pemilik', 'like', "%{$q}%")
                    ->orWhere('jenis_koleksi', 'like', "%{$q}%");
            });
        }

        if ($request->filled('jenis') && $request->jenis != 'all') {
            $query->where('jenis_koleksi', $request->jenis);
        }

        $koleksis = $query->latest()->paginate(10)->withQueryString();
        $jenisList = Koleksi::select('jenis_koleksi')->distinct()->pluck('jenis_koleksi');

        return view('admin.koleksi.index', compact('koleksis', 'jenisList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_koleksi' => 'required|string|max:50',
            'jenis_koleksi' => 'required|string|max:50',
            'nama_pemilik' => 'required|string|max:50',
            'cara_perolehan' => 'required|string|max:50',
            'tempat_perolehan' => 'required|string|max:50',
            'tanggal_masuk' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        $validated['nomor_koleksi'] = $this->generateNomor();

        Koleksi::create($validated);

        return redirect()->route('koleksi.index')->with('success', 'Data koleksi berhasil ditambahkan ke buku induk.');
    }

    public function update(Request $request, string $nomor_koleksi)
    {
        $koleksi = Koleksi::findOrFail($nomor_koleksi);

        $validated = $request->validate([
            'nama_koleksi' => 'required|string|max:50',
            'jenis_koleksi' => 'required|string|max:50',
            'nama_pemilik' => 'required|string|max:50',
            'cara_perolehan' => 'required|string|max:50',
            'tempat_perolehan' => 'required|string|max:50',
            'tanggal_masuk' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        $koleksi->update($validated);

        return redirect()->route('koleksi.index')->with('success', 'Data koleksi berhasil diperbarui.');
    }

    public function destroy(string $nomor_koleksi)
    {
        Koleksi::findOrFail($nomor_koleksi)->delete();

        return redirect()->route('koleksi.index')->with('success', 'Data koleksi berhasil dihapus.');
    }

    public function exportCsv(): StreamedResponse
    {
        $koleksis = Koleksi::orderBy('nomor_koleksi')->get();
        $filename = 'buku-induk-koleksi-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($koleksis) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No. Koleksi', 'Nama Koleksi', 'Jenis', 'Nama Pemilik', 'Cara Perolehan', 'Tempat Perolehan', 'Tanggal Masuk', 'Keterangan']);
            foreach ($koleksis as $k) {
                fputcsv($handle, [$k->nomor_koleksi, $k->nama_koleksi, $k->jenis_koleksi, $k->nama_pemilik, $k->cara_perolehan, $k->tempat_perolehan, $k->tanggal_masuk, $k->keterangan]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function exportPdf(Request $request)
    {
        $query = Koleksi::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_koleksi', 'like', "%{$q}%")
                    ->orWhere('nama_pemilik', 'like', "%{$q}%")
                    ->orWhere('jenis_koleksi', 'like', "%{$q}%");
            });
        }

        if ($request->filled('jenis') && $request->jenis != 'all') {
            $query->where('jenis_koleksi', $request->jenis);
        }

        $koleksis = $query->orderBy('nomor_koleksi')->get();

        $pdf = Pdf::loadView('admin.koleksi.pdf', compact('koleksis'))
            ->setPaper('a4', 'landscape'); // Use landscape for wide tables

        return $pdf->stream('buku-induk-koleksi-' . now()->format('Ymd_His') . '.pdf');
    }

    private function generateNomor(): string
    {
        do {
            $nomor = 'KOL-' . now()->format('ymd') . '-' . str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Koleksi::whereKey($nomor)->exists());

        return $nomor;
    }
}

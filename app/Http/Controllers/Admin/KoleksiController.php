<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Koleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class KoleksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Koleksi::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_koleksi', 'LIKE', "%{$search}%")
                  ->orWhere('nama_pemilik', 'LIKE', "%{$search}%");
        }

        if ($request->filled('jenis') && $request->jenis != 'all') {
            $query->where('jenis_koleksi', $request->jenis);
        }

        $koleksis = $query->orderBy('created_at', 'asc')->paginate(10)->withQueryString();

        // Get unique 'jenis_koleksi' for the dynamic filter dropdown
        $jenisKoleksiOptions = Koleksi::select('jenis_koleksi')
            ->whereNotNull('jenis_koleksi')
            ->where('jenis_koleksi', '!=', '')
            ->where('jenis_koleksi', '!=', '-')
            ->distinct()
            ->pluck('jenis_koleksi');

        return view('admin.koleksi.index', compact('koleksis', 'jenisKoleksiOptions'));
    }

    public function create()
    {
        return view('admin.koleksi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_koleksi' => 'required|string|max:20|unique:koleksis,nomor_koleksi',
            'nama_koleksi' => 'required|string|max:50',
            'jenis_koleksi' => 'nullable|string|max:50',
            'nama_pemilik' => 'nullable|string|max:50',
            'cara_perolehan' => 'nullable|string|max:50',
            'tempat_perolehan' => 'nullable|string|max:50',
            'tanggal_masuk' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            if (is_null($value)) {
                $validated[$key] = '-';
            }
        }

        Koleksi::create($validated);

        return redirect()->route('koleksi.index')
            ->with('success', 'Koleksi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $koleksi = Koleksi::findOrFail($id);
        return view('admin.koleksi.show', compact('koleksi'));
    }

    public function edit($id)
    {
        $koleksi = Koleksi::findOrFail($id);
        return view('admin.koleksi.edit', compact('koleksi'));
    }

    public function update(Request $request, $id)
    {
        $koleksi = Koleksi::findOrFail($id);

        $validated = $request->validate([
            'nomor_koleksi' => 'required|string|max:20|unique:koleksis,nomor_koleksi,' . $id . ',nomor_koleksi',
            'nama_koleksi' => 'required|string|max:50',
            'jenis_koleksi' => 'nullable|string|max:50',
            'nama_pemilik' => 'nullable|string|max:50',
            'cara_perolehan' => 'nullable|string|max:50',
            'tempat_perolehan' => 'nullable|string|max:50',
            'tanggal_masuk' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            if (is_null($value)) {
                $validated[$key] = '-';
            }
        }

        $koleksi->update($validated);

        return redirect()->route('koleksi.index')
            ->with('success', 'Koleksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $koleksi = Koleksi::findOrFail($id);
        $koleksi->delete();

        return redirect()->route('koleksi.index')
            ->with('success', 'Koleksi berhasil dihapus.');
    }

    /**
     * Export koleksi ke CSV
     * ===== PERBAIKAN: Method ini dipanggil oleh route koleksi.export =====
     */
    public function exportCsv(): StreamedResponse
    {
        $koleksis = Koleksi::orderBy('created_at', 'desc')->get();

        $filename = 'buku-induk-koleksi-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($koleksis) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Nomor Koleksi',
                'Nama Koleksi',
                'Jenis Koleksi',
                'Nama Pemilik/Penitip',
                'Cara Perolehan',
                'Tempat Perolehan',
                'Tanggal Masuk',
                'Keterangan'
            ]);

            foreach ($koleksis as $k) {
                fputcsv($handle, [
                    $k->nomor_koleksi ?? '',
                    $k->nama_koleksi ?? '',
                    $k->jenis_koleksi ?? '',
                    $k->nama_pemilik ?? '',
                    $k->cara_perolehan ?? '',
                    $k->tempat_perolehan ?? '',
                    $k->tanggal_masuk ?? '',
                    $k->keterangan ?? ''
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\""
        ]);
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

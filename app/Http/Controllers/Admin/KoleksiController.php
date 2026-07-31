<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Koleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KoleksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Koleksi::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_koleksi', 'LIKE', "%{$search}%")
                  ->orWhere('pemilik', 'LIKE', "%{$search}%");
        }

        if ($request->filled('jenis') && $request->jenis != 'all') {
            $query->where('jenis', $request->jenis);
        }

        $koleksis = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.koleksi.index', compact('koleksis'));
    }

    public function create()
    {
        return view('admin.koleksi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_koleksi' => 'required|string|max:50|unique:koleksis',
            'nama_koleksi' => 'required|string|max:255',
            'jenis' => 'nullable|string|max:100',
            'pemilik' => 'nullable|string|max:255',
            'cara_perolehan' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'kondisi' => 'nullable|string|max:50',
        ]);

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
            'kode_koleksi' => 'required|string|max:50|unique:koleksis,kode_koleksi,' . $id . ',koleksi_id',
            'nama_koleksi' => 'required|string|max:255',
            'jenis' => 'nullable|string|max:100',
            'pemilik' => 'nullable|string|max:255',
            'cara_perolehan' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'kondisi' => 'nullable|string|max:50',
        ]);

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
                'No. Koleksi',
                'Nama Koleksi',
                'Jenis',
                'Pemilik',
                'Cara Perolehan',
                'Tanggal Masuk',
                'Deskripsi',
                'Kondisi'
            ]);

            foreach ($koleksis as $k) {
                fputcsv($handle, [
                    $k->kode_koleksi ?? '',
                    $k->nama_koleksi ?? '',
                    $k->jenis ?? '',
                    $k->pemilik ?? '',
                    $k->cara_perolehan ?? '',
                    $k->tanggal_masuk ? Carbon::parse($k->tanggal_masuk)->format('Y-m-d') : '',
                    $k->deskripsi ?? '',
                    $k->kondisi ?? ''
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\""
        ]);
    }
}
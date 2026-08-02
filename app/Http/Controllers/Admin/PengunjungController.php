<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengunjung;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PengunjungController extends Controller
{
    /**
     * Menampilkan Buku Tamu Digital (BAB IV.4 poin 7 - Laporan Data Pengunjung).
     */
    public function index(Request $request)
    {
        $query = Pengunjung::query();

        $totalPengunjung = Pengunjung::count();
        $todayPengunjung = Pengunjung::whereDate('tanggal', now()->toDateString())->count();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('alamat', 'like', "%{$q}%")
                    ->orWhere('pekerjaan', 'like', "%{$q}%");
            });
        }

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }

        $pengunjungs = $query->orderBy('created_at', 'asc')->paginate(10)->withQueryString();

        return view('admin.pengunjung.index', compact('pengunjungs', 'totalPengunjung', 'todayPengunjung'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:50',
            'tanggal' => 'required|date',
        ]);

        $validated['no_pengunjung'] = $this->generateNomor();

        Pengunjung::create($validated);

        return redirect()->route('pengunjung.index')->with('success', 'Data pengunjung berhasil ditambahkan.');
    }

    /**
     * Endpoint publik agar pengunjung museum bisa mengisi buku tamu secara mandiri
     * lewat halaman /buku-tamu (tanpa perlu login admin).
     */
    public function storeMandiri(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:50',
        ]);

        $validated['tanggal'] = now()->toDateString();
        $validated['no_pengunjung'] = $this->generateNomor();

        Pengunjung::create($validated);

        return redirect()->route('home')->with('success', 'Terima kasih! Data kunjungan Anda berhasil dicatat.');
    }

    public function update(Request $request, string $no_pengunjung)
    {
        $pengunjung = Pengunjung::findOrFail($no_pengunjung);

        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:50',
            'tanggal' => 'required|date',
        ]);

        $pengunjung->update($validated);

        return redirect()->route('pengunjung.index')->with('success', 'Data pengunjung berhasil diperbarui.');
    }

    public function destroy(string $no_pengunjung)
    {
        Pengunjung::findOrFail($no_pengunjung)->delete();

        return redirect()->route('pengunjung.index')->with('success', 'Data pengunjung berhasil dihapus.');
    }

    /**
     * Unduh Laporan Data Pengunjung dalam format CSV.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $query = Pengunjung::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('alamat', 'like', "%{$q}%")
                    ->orWhere('pekerjaan', 'like', "%{$q}%");
            });
        }
        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }

        $pengunjungs = $query->orderBy('tanggal')->get();

        $filename = 'laporan-pengunjung-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($pengunjungs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No. Pengunjung', 'Nama', 'Alamat', 'Pekerjaan', 'Tanggal Kunjungan']);
            foreach ($pengunjungs as $p) {
                fputcsv($handle, [$p->no_pengunjung, $p->nama, $p->alamat, $p->pekerjaan, $p->tanggal]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function exportPdf(Request $request)
    {
        $query = Pengunjung::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('alamat', 'like', "%{$q}%")
                    ->orWhere('pekerjaan', 'like', "%{$q}%");
            });
        }
        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }

        $pengunjungs = $query->orderBy('tanggal')->get();

        $pdf = Pdf::loadView('admin.pengunjung.pdf', compact('pengunjungs'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-pengunjung-' . now()->format('Ymd_His') . '.pdf');
    }

    private function generateNomor(): string
    {
        $last = Pengunjung::orderByRaw('CAST(no_pengunjung AS INTEGER) DESC')->first();

        if ($last) {
            $urut = ((int) $last->no_pengunjung) + 1;
        } else {
            $urut = 1;
        }

        $nomor = (string) $urut;

        while (Pengunjung::whereKey($nomor)->exists()) {
            $urut++;
            $nomor = (string) $urut;
        }

        return $nomor;
    }
}

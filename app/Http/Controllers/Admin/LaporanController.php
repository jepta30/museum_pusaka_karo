<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Komentar;
use App\Models\Kunjungan;
use App\Models\Media;
use App\Models\WarisanBudaya;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    /**
     * Halaman hub yang menautkan ke semua jenis laporan (BAB IV.4).
     */
    public function index()
    {
        return view('admin.laporan.index');
    }

    /**
     * Menentukan rentang tanggal berdasarkan periode yang dipilih:
     * harian, mingguan, bulanan, atau rentang custom (dari/sampai).
     */
    private function rentangTanggal(Request $request): array
    {
        $periode = $request->get('periode', 'bulanan');

        if ($request->filled('dari') && $request->filled('sampai')) {
            return [Carbon::parse($request->dari)->startOfDay(), Carbon::parse($request->sampai)->endOfDay(), $periode];
        }

        return match ($periode) {
            'harian' => [now()->startOfDay(), now()->endOfDay(), $periode],
            'mingguan' => [now()->startOfWeek(), now()->endOfWeek(), $periode],
            default => [now()->startOfMonth(), now()->endOfMonth(), $periode],
        };
    }

    /**
     * Laporan Warisan Budaya (BAB IV.4 poin 6).
     */
    public function warisan(Request $request)
    {
        [$dari, $sampai, $periode] = $this->rentangTanggal($request);

        $query = WarisanBudaya::with('kategori')->whereBetween('created_at', [$dari, $sampai]);

        if ($request->filled('kategori_id') && $request->kategori_id != 'all') {
            $query->where('kategori_id', $request->kategori_id);
        }

        $warisans = $query->latest()->paginate(10)->withQueryString();
        $totalPerKategori = WarisanBudaya::whereBetween('created_at', [$dari, $sampai])
            ->join('kategoris', 'warisan_budayas.kategori_id', '=', 'kategoris.kategori_id')
            ->selectRaw('kategoris.nama, count(*) as total')
            ->groupBy('kategoris.nama')
            ->get();
        $kategoris = Kategori::all();

        return view('admin.laporan.warisan', compact('warisans', 'totalPerKategori', 'kategoris', 'dari', 'sampai', 'periode'));
    }

    public function warisanCsv(Request $request): StreamedResponse
    {
        [$dari, $sampai] = $this->rentangTanggal($request);
        $warisans = WarisanBudaya::with('kategori')->whereBetween('created_at', [$dari, $sampai])->orderBy('created_at')->get();
        $filename = 'laporan-warisan-budaya-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($warisans) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Judul', 'Kategori', 'Lokasi', 'Status', 'Jumlah Dilihat', 'Tanggal Ditambahkan']);
            foreach ($warisans as $w) {
                fputcsv($handle, [$w->warisan_budaya_id, $w->judul, $w->kategori->nama ?? '-', $w->lokasi, $w->status, $w->jumlah_dilihat, $w->created_at]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Laporan Rekapitulasi dan Statistik (BAB IV.4 poin 9).
     */
    public function rekapitulasi()
    {
        $totalWarisan = WarisanBudaya::count();
        $totalKategori = Kategori::count();
        $totalMedia = Media::count();

        $perKategori = Kategori::query()
            ->leftJoin('warisan_budayas', 'kategoris.kategori_id', '=', 'warisan_budayas.kategori_id')
            ->selectRaw('kategoris.nama, count(warisan_budayas.warisan_budaya_id) as total')
            ->groupBy('kategoris.kategori_id', 'kategoris.nama')
            ->get();

        $totalKomentar = Komentar::count();
        $komentarApproved = Komentar::where('status', 'approved')->count();
        $komentarPending = Komentar::where('status', 'pending')->count();
        $komentarRejected = Komentar::where('status', 'rejected')->count();
        $rasioApproved = $totalKomentar > 0 ? round(($komentarApproved / $totalKomentar) * 100, 1) : 0;

        $mediaFoto = Media::where('jenis_media', 'foto')->count();
        $mediaVideo = Media::where('jenis_media', 'video')->count();

        return view('admin.laporan.rekapitulasi', compact(
            'totalWarisan', 'totalKategori', 'totalMedia', 'perKategori',
            'totalKomentar', 'komentarApproved', 'komentarPending', 'komentarRejected', 'rasioApproved',
            'mediaFoto', 'mediaVideo'
        ));
    }

    public function rekapitulasiCsv(): StreamedResponse
    {
        $perKategori = Kategori::query()
            ->leftJoin('warisan_budayas', 'kategoris.kategori_id', '=', 'warisan_budayas.kategori_id')
            ->selectRaw('kategoris.nama, count(warisan_budayas.warisan_budaya_id) as total')
            ->groupBy('kategoris.kategori_id', 'kategoris.nama')
            ->get();
        $filename = 'laporan-rekapitulasi-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($perKategori) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Kategori', 'Jumlah Warisan Budaya']);
            foreach ($perKategori as $k) {
                fputcsv($handle, [$k->nama, $k->total]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Laporan Aktivitas Komentar (BAB IV.4 poin 10).
     */
    public function komentar(Request $request)
    {
        [$dari, $sampai, $periode] = $this->rentangTanggal($request);

        $query = Komentar::with('warisanBudaya')->whereBetween('created_at', [$dari, $sampai]);

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $komentars = $query->latest()->paginate(10)->withQueryString();

        $rekap = Komentar::whereBetween('created_at', [$dari, $sampai])
            ->selectRaw("status, count(*) as total")
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        return view('admin.laporan.komentar', compact('komentars', 'rekap', 'dari', 'sampai', 'periode'));
    }

    public function komentarCsv(Request $request): StreamedResponse
    {
        [$dari, $sampai] = $this->rentangTanggal($request);
        $komentars = Komentar::with('warisanBudaya')->whereBetween('created_at', [$dari, $sampai])->orderBy('created_at')->get();
        $filename = 'laporan-aktivitas-komentar-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($komentars) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Warisan Budaya', 'Nama', 'Email', 'Isi Komentar', 'Status', 'Tanggal']);
            foreach ($komentars as $k) {
                fputcsv($handle, [$k->komentar_id, $k->warisanBudaya->judul ?? '-', $k->nama, $k->email, $k->isi_komentar, $k->status, $k->created_at]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Statistik Kunjungan Website (BAB IV.4 poin 11).
     */
    public function kunjungan(Request $request)
    {
        [$dari, $sampai, $periode] = $this->rentangTanggal($request);

        $base = Kunjungan::whereBetween('tanggal', [$dari->toDateString(), $sampai->toDateString()]);

        $totalKunjungan = (clone $base)->count();

        $trenHarian = (clone $base)
            ->selectRaw('tanggal, count(*) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $halamanTerbanyak = (clone $base)
            ->selectRaw('halaman, count(*) as total')
            ->groupBy('halaman')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $perPerangkat = (clone $base)
            ->selectRaw('perangkat, count(*) as total')
            ->groupBy('perangkat')
            ->get();

        $warisanTerpopuler = (clone $base)
            ->whereNotNull('warisan_budaya_id')
            ->with('warisanBudaya')
            ->selectRaw('warisan_budaya_id, count(*) as total')
            ->groupBy('warisan_budaya_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.laporan.kunjungan', compact(
            'totalKunjungan', 'trenHarian', 'halamanTerbanyak', 'perPerangkat', 'warisanTerpopuler', 'dari', 'sampai', 'periode'
        ));
    }

    public function kunjunganCsv(Request $request): StreamedResponse
    {
        [$dari, $sampai] = $this->rentangTanggal($request);
        $data = Kunjungan::whereBetween('tanggal', [$dari->toDateString(), $sampai->toDateString()])->orderBy('tanggal')->get();
        $filename = 'statistik-kunjungan-website-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($data) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Tanggal', 'Waktu', 'Halaman', 'Perangkat', 'Kota', 'IP']);
            foreach ($data as $d) {
                fputcsv($handle, [$d->tanggal, $d->waktu, $d->halaman, $d->perangkat, $d->kota, $d->ip]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}

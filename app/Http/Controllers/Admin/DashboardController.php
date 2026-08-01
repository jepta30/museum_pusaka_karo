<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\WarisanBudaya;
use App\Models\Media;
use App\Models\Komentar;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKategori = Kategori::count();
        $totalWarisanBudaya = WarisanBudaya::count();
        $totalMedia = Media::count();
        $totalKomentarPending = Komentar::where('status', 'pending')->count();

        $recentComments = Komentar::with('warisanBudaya')
                                  ->orderBy('created_at', 'desc')
                                  ->take(5)
                                  ->get();

        // Statistik Pengunjung 14 Hari Terakhir
        $chartLabels = [];
        $chartData = [];
        for ($i = 13; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = \Carbon\Carbon::parse($date)->format('d/m');
            $chartData[] = 0;
        }

        $visitorStats = \App\Models\Pengunjung::where('tanggal', '>=', \Carbon\Carbon::now()->subDays(13)->format('Y-m-d'))
            ->selectRaw('tanggal, count(*) as total')
            ->groupBy('tanggal')
            ->get();

        foreach ($visitorStats as $stat) {
            $formattedDate = \Carbon\Carbon::parse($stat->tanggal)->format('d/m');
            $index = array_search($formattedDate, $chartLabels);
            if ($index !== false) {
                $chartData[$index] = $stat->total;
            }
        }

        return view('admin.dashboard', compact(
            'totalKategori', 
            'totalWarisanBudaya', 
            'totalMedia', 
            'totalKomentarPending',
            'recentComments',
            'chartLabels',
            'chartData'
        ));
    }
}

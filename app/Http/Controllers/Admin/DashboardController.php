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

        return view('admin.dashboard', compact(
            'totalKategori', 
            'totalWarisanBudaya', 
            'totalMedia', 
            'totalKomentarPending',
            'recentComments'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarisanBudaya;
use App\Models\Kategori;

class HomeController extends Controller
{
    public function index()
    {
        // Get statistics for the floating card
        $totalWarisan = WarisanBudaya::count();
        $totalKategori = Kategori::count();
        
        // As per the wireframe stats "21 Titik Persebaran", "14 Kabupaten/Kota"
        // We will just mock these two for now or calculate from unique locations
        $totalTitik = WarisanBudaya::distinct('lokasi')->count('lokasi') ?: 21; 
        $totalKabupaten = 14; 
        
        // Get categories for the grid
        $kategoris = Kategori::withCount('warisanBudayas')->take(6)->get();
        
        // Get some random/featured collections for the carousel if needed
        $featured = WarisanBudaya::with('media')->latest()->take(5)->get();

        return view('home', compact(
            'totalWarisan', 'totalKategori', 'totalTitik', 'totalKabupaten',
            'kategoris', 'featured'
        ));
    }
}

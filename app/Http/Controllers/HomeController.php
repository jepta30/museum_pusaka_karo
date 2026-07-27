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
        $featured = WarisanBudaya::with('medias')->latest()->take(5)->get();

        return view('home', compact(
            'totalWarisan', 'totalKategori', 'totalTitik', 'totalKabupaten',
            'kategoris', 'featured'
        ));
    }

    public function tentang()
    {
        $totalWarisan = WarisanBudaya::count();
        $totalKategori = Kategori::count();

        return view('tentang', compact('totalWarisan', 'totalKategori'));
    }

    public function petaPersebaran()
    {
        $warisans = WarisanBudaya::select('warisan_budaya_id', 'judul', 'lokasi')->get();

        $locationCoords = [
            'Kaban Jahe' => [3.12095, 98.42346],
            'Kabanjahe' => [3.13220, 98.46650],
            'Lingga Budaya' => [3.12520, 98.42580],
        ];

        $markerPoints = $warisans->map(function ($warisan) use ($locationCoords) {
            return [
                'judul' => $warisan->judul,
                'lokasi' => $warisan->lokasi,
                'coords' => $locationCoords[$warisan->lokasi] ?? null,
            ];
        })->filter(function ($item) {
            return $item['coords'] !== null;
        })->values()->all();

        return view('peta.persebaran', compact('warisans', 'markerPoints'));
    }
}

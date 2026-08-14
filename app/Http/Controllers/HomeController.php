<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarisanBudaya;
use App\Models\Kategori;
use App\Models\SaranKritik;

class HomeController extends Controller
{
    public function index()
    {
        // Get statistics for the floating card
        $totalWarisan = WarisanBudaya::count();
        $totalKategori = Kategori::count();
        
        // Hitung jumlah titik persebaran berdasarkan data warisan yang benar-benar memiliki koordinat valid
        $totalTitik = WarisanBudaya::query()
            ->where('status', 'aktif')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('latitude', '!=', 0)
            ->where('longitude', '!=', 0)
            ->count();
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
        $warisans = WarisanBudaya::select('warisan_budaya_id', 'judul', 'lokasi', 'asal', 'latitude', 'longitude')->get();

        $markerPoints = $warisans->map(function ($warisan) {
            return [
                'judul' => $warisan->judul,
                'lokasi' => $warisan->lokasi,
                'asal' => $warisan->asal,
                'coords' => ($warisan->latitude && $warisan->longitude) ? [(float) $warisan->latitude, (float) $warisan->longitude] : null,
            ];
        })->filter(function ($item) {
            return $item['coords'] !== null;
        })->values()->all();

        return view('peta.persebaran', compact('warisans', 'markerPoints'));
    }

    public function storeSaran(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'pesan' => 'required|string'
        ]);

        $saran = SaranKritik::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Terimakasih telah mengisi saran dan pesan'
            ]);
        }

        return redirect()->back()->with('success', 'Terimakasih telah mengisi saran dan pesan');
    }
}

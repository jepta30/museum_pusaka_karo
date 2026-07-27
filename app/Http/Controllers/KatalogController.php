<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarisanBudaya;
use App\Models\Kategori;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = WarisanBudaya::with('kategori')->where('status', 'aktif');

        // Filter based on search input
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($sub) use ($searchTerm) {
                $sub->where('judul', 'like', "%{$searchTerm}%")
                    ->orWhere('deskripsi', 'like', "%{$searchTerm}%");
            });
        }

        // Filter based on category
        if ($request->filled('kategori_id') && $request->kategori_id != 'all') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Paginate results (9 per page for a 3x3 grid)
        $warisans = $query->latest()->paginate(9)->withQueryString();
        
        $kategoris = Kategori::all();

        return view('katalog.index', compact('warisans', 'kategoris'));
    }

    public function show($id)
    {
        $warisan = WarisanBudaya::with(['kategori', 'medias', 'komentars' => function($q) {
            $q->where('status', 'approved')->latest();
        }])->findOrFail($id);

        // Fetch related items from the same category
        $relatedWarisans = WarisanBudaya::where('kategori_id', $warisan->kategori_id)
                                        ->where('warisan_budaya_id', '!=', $warisan->warisan_budaya_id)
                                        ->take(3)
                                        ->get();

        return view('katalog.show', compact('warisan', 'relatedWarisans'));
    }

    public function storeKomentar(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'isi_komentar' => 'required|string'
        ]);

        $warisan = WarisanBudaya::findOrFail($id);

        $warisan->komentars()->create([
            'nama' => $request->nama,
            'email' => $request->email,
            'isi_komentar' => $request->isi_komentar,
            'status' => 'pending' // Menunggu persetujuan admin
        ]);

        return back()->with('success', 'Terima kasih! Komentar Anda berhasil dikirim dan sedang menunggu persetujuan admin.');
    }
}

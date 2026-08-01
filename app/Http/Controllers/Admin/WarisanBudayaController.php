<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WarisanBudaya;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class WarisanBudayaController extends Controller
{
    public function index(Request $request)
    {
        $query = WarisanBudaya::with('kategori');
        
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%");
            });
        }
        
        $warisans = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::all();
        return view('admin.warisan.index', compact('warisans', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:150',
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'lokasi' => 'required|max:150',
            'status' => 'required|in:aktif,nonaktif',
            'kondisi' => 'nullable|string|max:50',
            'asal' => 'nullable|string|max:100',
            'deskripsi' => 'required',
            'sejarah' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric'
        ]);

        $gambarPath = $request->file('gambar')->store('warisan_images', 'public');

        WarisanBudaya::create([
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
            'kondisi' => $request->kondisi,
            'asal' => $request->asal,
            'deskripsi' => $request->deskripsi,
            'sejarah' => $request->sejarah,
            'gambar' => $gambarPath,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('warisan.index')->with('success', 'Data Warisan Budaya berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $warisan = WarisanBudaya::where('warisan_budaya_id', $id)->firstOrFail();

        $request->validate([
            'judul' => 'required|max:150',
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'lokasi' => 'required|max:150',
            'status' => 'required|in:aktif,nonaktif',
            'kondisi' => 'nullable|string|max:50',
            'asal' => 'nullable|string|max:100',
            'deskripsi' => 'required',
            'sejarah' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric'
        ]);

        if ($request->hasFile('gambar')) {
            if ($warisan->gambar && Storage::disk('public')->exists($warisan->gambar)) {
                Storage::disk('public')->delete($warisan->gambar);
            }
            $gambarPath = $request->file('gambar')->store('warisan_images', 'public');
            $warisan->gambar = $gambarPath;
        }

        $warisan->judul = $request->judul;
        $warisan->kategori_id = $request->kategori_id;
        $warisan->lokasi = $request->lokasi;
        $warisan->status = $request->status;
        $warisan->kondisi = $request->kondisi;
        $warisan->asal = $request->asal;
        $warisan->deskripsi = $request->deskripsi;
        $warisan->sejarah = $request->sejarah;
        if ($request->has('latitude')) {
            $warisan->latitude = $request->latitude;
        }
        if ($request->has('longitude')) {
            $warisan->longitude = $request->longitude;
        }
        $warisan->save();

        return redirect()->route('warisan.index')->with('success', 'Data Warisan Budaya berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $warisan = WarisanBudaya::where('warisan_budaya_id', $id)->firstOrFail();
        
        if ($warisan->gambar && Storage::disk('public')->exists($warisan->gambar)) {
            Storage::disk('public')->delete($warisan->gambar);
        }
        
        $warisan->delete();

        return redirect()->route('warisan.index')->with('success', 'Data Warisan Budaya berhasil dihapus.');
    }
}

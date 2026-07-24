<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WarisanBudaya;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class WarisanBudayaController extends Controller
{
    public function index()
    {
        $warisans = WarisanBudaya::with('kategori')->latest()->paginate(10);
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
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $gambarPath = $request->file('gambar')->store('warisan_images', 'public');

        WarisanBudaya::create([
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'sejarah' => $request->deskripsi, // Kombinasi seperti di wireframe
            'gambar' => $gambarPath,
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
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
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
        $warisan->deskripsi = $request->deskripsi;
        $warisan->sejarah = $request->deskripsi;
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Kategori::query();
        
        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }
        
        $kategoris = $query->latest()->paginate(10)->withQueryString();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:25',
            'deskripsi' => 'required',
            'icon' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        $iconPath = $request->file('icon')->store('kategori_icons', 'public');

        Kategori::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'icon' => $iconPath,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori Budaya berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Parameter name matching the database primary key 'kategori_id'
        $kategori = Kategori::where('kategori_id', $id)->firstOrFail();
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::where('kategori_id', $id)->firstOrFail();

        $request->validate([
            'nama' => 'required|max:25',
            'deskripsi' => 'required',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        if ($request->hasFile('icon')) {
            // Hapus icon lama jika ada
            if ($kategori->icon && Storage::disk('public')->exists($kategori->icon)) {
                Storage::disk('public')->delete($kategori->icon);
            }
            $iconPath = $request->file('icon')->store('kategori_icons', 'public');
            $kategori->icon = $iconPath;
        }

        $kategori->nama = $request->nama;
        $kategori->deskripsi = $request->deskripsi;
        $kategori->save();

        return redirect()->route('kategori.index')->with('success', 'Kategori Budaya berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::where('kategori_id', $id)->firstOrFail();
        
        if ($kategori->icon && Storage::disk('public')->exists($kategori->icon)) {
            Storage::disk('public')->delete($kategori->icon);
        }
        
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori Budaya berhasil dihapus.');
    }
}

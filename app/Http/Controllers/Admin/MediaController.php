<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\WarisanBudaya;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::with('warisanBudaya');
        
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($qBuilder) use ($q) {
                $qBuilder->where('keterangan', 'like', "%{$q}%")
                         ->orWhereHas('warisanBudaya', function($sub) use ($q) {
                             $sub->where('judul', 'like', "%{$q}%");
                         });
            });
        }

        if ($request->filled('kategori_id') && $request->kategori_id != 'all') {
            $query->whereHas('warisanBudaya', function($sub) use ($request) {
                $sub->where('kategori_id', $request->kategori_id);
            });
        }

        if ($request->filled('jenis_media') && $request->jenis_media != 'all') {
            $query->where('jenis_media', $request->jenis_media);
        }
        
        $medias = $query->latest()->paginate(10)->withQueryString();
        $warisans = WarisanBudaya::all();
        $kategoris = \App\Models\Kategori::all();
        return view('admin.media.index', compact('medias', 'warisans', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warisan_budaya_id' => 'required|exists:warisan_budayas,warisan_budaya_id',
            'jenis_media' => 'required|in:foto,video',
            'keterangan' => 'required|max:255',
            'file_media' => 'required|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:51200' // 50MB max for videos
        ]);

        $filePath = $request->file('file_media')->store('media_dokumentasi', 'public');

        Media::create([
            'warisan_budaya_id' => $request->warisan_budaya_id,
            'jenis_media' => $request->jenis_media,
            'keterangan' => $request->keterangan,
            'file_media' => $filePath,
        ]);

        return redirect()->route('media.index')->with('success', 'Media Dokumentasi berhasil diunggah.');
    }

    public function update(Request $request, $id)
    {
        $media = Media::where('media_id', $id)->firstOrFail();

        $request->validate([
            'warisan_budaya_id' => 'required|exists:warisan_budayas,warisan_budaya_id',
            'jenis_media' => 'required|in:foto,video',
            'keterangan' => 'required|max:255',
            'file_media' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:51200'
        ]);

        if ($request->hasFile('file_media')) {
            if ($media->file_media && Storage::disk('public')->exists($media->file_media)) {
                Storage::disk('public')->delete($media->file_media);
            }
            $filePath = $request->file('file_media')->store('media_dokumentasi', 'public');
            $media->file_media = $filePath;
        }

        $media->warisan_budaya_id = $request->warisan_budaya_id;
        $media->jenis_media = $request->jenis_media;
        $media->keterangan = $request->keterangan;
        $media->save();

        return redirect()->route('media.index')->with('success', 'Media Dokumentasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $media = Media::where('media_id', $id)->firstOrFail();
        
        if ($media->file_media && Storage::disk('public')->exists($media->file_media)) {
            Storage::disk('public')->delete($media->file_media);
        }
        
        $media->delete();

        return redirect()->route('media.index')->with('success', 'Media Dokumentasi berhasil dihapus.');
    }
}

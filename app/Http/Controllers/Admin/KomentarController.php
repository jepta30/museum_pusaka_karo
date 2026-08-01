<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Komentar;

class KomentarController extends Controller
{
    public function index(Request $request)
    {
        $query = Komentar::query();
        
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama', 'like', "%{$q}%")
                  ->orWhere('isi_komentar', 'like', "%{$q}%");
        }
        
        $komentars = $query->latest()->paginate(10)->withQueryString();
        return view('admin.komentar.index', compact('komentars'));
    }

    public function update(Request $request, $id)
    {
        $komentar = Komentar::where('komentar_id', $id)->firstOrFail();

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $komentar->status = $request->status;
        $komentar->save();

        $statusMsg = $request->status == 'approved' ? 'disetujui' : 'ditolak';

        return back()->with('success', "Komentar berhasil $statusMsg.");
    }

    public function destroy($id)
    {
        $komentar = Komentar::where('komentar_id', $id)->firstOrFail();
        $komentar->delete();

        return back()->with('success', 'Komentar berhasil dihapus permanen.');
    }
}

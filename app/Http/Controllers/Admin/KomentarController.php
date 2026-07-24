<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Komentar;

class KomentarController extends Controller
{
    public function index()
    {
        $komentars = Komentar::latest()->paginate(10);
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

        return redirect()->route('komentar.index')->with('success', "Komentar berhasil $statusMsg.");
    }

    public function destroy($id)
    {
        $komentar = Komentar::where('komentar_id', $id)->firstOrFail();
        $komentar->delete();

        return redirect()->route('komentar.index')->with('success', 'Komentar berhasil dihapus permanen.');
    }
}

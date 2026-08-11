<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SaranKritik;

class SaranController extends Controller
{
    public function index()
    {
        $sarans = SaranKritik::orderBy('created_at', 'desc')->get();
        return view('admin.saran.index', compact('sarans'));
    }

    public function destroy($id)
    {
        $saran = SaranKritik::findOrFail($id);
        $saran->delete();

        return redirect()->route('saran.index')->with('success', 'Kritik/Saran berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraan = Kendaraan::where('user_id', Auth::id())->get(); // hanya kendaraan user login
        return view('user.kendaraan.index', compact('kendaraan'));
    }

    public function store(Request $request)
    {
        dd('STORE MASUK');

        $request->validate([
            'merk' => 'required',
            'model' => 'required',
            'plat_nomor' => 'required|unique:kendaraan,plat_nomor',
        ]);

        Kendaraan::create([
            'user_id' => Auth::id(), // otomatis ke user login
            'merk' => $request->merk,
            'model' => $request->model,
            'plat_nomor' => $request->plat_nomor,
        ]);

        return back()->with('success', 'Kendaraan berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->get();
        $kendaraan->delete();

        return back()->with('success', 'Kendaraan berhasil dihapus');
    }
}

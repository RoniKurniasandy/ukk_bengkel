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
        Kendaraan::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->route('user.kendaraan')
            ->with('success', 'Kendaraan berhasil dihapus!');
    }
}

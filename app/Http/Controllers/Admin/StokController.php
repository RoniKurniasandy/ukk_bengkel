<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $stok = Stok::orderBy('stok_id', 'DESC')->get();
        return view('admin.stok.index', compact('stok'));
    }


    public function create()
    {
        return view('admin.stok.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:stok',
            'nama_barang' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'jumlah' => 'required|integer'
        ]);

        Stok::create($request->all());
        return redirect()->route('admin.stok.index')->with('success', 'Data barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $stok = Stok::findOrFail($id);
        return view('admin.stok.edit', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        $stok = Stok::findOrFail($id);

        $request->validate([
            'kode_barang' => 'required|unique:stok,kode_barang,' . $id . ',stok_id',
            'nama_barang' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'jumlah' => 'required|integer'
        ]);

        $stok->update($request->all());
        return redirect()->route('admin.stok.index')->with('success', 'Data barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        Stok::findOrFail($id)->delete();
        return redirect()->route('admin.stok.index')->with('success', 'Data barang berhasil dihapus');
    }
}

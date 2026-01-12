<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stok;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $stok = Stok::create($request->all());

        // Record Transaction (Pengeluaran - Belanja Stok Awal)
        if ($request->jumlah > 0) {
            Transaksi::create([
                'user_id' => Auth::id(),
                'stok_id' => $stok->stok_id,
                'jenis_transaksi' => 'pengeluaran',
                'sumber' => 'belanja_stok',
                'jumlah' => $request->jumlah,
                'total' => $request->jumlah * $request->harga_beli,
                'keterangan' => 'Belanja Stok Baru: ' . $stok->nama_barang,
                'status' => 'selesai'
            ]);
        }

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
            // exclude kode_barang validation since it's not editable
            'nama_barang' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'jumlah' => 'required|integer'
        ]);

        // Calculate difference for transaction
        $oldJumlah = $stok->jumlah;
        $newJumlah = $request->jumlah;
        $diff = $newJumlah - $oldJumlah;

        // Prevent kode_barang from updating
        $stok->update($request->except('kode_barang'));

        // Record Transaction if stock increased (Restock)
        if ($diff > 0) {
            Transaksi::create([
                'user_id' => Auth::id(),
                'stok_id' => $stok->stok_id,
                'jenis_transaksi' => 'pengeluaran',
                'sumber' => 'belanja_stok',
                'jumlah' => $diff,
                'total' => $diff * $request->harga_beli,
                'keterangan' => 'Restock Barang: ' . $stok->nama_barang,
                'status' => 'selesai'
            ]);
        }

        return redirect()->route('admin.stok.index')->with('success', 'Data barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        Stok::findOrFail($id)->delete();
        return redirect()->route('admin.stok.index')->with('success', 'Data barang berhasil dihapus');
    }
}

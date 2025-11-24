<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stok;

class PenjualanController extends Controller
{
    public function create()
    {
        $stok = Stok::where('jumlah', '>', 0)->get();
        return view('admin.penjualan.create', compact('stok'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stok_id' => 'required|exists:stok,stok_id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $stok = Stok::findOrFail($request->stok_id);

        if ($stok->jumlah < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        // Kurangi stok
        $stok->decrement('jumlah', $request->jumlah);

        // Hitung total harga (opsional, bisa disimpan ke tabel transaksi jika ada)
        $totalHarga = $stok->harga_jual * $request->jumlah;

        return redirect()->route('admin.stok.index')
            ->with('success', "Penjualan berhasil! Total: Rp " . number_format($totalHarga, 0, ',', '.'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['user', 'servis.booking.kendaraan', 'stok'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPemasukan = $transaksi->where('jenis_transaksi', 'pemasukan')->sum('total');
        $totalPengeluaran = $transaksi->where('jenis_transaksi', 'pengeluaran')->sum('total');

        return view('transaksi.index', compact('transaksi', 'totalPemasukan', 'totalPengeluaran'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with([
            'user',
            'servis.booking.kendaraan',
            'servis.booking.user',
            'servis.detailServis.stok',
            'stok'
        ])->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }
}


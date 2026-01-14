<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $jenis = $request->get('jenis_transaksi');

        $query = Transaksi::with(['user', 'servis.booking.kendaraan', 'stok']);

        // Filter Pencarian (keterangan, nama user, plat nomor)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('servis.booking.kendaraan', function ($q) use ($search) {
                        $q->where('plat_nomor', 'like', "%{$search}%");
                    });
            });
        }

        // Filter Rentang Tanggal
        if ($dateFrom && $dateTo) {
            $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
        } elseif ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        } elseif ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Filter Jenis Transaksi
        if ($jenis && in_array($jenis, ['pemasukan', 'pengeluaran'])) {
            $query->where('jenis_transaksi', $jenis);
        }

        $transaksi = $query->orderBy('created_at', 'desc')->get();

        // Hitung total berdasarkan hasil filter
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
            'servis.mekanik',
            'servis.detailServis.stok',
            'stok'
        ])->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }
}


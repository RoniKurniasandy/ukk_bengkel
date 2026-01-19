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
            'satuan' => 'required|string',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'jumlah' => 'required|integer',
            'keterangan' => 'nullable'
        ]);

        $data = $request->all();
        $data['nomor_seri'] = $this->generateNomorSeri($request->kode_barang, $request->nama_barang);

        $stok = Stok::create($data);

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

        return redirect()->route('admin.stok.index')->with('success', 'Data barang berhasil ditambahkan dengan Nomor Seri: ' . $data['nomor_seri']);
    }

    private function generateNomorSeri($kode_barang, $nama_barang)
    {
        // 1. Bersihkan Kode Barang (Hilangkan simbol, ambil alphanumeric)
        $cleanCode = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $kode_barang));

        // 2. Ambil inisial dari nama barang
        $words = explode(' ', str_replace(['-', '_'], ' ', $nama_barang));
        $initials = '';
        foreach ($words as $w) {
            if (!empty($w)) {
                $initials .= strtoupper(substr($w, 0, 1));
            }
        }

        if (strlen($initials) < 2) {
            $initials = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $nama_barang), 0, 3));
        }

        $prefix = $cleanCode . '-' . $initials;

        // 3. Cari nomor urut terakhir untuk kombinasi ini
        $lastStok = Stok::where('nomor_seri', 'LIKE', $prefix . '-%')
            ->orderBy('nomor_seri', 'desc')
            ->first();

        if ($lastStok) {
            $lastNumber = intval(substr($lastStok->nomor_seri, strrpos($lastStok->nomor_seri, '-') + 1));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . '-' . $newNumber;
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
            // exclude certain fields from direct update
            'nama_barang' => 'required',
            'satuan' => 'required|string',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'jumlah' => 'required|integer'
        ]);

        // Calculate difference for transaction
        $oldJumlah = $stok->jumlah;
        $newJumlah = $request->jumlah;
        $diff = $newJumlah - $oldJumlah;

        // Prevent kode_barang and nomor_seri from updating
        $data = $request->except(['kode_barang', 'nomor_seri']);
        $stok->update($data);

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
        $stok = Stok::findOrFail($id);

        // 1. Check Usage in Jobs (Repairs)
        if ($stok->detailServis()->exists()) {
            return redirect()->route('admin.stok.index')->with('error', 'Barang tidak bisa dihapus karena sudah tercatat digunakan dalam riwayat servis.');
        }

        // 2. Check Usage in Sales/Other Transactions
        // We only allow deletion if ALL transactions linked to this stok are 'belanja_stok' (Restock/Initial)
        $allCount = \App\Models\Transaksi::where('stok_id', $id)->count();
        $purchaseCount = \App\Models\Transaksi::where('stok_id', $id)->where('sumber', 'belanja_stok')->count();

        if ($allCount > $purchaseCount) {
             return redirect()->route('admin.stok.index')->with('error', 'Barang tidak bisa dihapus karena sudah memiliki riwayat penjualan atau riwayat finansial selain pembelian.');
        }

        // 3. Perform Deletion in a Transaction
        try {
            \Illuminate\Support\Facades\DB::transaction(function() use ($id, $stok) {
                \App\Models\Transaksi::where('stok_id', $id)->where('sumber', 'belanja_stok')->delete();
                $stok->delete();
            });

            return redirect()->route('admin.stok.index')->with('success', 'Data barang berhasil dihapus beserta riwayat pembelian terkait.');
        } catch (\Exception $e) {
            return redirect()->route('admin.stok.index')->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}

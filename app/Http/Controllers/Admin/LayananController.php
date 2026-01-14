<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;

use App\Models\Booking;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::orderBy('created_at','DESC')->get();
        return view('admin.layanan.index', compact('layanan'));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'estimasi_waktu' => 'required' // contoh input: "1-2 Jam" atau "30 Menit"
        ]);

        Layanan::create($request->all());

        return redirect()->route('admin.layanan.index')
            ->with('success','Layanan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'estimasi_waktu' => 'required'
        ]);

        $layanan->update($request->all());

        return redirect()->route('admin.layanan.index')
            ->with('success','Layanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cek apakah layanan sedang digunakan di tabel booking
        $isUsed = Booking::where('layanan_id', $id)->exists();

        if ($isUsed) {
            return redirect()->route('admin.layanan.index')
                ->with('error', 'Layanan tidak dapat dihapus karena sudah ada riwayat transaksi/booking yang menggunakannya.');
        }

        Layanan::findOrFail($id)->delete();
        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}

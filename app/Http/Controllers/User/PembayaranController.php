<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function create($servisId)
    {
        $servis = \App\Models\Servis::with(['booking.layanan', 'booking.kendaraan'])->findOrFail($servisId);

        // Cek apakah user berhak melihat servis ini (security check)
        if ($servis->booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.pembayaran.create', compact('servis'));
    }

    public function store(Request $request, $servisId)
    {
        $servis = \App\Models\Servis::findOrFail($servisId);

        // Security check
        if ($servis->booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Validasi input
        $validated = $request->validate([
            'jenis_pembayaran' => 'required|in:dp,pelunasan,full',
            'metode_pembayaran' => 'required|in:transfer,tunai',
            'jumlah' => 'nullable|numeric|min:1000',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        // Set jumlah berdasarkan jenis pembayaran
        if ($request->jenis_pembayaran === 'full') {
            $jumlah = $servis->estimasi_biaya;
        } else {
            $jumlah = $request->jumlah;
        }

        // Validasi manual untuk transfer harus ada bukti
        if ($request->metode_pembayaran === 'transfer' && !$request->hasFile('bukti_pembayaran')) {
            return redirect()->back()->withErrors(['bukti_pembayaran' => 'Bukti pembayaran wajib diupload untuk metode transfer.'])->withInput();
        }

        $path = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $servis->pembayarans()->create([
            'jumlah' => $jumlah,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_pembayaran' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('user.servis')->with('success', 'Pembayaran berhasil dikirim dan menunggu verifikasi admin.');
    }
}

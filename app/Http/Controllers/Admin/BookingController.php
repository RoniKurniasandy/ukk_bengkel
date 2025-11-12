<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar semua booking
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'kendaraan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.booking.index', compact('bookings'));
    }

    /**
     * Menampilkan form edit status booking
     */
    public function edit($id)
    {
        $booking = Booking::with(['user', 'kendaraan'])->findOrFail($id);
        $statusOptions = ['menunggu', 'disetujui', 'ditolak', 'dibatalkan', 'selesai'];

        return view('admin.booking.edit', compact('booking', 'statusOptions'));
    }

    /**
     * Mengubah status booking
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,disetujui,ditolak,dibatalkan,selesai',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        return redirect()->route('admin.booking')->with('success', 'Status booking berhasil diperbarui.');
    }

    /**
     * Menghapus booking (opsional, jika ingin)
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.booking')->with('success', 'Data booking berhasil dihapus.');
    }
}

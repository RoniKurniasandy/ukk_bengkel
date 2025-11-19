<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Servis;
use App\Models\User;

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
        $mekanik = User::where('role', 'mekanik')->get(); // ⬅ list mekanik

        return view('admin.booking.edit', compact('booking', 'statusOptions', 'mekanik'));
    }

    /**
     * Mengubah status booking + Sinkronisasi ke tabel servis
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'mekanik_id' => 'required_if:status,disetujui|exists:users,id',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        // Jika booking disetujui → buat data servis
        if ($request->status === 'disetujui') {
            Servis::create([
                'booking_id' => $booking->booking_id,
                'mekanik_id' => $request->mekanik_id, // ⬅ berasal dari form
                'status' => 'dikerjakan',
            ]);
        }

        return redirect()->route('admin.booking')
            ->with('success', 'Booking berhasil diperbarui');
    }

    /**
     * Menghapus booking
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.booking')->with('success', 'Data booking berhasil dihapus.');
    }
}

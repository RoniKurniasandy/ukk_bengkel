<<<<<<< HEAD
=======
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Kendaraan;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('user.booking.index', compact('bookings'));
    }

    public function create()
    {
        // kendaraan hanya milik user yang sedang login
        $kendaraan = Kendaraan::where('user_id', Auth::id())->get();
        $layanan = Layanan::all();
        return view('user.booking.create', compact('kendaraan', 'layanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required',
            'layanan_id' => 'required|exists:layanans,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'keluhan' => 'required',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'kendaraan_id' => $request->kendaraan_id,
            'layanan_id' => $request->layanan_id,
            'tanggal_booking' => $request->tanggal_booking,
            'keluhan' => $request->keluhan,
            'status' => 'menunggu', // FIX ENUM
        ]);

        return redirect()->route('user.booking.index')
            ->with('success', 'Booking berhasil dikirim!');
    }


    public function destroy($id)
    {
        $booking = Booking::where('booking_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($booking->status !== 'menunggu') {
            return redirect()->route('user.booking.index')
                ->with('error', 'Booking tidak dapat dibatalkan karena sudah dikonfirmasi.');
        }

        $booking->update(['status' => 'dibatalkan']); // bukan delete
        return redirect()->route('user.booking.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}
>>>>>>> 2f9a12e6b36e5ea78911cc2bbb6eeffa2c9d8f16

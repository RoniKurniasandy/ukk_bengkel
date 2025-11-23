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
        $kendaraan = Kendaraan::where('user_id', Auth::id())->get();
        $layanan = Layanan::orderBy('nama_layanan', 'ASC')->get(); // urut dari A–Z
        return view('user.booking.create', compact('kendaraan', 'layanan'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required',
            'jenis_layanan' => 'required', // input berasal dari pilihan layanan admin
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'keluhan' => 'required',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'kendaraan_id' => $request->kendaraan_id,
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_booking' => $request->tanggal_booking,
            'keluhan' => $request->keluhan,
            'status' => 'menunggu',
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
                ->with('error', 'Booking tidak dapat dibatalkan karena sudah diproses.');
        }

        $booking->update(['status' => 'dibatalkan']);
        return redirect()->route('user.booking.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Kendaraan;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BookingNotification;
use App\Models\User;


class BookingController extends Controller
{
    public function index()
    {
        // Show bookings that are waiting, approved (but not started), rejected, or cancelled
        // Status 'dikerjakan' and 'selesai' will be removed from here
        $bookings = Booking::where('user_id', Auth::id())
            ->whereIn('status', ['menunggu', 'disetujui', 'ditolak', 'dibatalkan'])
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('user.booking.index', compact('bookings'));
    }

    public function servisIndex()
    {
        // Show services that are approved (waiting for mechanic), ongoing, or completed
        $servis = Booking::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->whereHas('servis') // Ongoing/Completed (dikerjakan/selesai)
                    ->orWhere('status', 'disetujui'); // Approved but not started yet
            })
            ->with(['servis', 'kendaraan', 'layanan'])
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('user.servis.index', compact('servis'));
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
            'jam_booking' => 'required|date_format:H:i|after:07:59|before:18:01',
            'keluhan' => 'required',
        ], [
            'jam_booking.after' => 'Jam booking harus setelah jam 08:00',
            'jam_booking.before' => 'Jam booking harus sebelum jam 18:00',
            'jam_booking.required' => 'Jam booking wajib diisi',
            'jam_booking.date_format' => 'Format jam tidak valid',
        ]);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'kendaraan_id' => $request->kendaraan_id,
            'layanan_id' => $request->layanan_id,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_booking' => $request->jam_booking,
            'keluhan' => $request->keluhan,
            'status' => 'menunggu',
        ]);

        // Notify Admin
        $admins = User::where('role', 'admin')->get();
        $notifData = [
            'title' => 'Booking Baru Masuk',
            'message' => 'Ada pesanan servis baru dari ' . Auth::user()->nama,
            'url' => route('admin.servis.index'),
            'icon' => 'bi-wrench',
            'type' => 'danger'
        ];
        foreach ($admins as $admin) {
            $admin->notify(new BookingNotification($notifData));
        }

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

    public function show($id)
    {
        $booking = Booking::with([
            'kendaraan',
            'layanan',
            'servis.detailServis.stok',
            'servis.mekanik'
        ])
            ->where('booking_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.booking.show', compact('booking'));
    }
}


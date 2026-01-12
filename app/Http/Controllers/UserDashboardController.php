<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'semua'); // semua, aktif, selesai
        $sort = $request->get('sort', 'terbaru'); // terbaru, terlama

        $query = Booking::with(['layanan', 'servis', 'kendaraan'])
            ->where('user_id', Auth::id());

        // Filter berdasarkan status
        if ($filter === 'aktif') {
            $query->whereIn('status', ['menunggu', 'disetujui', 'dikerjakan']);
        } elseif ($filter === 'selesai') {
            $query->where('status', 'selesai');
        }

        // Sorting
        if ($sort === 'terlama') {
            $query->orderBy('tanggal_booking', 'asc');
        } else {
            $query->orderBy('tanggal_booking', 'desc');
        }

        $bookings = $query->get();

        // Hitung statistik
        $allBookings = Booking::with(['servis'])->where('user_id', Auth::id())->get();

        $totalServis = $allBookings->filter(function ($b) {
            return $b->servis !== null;
        })->count();

        $servisAktif = $allBookings->whereIn('status', ['disetujui', 'dikerjakan'])->count();

        $totalPengeluaran = 0;
        $sisaTagihan = 0;

        foreach ($allBookings as $booking) {
            if ($booking->servis) {
                $totalBayar = \App\Models\Pembayaran::where('servis_id', $booking->servis->id)
                    ->where('status', 'diterima')
                    ->sum('jumlah');
                $totalPengeluaran += $totalBayar;
                $sisaTagihan += max(0, $booking->servis->estimasi_biaya - $totalBayar);
            }
        }

        return view('dashboard.user', compact(
            'bookings',
            'totalServis',
            'servisAktif',
            'totalPengeluaran',
            'sisaTagihan'
        ));
    }

}

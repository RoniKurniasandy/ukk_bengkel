<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Servis;

class MekanikDashboardController extends Controller
{
    public function index()
    {
        $mekanik_id = Auth::id();
        
        // Stats
        $servis_dikerjakan = Servis::where('status', 'dikerjakan')
            ->where('mekanik_id', $mekanik_id)
            ->count();

        $servis_selesai = Servis::where('status', 'selesai')
            ->where('mekanik_id', $mekanik_id)
            ->count();

        $jadwal_hari_ini = \App\Models\Booking::where('mekanik_id', $mekanik_id)
            ->where('status', 'disetujui')
            ->count();

        // Recent Activity
        $servis_terbaru = Servis::where('mekanik_id', $mekanik_id)
            ->with(['booking.user', 'booking.kendaraan', 'booking.layanan'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.mekanik', compact(
            'servis_dikerjakan', 
            'servis_selesai', 
            'jadwal_hari_ini',
            'servis_terbaru'
        ));
    }
}

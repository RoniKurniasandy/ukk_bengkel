<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Servis;
use App\Models\Transaksi;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.admin', [
            'servis_aktif' => Servis::where('status', 'dikerjakan')->count(), // Status 'proses' diganti 'dikerjakan' sesuai update sebelumnya
            'transaksi_hari_ini' => Transaksi::whereDate('created_at', today())->count(),
            'jumlah_user' => User::where('role', 'pelanggan')->count(),
            'jumlah_mekanik' => User::where('role', 'mekanik')->count(),
            'servis_terbaru' => Servis::with(['booking.user', 'booking.kendaraan', 'booking.layanan'])
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

}

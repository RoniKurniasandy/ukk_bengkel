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
        'servis_aktif' => Servis::where('status', 'proses')->count(),
        'transaksi_hari_ini' => Transaksi::whereDate('created_at', today())->count(),
        'jumlah_user' => User::where('role', 'user')->count(),
        'jumlah_mekanik' => User::where('role', 'mekanik')->count(),
        'servis_terbaru' => Servis::latest()->take(5)->get(),
    ]);
}

}

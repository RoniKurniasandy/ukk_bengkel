<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Servis;
use App\Models\Transaksi;

class AdminController extends Controller
{
    // Fungsi utama untuk menampilkan dashboard admin
    public function index()
    {
        // Hitung jumlah servis yang sedang dalam status 'proses'
        $servis_aktif = Servis::where('status', 'proses')->count();

        // Hitung jumlah transaksi yang dibuat pada hari ini
        $transaksi_hari_ini = Transaksi::whereDate('created_at', now())->count();

        // Hitung jumlah user dengan role 'user' (pelanggan)
        $jumlah_user = User::where('role', 'user')->count();

        // Hitung jumlah user dengan role 'mekanik'
        $jumlah_mekanik = User::where('role', 'mekanik')->count();

        // Ambil 5 data servis terbaru (urut dari yang paling baru)
        $servis_terbaru = Servis::latest()->take(5)->get();

        // Kirim data statistik dan servis terbaru ke view dashboard.admin
        return view('dashboard.admin', compact(
            'servis_aktif',
            'transaksi_hari_ini',
            'jumlah_user',
            'jumlah_mekanik',
            'servis_terbaru'
        ));
    }
}

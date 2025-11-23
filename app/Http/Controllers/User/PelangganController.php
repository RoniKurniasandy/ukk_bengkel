<?php 

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function servisSaya()
    {
        // Logika untuk menampilkan halaman Servis Saya
        return view('user.servis.index');
    }

    public function riwayatServis()
    {
        // Logika untuk menampilkan halaman Riwayat Servis
        return view('user.servis.riwayat');
    }
}


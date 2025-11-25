<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    // Method untuk menampilkan daftar user
    public function index()
    {
        // Ambil semua data user dari database kecuali admin
        // Urutkan berdasarkan role (mekanik, pelanggan) kemudian abjad nama
        $users = User::where('role', '!=', 'admin')
            ->orderByRaw("CASE 
                         WHEN role = 'mekanik' THEN 1
                         WHEN role = 'pelanggan' THEN 2
                         ELSE 3
                     END")
            ->orderBy('nama', 'asc')
            ->get();

        // Kirim data user ke view 'admin.user.index'
        return view('admin.user.index', compact('users'));
    }
}

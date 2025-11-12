<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    // Method untuk menampilkan daftar user
    public function index()
    {
        // Ambil semua data user dari database, urutkan dari yang terbaru
        $users = User::orderBy('created_at', 'desc')->get();

        // Kirim data user ke view 'admin.user.index'
        // (Catatan: harusnya compact('users'), bukan 'user')
        return view('admin.user.index', compact('users'));
    }
}

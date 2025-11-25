<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Servis;

class ServisController extends Controller
{
    public function index()
    {
        // Ambil data servis milik user berdasarkan relasi booking -> user
        $servis = Servis::with('booking.kendaraan')->whereHas('booking', function($q) {
            $q->where('user_id', Auth::id());
        })->latest()->get();

        return view('user.servis.index', compact('servis'));
    }
}

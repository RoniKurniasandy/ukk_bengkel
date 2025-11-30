<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class UserDashboardController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['layanan', 'servis'])->where('user_id', Auth::id())->get();
        return view('dashboard.user', compact('bookings'));
    }

}

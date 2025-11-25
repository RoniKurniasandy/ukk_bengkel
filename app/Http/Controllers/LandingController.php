<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index()
    {
        // Get top 3 most frequently booked services
        $topLayanan = Booking::select('layanan_id', DB::raw('count(*) as total'))
            ->groupBy('layanan_id')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->with('layanan')
            ->get()
            ->pluck('layanan')
            ->filter(); // Remove null values

        // If less than 3, fill with regular services
        if ($topLayanan->count() < 3) {
            $existingIds = $topLayanan->pluck('id')->toArray();
            $additionalLayanan = Layanan::whereNotIn('id', $existingIds)
                ->limit(3 - $topLayanan->count())
                ->get();
            $topLayanan = $topLayanan->merge($additionalLayanan);
        }

        return view('landing', compact('topLayanan'));
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Models\Booking;

Route::get('/debug-payment', function () {
    $bookings = Booking::with('servis')->get();

    $output = "Database: " . DB::connection()->getDatabaseName() . "<br>";
    $output .= "Total Approved Bookings: " . $bookings->count() . "<br>";

    foreach ($bookings as $b) {
        $output .= "Booking ID: " . $b->booking_id . " | Status: " . $b->status . "<br>";
        if ($b->servis) {
            $output .= "  Servis Found (ID: " . $b->servis->id . ")<br>";
            $output .= "  Status Pembayaran: " . $b->servis->status_pembayaran . "<br>";
        } else {
            $output .= "  NO SERVIS RECORD FOUND!<br>";
        }
        $output .= "------------------------<br>";
    }
    return $output;
});

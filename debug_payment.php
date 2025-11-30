<?php

use App\Models\Booking;
use App\Models\Servis;

$bookings = Booking::with('servis')->where('status', 'disetujui')->get();

echo "Total Approved Bookings: " . $bookings->count() . "\n";

foreach ($bookings as $b) {
    echo "Booking ID: " . $b->booking_id . "\n";
    if ($b->servis) {
        echo "  Servis Found (ID: " . $b->servis->id . ")\n";
        echo "  Status Pembayaran: " . $b->servis->status_pembayaran . "\n";
    } else {
        echo "  NO SERVIS RECORD FOUND!\n";
    }
    echo "------------------------\n";
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    protected $table = 'servis';

    protected $fillable = [
        'booking_id',
        'mekanik_id',
        'status'
    ];

    public function booking()
    {
        // FIX foreign key
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }
}

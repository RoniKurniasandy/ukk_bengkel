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
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function mekanik()
    {
        return $this->belongsTo(User::class, 'mekanik_id');
    }
}

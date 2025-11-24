<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    protected $table = 'servis';
    protected $primaryKey = 'servis_id';
    protected $fillable = ['mekanik_id', 'booking_id', 'diagnosa', 'estimasi_biaya', 'estimasi_waktu', 'status', 'tanggal_mulai', 'tanggal_selesai'];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }
    public function mekanik()
    {
        return $this->belongsTo(User::class, 'mekanik_id', 'id');
    }

}

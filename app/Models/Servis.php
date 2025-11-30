<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    protected $table = 'servis';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mekanik_id',
        'booking_id',
        'diagnosa',
        'estimasi_biaya',
        'estimasi_waktu',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'status_pembayaran'
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }
    public function mekanik()
    {
        return $this->belongsTo(User::class, 'mekanik_id', 'id');
    }

    public function detailServis()
    {
        return $this->hasMany(DetailServis::class, 'servis_id');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'servis_id');
    }

    // Calculate total cost from items used
    public function getTotalBiaya()
    {
        return $this->detailServis()->sum('subtotal');
    }

}

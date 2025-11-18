<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'alamat',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi contoh, sesuaikan kalau perlu
    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }


    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }
}

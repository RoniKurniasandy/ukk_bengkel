<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\EmailVerificationOTP;


/**
 * @property int $id
 * @property string $nama
 * @property string $email
 * @property string $password
 * @property string|null $no_hp
 * @property string|null $alamat
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    public function membershipTier()
    {
        return $this->belongsTo(MembershipTier::class, 'membership_tier_id');
    }

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'alamat',
        'role',
        'foto',
        'total_transaksi',
        'membership_tier_id',
        'email_verification_code',
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

    public function sendEmailVerificationNotification()
    {
        $otp = rand(100000, 999999);
        $this->update(['email_verification_code' => $otp]);
        
        $this->notify(new EmailVerificationOTP($otp));
    }
}


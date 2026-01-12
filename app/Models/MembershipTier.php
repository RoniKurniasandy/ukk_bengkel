<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipTier extends Model
{
    protected $fillable = [
        'nama_level',
        'min_transaksi',
        'diskon_jasa',
        'diskon_part',
    ];
}

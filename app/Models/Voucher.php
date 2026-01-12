<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'kode',
        'tipe_diskon',
        'nilai',
        'min_transaksi',
        'kuota',
        'tgl_mulai',
        'tgl_berakhir',
        'is_active',
    ];

    protected $casts = [
        'tgl_mulai' => 'datetime',
        'tgl_berakhir' => 'datetime',
        'is_active' => 'boolean',
    ];
}

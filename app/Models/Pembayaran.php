<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'servis_id',
        'jumlah',
        'subtotal',
        'diskon_member',
        'diskon_voucher',
        'kode_voucher',
        'grand_total',
        'diskon_manual',
        'alasan_diskon_manual',
        'jenis_pembayaran',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status',
        'catatan',
    ];

    public function servis()
    {
        return $this->belongsTo(Servis::class, 'servis_id');
    }
}

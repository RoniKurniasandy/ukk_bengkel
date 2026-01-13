<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'transaksi_id';
    protected $fillable = [
        'user_id',
        'servis_id',
        'stok_id',
        'jenis_transaksi', // pemasukan, pengeluaran
        'sumber', // servis, belanja_stok, penjualan_stok
        'subtotal',
        'diskon_member',
        'diskon_voucher',
        'kode_voucher',
        'diskon_manual',
        'alasan_diskon_manual',
        'grand_total',
        'jumlah',
        'total',
        'keterangan',
        'status'
    ];

    public function servis()
    {
        return $this->belongsTo(Servis::class, 'servis_id');
    }

    public function stok()
    {
        return $this->belongsTo(Stok::class, 'stok_id', 'stok_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

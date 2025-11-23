<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok';
    protected $primaryKey = 'stok_id';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'satuan',
        'harga_beli',
        'harga_jual',
        'jumlah',
        'nomor_seri',
        'keterangan',
    ];
}

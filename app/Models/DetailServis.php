<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailServis extends Model
{
    protected $table = 'detail_servis';

    protected $fillable = [
        'servis_id',
        'stok_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relationships
    public function servis()
    {
        return $this->belongsTo(Servis::class, 'servis_id');
    }

    public function stok()
    {
        return $this->belongsTo(Stok::class, 'stok_id', 'stok_id');
    }

    // Auto-calculate subtotal before saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detailServis) {
            $detailServis->subtotal = $detailServis->jumlah * $detailServis->harga_satuan;
        });
    }
}

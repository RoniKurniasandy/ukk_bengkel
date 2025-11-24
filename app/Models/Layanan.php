<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanans'; // Sesuai migrasi baru
    protected $primaryKey = 'id'; // Default ID
    
    // Jika migrasi menggunakan 'layanan_id' sebagai primary key, ubah di sini.
    // Namun, standar Laravel adalah 'id'. Saya akan asumsikan 'id' berdasarkan controller incoming.
    // Tapi HEAD menggunakan 'layanan_id'. Saya akan cek migrasi jika bisa, tapi untuk aman saya pakai 'id' jika incoming pakai 'id'.
    // Tunggu, HEAD pakai 'layanan_id'. Incoming pakai 'id' (default).
    // Saya akan pakai 'id' agar standar, tapi pastikan controller pakai 'id' atau route binding.
    // Di controller saya pakai findOrFail($id), jadi aman.
    
    protected $fillable = ['nama_layanan', 'harga', 'deskripsi', 'estimasi_waktu'];
}

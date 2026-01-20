<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetodePembayaran;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'tipe' => 'tunai',
                'nama_bank' => 'Tunai / QRIS Kasir',
                'nomor_rekening' => null,
                'atas_nama' => null,
                'deskripsi' => 'Pembayaran langsung di meja kasir menggunakan uang tunai atau scan QRIS.',
                'is_active' => true,
            ],
            [
                'tipe' => 'transfer',
                'nama_bank' => 'BCA',
                'nomor_rekening' => '1234567890',
                'atas_nama' => 'KINGS BENGKEL MOBIL',
                'deskripsi' => 'Transfer antar bank BCA.',
                'is_active' => true,
            ],
            [
                'tipe' => 'transfer',
                'nama_bank' => 'Mandiri',
                'nomor_rekening' => '0987654321',
                'atas_nama' => 'KINGS BENGKEL MOBIL',
                'deskripsi' => 'Transfer antar bank Mandiri.',
                'is_active' => true,
            ],
            [
                'tipe' => 'transfer',
                'nama_bank' => 'DANA (eWallet)',
                'nomor_rekening' => '08123456789',
                'atas_nama' => 'KINGS BENGKEL MOBIL',
                'deskripsi' => 'Pembayaran via e-wallet DANA.',
                'is_active' => true,
            ],
        ];

        foreach ($methods as $method) {
            MetodePembayaran::create($method);
        }
    }
}

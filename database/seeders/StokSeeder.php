<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stok;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spareparts = [
            [
                'kode_barang' => 'SP-001',
                'nama_barang' => 'Oli Mesin Shell Helix 10W-40',
                'nomor_seri' => 'OMSH-0001',
                'satuan' => 'liter',
                'jumlah' => 20,
                'harga_beli' => 85000,
                'harga_jual' => 110000,
                'keterangan' => 'Oli mesin bensin kualitas premium',
            ],
            [
                'kode_barang' => 'SP-002',
                'nama_barang' => 'Filter Oli Avanza/Xenia',
                'nomor_seri' => 'FOAX-0001',
                'satuan' => 'pcs',
                'jumlah' => 15,
                'harga_beli' => 35000,
                'harga_jual' => 50000,
                'keterangan' => 'Filter oli original Astra',
            ],
            [
                'kode_barang' => 'SP-003',
                'nama_barang' => 'Kampas Rem Depan Brio',
                'nomor_seri' => 'KRDB-0001',
                'satuan' => 'set',
                'jumlah' => 10,
                'harga_beli' => 180000,
                'harga_jual' => 250000,
                'keterangan' => 'Kampas rem depan berkualitas',
            ],
            [
                'kode_barang' => 'SP-004',
                'nama_barang' => 'Aki GS Astra Maintenance Free',
                'nomor_seri' => 'AGAMF-0001',
                'satuan' => 'pcs',
                'jumlah' => 5,
                'harga_beli' => 750000,
                'harga_jual' => 950000,
                'keterangan' => 'Aki kering bebas perawatan',
            ],
            [
                'kode_barang' => 'SP-005',
                'nama_barang' => 'Busi Denso Iridium',
                'nomor_seri' => 'BDI-0001',
                'satuan' => 'pcs',
                'jumlah' => 50,
                'harga_beli' => 95000,
                'harga_jual' => 125000,
                'keterangan' => 'Busi performa tinggi',
            ],
            [
                'kode_barang' => 'SP-006',
                'nama_barang' => 'Oli Transmisi Matic T-IV',
                'nomor_seri' => 'OTM-0001',
                'satuan' => 'liter',
                'jumlah' => 12,
                'harga_beli' => 120000,
                'harga_jual' => 155000,
                'keterangan' => 'Oli transmisi khusus matic Toyota',
            ],
            [
                'kode_barang' => 'SP-007',
                'nama_barang' => 'Filter Udara Ferrox Honda Jazz',
                'nomor_seri' => 'FUF-0001',
                'satuan' => 'pcs',
                'jumlah' => 4,
                'harga_beli' => 450000,
                'harga_jual' => 550000,
                'keterangan' => 'Filter udara racing stainless steel',
            ],
            [
                'kode_barang' => 'SP-008',
                'nama_barang' => 'Coolant Prestone Ready To Use',
                'nomor_seri' => 'CP-0001',
                'satuan' => 'botol',
                'jumlah' => 10,
                'harga_beli' => 65000,
                'harga_jual' => 85000,
                'keterangan' => 'Air radiator siap pakai',
            ],
            [
                'kode_barang' => 'SP-009',
                'nama_barang' => 'Wiper Blade Bosch Advantage 20"',
                'nomor_seri' => 'WBA-0001',
                'satuan' => 'pcs',
                'jumlah' => 8,
                'harga_beli' => 45000,
                'harga_jual' => 65000,
                'keterangan' => 'Wiper kaca depan berkualitas',
            ],
            [
                'kode_barang' => 'SP-010',
                'nama_barang' => 'Fan Belt Avanza Dual VVT-i',
                'nomor_seri' => 'FB-0001',
                'satuan' => 'pcs',
                'jumlah' => 6,
                'harga_beli' => 120000,
                'harga_jual' => 165000,
                'keterangan' => 'Tali kipas original',
            ],
            [
                'kode_barang' => 'SP-011',
                'nama_barang' => 'Minyak Rem Prestone DOT 4',
                'nomor_seri' => 'MR-0001',
                'satuan' => 'botol',
                'jumlah' => 15,
                'harga_beli' => 30000,
                'harga_jual' => 45000,
                'keterangan' => 'Minyak rem performa tinggi',
            ],
            [
                'kode_barang' => 'SP-012',
                'nama_barang' => 'Shockbreaker Kayaba Excel-G Depan',
                'nomor_seri' => 'SB-0001',
                'satuan' => 'set',
                'jumlah' => 3,
                'harga_beli' => 1200000,
                'harga_jual' => 1500000,
                'keterangan' => 'Shockbreaker gas untuk kenyamanan',
            ],
        ];

        foreach ($spareparts as $part) {
            Stok::updateOrCreate(['kode_barang' => $part['kode_barang']], $part);
        }
    }
}

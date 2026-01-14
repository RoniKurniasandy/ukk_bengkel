<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanans = [
            [
                'nama_layanan' => 'Ganti Oli',
                'harga' => 100000,
                'deskripsi' => 'Penggantian oli mesin dengan oli standar berkualitas.',
                'estimasi_waktu' => '30 Menit',
            ],
            [
                'nama_layanan' => 'Tune Up',
                'harga' => 250000,
                'deskripsi' => 'Mengembalikan performa mesin ke kondisi optimal.',
                'estimasi_waktu' => '2 Jam',
            ],
            [
                'nama_layanan' => 'Spooring & Balancing',
                'harga' => 200000,
                'deskripsi' => 'Penyetelan sudut roda dan penyeimbangan putaran roda.',
                'estimasi_waktu' => '1.5 Jam',
            ],
        ];

        foreach ($layanans as $layanan) {
            \App\Models\Layanan::updateOrCreate(
                ['nama_layanan' => $layanan['nama_layanan']], // Cek berdasarkan nama
                $layanan
            );
        }
    }
}

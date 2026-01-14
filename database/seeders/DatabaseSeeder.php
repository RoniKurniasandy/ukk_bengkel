<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan semua seeder di sini
     */
    public function run(): void
    {
        // Panggil UserSeeder untuk memasukkan data user
        $this->call([
            UserSeeder::class,
            LayananSeeder::class,
            // Tambahkan seeder lain jika ada, contoh:
            // BookingSeeder::class,
        ]);
    }
}

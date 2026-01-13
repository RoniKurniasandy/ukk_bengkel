<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama dengan aman
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\MembershipTier::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // One and Only Member level (Syarat 5 Juta, Diskon 10%)
        \App\Models\MembershipTier::create([
            'nama_level' => 'Member Loyal',
            'min_transaksi' => 5000000,
            'diskon_jasa' => 10,
            'diskon_part' => 10, // Menghasilkan 10% dari total (subtotal)
        ]);
    }
}

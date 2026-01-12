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
        // Bronze: Default (0% discount)
        \App\Models\MembershipTier::create([
            'nama_level' => 'Bronze',
            'min_transaksi' => 0,
            'diskon_jasa' => 0,
            'diskon_part' => 0,
        ]);

        // Silver: Belanja > 1 Juta (5% Jasa)
        \App\Models\MembershipTier::create([
            'nama_level' => 'Silver',
            'min_transaksi' => 1000000,
            'diskon_jasa' => 5,
            'diskon_part' => 0,
        ]);

        // Gold: Belanja > 5 Juta (10% Jasa + 2% Part)
        \App\Models\MembershipTier::create([
            'nama_level' => 'Gold',
            'min_transaksi' => 5000000,
            'diskon_jasa' => 10,
            'diskon_part' => 2,
        ]);
        
        // Platinum: Belanja > 10 Juta (15% Jasa + 5% Part)
         \App\Models\MembershipTier::create([
            'nama_level' => 'Platinum',
            'min_transaksi' => 10000000,
            'diskon_jasa' => 15,
            'diskon_part' => 5,
        ]);
    }
}

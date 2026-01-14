<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // --- Roles ---
        DB::table('roles')->insert([
            ['name' => 'admin', 'description' => 'Akses penuh ke sistem'], 
            ['name' => 'mekanik', 'description' => 'Mengelola servis kendaraan'],
            ['name' => 'pelanggan', 'description' => 'Melakukan booking dan melihat status servis'],
        ]);

        // --- Users ---
        DB::table('users')->insert([
            [
                'nama' => 'Admin Bengkel',
                'email' => 'admin@bengkel.com',
                'password' => Hash::make('admin123'),
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Raya Utama No. 1',
                'role' => 'admin', // Explicitly set role
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Joko Mechanic',
                'email' => 'joko@bengkel.com',
                'password' => Hash::make('joko123'),
                'no_hp' => '08155667788',
                'alamat' => 'Jl. Kenanga No. 10',
                'role' => 'mekanik', // Explicitly set role
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Andi Mechanic',
                'email' => 'andi@bengkel.com',
                'password' => Hash::make('andi123'),
                'no_hp' => '08166778899',
                'alamat' => 'Jl. Flamboyan No. 12',
                'role' => 'mekanik', // Explicitly set role
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('budi123'),
                'no_hp' => '08122334455',
                'alamat' => 'Jl. Melati No. 5',
                'role' => 'pelanggan', // Explicitly set role
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Aminah',
                'email' => 'siti@gmail.com',
                'password' => Hash::make('siti123'),
                'no_hp' => '08133445566',
                'alamat' => 'Jl. Mawar No. 8',
                'role' => 'pelanggan', // Explicitly set role
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // --- User Roles Mapping ---
        DB::table('user_roles')->insert([
            ['user_id' => 1, 'role_id' => 1], // Admin Bengkel -> Admin
            ['user_id' => 2, 'role_id' => 2], // Joko -> Mekanik
            ['user_id' => 3, 'role_id' => 2], // Andi -> Mekanik
            ['user_id' => 4, 'role_id' => 3], // Budi -> Pelanggan
            ['user_id' => 5, 'role_id' => 3], // Siti -> Pelanggan
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@kost.com',
            'password' => Hash::make('password_baru'),
            'no_hp' => '081234567890',
            'role' => 'admin',
        ]);

        // Pemilik Contoh
        User::create([
            'name' => 'Dwi Irianto',
            'email' => 'dwi@kost.com',
            'password' => Hash::make('Irianto60'),
            'no_hp' => '08127500394',
            'role' => 'pemilik',
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@kost.com',
            'password' => Hash::make('pwuser23'),
            'no_hp' => '081234567892',
            'role' => 'pemilik',
        ]);
    }
}
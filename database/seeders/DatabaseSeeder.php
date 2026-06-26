<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    $this->call([
        UserSeeder::class,
        KostSeeder::class,         // Bapak dulu
        KostProfileSeeder::class,  // Profil bapak
        FasilitasSeeder::class,    // Baru anaknya (fasilitas)
        KamarSeeder::class,        // Baru anaknya (kamar)
    ]);
}
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamar;
use App\Models\Kost;

class KamarSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil semua kost yang ada
        $kosts = Kost::all();

        if ($kosts->isEmpty()) {
            $this->command->warn("Data Kost kosong! Kamar tidak bisa dibuat.");
            return;
        }

        // 2. Loop setiap kost dan buatkan beberapa kamar untuk masing-masing kost
        foreach ($kosts as $kost) {
            
            // Membuat kamar pertama untuk kost ini
            Kamar::create([
                'kost_id'     => $kost->id, // Mengambil ID asli dari database
                'nomor_kamar' => 'A1',
                'tipe_kamar'  => 'standar',
                'harga'       => 1500000,
                'fasilitas'   => 'AC, Kamar Mandi Dalam, Lemari',
                'status'      => 'tersedia'
            ]);

            // Membuat kamar kedua untuk kost ini
            Kamar::create([
                'kost_id'     => $kost->id,
                'nomor_kamar' => 'B1',
                'tipe_kamar'  => 'standar',
                'harga'       => 1200000,
                'fasilitas'   => 'Kipas Angin, Kamar Mandi Luar, Meja Belajar',
                'status'      => 'tersedia'
            ]);
        }
        
        $this->command->info("Berhasil membuat kamar untuk semua kost.");
    }
}
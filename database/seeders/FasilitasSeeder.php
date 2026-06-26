<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fasilitas;
use App\Models\Kost; // Pastikan Model Kost juga di-import

class FasilitasSeeder extends Seeder 
{
    public function run(): void
    {
        // 1. Ambil semua data kost
        $kosts = Kost::all();

        // 2. Cek apakah data kost ada
        if ($kosts->isEmpty()) {
            $this->command->warn("Tidak ada data Kost, Fasilitas tidak bisa dibuat.");
            return;
        }

        // 3. Looping setiap kost untuk diberi fasilitas
        foreach ($kosts as $kost) {
            
            Fasilitas::create([
                'kost_id' => $kost->id,
                'nama_fasilitas' => 'Parkir Motor',
                'kategori' => 'umum',
            ]);

            Fasilitas::create([
                'kost_id' => $kost->id,
                'nama_fasilitas' => 'WiFi',
                'kategori' => 'umum',
            ]);
            
        } // Penutup foreach
    } // Penutup function run
} // Penutup class
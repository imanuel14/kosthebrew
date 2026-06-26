<?php

namespace Database\Seeders;

use App\Models\Kost;
use App\Models\KostProfile;
use Illuminate\Database\Seeder;

class KostProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua kost yang sudah dibuat
        $kosts = Kost::all();

        foreach ($kosts as $kost) {
            KostProfile::create([
                'kost_id' => $kost->id, // Gunakan ID yang benar-benar ada
                'rules' => "1. Dilarang merokok di kamar\n2. Tamu dilarang menginap\n3. Dilarang membawa hewan peliharaan\n4. Jam malam pukul 22:00",
                'check_in_time' => '14:00:00',
                'check_out_time' => '12:00:00',
                'minimum_stay' => 3,
                'electricity_included' => rand(0, 1),
                'water_included' => true,
                'wifi_included' => true,
                'parking_available' => rand(0, 1),
                'kitchen_available' => rand(0, 1),
                'laundry_available' => rand(0, 1),
                'cleaning_service' => rand(0, 1),
                'curfew_time' => rand(0, 1) ? '22:00:00' : null,
                'pet_allowed' => false,
                'visitor_allowed' => rand(0, 1),
                'additional_info' => 'Kost ini dikelola dengan profesional dan terawat dengan baik.'
            ]);
        }
    }
}
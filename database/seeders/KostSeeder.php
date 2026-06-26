<?php

namespace Database\Seeders;

use App\Models\Kost;
use App\Models\KostImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KostSeeder extends Seeder
{
    public function run(): void
    {

        $kosts = [
            [
                'name' => 'Kost Putri Melati AC',
                'description' => 'Kost nyaman dengan AC dingin dan fasilitas lengkap.',
                'address' => 'Jl. Melati No. 123',
                'city' => 'Jakarta Selatan',
                'district' => 'Kebayoran Baru',
                'price_monthly' => 1500000,
                'price_yearly' => 16000000,
                'room_total' => 10,
                'room_available' => 3,
                'category' => 'ac',
                'is_featured' => true,
                'contact_phone' => '081234567890',
                'contact_whatsapp' => '081234567890'
            ],
            [
                'name' => 'Kost Mawar Kipas',
                'description' => 'Kost ekonomis dengan sirkulasi udara bagus.',
                'address' => 'Jl. Mawar No. 45',
                'city' => 'Jakarta Selatan',
                'district' => 'Pancoran',
                'price_monthly' => 800000,
                'price_yearly' => 9000000,
                'room_total' => 8,
                'room_available' => 2,
                'category' => 'kipas',
                'is_featured' => false,
                'contact_phone' => '081234567891',
                'contact_whatsapp' => '081234567891'
            ],
            [
                'name' => 'Homestay Hebrew',
                'description' => 'Rumah sewa harian/bulanan untuk keluarga.',
                'address' => 'Jl. Anggrek No. 78',
                'city' => 'Jakarta Barat',
                'district' => 'Kebon Jeruk',
                'price_monthly' => 5000000,
                'price_yearly' => 50000000,
                'room_total' => 1,
                'room_available' => 1,
                'category' => 'homestay',
                'is_featured' => true,
                'contact_phone' => '081234567892',
                'contact_whatsapp' => '081234567892'
            ],
        ];

        foreach ($kosts as $index => $data) {
        \App\Models\Kost::create([
            'name' => $data['name'],
            'description' => 'Fasilitas lengkap dan strategis.',
            'address' => 'Jl. Contoh No. ' . $index,
            'city' => $data['city'],
            'district' => 'Kecamatan ' . $index,
            'price_monthly' => $data['price_monthly'],
            'category' => $data['category'],
            'is_featured' => $data['is_featured'],
            'contact_phone' => '0812345678',
            'slug' => \Illuminate\Support\Str::slug($data['name']) . '-' . rand(100,999),
            'owner_id' => 1, // Pastikan ID ini ada di tabel users
            'is_active' => true,
            'room_total' => 10,
            'room_available' => 5
        ]);
        }
    }
}

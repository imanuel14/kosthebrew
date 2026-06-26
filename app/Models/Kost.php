<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kost extends Model
{
    use HasFactory;

    protected $table = 'kost';

    // Sesuaikan fillable dengan kolom asli di database Anda
    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'district',
        'price_monthly',
        'price_yearly',
        'image',
        'room_total',
        'room_available',
        'category',
        'is_featured',
        'contact_phone'=> 'required|string',
        'contact_whatsapp'=> 'required|string',
        'slug',
        'bathroom_facilities',
        'general_facilities',
        'parking_facilities',
        'room_rules',
        'special_rules',
        'owner_id',
        'is_active',
        'nearby_places',
        'price_monthly',
        'rental_period',
        'is_occupied'
    ];

    protected $casts = [
        'bathroom_facilities' => 'array',
        'general_facilities' => 'array',
        'parking_facilities' => 'array',
        'room_rules' => 'array',
        'special_rules' => 'array',
        'nearby_places' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($kost) {
            // Gunakan $kost->name sesuai kolom database
            if ($kost->isDirty('name') || !$kost->slug) {
                $kost->slug = \Illuminate\Support\Str::slug($kost->name) . '-' . rand(100, 999);
            }
        });
    }

    // Relasi ke tabel profil (one-to-one)
    public function profile()
    {
        return $this->hasOne(KostProfile::class);
    }

    // Relasi ke banyak gambar (one-to-many)
    public function images()
    {
        return $this->hasMany(KostImage::class, 'kost_id');
    }

    // Relasi ke fasilitas
    public function facilities()
    {
        return $this->hasMany(Fasilitas::class);
    }

    // Relasi ke kamar
    public function kamar()
    {
        return $this->hasMany(Kamar::class, 'kost_id');
    }

    // Relasi ke penyewa
    public function penyewa()
    {
        return $this->hasMany(Penyewa::class);
    }

    // Relasi ke pemilik (user)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}

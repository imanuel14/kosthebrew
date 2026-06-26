<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    // Tambahkan baris ini untuk memaksa Laravel menggunakan tabel 'kamar' bukan 'kamars'
    protected $table = 'kamar';

    protected $fillable = [
        'kost_id', 
        'nomor_kamar', 
        'tipe_kamar', 
        'harga', 
        'fasilitas', 
        'status'
    ];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }

    public function penyewa()
    {
        return $this->hasOne(Penyewa::class);
    }
}
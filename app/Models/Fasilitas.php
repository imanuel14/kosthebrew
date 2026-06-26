<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'kost_id',
        'nama_fasilitas',
        'icon',
        'kategori' // umum/kamar
    ];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }
}
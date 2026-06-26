<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    use HasFactory;

    protected $table = 'penyewa';

    protected $fillable = [
        'user_id',
        'kost_id',
        'kamar_id',
        'tanggal_masuk',
        'tanggal_keluar',
        'status', // aktif, nonaktif
        'jaminan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
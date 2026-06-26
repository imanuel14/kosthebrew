<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    // TAMBAHKAN BARIS INI
    // Sesuaikan dengan nama tabel yang ada di phpMyAdmin Anda (biasanya 'transaksi')
    protected $table = 'transaksi';

    protected $fillable = [
        'penyewa_id',
        'kamar_id',
        'bulan',
        'tahun',
        'jumlah_bayar',
        'tanggal_bayar',
        'metode_pembayaran',
        'status', // lunas, pending, gagal
        'keterangan'
    ];

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}
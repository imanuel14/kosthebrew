<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KostImage extends Model
{
    // Jika nama tabel Anda di database bukan 'kost_images', tentukan di sini:
    // protected $table = 'nama_tabel_foto_anda';

    protected $fillable = [
        'kost_id',
        'image_path',
    ];

    /**
     * Relasi balik ke Kost
     */
    public function kost(): BelongsTo
    {
        return $this->belongsTo(Kost::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model (opsional jika nama tabelnya 'messages').
     * Laravel mendeteksi bentuk jamak secara otomatis, namun menulisnya secara eksplisit
     * adalah praktik yang bagus.
     */
    protected $table = 'messages';

    /**
     * Kolom-kolom yang diizinkan untuk diisi secara massal (Mass Assignment).
     * Ini harus sinkron dengan kolom yang ada di file migration Anda.
     */
    protected $fillable = [
        'name',
        'whatsapp', 
        'email',
        'subject',
        'message',
        'is_read',
    ];

    /**
     * Atribut atau kolom yang otomatis dikonversi ke tipe data tertentu.
     * Kita konversi 'is_read' menjadi boolean agar di Controller 
     * bisa dibaca sebagai true/false (bukan 1 atau 0 saja).
     */
    protected $casts = [
        'is_read' => 'boolean',
    ];
}
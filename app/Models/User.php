<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


// use Laravel\Sanctum\HasApiTokens; // HAPUS atau comment

class User extends Authenticatable
{
    use HasFactory, Notifiable; // HAPUS HasApiTokens

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'avatar',
        'ktp_path',
        'address',
        'no_hp',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean'
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isOwner()
    {
        return $this->role === 'owner';
    }
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }
    public function penyewa()
    {
        // Jika satu user hanya menjadi satu penyewa
        return $this->hasOne(Penyewa::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'penyewa_id');
    }

}


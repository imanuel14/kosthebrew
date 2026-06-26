<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'penyewa_id',
        'kamar_id',
        'order_id',
        'amount',
        'metode_pembayaran',
        'provider',
        'status',
        'snap_token',
        'transaction_id',
        'metadata',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'metadata' => 'array',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_EXPIRED = 'expired';

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }

    // Generate unique order ID
    public static function generateOrderId()
    {
        return 'ORD-' . strtoupper(uniqid()) . '-' . date('Ymd');
    }

    // Check if payment is successful
    public function isSuccessful()
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    // Scope for pending payments
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    // Scope for successful payments
    public function scopeSuccessful($query)
    {
        return $query->where('status', self::STATUS_SUCCESS);
    }
}
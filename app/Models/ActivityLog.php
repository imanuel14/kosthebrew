<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'activity',
        'description',
        'ip_address',
        'user_agent'
    ];

    public static function tap($activity, $description = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'activity' => $activity,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KostProfile extends Model
{
    use HasFactory;

    protected $fillable = [
    'kost_id', 
    'rules', 
    'check_in_time', 
    'check_out_time', 
    'minimum_stay',
    'electricity_included', 
    'water_included', 
    'wifi_included', 
    'parking_available',
    'kitchen_available', 
    'laundry_available', 
    'cleaning_service', 
    'curfew_time',
    'pet_allowed', 
    'visitor_allowed', 
    'additional_info'
];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }
}
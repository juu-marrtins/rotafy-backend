<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ride extends Model
{
    protected $fillable = [
        'driver_profile_id',
        'origin_city',
        'destination_city',
        'origin_lat_lng',
        'destination_lat_lng',
        'distance_km',
        'departure_at',
        'avaliable_seats',
        'status',
        'fuel_price_used',
        'notes',
    ];

    public function casts(): array {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'departure_at' => 'datetime',
        ];
    }

    public function driverProfile(): BelongsTo {
        return $this->belongsTo(DriverProfile::class);
    }
}
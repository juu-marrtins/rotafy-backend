<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ride extends Model
{
    protected $fillable = [
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
        'driver_id',
        'total_cost',
    ];

    public function casts(): array {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'departure_at' => 'datetime',
        ];
    }

    public function driver(): BelongsTo {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function rideRequests(): HasMany {
        return $this->hasMany(RideRequest::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RideRequest extends Model
{
    protected $fillable = [
        'passenger_id',
        'ride_id',
        'status',
        'calculated_price',
        'plataform_fee',
        'pickup_address',
        'message',
        'responded_at',
    ];

    public function casts(): array {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'responded_at' => 'datetime',
        ];
    }

    public function passenger(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function ride(): BelongsTo {
        return $this->belongsTo(Ride::class);
    }

    public function ratings(): HasMany {
        return $this->hasMany(Rating::class);
    }

    public function payments(): HasOne {
        return $this->hasOne(Payment::class);
    }
}
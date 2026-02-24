<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $fillable = [
        'ride_request_id',
        'rater_id',
        'rated_id',
        'rating',
        'comment',
        'type',
    ];

    public function casts(): array {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function rideRequest(): BelongsTo {
        return $this->belongsTo(RideRequest::class);
    }

    public function rater(): BelongsTo {
        return $this->belongsTo(User::class, 'rater_id');
    }

    public function rated(): BelongsTo {
        return $this->belongsTo(User::class, 'rated_id');
    }
}
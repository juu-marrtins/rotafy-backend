<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'ride_request_id',
        'payer_id',
        'receiver_id',
        'gross_amount',
        'plataform_fee',
        'net_amount',
        'method',
        'status',
        'paid_at',
    ];

    public function casts(): array {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function rideRequest(): BelongsTo {
        return $this->belongsTo(RideRequest::class);
    }

    public function payer(): BelongsTo {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function receiver(): BelongsTo {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
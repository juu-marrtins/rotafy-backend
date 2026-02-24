<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DriverProfile extends Model
{
    protected $fillable = [
        'user_id',
        'avaliable_seats',
        'status',
    ];

    public function casts(): array {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function vehicle(): HasOne {
        return $this->hasOne(Vehicles::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasOne {
        return $this->hasOne(DriverDocuments::class);
    }
}
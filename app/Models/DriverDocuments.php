<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverDocuments extends Model
{
    protected $fillable = [
        'driver_profile_id',
        'file_path',
        'status',
        'reject_reason',
        'reviwed_at',
    ];

    public function casts(): array {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'reviwed_at' => 'datetime',
        ];
    }

    public function driverProfile(): BelongsTo {
        return $this->belongsTo(DriverProfile::class);
    }
}
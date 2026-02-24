<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicles extends Model
{
    protected $fillable = [
        'driver_profile_id',
        'plate',
        'brand',
        'model',
        'version',
        'year',
        'fuel_type',
        'consumption_city',
        'consumption_road',
        'consumption_mixed',
        'fetched_from_api',
    ];

    public function casts(): array {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'year' => 'date'
        ];
    }

    public function driverProfile(): BelongsTo {
        return $this->belongsTo(DriverProfile::class);
    }
}
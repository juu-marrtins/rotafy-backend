<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicles extends Model
{
    protected $fillable = [
        'driver_id',
        'plate',
        'model',
        'version',
        'year',
        'fetched_from_api',
        'crlv_url',
        'color',
        'situation',
        'fuel_type'
    ];

    public function casts(): array {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function owner(): BelongsTo {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverDocuments extends Model
{
    protected $fillable = [
        'driver_id',
        'cnh_digit',
        'cnh_verse_url',
        'cnh_front_url',
        'handle_cnh_url',
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

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
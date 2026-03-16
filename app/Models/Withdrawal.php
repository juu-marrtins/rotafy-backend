<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    protected $fillable = [
        'wallet_id',
        'amount',
        'pix_key_type',
        'pix_key',
        'status',
        'external_tx_id'
    ];

    public function casts(): array {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'requested_at' => 'datetime',
        ];
    }

    public function wallet(): BelongsTo {
        return $this->belongsTo(Wallet::class);
    }
}
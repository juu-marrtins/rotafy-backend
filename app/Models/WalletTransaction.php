<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $table = 'wallet_transactions';
    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'external_tx_id',
        'reference_id',
        'status',
    ];

    public function casts(): array {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function wallet(): BelongsTo {
        return $this->belongsTo(Wallet::class);
    }
}
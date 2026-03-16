<?php

namespace App\Http\Resources\Wallet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PixTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        $amount = data_get($this, 'data.amount', 0) / 100;
        return [
            'amount' => number_format($amount, 2, '.', ''),
            'pix_key' => data_get($this, 'data.brCode'),
            'qr_code_url' => data_get($this, 'data.brCodeBase64'),
        ];
    }
}

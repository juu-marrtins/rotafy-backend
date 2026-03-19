<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => data_get($this, 'id'),
            'name' => data_get($this, 'name'),
            'email' => data_get($this, 'email'),
            'abacate_id' => data_get($this, 'abacate_id'),
            'photo_url' => data_get($this, 'photo_url'),
            'phone' => data_get($this, 'phone'),
            'user_type' => data_get($this, 'user_type'),
            'user_title' => data_get($this, 'user_title'),
        ];
    }
}
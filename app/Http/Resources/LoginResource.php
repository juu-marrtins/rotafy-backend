<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->createToken('auth_token')->plainTextToken,
            'user' => [
                'name' => $this->name,
                'email' => $this->email,
                'university_id' => $this->university_id,
                'photo_url' => $this->photo_url,
                'user_title' => $this->user_title,
                'user_type' => $this->user_type,
            ]
        ];
    }
}

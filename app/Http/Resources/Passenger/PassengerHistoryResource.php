<?php

namespace App\Http\Resources\Passenger;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassengerHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'driver' => [
                'id' => data_get($this, 'driver_id'),
                'name' => data_get($this, 'driver.name'),
                'photo_url' => data_get($this, 'driver.photo_url'),
                'rating' => data_get($this, 'driver_rating'),
            ],
            'vehicle' => [
                'id' => data_get($this, 'vehicle_id'),
                'plate' => data_get($this, 'plate'),
                'model' => data_get($this, 'model'),
                'year' => data_get($this, 'year'),
                'color' => data_get($this, 'color'),
            ],
            'ride' => [
                'id' => data_get($this, 'ride_id'),
                'destination_city' => data_get($this, 'destination_city'),
                'origin_city' => data_get($this, 'origin_city'),
                'departure_at' => data_get($this, 'departure_at'),
                'available_seats' => data_get($this, 'available_seats'),
                'status' => data_get($this, 'status'),
            ]
        ];
    }
}

<?php

namespace App\Http\Resources\Passenger;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassengerHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'driver' => [
                'id' => data_get($this, 'ride.driver.id'),
                'name' => data_get($this, 'ride.driver.name'),
            ],
            'ride' => [
                'id' => data_get($this, 'ride.id'),
                'destination_city' => data_get($this, 'ride.destination_city'),
                'origin_city' => data_get($this, 'ride.origin_city'),
                'departure_at' => data_get($this, 'ride.departure_at'),
                'status' => data_get($this, 'ride.status'),
            ],
            'request' => [
                'calculated_price' => $this->calculated_price,
            ],
        ];
    }
}
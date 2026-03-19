<?php

namespace App\Repositories;

use App\Models\Ride;
use App\Models\RideRequest;

class RideRepository
{
    public function getRides() {
        return Ride::select('id', 'origin_city', 'destination_city', 'calculated_price', 'departure_at', 'avaliable_seats', 'driver_id', 'status')
            ->where('status', '!=', 'cancelled')
            ->orWhere('status', '!=', 'completed')
            ->orderBy('created_at', 'desc');
    }

    public function nextRide(int $passengerId) {
        return RideRequest::select(
            'ride_requests.id',
            'ride_requests.passenger_id', 
            'ride_requests.driver_id',
            'ride_requests.ride_id',
            'ride_requests.status',
            'ride_requests.calculated_price'
        )
        ->where('ride_requests.passenger_id', $passengerId)
        ->join('rides', 'rides.id', '=', 'ride_requests.ride_id')
        ->with([
            'ride:id,destination_city,origin_city,departure_at,available_seats',
            'driver:id,name,photo_url',
            'rating:id,ride_request_id,rating,comment'
        ])
        ->orderBy('rides.departure_at', 'asc')
        ->first();
    }


    public function getPassengerHistory(int $passengerId) {
        return RideRequest::with([
                'ride:id,destination_city,origin_city,departure_at,available_seats',
                'driver:id,name,photo_url',
                'driver.vehicle:id,driver_id,plate,model,year,color'
            ])
            ->withAvg('driver.ratings as driver_rating', 'rating')
            ->where('passenger_id', $passengerId)
            ->orderBy(
                Ride::select('departure_at')
                    ->whereColumn('rides.id', 'ride_requests.ride_id'),
                'asc'
            )
            ->first();
    }
}

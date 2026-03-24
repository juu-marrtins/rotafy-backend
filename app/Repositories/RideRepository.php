<?php

namespace App\Repositories;

use App\Models\Ride;
use App\Models\RideRequest;

class RideRepository
{
    public function getRides(int $userId) {
        return Ride::select(
                'rides.id',
                'rides.origin_city',
                'rides.destination_city',
                'rides.departure_at',
                'rides.avaliable_seats',
                'rides.driver_id',
                'rides.total_cost',
                'rides.status'
            )
            ->selectSub(function ($query) {
                $query->from('ratings')
                    ->selectRaw('AVG(rating)')
                    ->whereColumn('ratings.rated_id', 'rides.driver_id');
            }, 'driver_rating_avg')
            ->selectSub(function ($query) {
                $query->from('ride_requests')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('ride_requests.ride_id', 'rides.id')
                    ->where('ride_requests.status', 'accepted');
            }, 'confirmed_passengers_count')
            ->whereNotIn('rides.status', ['cancelled', 'completed'])
            ->where('rides.driver_id', '!=', $userId)
            ->whereRaw('(
                SELECT COUNT(*) FROM ride_requests 
                WHERE ride_requests.ride_id = rides.id 
                AND ride_requests.status = ?
            ) < rides.avaliable_seats', ['accepted']
            )
            ->with([
                'driver:id,name,photo_url',
            ])
            ->orderBy('rides.created_at', 'desc');
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

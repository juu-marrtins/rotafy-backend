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
            'ride_requests.ride_id',
            'ride_requests.status',
            'ride_requests.calculated_price'
        )
        ->where('ride_requests.passenger_id', $passengerId)
        ->join('rides', 'rides.id', '=', 'ride_requests.ride_id')
        ->with([
            'ride:id,destination_city,origin_city,departure_at,avaliable_seats,driver_id',
            'ride.driver:id,name,photo_url', 
            'ratings:id,ride_request_id,rating,comment'
        ])
        ->orderBy('rides.departure_at', 'asc')
        ->first();
    }

    public function getPassengerHistory(int $passengerId) {
        return RideRequest::select(
                'id',
                'calculated_price',
                'passenger_id',
                'ride_id',
                'status'
            )
            ->with([
                'ride:id,destination_city,origin_city,departure_at,status,driver_id',
                'ride.driver:id,name',
            ])
            ->where('passenger_id', $passengerId)
            ->where('status', 'accepted')
            ->whereHas('ride', function ($query) {
                $query->where('status', 'completed')
                    ->orWhere('status', 'cancelled');
            })
            ->orderBy(
                Ride::select('departure_at')
                    ->whereColumn('rides.id', 'ride_requests.ride_id'),
                'asc'
            );
    }
    public function getRideDetails(int $id) {
        return Ride::select(
                'rides.id',
                'rides.origin_city',
                'rides.destination_city',
                'rides.origin_lat_lng',
                'rides.destination_lat_lng',
                'rides.departure_at',
                'rides.avaliable_seats',
                'rides.driver_id',
                'rides.total_cost',
                'rides.status'
            )
            ->where('id', $id)
            ->with([
                'driver:id,name,photo_url',
                'driver.vehicle:id,driver_id,plate,model,year,color',
                'rideRequests:id,passenger_id,ride_id,status,calculated_price',
                'rideRequests.passenger:id,name,photo_url',
            ])
            ->first();
    }

    public function findById(int $id) {
        return Ride::where('id', $id)->first();
    }

    public function request(array $data) {
        return RideRequest::create($data);
    }

    public function updateRideRequest(int $id, array $data) {
        return RideRequest::where('id', $id)->update($data);
    }
}

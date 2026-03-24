<?php

namespace App\Services;

use App\Enum\ApportionmentPercentageEnum;
use App\Enum\FuelTypeEnum;
use App\Filters\SearchRidesFilter;
use App\Helpers\AuthUtils;
use App\Http\Resources\Passenger\PassengerHistoryResource;
use App\Models\Ride;
use App\Providers\MapBoxProvider;
use App\Repositories\RideRepository;

class RideService
{
    public function __construct(
        protected RideRepository $rideRepository,
        protected AuthUtils $authUtils,
        protected MapBoxProvider $mapBoxProvider,
    ) {}

    public function search(array $queryParams): array {

        $user = $this->authUtils->user();
        $query = (new SearchRidesFilter(
            $this->rideRepository->getRides($user->id),
            $queryParams
            ))->applyFilter();

        $paginated = $query->paginate(10)->through(function ($ride) {
            $ride->cost_per_passenger = $this->getPricePerPassenger(
                $ride->total_cost,
                $ride->confirmed_passengers_count + 1
            );

            return $ride;
        });

        return [
            'items' => $paginated->items(),
            'pagination' => [
                'perPage' => $paginated->perPage(),
                'currentPage' => $paginated->currentPage(),
                'lastPage' => $paginated->lastPage(),
                'total' => $paginated->total(),
            ]
        ];
    }

    public function getNextRide():mixed {
        $passengerId = $this->authUtils->user()->id;

        return $this->rideRepository->nextRide($passengerId)->get() ?? []; 
    }

    public function getPassengerHistory(array $queryParams):mixed {
        $passengerId = $this->authUtils->user()->id;
        $history = $this->rideRepository->getPassengerHistory($passengerId);
        $paginated = $history->paginate($queryParams['per_page']);

        return [
            'items' => new PassengerHistoryResource($paginated->items()),
            'pagination' => [
                'perPage' => $paginated->perPage(),
                'currentPage' => $paginated->currentPage(),
                'lastPage' => $paginated->lastPage(),
                'total' => $paginated->total(),
            ]
        ];
    }

    public function create(array $data)
    {
        $driver = $this->authUtils->user();
        $driver->ensureDocumentIsApproved();

        $vehicle = $driver->vehicle;
        $fuel = FuelTypeEnum::from($vehicle->fuel_type);

        $distanceKm = $this->mapBoxProvider->calculateDistance(
            $data['origin_lat'],
            $data['origin_lng'],
            $data['destination_lat'],
            $data['destination_lng']
        );

        $totalCost = ($distanceKm / $fuel->consumption()) * $fuel->price();

        $ride = Ride::create([
            'origin_city'       => $data['origin_city'],
            'destination_city'  => $data['destination_city'],
            'origin_lat_lng'    => $data['origin_lat'].','.$data['origin_lng'],
            'destination_lat_lng'=> $data['destination_lat'].','.$data['destination_lng'],
            'departure_at'      => $data['departure_at'],
            'avaliable_seats'   => $data['available_seats'],
            'status'            => 'open',
            'distance_km'       => $distanceKm,
            'fuel_price_used'   => $fuel->price(), 
            'driver_id'         => $driver->id,
            'total_cost'        => $totalCost,
            'notes'             => $data['notes'],
        ]);

        $priceScenarios = $this->getPriceScenarios($totalCost, $data['available_seats']);

        return [
            'ride'           => $ride,
            'price_scenarios' => $priceScenarios,
        ];
    }

    private function getPriceScenarios(float $totalCost, int $seats): array
    {
        $scenarios = [];

        for ($passenger = 1; $passenger <= min($seats, 3); $passenger++) {
            $percentage = ApportionmentPercentageEnum::fromSeats($passenger)->value();
            $sharedCost = $totalCost * $percentage;
            $valueBase  = $sharedCost / $passenger;

            $scenarios[$passenger] = [
                'passenger_pays'    => round($valueBase * 1.10, 2),
                'driver_receives'   => round($valueBase, 2),
            ];
        }

        return $scenarios;
    }

    private function getPricePerPassenger(float $totalCost, int $seats): float {
        $percentage = ApportionmentPercentageEnum::fromSeats($seats)->value();
        $sharedCost = $totalCost * $percentage;
        $valueBase  = $sharedCost / $seats;

        return round($valueBase * 1.10, 2);
    }
}



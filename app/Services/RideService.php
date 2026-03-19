<?php

namespace App\Services;

use App\Filters\SearchRidesFilter;
use App\Helpers\AuthUtils;
use App\Http\Resources\Passenger\PassengerHistoryResource;
use App\Repositories\RideRepository;

class RideService
{
    public function __construct(
        protected RideRepository $rideRepository,
        protected AuthUtils $authUtils,
    ) {}

    public function search(array $queryParams): array {
        $query = (new SearchRidesFilter(
            $this->rideRepository->getRides(), 
            $queryParams
            ))->applyFilter();    

        $paginated = $query->paginate(10);

        return [
            'items' => $paginated->get(),
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

    public function getPassengerHistory():mixed {
        $passengerId = $this->authUtils->user()->id;
        $history = $this->rideRepository->getPassengerHistory($passengerId);
        $paginated = $history->paginate(1);

        return [
            'items' => new PassengerHistoryResource($history->get()),
            'pagination' => [
                'perPage' => 1,
                'currentPage' => 1,
                'lastPage' => 1,
                'total' => 1,
            ]
        ];
    }
}



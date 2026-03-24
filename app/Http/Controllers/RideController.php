<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Driver\CreateRideRequest;
use App\Http\Requests\Passenger\PassengerHistoryRequest;
use App\Http\Requests\Passenger\SearchRidesRequest;
use App\Services\RideService;
use Illuminate\Http\JsonResponse;

class RideController extends Controller
{
    public function __construct(
        protected RideService $rideService,
    ) {}

    public function search(SearchRidesRequest $request): JsonResponse {
        $rides = $this->rideService->search($request->validated());
        return ApiResponse::paginate(
            'Search rides successfully',
            $rides['items'],
            $rides['pagination']
        );
    }

    public function getNextRide(): JsonResponse {
        $previous = $this->rideService->getNextRide();
        return ApiResponse::success(
            'Successfully get next ride', 
            $previous,
            200
        );
    }

    public function getPassengerHistory(PassengerHistoryRequest $request): JsonResponse {
        $history = $this->rideService->getPassengerHistory($request->validated());
        return ApiResponse::paginate(
            'Successfully get passenger history', 
            $history['items'],
            $history['pagination']
        );
    }

    public function create(CreateRideRequest $request): JsonResponse {
        $ride = $this->rideService->create($request->validated());
        return ApiResponse::success(
            'Successfully create ride',
            $ride,
            200
        );
    }
}


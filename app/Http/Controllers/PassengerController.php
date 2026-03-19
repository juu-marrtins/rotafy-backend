<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Passenger\RechargeWalletRequest;
use App\Http\Resources\Wallet\PixTransactionResource;
use App\Services\PassengerService;
use Illuminate\Http\JsonResponse;

class PassengerController extends Controller
{
    public function __construct(
        protected PassengerService $passengerService,
    ){}

    public function balance(): JsonResponse {
        $wallet = $this->passengerService->getWallet();
        return ApiResponse::success(
            'Balance successfully retrieved',
            $wallet,
            200
        );
    }

    public function recharge(RechargeWalletRequest $request): JsonResponse {
        $pix = $this->passengerService->recharge($request->validated());
        return ApiResponse::success(
            'Recharge successfully requested',
            new PixTransactionResource($pix),
            200
        );
    }
}
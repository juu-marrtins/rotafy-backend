<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse {
        $this->authService->register(
            $request->validated(),
            $request->file('photo')
        );

        return ApiResponse::success(
            'Verify your email to confirm your registration',
            [],
            201
        );
    }

    public function login(LoginRequest $request): JsonResponse {
        $user = $this->authService->login(
            $request->validated()
        );

        return ApiResponse::success(
            'Login successful',
            new LoginResource($user),
            200
        );
    }
}

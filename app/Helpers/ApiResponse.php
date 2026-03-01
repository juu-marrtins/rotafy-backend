<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class ApiResponse
{
    public static function success(string $message = 'OK', $data = [], int $statusCode = 200): JsonResponse {
        return new JsonResponse([
            'status' => $statusCode,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public static function fail(string $message, int $statusCode = 500): JsonResponse {
        return new JsonResponse([
            'status' => $statusCode,
            'message' => $message,
            'data' => []
        ], $statusCode);
    }
}
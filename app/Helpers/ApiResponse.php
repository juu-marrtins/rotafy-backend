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

    public static function paginate(string $message, mixed $data, array $pagination): JsonResponse {
        return new JsonResponse([
            'status' => 200,
            'message' => $message,
            'data' => $data,
            'pagination'=> [
                'per_page' => $pagination['perPage'],
                'current_page' => $pagination['currentPage'],
                'last_page' => $pagination['lastPage'],
                'total' => $pagination['total'],
            ]
        ], 200);
    }
}
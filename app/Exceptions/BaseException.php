<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class BaseException extends Exception
{
    protected int $statusCode = 500;

    public function render($request): JsonResponse
    {
        return ApiResponse::fail(
            $this->getMessage(),
            $this->statusCode,
        );
    }
}
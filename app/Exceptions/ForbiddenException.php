<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;

class ForbiddenException extends BaseException
{
    protected int $statusCode = 403;

    public function __construct($message = '')
    {
        parent::__construct($message);
    }
}
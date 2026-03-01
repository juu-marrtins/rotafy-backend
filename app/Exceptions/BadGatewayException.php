<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;

class BadGatewayException extends BaseException
{
    protected int $statusCode = 502;

    public function __construct($message = '', $messageToLog = '')
    {
        Log::error('Bac Gateway em API externa: ' . $messageToLog);
        parent::__construct($message);
    }
}
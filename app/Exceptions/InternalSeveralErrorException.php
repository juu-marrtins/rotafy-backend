<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;

class InternalSeveralErrorException extends BaseException
{
    protected int $statusCode = 500;

    public function __construct($message = '', $messageToLog)
    {
        Log::error($message . ': ' .  $messageToLog);

        parent::__construct($message);
    }
}
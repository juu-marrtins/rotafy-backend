<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;

class NotFoundException extends BaseException
{
    protected int $statusCode = 404;

    public function __construct($message = '')
    {
        parent::__construct($message);
    }
}
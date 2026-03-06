<?php

namespace App\Exceptions;

class UnauthorizedException extends BaseException
{
    protected int $statusCode = 401;

    public function __construct($message = '')
    {
        parent::__construct($message);
    }
}
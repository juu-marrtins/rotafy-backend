<?php

namespace App\Exceptions;

class UnprocessableContentException extends BaseException
{
    protected int $statusCode = 422;

    public function __construct($message = '')
    {
        parent::__construct($message);
    }
}
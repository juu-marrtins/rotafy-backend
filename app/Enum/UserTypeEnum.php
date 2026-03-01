<?php

namespace App\Enum;

enum UserTypeEnum: string
{
    case DRIVER = 'driver';
    case PASSENGER = 'passenger';
    case BOTH = 'both';
}
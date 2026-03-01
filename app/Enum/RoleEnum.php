<?php

namespace App\Enum;

enum RoleEnum: int
{
    case ADMIN = 1;
    case PASSENGER = 2;
    case DRIVER = 3;
    case BOTH = 4;
}
<?php

namespace App\Enum;

enum DriverDocumentsEnum: string
{
    case VERIFIED = 'verified';
    case REJECTED = 'rejected';
    case PENDING = 'pending';
}
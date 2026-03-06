<?php

namespace App\Enum;

enum DriverDocumentsEnum: string
{
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PENDING = 'pending';
}
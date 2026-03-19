<?php

namespace App\Enum;

enum WebhookStatusEnum: string
{
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case PENDING = 'pending';
}
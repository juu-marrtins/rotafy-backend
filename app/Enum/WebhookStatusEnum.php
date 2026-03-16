<?php

namespace App\Enum;

enum WebhookStatusEnum: string
{
    case PIX_PAID = 'pix_paid';
    case PIX_DISPUTED = 'pix_disputed';
    case WITHDRAWAL_DONE = 'withdrawal_done';
    case WITHDRAWAL_FAILED = 'withdrawal_failed';
    case PENDING = 'pending';
}
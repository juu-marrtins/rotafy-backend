<?php

namespace App\Enum;

enum WebhookTriggerEnum: string
{
    case BILLING_PAID = 'billing.paid';
    case BILLING_DISPUTED = 'billing.disputed';
    case WITHDRAWAL_DONE = 'withdrawal.done';
    case WITHDRAWAL_FAILED = 'withdrawal.failed';
}
<?php

namespace App\Enum;

enum WalletTransactionTypeEnum: string
{
    case RECHARGE = 'recharge';
    case WITHDRAWAL = 'withdrawal';
    case DEBIT = 'debit';
    case CREDIT = 'credit';
}
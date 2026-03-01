<?php

namespace App\Enum;


enum UserStatusEnum: string
{
    const PENDING = 'pending';
    const VERIFIED = 'verified';
    const REJECTED = 'rejected';
}
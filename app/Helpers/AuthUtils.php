<?php

namespace App\Helpers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class AuthUtils
{
    public function user(): Authenticatable {
        return Auth::user();
    }
}
<?php

namespace App\Rules;

use App\Helpers\Validators;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CnpjRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validator = new Validators();
        $validator->validateCNPJ($value);
    }
}
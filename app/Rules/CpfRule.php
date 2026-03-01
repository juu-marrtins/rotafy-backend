<?php

namespace App\Rules;

use App\Helpers\Validators;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validator = new Validators();
        $validator->validateCPF($value);
    }
}

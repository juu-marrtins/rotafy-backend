<?php

namespace App\Rules;

use App\Helpers\Validators;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CnhRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validator = app(Validators::class);
        $validator->validateCNH($value);
    }
}

<?php

namespace App\Http\Requests\Passenger;

use Illuminate\Foundation\Http\FormRequest;

class PassengerHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'per_page' => 'required|integer|min:1|max:100',
            'page' => 'required|integer|min:1',
        ];
    }
}

<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class CreateRideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'origin_city'      => 'required|string',
            'destination_city' => 'required|string',
            'origin_lat'       => 'required|numeric',
            'origin_lng'       => 'required|numeric',
            'destination_lat'  => 'required|numeric',
            'destination_lng'  => 'required|numeric',
            'departure_at'     => 'required|date',
            'available_seats'  => 'required|integer|min:1|max:4',
            'notes'            => 'sometimes|string|nullable',
        ];
    }
}

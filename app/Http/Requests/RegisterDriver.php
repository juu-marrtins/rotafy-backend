<?php

namespace App\Http\Requests;

use App\Rules\CnhRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterDriver extends FormRequest
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
            'cnh_verse'  => 'required|file|mimetypes:image/jpeg,image/png,image/jpg,application/pdf',
            'cnh_front'  => 'required|file|mimetypes:image/jpeg,image/png,image/jpg,application/pdf',
            'handle_cpf' => 'required|file|mimetypes:image/jpeg,image/png,image/jpg,application/pdf',
            'crlv'  => 'required|file|mimetypes:image/jpeg,image/png,image/jpg,application/pdf',
            'cnh_digits' => ['required', 'string', 'size:11', 'unique:driver_documents,cnh_digit', new CnhRule],
            'plate' => ['required', 'string', 'unique:vehicles,plate'],
        ];
    }
}

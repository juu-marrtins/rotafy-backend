<?php

namespace App\Http\Requests;

use App\Enum\UserTitleEnum;
use App\Enum\UserTypeEnum;
use App\Helpers\Validators;
use App\Rules\CnpjRule;
use App\Rules\CpfRule;
use App\Rules\InstitutionalEmailRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void {    
        $numericFields = ['cpf', 'cnpj', 'phone'];

        foreach ($numericFields as $field) {
            if ($this->filled($field)) {
                $this->merge([
                    $field => Validators::cleanDigits($this->input($field))
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'], #new InstitutionalEmailRule],
            'password' => ['required', Password::min(8)->letters()->mixedCase()->symbols()],
            'cpf'  => ['required', 'string', 'size:11', 'unique:users', new CpfRule],
            'cnpj' => ['required', 'string', 'size:14', new CnpjRule],
            'type' => ['required', new Enum(UserTypeEnum::class)],
            'title' => ['required', new Enum(UserTitleEnum::class)],
            'phone' => ['required', 'string', 'max:10'],
            'photo' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp','max:2048'],
            'terms_accepted' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.requred' => 'O nome é obrigatório',
            'name.max' => 'O nome não pode ter mais de 60 caracteres',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'O email não é válido',
            'email.unique' => 'O email já está cadastrado',
            'email.max' => 'O email não pode ter mais de 100 caracteres',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres',
            'password.letters' => 'A senha deve conter letras',
            'password.mixedCase' => 'A senha deve conter maiúsculas e minúsculas',
            'password.symbols' => 'A senha deve conter símbolos',
            'cpf.required' => 'O CPF é obrigatório',
            'cpf.unique' => 'O CPF já está cadastrado',
            'cpf.max' => 'O CPF não pode ter mais de 11 caracteres',
            'cnpj.required' => 'O CNPJ é obrigatório',
            'cnpj.max' => 'O CNPJ não pode ter mais de 14 caracteres',
            'type.required' => 'O tipo de usuário é obrigatório',
            'title.required' => 'O título de usuário é obrigatório',
            'phone.required' => 'O telefone é obrigatório',
            'phone.unique' => 'O telefone já está cadastrado',
            'phone.max' => 'O telefone não pode ter mais de 11 caracteres',
            'photo.image' => 'O arquivo selecionado não é uma imagem',
            'photo.mimes' => 'O arquivo selecionado não é uma imagem',
            'photo.max' => 'O arquivo selecionado não é uma imagem',
            'terms_accepted.accepted' => 'Você precisa aceitar os termos e condições',
        ];
    }
}

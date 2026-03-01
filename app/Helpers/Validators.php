<?php

namespace App\Helpers;

use App\Exceptions\UnprocessableContentException;

class Validators
{
    public static function cleanDigits(String $value): ?String {
        return preg_replace('/\D/', '', $value);
    }

    public static function validateCPF(String $cpf): ?String
    {
        if (strlen($cpf) != 11) {
            throw new UnprocessableContentException('CPF deve ter 11 dígitos');
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            throw new UnprocessableContentException('CPF não pode ter repetição de dígitos');
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += intval($cpf[$i]) * (10 - $i);
        }
        $remainder = $sum % 11;
        $digit1 = $remainder < 2 ? 0 : 11 - $remainder;

        if ($digit1 != intval($cpf[9])) {
            throw new UnprocessableContentException('CPF inválido');
        }
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += intval($cpf[$i]) * (11 - $i);
        }
        $remainder = $sum % 11;
        $digit2 = $remainder < 2 ? 0 : 11 - $remainder;
        
        if ($digit2 != intval($cpf[10])) {
            throw new UnprocessableContentException('CPF inválido');
        }

        return $cpf;
    }

    public static function validateCNPJ(String $cnpj): ?String
    {
        if (strlen($cnpj) != 14) {
            throw new UnprocessableContentException('CNPJ deve ter 14 dígitos');
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            throw new UnprocessableContentException('CNPJ não pode ter repetição de dígitos');
        }

        $length = strlen($cnpj) - 2;
        $numbers = substr($cnpj, 0, $length);
        $digits = substr($cnpj, $length);
        $sum = 0;
        $position = $length - 7;
        
        for ($i = $length; $i >= 1; $i--) {
            $sum += intval($numbers[$length - $i]) * $position--;
            if ($position < 2) {
                $position = 9;
            }
        }
        
        $result = $sum % 11 < 2 ? 0 : 11 - ($sum % 11);
        
        if ($result != intval($digits[0])) {
            throw new UnprocessableContentException('CNPJ inválido');
        }

        $length = $length + 1;
        $numbers = substr($cnpj, 0, $length);
        $sum = 0;
        $position = $length - 7;
        
        for ($i = $length; $i >= 1; $i--) {
            $sum += intval($numbers[$length - $i]) * $position--;
            if ($position < 2) {
                $position = 9;
            }
        }
        
        $result = $sum % 11 < 2 ? 0 : 11 - ($sum % 11);
        
        if ($result != intval($digits[1])) {
            throw new UnprocessableContentException('CNPJ inválido');
        }

        return $cnpj;
    }

    public function validateInstitutionalEmail(String $email): ?String
    {
        $domain = explode('@', $email)[1];

        if(!str_ends_with($domain, 'edu.br')){
            throw new UnprocessableContentException('Email não é institucional');
        }

        return $email;
    }
}
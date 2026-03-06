<?php

namespace App\Helpers;

use App\Exceptions\UnprocessableContentException;

class Validators
{
    public static function cleanDigits(String $value): ?String {
        return preg_replace('/\D/', '', $value);
    }

    public static function validateCPF(String $cpf): ?String {
        if (strlen($cpf) != 11) {
            throw new UnprocessableContentException('CPF must have 11 digits');
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            throw new UnprocessableContentException('CPF can not have repeated digits');
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += intval($cpf[$i]) * (10 - $i);
        }
        $remainder = $sum % 11;
        $digit1 = $remainder < 2 ? 0 : 11 - $remainder;

        if ($digit1 != intval($cpf[9])) {
            throw new UnprocessableContentException('CPF invalid');
        }
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += intval($cpf[$i]) * (11 - $i);
        }
        $remainder = $sum % 11;
        $digit2 = $remainder < 2 ? 0 : 11 - $remainder;
        
        if ($digit2 != intval($cpf[10])) {
            throw new UnprocessableContentException('CPF invalid');
        }

        return $cpf;
    }

    public static function validateCNPJ(String $cnpj): ?String {
        if (strlen($cnpj) != 14) {
            throw new UnprocessableContentException('CNPJ must have 14 digits');
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            throw new UnprocessableContentException('CNPJ can not have repeated digits');
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
            throw new UnprocessableContentException('CNPJ invalid');
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
            throw new UnprocessableContentException('CNPJ invalid');
        }

        return $cnpj;
    }

    public function validateInstitutionalEmail(String $email): ?String {
        $domain = explode('@', $email)[1];

        if(!str_ends_with($domain, 'edu.br')){
            throw new UnprocessableContentException('Email is not institutional');
        }

        return $email;
    }

    public function validateCNH(string $cnh): ?string {
        $cnh = $this->cleanDigits($cnh);

        if(strlen($cnh) !== 11){
            throw new UnprocessableContentException('CNH must have 11 digits');
        }

        if (preg_match('/^(\d)\1{10}$/', $cnh)) {
            throw new UnprocessableContentException('CNH can not have repeated digits');
        }    

        $soma = 0;
        for ($i = 0, $j = 9; $i < 9; $i++, $j--) {
            $soma += (int)$cnh[$i] * $j;
        }

        $primeiroResto = $soma % 11;
        $dsp = $primeiroResto > 9 ? 0 : $primeiroResto;

        $soma = 0;
        $multiplicador = 1;
        for ($i = 0; $i < 9; $i++, $multiplicador++) {
            $soma += (int)$cnh[$i] * $multiplicador;
        }

        $segundoResto = $soma % 11;
        $dsp2 = $segundoResto > 9 ? 0 : $segundoResto;

        if ((int)$cnh[9] !== $dsp || (int)$cnh[10] !== $dsp2) {
            throw new UnprocessableContentException('CNH invalid');
        }

        return $cnh;
    }
}
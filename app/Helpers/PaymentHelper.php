<?php

namespace App\Helpers;

class PaymentHelper
{
    public function makeCustomerData(string $name, string $phone, string $email, string $cpf): array {
        return [
            'name' => $name,
            'cellphone' => $this->formatPhone($phone),
            'email' => $email,
            'taxId' => $cpf,
        ];
    }

    private function formatPhone(string $phone): string {    
        return sprintf('(%s) %s-%s', substr($phone, 0, 2), substr($phone, 2, 4), substr($phone, 6));
    }
}
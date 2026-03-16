<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;

class PaymentProvider
{
    public function createAccount(array $data): string {
        $url = 'https://api.abacatepay.com/v1/customer/create';

        $payload = [
            'name' => $data['name'],
            'cellphone' => $data['phone'],
            'email' => $data['email'],
            'taxId' => $data['cpf'],
        ];

        $headers = [
            'Authorization' => ' Bearer ' . env('ABACATEPAY_API_KEY'),
            'Content-Type' => 'application/json',
        ];

        $result = Http::withHeaders($headers)->post($url, $payload);

        $data = $result->json();

        return data_get($data, 'data.id');
    }

    public function createPix(float $amount, array $customerData, int $expiresIn, string $message) {
        $url = 'https://api.abacatepay.com/v1/pixQrCode/create';

        $payload = [
            'amount' => $amount * 100,
            'expiresIn' => $expiresIn,
            'description' => $message,
            'customer' => $customerData,
            'metadata' => []
        ];

        $headers = [
            'Authorization' => ' Bearer ' . env('ABACATEPAY_API_KEY'),
            'Content-Type' => 'application/json',
        ];

        $result = Http::withHeaders($headers)->post($url, $payload);

        return $result->json();
    }
}
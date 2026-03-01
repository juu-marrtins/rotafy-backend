<?php

namespace App\Repositories;

use App\Models\University;

class UniversityRepository
{
    public function create(array $data): University {
        return University::create($data);
    }

    public function getIdByCnpj(string $cnpj): ?int {
        return University::where('cnpj', $cnpj)->value('id');
    }
}
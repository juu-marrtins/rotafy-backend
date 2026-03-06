<?php

namespace App\Repositories;

use App\Models\DriverDocuments;

class DriverRepository
{
    public function create(array $data): DriverDocuments {
        return DriverDocuments::create($data);
    }
}
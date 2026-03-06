<?php

namespace App\Repositories;

use App\Models\Vehicles;

class VehicleRepository
{
    public function create(array $data): Vehicles {
        return Vehicles::create($data);
    }
}
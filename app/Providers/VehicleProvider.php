<?php

namespace App\Providers;

use App\Helpers\MockData;

class VehicleProvider
{
    public function getVehicleData(): array {
        return MockData::vechicleMockData();
    }
}
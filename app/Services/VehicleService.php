<?php

namespace App\Services;

use App\Models\Vehicles;
use App\Providers\VehicleProvider;
use App\Repositories\VehicleRepository;
use Illuminate\Http\UploadedFile;

class VehicleService
{
    public function __construct(
        protected VehicleProvider $vehicleProvider,
        protected CloudinaryService $cloudinaryService,
        protected VehicleRepository $vehicleRepository
    ) {} 

    public function uploadCRLV(string $plate, UploadedFile $crlv, int $userId): array {
        $path = 'rotafy/vehicles/' . $plate;

        return $this->cloudinaryService->upload($crlv, $path);
    }

    public function create(string $plate, string $crlvUrl, int $userId): Vehicles {
        $data = $this->vehicleProvider->getVehicleData(); # NOTE: Dados mocados ate conseguir API

        return $this->vehicleRepository->create([
            'plate' => $plate,
            'model' => data_get($data, 'MODELO'),
            'version' => data_get($data, 'VERSAO'),
            'year' => data_get($data, 'ano'),
            'fetched_from_api' => true,
            'driver_id' => $userId,
            'crlv_url' => $crlvUrl,
            'color' => data_get($data, 'cor'),
            'situation' => data_get($data, 'situacao'),
            'fuel_type' => data_get($data, 'fipe.data.combustivel', data_get($data, 'extra.combustivel', 'Gasolina')),
        ]);
    }
}

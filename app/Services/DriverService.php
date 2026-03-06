<?php

namespace App\Services;

use App\Enum\DriverDocumentsEnum;
use App\Helpers\AuthUtils;
use App\Repositories\DriverRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class DriverService
{
    public function __construct(
        protected AuthUtils $authUtils,
        protected DriverRepository $driverRepository,
        protected CloudinaryService $cloudinaryService,
        protected VehicleService $vehicleService
    ){}

    public function register(UploadedFile $cnhVerse, UploadedFile $cnhFront, UploadedFile $handleCpf, string $cnhDigit, string $plate, UploadedFile $crlv){
        $user = $this->authUtils->user();
        $userId = $user->id;
        $path = 'rotafy/drivers/' . $userId . '_documents';

        $cnhVerseUploaded = $this->cloudinaryService->upload($cnhVerse, $path);
        $cnhFrontUploaded = $this->cloudinaryService->upload($cnhFront, $path);
        $handleCpfUploaded = $this->cloudinaryService->upload($handleCpf, $path);
        $crlvUploaded = $this->vehicleService->uploadCRLV($plate, $crlv, $userId);

        DB::transaction(function () use ($userId, $cnhDigit, $crlvUploaded, $plate, $cnhVerseUploaded, $cnhFrontUploaded, $handleCpfUploaded) {

            $this->driverRepository->create([
                'driver_id' => $userId,
                'cnh_digit' => $cnhDigit,
                'cnh_verse_url' => data_get($cnhVerseUploaded, 'url'),
                'cnh_front_url' => data_get($cnhFrontUploaded, 'url'),
                'handle_cnh_url' => data_get($handleCpfUploaded, 'url'),
                'status' => DriverDocumentsEnum::PENDING->value,
            ]);

            $this->vehicleService->create($plate, $crlvUploaded['url'], $userId);
        });
    }
}
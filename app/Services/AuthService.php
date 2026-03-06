<?php

namespace App\Services;

use App\Enum\RoleEnum;
use App\Exceptions\InternalSeveralErrorException;
use App\Exceptions\UnauthorizedException;
use App\Models\User;
use App\Providers\PaymentProvider;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        protected CloudinaryService $cloudinaryService,
        protected UniversityService $universityService,
        protected UserService $userService,
        protected PaymentProvider $paymentProvider,
    ) {}

    public function register(array $data, ?UploadedFile $photo): void {
        $universityId = $this->universityService->getOrCreateByCnpj($data['cnpj']);
        $photoData = [];

        if($photo){
            $photoData = $this->cloudinaryService->upload($photo, 'rotafy/profile_photos');
        }

        try {
            DB::transaction(function () use ($universityId, $photoData, $data) {

                $userData = $this->buildUserData($data, $photoData, $universityId);

                $user = $this->userService->create($userData);

                $user->sendEmailVerificationNotification();
            });
        } catch (\Exception $e) {
            if($photo){
                $this->cloudinaryService->delete($photoData['public_id']);
            }
            throw new InternalSeveralErrorException('Error creating user account', $e->getMessage());
        }
    }

    private function buildUserData(array $data, array $photoData = [], int $universityId): array
    {
        return [
            'name' => $data['name'],
            'role_id' => RoleEnum::PASSENGER->value,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'cpf' => $data['cpf'],
            'phone' => $data['phone'],
            'user_title' => $data['title'],
            'user_type' => $data['type'],
            'photo_url' => data_get($photoData, 'url'),
            'photo_public_id' => data_get($photoData, 'public_id'),
            'university_id' => $universityId,
        ];
    }

    public function login(array $credentials): User {
        if (!Auth::attempt($credentials)) {
            throw new UnauthorizedException('Invalid credentials');
        }

        $user = Auth::user();

        /** @var \App\Models\User $user */
        if (!$user->hasVerifiedEmail()) {
            throw new UnauthorizedException('Email not verified');
        }

        return $user;
    }
}


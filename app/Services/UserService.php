<?php

namespace App\Services;

use App\Enum\UserStatusEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Verified;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ){}

    public function create(array $data): User {
        return $this->userRepository->create($data);
    }

    public function verifyEmail(string $id, string $hash): array
    {
        $user = User::findOrFail($id);

        if (!hash_equals($hash, sha1($user->getEmailForVerification()))) {
            return ['status' => 'invalid'];
        }

        if ($user->hasVerifiedEmail()) {
            return ['status' => 'already_verified'];
        }
    
        $user->markEmailAsVerified();

        $user->update([
            'status' => UserStatusEnum::VERIFIED
        ]);
        
        event(new Verified($user));
        
        return ['status' => 'verified'];
    }
}
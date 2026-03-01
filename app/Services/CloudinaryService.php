<?php

namespace App\Services;

use App\Models\User;
use Cloudinary\Api\Upload\UploadApi;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CloudinaryService
{
    public function upload(?UploadedFile $photo): ?array
    {
        if (!$photo) {
            return [
                'url' => null,
                'public_id' => null,
            ];
        }

        $result = (new UploadApi())->upload(
            $photo->getRealPath(),
            [
                'folder' => 'rotafy/profile_photos',
                'public_id' => (string) Str::uuid(),
                'resource_type' => 'image',
            ]
        );

        return [
            'url' => $result['secure_url'] ?? null,
            'public_id' => $result['public_id'] ?? null,
        ];
    }

    public function delete(string $publicId): void {
        $uploadApi = new UploadApi();

        $uploadApi->destroy($publicId, [
            'resource_type' => 'image',
        ]);
    }

    public function updateAvatar(User $user, UploadedFile $photo)
    {
        if ($user->photo_public_id) {
            $this->delete($user->photo_public_id);
        }
        $result = $this->upload($photo);

        $user->update([
            'photo_url' => $result['url'],
            'photo_public_id' => $result['public_id'],
        ]);
    }
}
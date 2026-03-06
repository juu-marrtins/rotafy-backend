<?php

namespace App\Services;

use App\Exceptions\BadGatewayException;
use App\Models\User;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CloudinaryService
{
    public function upload(?UploadedFile $photo, string $folder): ?array
    {
        if (!$photo) {
            return [
                'url' => null,
                'public_id' => null,
            ];
        }
        try {
            $result = (new UploadApi())->upload(
                $photo->getRealPath(),
                [
                    'folder' => $folder,
                    'public_id' => (string) Str::uuid(),
                    'resource_type' => 'image',
                ]
            );
        } catch (\Exception $e) {
            throw new BadGatewayException('Error uploading file to cloudinary', $e->getMessage());
        }

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

    public function updateAvatar(User $user, UploadedFile $photo, string $folder)
    {
        if ($user->photo_public_id) {
            $this->delete($user->photo_public_id);
        }

        $result = $this->upload($photo, $folder);

        $user->update([
            'photo_url' => $result['url'],
            'photo_public_id' => $result['public_id'],
        ]);
    }
}
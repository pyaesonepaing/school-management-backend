<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryService
{
    public function upload($file, $folder)
    {
        $uploaded = Cloudinary::upload(
            $file->getRealPath(),
            [
                'folder' => $folder
            ]
        );

        return [
            'public_id' => $uploaded->getPublicId(),
            'url' => $uploaded->getSecurePath(),
        ];
    }
}
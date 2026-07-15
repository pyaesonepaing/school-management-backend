<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryService
{
    public function upload($file, $folder)
    {
        $uploaded = cloudinary()->uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder' => $folder
            ]
        );

        return [
            'public_id' => $uploaded['public_id'],
            'url' => $uploaded['secure_url'],
        ];
    }
}
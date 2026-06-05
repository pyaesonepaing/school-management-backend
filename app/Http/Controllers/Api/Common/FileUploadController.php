<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{   
    public function upload(
        Request $request,
        CloudinaryService $cloudinary
    )
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'folder' => 'required|string'
        ]);

        $result = $cloudinary->upload(
            $request->file('file'),
            $request->folder
        );

        return response()->json($result);
    }
}
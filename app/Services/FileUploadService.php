<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadFile($file, $directory = 'uploads')
    {
        $path = $file->store($directory, 'public');

        return Storage::url($path);
    }
}

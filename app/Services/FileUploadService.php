<?php

namespace App\Services;

use App\Repositories\Interface\FileUploadInterface;

class FileUploadService
{
    protected FileUploadInterface $fileUpload;

    public function __construct(FileUploadInterface $fileUpload)
    {
        $this->fileUpload = $fileUpload;
    }
    
    public function save($image, $path, $prefix = null)
    {
        return $this->fileUpload->save($image, $path, $prefix);
    }

    public function unlink($file)
    {
        return $this->fileUpload->unlink($file);
    }
}
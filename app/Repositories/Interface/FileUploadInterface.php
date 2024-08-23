<?php

namespace App\Repositories\Interface;

interface FileUploadInterface
{
    public function save($image, $path, $prefix = null);
    public function unlink($file);
}
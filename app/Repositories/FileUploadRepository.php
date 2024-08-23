<?php

namespace App\Repositories;

use App\Repositories\Interface\FileUploadInterface;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class FileUploadRepository implements FileUploadInterface
{
    public function save($image, $path, $prefix = null)
    {
        $path = "storage/" . $path;
        $width = 0;
        $height = 0;
        if ($prefix) {
            $prefix = '-' . $prefix;
        }

        $path_arr = explode('/', $path);

        $directory = null;
        foreach ($path_arr as $path) {
            if ($path) {
                $directory .= $path . '/';
                if (!File::isDirectory(public_path($directory))) {
                    File::makeDirectory(public_path($directory));
                }
            }
        }

        if (Image::make($image)->width() > 900) {
            $width = 900;
        } else {
            $width = Image::make($image)->width();
        }
        if (Image::make($image)->height() > 700) {
            $height = 700;
        } else {
            $height = Image::make($image)->height();
        }

        $imageName = Str::uuid() . $prefix . '.' . $image->extension();
        Image::make($image)
            ->resize($width, $height)
            ->save(public_path($directory . $imageName));

        return $directory . $imageName;
    }

    public function unlink($file)
    {
        if ($file)
            unlink($file);
    }

}

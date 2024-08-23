<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use File;

class DropzoneController extends Controller
{
    public function uploadimage(Request $request)
    {
        $path = storage_path('tmp/uploads');
        $imgwidth = 600;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $file = $request->file('file');
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        // $name = $file->getClientOriginalName();
        $full_path = storage_path('tmp/uploads/' . $name);
        $img = Image::make($file->getRealPath());
        if ($img->width() > $imgwidth) {
            $img->resize($imgwidth, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $img->save($full_path);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function deleteupload(Request $request)
    {
        if (File::exists(storage_path('tmp/uploads/' . $request->name))) {
            File::delete(storage_path('tmp/uploads/' . $request->name));
        } else {

        }
        // return response()->json(['message' => $request->name]);
    }
}

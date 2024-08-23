<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

class SummernoteController extends Controller
{
    public function uploadimage(Request $request)
    {
        if ($request->image){
            $path = storage_path('tmp/uploads');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file = $request->image;
            $name = uniqid() . '_' . trim($file->getClientOriginalName());
            $full_path = public_path('uploads/summernote/'.$name);
            $img = \Image::make($file->getRealPath());

            $img->save($full_path);
            $url = asset('uploads/summernote/'.$name);

            return response()->json(['url' => $url, 'name' => $name]);
        }
    }

    public function deleteupload(Request $request)
    {
        unlink("uploads/summernote/".$request->image);
    }
}

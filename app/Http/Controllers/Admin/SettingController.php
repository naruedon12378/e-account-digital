<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.setting.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->title_th) {
            setting(['title_th' => $request->title_th])->save();
        }

        if ($request->title_en) {
            setting(['title_en' => $request->title_en])->save();
        }

        setting(['address_th' => $request->address_th])->save();

        setting(['address_en' => $request->address_en])->save();

        setting(['phone1' => $request->phone1])->save();

        setting(['phone2' => $request->phone2])->save();

        setting(['company_number' => $request->company_number])->save();

        setting(['fax' => $request->fax])->save();

        setting(['email1' => $request->email1])->save();

        setting(['email2' => $request->email2])->save();

        setting(['google_map' => $request->google_map])->save();

        setting(['line' => $request->line])->save();

        setting(['line_token' => $request->line_token])->save();

        setting(['facebook' => $request->facebook])->save();

        setting(['messenger' => $request->messenger])->save();

        setting(['youtube' => $request->youtube])->save();

        setting(['youtube_embed' => $request->youtube_embed])->save();

        setting(['instagram' => $request->instagram])->save();

        setting(['twitter' => $request->twitter])->save();

        setting(['linkedin' => $request->linkedin])->save();

        setting(['whatsapp' => $request->whatsapp])->save();

        setting(['social1' => $request->social1])->save();

        setting(['social2' => $request->social2])->save();

        setting(['tag_google_analytics' => $request->tag_google_analytics])->save();

        setting(['tag_facebook_pixel' => $request->tag_facebook_pixel])->save();

        setting(['short_about_us_th' => $request->short_about_us_th])->save();

        setting(['short_about_us_en' => $request->short_about_us_en])->save();

        setting(['about_us_th' => $request->about_us_th])->save();

        setting(['about_us_en' => $request->about_us_en])->save();

        setting(['seo_keyword' => $request->seo_keyword])->save();

        setting(['seo_description' => $request->seo_description])->save();

        if ($request->file('img_favicon')) {
            if (!empty(setting('img_favicon'))) {
                File::delete(public_path(setting('img_favicon')));
            }
            //resize image
            $path = storage_path('tmp/uploads');
            $imgwidth = 300;

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file = $request->file('img_favicon');
            $name = uniqid() . '_' . trim($file->getClientOriginalName());
            $full_path = public_path('uploads/setting/' . $name);
            $img = \Image::make($file->getRealPath());
            if ($img->width() > $imgwidth) {
                $img->resize($imgwidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $img->save($full_path);
            setting(['img_favicon' => 'uploads/setting/' . $name])->save();
        }

        if ($request->file('img_logo')) {
            if (!empty(setting('img_logo'))) {
                File::delete(public_path(setting('img_logo')));
            }
            //resize image
            $path = storage_path('tmp/uploads');
            $imgwidth = 300;

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file = $request->file('img_logo');
            $name = uniqid() . '_' . trim($file->getClientOriginalName());
            $full_path = public_path('uploads/setting/' . $name);
            $img = \Image::make($file->getRealPath());
            if ($img->width() > $imgwidth) {
                $img->resize($imgwidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $img->save($full_path);
            setting(['img_logo' => 'uploads/setting/' . $name])->save();
        }

        if ($request->file('img_og')) {
            if (!empty(setting('img_og'))) {
                File::delete(public_path(setting('img_og')));
            }
            //resize image
            $path = storage_path('tmp/uploads');
            $imgwidth = 300;

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file = $request->file('img_og');
            $name = uniqid() . '_' . trim($file->getClientOriginalName());
            $full_path = public_path('uploads/setting/' . $name);
            $img = \Image::make($file->getRealPath());
            if ($img->width() > $imgwidth) {
                $img->resize($imgwidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $img->save($full_path);
            setting(['img_og' => 'uploads/setting/' . $name])->save();
        }

        Alert::success('บันทึกข้อมูลสำเร็จ');
        return redirect()->route('setting.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

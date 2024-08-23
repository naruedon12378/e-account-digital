<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Facades\Auth;

use App\Models\Article;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Article::all();

            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('btn',function ($data){
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all article', 'edit article']) ? '<a class="btn btn-sm btn-warning" href="'.route('article.edit',['article' => $data['id']]).'"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all article', 'delete article']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`' . url('article') . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    $btn = $btnEdit . ' ' . $btnDel;

                    return $btn;
                })
                ->addColumn('publish', function ($data) {
                    if ($data['publish']) {
                        $publish = '<label class="switch"> <input type="checkbox" checked value="0" id="' . $data['id'] . '" onchange="publish(`' . url('article/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                    } else {
                        $publish = '<label class="switch"> <input type="checkbox" value="1" id="' . $data['id'] . '" onchange="publish(`' . url('article/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                    }
                    return $publish;
                })
                ->addColumn('sorting', function ($data) {
                    $sorting = '<input name="sort" type="number" class="form-control " value="' . $data['sort'] . '" id="' . $data['id'] . '" onkeyup="sort(this,`' . url('article/sort') . '/' . $data['id'] . '`)"/>';
                    return $sorting;
                })
                ->addColumn('img', function ($data) {
                    if ($data->getFirstMediaUrl('article')) {
                        $img = '<img src="' . asset($data->getFirstMediaUrl('article')) . '" style="width: auto; height: 40px;">';
                    } else {
                        $img = '<img src="' . asset('images/no-image.jpg') . '" style="width: auto; height: 40px;">';
                    }

                    return $img;
                })
                ->rawColumns(['btn', 'img', 'publish', 'sorting'])
                ->make(true);
        }

        return view('admin.article.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $article = new Article();
        $article->name_th = $request->name_th;
        $article->name_en = $request->name_en;
        $article->sub_detail_th = $request->sub_detail_th;
        $article->sub_detail_en = $request->sub_detail_en;
        $article->detail_th = $request->detail_th;
        $article->detail_en = $request->detail_en;
        $article->date = $request->date;

        $article->seo_keyword = json_encode($request->post('seo_keyword'));
        $article->seo_description = $request->post('seo_description');

        $article->created_at = Carbon::now();
        $article->updated_at = Carbon::now();

        if ($article->save()) {
            $i = 0;
            $medias_original_name = $request->input('image', []);
            foreach ($request->input('image', []) as $file) {
                $article->addMedia(storage_path('tmp/uploads/' . $file))
                    ->withCustomProperties(['order' => $i])
                    ->setName($medias_original_name[$i])
                    ->toMediaCollection('article');
                $i++;
            }

            toast('บันทึกข้อมูล', 'success');
            return redirect()->route('article.index');
        }

        Alert::error('ผิดพลาด');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $article = Article::whereId($id)->first();

        $medias = $article->getMedia('article');
        $images = $medias->sortBy(function ($med, $key) {
            return $med->getCustomProperty('order');
        });
        return view('admin.article.edit', compact('article', 'images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $article = Article::whereId($id)->first();
        $article->name_th = $request->name_th;
        $article->name_en = $request->name_en;
        $article->sub_detail_th = $request->sub_detail_th;
        $article->sub_detail_en = $request->sub_detail_en;
        $article->detail_th = $request->detail_th;
        $article->detail_en = $request->detail_en;
        $article->date = $request->date;
        $article->seo_keyword = json_encode($request->post('seo_keyword'));
        $article->seo_description = $request->seo_description;
        $article->slug = null;

        if ($article->save()) {

            //delete old images
            $medias = $article->getMedia('article');
            if (count($medias) > 0) {
                foreach ($medias as $media) {
                    if (!in_array($media->file_name, $request->input('image', []))) {
                        $media->delete();
                    }
                }
            }
            //end delete old images

            //add new images
            $i = 1;
            $medias = $article->getMedia('article')->pluck('file_name')->toArray();
            $medias_original_name = $request->input('image', []);

            foreach ($request->input('image', []) as $file) {
                if (count($medias) === 0 || !in_array($file, $medias)) {
                    $article->addMedia(storage_path('tmp/uploads/' . $file))
                        ->withCustomProperties(['order' => $i])
                        ->setName($medias_original_name[$i - 1])
                        ->toMediaCollection('article');
                } else {
                    $image = $article->getMedia('article')->where('file_name', $file)->first();
                    $image->setCustomProperty('order', $i);
                    $image->save();
                }
                $i++;
            }
            //end add new images

            toast('บันทึกข้อมูล', 'success');
            return redirect()->route('article.index');
        }

        Alert::error('บันทึกข้อมูลผิดพลาด');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ลบข้อมูลผิดพลาด';

        $article = Article::whereId($id)->first();

        $detail_th = $article->detail_th;
        $detail_en = $article->detail_en;
        $sub_detail_th = $article->sub_detail_th;
        $sub_detail_en = $article->sub_detail_en;

        $imgs = [];

        if ($detail_th || $detail_en || $sub_detail_th || $sub_detail_en) {
            $dom = new \domDocument;
            libxml_use_internal_errors(true);
            $dom->loadHTML($detail_th . $detail_en . $sub_detail_th . $sub_detail_en);
            $dom->preserveWhiteSpace = false;
            $imgs  = $dom->getElementsByTagName("img");
        }

        if ($article->delete()) {

            if ($imgs) {
                foreach ($imgs as $img) {
                    $data = explode("/", $img->getAttribute('src'));
                    unlink("uploads/ckeditor/" . $data[5]);
                }
            }

            $status = true;
            $msg = 'ลบข้อมูลเสร็จสิ้น';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function publish($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $article = Article::whereId($id)->first();
        if ($article->publish == 1) {
            $article->publish = 0;
        } else {
            $article->publish = 1;
        }

        if ($article->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }

    public function sort($id, Request $request)
    {
        $status = false;
        $message = 'ไม่สามารถบันทึกข้อมูลได้';

        $article = Article::whereId($id)->first();
        $article->sort = $request->data;
        $article->updated_at = Carbon::now();
        if ($article->save()) {
            $status = true;
            $message = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }
}

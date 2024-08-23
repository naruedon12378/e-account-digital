<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Image;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = ProductCategory::myCompany()->get();
            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    if ($data->getFirstMediaUrl('product_category')) {
                        $img = '<img src="' . asset($data->getFirstMediaUrl('product_category')) . '" style="width: auto; height: 40px;">';
                    } else {
                        $img = '<img src="' . asset('images/no-image.jpg') . '" style="width: auto; height: 40px;">';
                    }
                    return $img;
                })
                ->addColumn('product_type_name', function ($data) {
                    if( !empty($data->prodcut_type ))
                        return $data->prodcut_type->name_th;
                    return null;
                })
                // ->addColumn('status',function ($data){
                ->addColumn('isActive', function ($data) {
                    return $data->active_style;
                })
                ->addColumn('action', function ($data) {
                    return $data->btn_edit . ' ' . $data->btn_delete;
                })
                ->rawColumns(['image', 'product_type_name', 'isActive', 'action'])
                ->make(true);
        }

        $product_types = ProductType::where('company_id', Auth::user()->company_id)->get();
        return view('admin.product_category.index',
            ["product_types"=>$product_types]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryRequest $request)
    {

        return $this->_storeOrUpdate($request, null);
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
        $product_category = ProductCategory::find($id);
        $image = $product_category->getFirstMediaUrl('product_category');

        return response()->json(['product_category' => $product_category, 'image' => $image]);
    }

    public function update(ProductCategoryRequest $request, $id)
    {
        return $this->_storeOrUpdate($request, $id);
    }

    public function destroy($id)
    {
        $status = false;
        $msg = 'ไม่สามารถลบข้อมูลได้';

        $product_category = ProductCategory::find($id);
        if( !empty($product_category) ){
            if ($product_category->delete()) {

                $medias = $product_category->getMedia('product_category');
                if (count($medias) > 0) {
                    foreach ($medias as $media) {
                        $media->delete();
                    }
                }

                $status = true;
                $msg = 'ลบข้อมูลเรียบร้อย';
            }
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function toggleActive($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $product_category = ProductCategory::find($id);
        if ( !empty( $product_category) ) {
            $product_category->is_active = !$product_category->is_active;
            $product_category->save();

            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }

    private function _storeOrUpdate($request, $id){
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        if( !empty($id) && $id>0 ){
            $process = 'update';
            $product_category = ProductCategory::find($id);
        }else{
            $process = 'store';
            $product_category = new ProductCategory();
            $product_category->company_id = Auth::user()->company_id;
        }

        $product_category->product_type_id = $request->product_type_id;
        $product_category->code = @setParamEmptyIsNull($request->$request->code);
        $product_category->name_th = $request->name_th;
        $product_category->name_en = @setParamEmptyIsNull($request->name_en);
        $product_category->description = @setParamEmptyIsNull($request->description); ;
        $product_category->is_active = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);

        if( isset($request->cost_calculation_type) ){
            $product_category->cost_calculation_type = $request->cost_calculation_type;
        }

        if ($product_category->save()) {

            if ($request->hasFile('image')) {

                if( $process == 'update' ){
                    $medias = $product_category->getMedia('product_category');
                    if (count($medias) > 0) {
                        foreach ($medias as $media) {
                            $media->delete();
                        }
                    }
                }

                $file_image = $request->file('image');
                $extension = $file_image->getClientOriginalExtension();
                $image_name = $product_category->id.'_'.genRandCode(10).'.'.$extension;

                $product_category->addMedia($file_image)
                    ->usingFileName($image_name)
                    ->toMediaCollection('product_category');
            }

            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }
}

<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductTypeRequest;
use App\Models\ProductType;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = [];
        if ($request->ajax()) {
            $data = ProductType::myCompany()->get();
            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return $data->btn_edit . ' ' . $data->btn_delete;
                })
                ->addColumn('isActive', function ($data) {
                    return $data->active_style;
                })
                ->rawColumns(['action', 'isActive'])
                ->make(true);
        }
        return view('admin.product_type.index');
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
    public function store(ProductTypeRequest $request)
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
    public function edit(string $id)
    {
        $product_type = ProductType::find($id);
        return $product_type;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductTypeRequest $request, $id)
    {
        return $this->_storeOrUpdate($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ผิดพลาด';
        $product_type = ProductType::whereId($id)->first();
        if ($product_type->delete()) {
            $status = true;
            $msg = 'เสร็จสิ้น';
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function toggleActive($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $product_type = ProductType::find($id);
        if ( !empty( $product_type) ) {
            $product_type->is_active = !$product_type->is_active;
            $product_type->save();

            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }


    public function _storeOrUpdate($request, $id)
    {
        $data = $request->except('_token');
        $id = $request->id;
        $status = false;
        $msg = "";

        if ( !empty($id) ) {
            $product_type = ProductType::find($id);
            if( !empty($product_type) ){
                $product_type->update($data);
                $status = true;
                $msg = "Updated successfully";
            }else{
                $msg = "Data not found!";
            }
        } else {
            $product_type = new ProductType();
            $product_type->company_id =  Auth::user()->company_id;
            $product_type->code = $request->code;
            $product_type->name_th = $request->name_th;
            $product_type->name_en = $request->name_en;
            $product_type->description = $request->description;
            $product_type->save();
            $status = true;
            $msg = "Created successfully";
        }
        // Session::flash('success', $msg);

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    // public function sort($id, Request $request)
    // {
    //     $status = false;
    //     $message = 'ไม่สามารถบันทึกข้อมูลได้';

    //     $product_type = ProductType::whereId($id)->first();
    //     $product_type->sort = $request->data;
    //     $product_type->updated_at = Carbon::now();
    //     if ($product_type->save()) {
    //         $status = true;
    //         $message = 'บันทึกข้อมูลเรียบร้อย';
    //     }
    //     return response()->json(['status' => $status, 'message' => $message]);
    // }
}

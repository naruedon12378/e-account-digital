<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductComponentSetRequest;
use App\Models\Product;
use App\Models\ProductComponentSet;
use App\Models\ProductComponentSetItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;

class ProductComponentSetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data = [];
        if ($request->ajax()) {
            $data = ProductComponentSet::myCompany()
                ->with('product')
                ->withCount('items')
                ->get();

            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return $data->btnEdit. ' ' .$data->btn_delete;
                })
                ->addColumn('isActive', function ($data) {
                    return $data->active_style;
                })
                ->rawColumns(['action', 'isActive'])
                ->make(true);
        }
        return view('admin.product_set.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product_set = (object) [
            'price_parent_show' => true,
            'price_child_show' => true,
        ];
        $product_parent_id = null;
        $selected_products = null;
        $product_amounts = [];

        $products = Product::myCompany()
            ->where('is_active', true)
            ->get();

        $product_options = getProductOptions();

        $action = 'create';
        // $form_action = route('productset.store');

        return view('admin.product_set.edit', compact('action', 'products', 'product_options', 'product_set', 'product_parent_id', 'selected_products', 'product_amounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductComponentSetRequest $request)
    {
        return $this->_storeOrUpdate($request, null);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product_parent_id = null;
        $selected_products = [];
        $product_amounts = [];

        // $products = Product::myCompany()
        //     ->where('is_active', true)
        //     ->get();
        $product_options = getProductOptions();

        $product_set = ProductComponentSet::myCompany()
            ->where('id', $id)
            ->with('product')
            ->with('items')
            ->first();

        if( !empty($product_set) ){
            $product_parent_id = $product_set->product_id;
        }

        $action = 'edit';
        // $form_action = route('productset.update', ['productset' => $id]);

        return view('admin.product_set.edit', compact('action', 'product_options', 'product_set', 'product_parent_id', 'selected_products', 'product_amounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductComponentSetRequest $request, $id)
    {
        return $this->_storeOrUpdate($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $status = false;
        // $msg = 'ผิดพลาด';
        // $product_type = ProductType::whereId($id)->first();
        // if ($product_type->delete()) {
        //     $status = true;
        //     $msg = 'เสร็จสิ้น';
        // }
        // return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function _storeOrUpdate($request, $id)
    {
        // $data = $request->except('_token');
        $status = false;
        $message = "";
        $errors = [];
        $process = 'create';
        $chk_valid = true;

        //check duplicate product_id
        $check_product_ids = [$request->product_parent_id];
        foreach( $request->selected_products as $key =>  $selected_product_id ){
            if( in_array($selected_product_id, $check_product_ids) ){
                $chk_valid = false;
                $message = 'สินค้าไม่สามารถซ้ำกันได้';
                $errors[] = setInputError('selected_products.'.$key, $message);
            }
            $check_product_ids[] = $check_product_ids;
        }


        if(!$chk_valid){

        }else{

            try{

                // $product_set_id_deletes = [];
                if( !empty($id) ){

                    $product_set = ProductComponentSet::myCompany()
                        ->where('id', $id)
                        ->first();

                    $process = 'edit';
                }else{
                    $product_set = new ProductComponentSet();
                    $product_set->company_id =  Auth::user()->company_id;
                    $product_set->is_active = true;
                    $product_set->amount = 1;
                }

                $product_set->product_id =  $request->product_parent_id;
                $product_set->show_parent_price =  filter_var($request->show_parent_price, FILTER_VALIDATE_BOOLEAN);
                $product_set->show_child_price =  filter_var($request->show_child_price, FILTER_VALIDATE_BOOLEAN);
                $product_set->user_creator_id =  Auth::user()->id;
                $product_set->save();

                if( !empty($product_set->id) ){

                    $product_set_item_id_deletes = ProductComponentSetItem::where('product_component_set_id', $product_set->id)
                        ->pluck('id')
                        ->toArray();

                    foreach( $request->selected_products as $index => $product_id){

                        $product_set_item = ProductComponentSetItem::where('product_component_set_id', $product_set->id)
                            ->where('product_id', $product_id)
                            ->first();

                        if ( !empty($product_set_item) ) {
                            if( isset($product_set_item_id_deletes) ){
                                if (($key = array_search($product_set_item->id, $product_set_item_id_deletes)) !== false) {
                                    unset($product_set_item_id_deletes[$key]);
                                }
                            }
                        }else{
                            $product_set_item = new ProductComponentSetItem();
                            $product_set_item->product_component_set_id =  $product_set->id;
                            $product_set_item->product_id =  $product_id;
                        }

                        $product_set_item->amount =  $request->product_amounts[$index];
                        $product_set_item->save();

                    }

                    if( isset($product_set_item_id_deletes) && count($product_set_item_id_deletes) > 0){
                        ProductComponentSetItem::whereIn('id', $product_set_item_id_deletes)->delete();
                    }

                    $status = true;
                    if( $process == 'edit'){
                        $message = 'แก้ไขข้อมูลเรียบร้อย';
                    }else{
                        $message = 'เพิ่มข้อมูลเรียบร้อย';
                    }

                    return response()->json(['status' => $status, 'msg' => $message, 'redirect' => route('productset.index')]);
                }

            } catch (\Exception $e) {
                $message = $e->getMessage();
                $errors[] = setInputError('all', $message);
            }

        }

        return response()->json(['status' => $status, 'input_errors' =>$errors, 'msg' => $message], 400);
    }

    public function toggleActive($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $product_set = ProductComponentSet::find($id);
        if ( !empty( $product_set) ) {
            $product_set->is_active = !$product_set->is_active;
            $product_set->save();

            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}

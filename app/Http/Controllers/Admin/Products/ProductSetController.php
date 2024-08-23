<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSetRequest;
use App\Models\Product;
use App\Models\ProductSet;
use App\Models\ProductSetItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;

class ProductSetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data = [];
        if ($request->ajax()) {
            $data = ProductSet::myCompany()
                ->withCount('items')
                ->get();

            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return $data->btnDuplicate.' '.$data->btnEdit.' '.$data->btn_delete;
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
    public function create(Request $request)
    {

        $action = 'create';

        $product_set = (object) [
            'code' => null,
            'name_th' => null,
            'name_en' => null,
            'sale_price' => null,
            'description' => null,
            'show_set_price' => true,
            'show_item_price' => true,
            'items' => [],
        ];

        if( !empty($request->dupid) ){
            $product_set_query = ProductSet::myCompany()
            ->where('id', $request->dupid)
            ->with('items')
            ->first();
            if( !empty($product_set_query) ){
                $product_set->name_th = $product_set_query->name_th.' (คัดลอก)';
                if( !empty($product_set_query->name_en) )
                    $product_set->name_en = $product_set_query->name_en.' (คัดลอก)';
                $product_set->sale_price = $product_set_query->sale_price;
                $product_set->show_set_price = $product_set_query->show_set_price;
                $product_set->show_item_price = $product_set_query->show_item_price;
                $product_set->description = $product_set_query->description;
                $product_set->items = $product_set_query->items;
            }

            $action = 'duplicate';
        }

        $product_parent_id = null;
        $selected_products = null;
        $product_amounts = [];

        $product_options = getProductOptions();

        // $form_action = route('productset.store');

        return view('admin.product_set.edit', compact('action', 'product_options', 'product_set', 'product_parent_id', 'selected_products', 'product_amounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductSetRequest $request)
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

        $product_set = ProductSet::myCompany()
            ->where('id', $id)
            ->with('items')
            ->first();

        $action = 'edit';
        // $form_action = route('productset.update', ['productset' => $id]);

        return view('admin.product_set.edit', compact('action', 'product_options', 'product_set', 'product_parent_id', 'selected_products', 'product_amounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductSetRequest $request, $id)
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
        $product_set = ProductSet::whereId($id)->first();
        if ($product_set->delete()) {
            $status = true;
            $msg = 'ทำการลบข้อมูลเสร็จสิ้น';
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
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
        $check_product_ids = [];
        foreach( $request->selected_products as $key =>  $selected_product_id ){
            if( in_array($selected_product_id, $check_product_ids) ){
                $chk_valid = false;
                $message = 'สินค้าไม่สามารถซ้ำกันได้';
                $errors[] = setInputError('selected_products.'.$key, $message);
            }
            $check_product_ids[] = $selected_product_id;
        }

        if(!$chk_valid){

        }else{

            try{

                // $product_set_id_deletes = [];
                if( !empty($id) ){

                    $product_set = ProductSet::myCompany()
                        ->where('id', $id)
                        ->first();

                    $process = 'edit';
                }else{
                    $product_set = new ProductSet();
                    $product_set->company_id =  Auth::user()->company_id;
                    $product_set->is_active = true;
                    $product_set->user_creator_id =  Auth::user()->id;
                }

                $product_set->code =  $request->code;
                $product_set->name_th =  $request->name_th;
                $product_set->name_en =  @setParamEmptyIsNull($request->name_en);
                $product_set->sale_price =  @setParamEmptyIsNull($request->sale_price, 0);
                $product_set->description =  @setParamEmptyIsNull($request->description);
                $product_set->show_set_price =  filter_var($request->show_set_price, FILTER_VALIDATE_BOOLEAN);
                $product_set->show_item_price =  filter_var($request->show_item_price, FILTER_VALIDATE_BOOLEAN);
                $product_set->save();

                if( !empty($product_set->id) ){

                    $product_set_item_id_deletes = ProductSetItem::where('product_set_id', $product_set->id)
                        ->pluck('id')
                        ->toArray();

                    foreach( $request->selected_products as $index => $product_id){

                        $product_set_item = ProductSetItem::where('product_set_id', $product_set->id)
                            ->where('product_id', $product_id)
                            ->first();

                        if ( !empty($product_set_item) ) {
                            if( isset($product_set_item_id_deletes) ){
                                if (($key = array_search($product_set_item->id, $product_set_item_id_deletes)) !== false) {
                                    unset($product_set_item_id_deletes[$key]);
                                }
                            }
                        }else{
                            $product_set_item = new ProductSetItem();
                            $product_set_item->product_set_id =  $product_set->id;
                            $product_set_item->product_id =  $product_id;
                        }

                        $product_set_item->amount =  $request->product_amounts[$index];
                        $product_set_item->save();

                    }

                    if( isset($product_set_item_id_deletes) && count($product_set_item_id_deletes) > 0){
                        ProductSetItem::whereIn('id', $product_set_item_id_deletes)->delete();
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

        $product_set = ProductSet::find($id);
        if ( !empty( $product_set) ) {
            $product_set->is_active = !$product_set->is_active;
            $product_set->save();

            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}

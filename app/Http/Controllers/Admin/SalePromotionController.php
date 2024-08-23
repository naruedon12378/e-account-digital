<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalePromotionRequest;
use App\Models\Product;
use App\Models\ProductSet;
use App\Models\ProductSetItem;
use App\Models\SalePromotion;
use App\Models\SalePromotionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use DateTime;

class SalePromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data = [];
        if ($request->ajax()) {
            $data = SalePromotion::myCompany()
                ->withCount('items')
                ->get();

            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return $data->btnEdit.' '.$data->btn_delete;
                })
                ->addColumn('isActive', function ($data) {
                    return $data->active_style;
                })
                ->rawColumns(['action', 'isActive'])
                ->make(true);
        }
        return view('admin.sale_promotion.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $action = 'create';

        $sale_promotion = (object) [
            'code' => null,
            'name_th' => null,
            'name_en' => null,
            'description' => null,
            'discount_percent' => null,
            'discount_price' => null,
            'discount_limit' => null,
            'discount_type' => 'percent',
            'start_date' => null,
            'end_date' => null,
            'items' => [],
        ];

        $product_options = getProductOptions();
        $condition_options = [];//collect(SalePromotion::coditions);
        foreach( SalePromotion::coditions as $coditions){
            $condition_options[$coditions['value']] = __('sale_promotion.'.$coditions['value']).'('.$coditions['symbol'].')';
        }

        return view('admin.sale_promotion.edit', compact('action', 'product_options', 'sale_promotion', 'condition_options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalePromotionRequest $request)
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
        $action = 'edit';

        $sale_promotion = SalePromotion::where('id', $id)
            ->myCompany()
            ->with('items')
            ->first();

        if( !empty($sale_promotion) ){
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s',$sale_promotion->start_date);
            if( $dateTime )
                $sale_promotion->start_date = $dateTime->format('dmY');
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s',$sale_promotion->end_date);
            if( $dateTime )
                $sale_promotion->end_date = $dateTime->format('dmY');
        }else{
            SalePromotion::error('ไม่พบข้อมูล');
            return redirect()->back();
        }

        $product_options = getProductOptions();
        $condition_options = [];//collect(SalePromotion::coditions);
        foreach( SalePromotion::coditions as $coditions){
            $condition_options[$coditions['value']] = __('sale_promotion.'.$coditions['value']).'('.$coditions['symbol'].')';
            // $condition_options[$coditions['value']] = $coditions['label'].'('.$coditions['symbol'].')';
        }

        return view('admin.sale_promotion.edit', compact('action', 'product_options', 'sale_promotion', 'condition_options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalePromotionRequest $request, $id)
    {
        return $this->_storeOrUpdate($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ไม่สามารถลบข้อมูลได้';
        $sale_promotion = SalePromotion::myCompany()->where('id', $id)->first();
        if ( !empty($sale_promotion) && $sale_promotion->delete()) {
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

                if( !empty($id) ){

                    $sale_promotion = SalePromotion::myCompany()
                        ->where('id', $id)
                        ->first();

                    $process = 'edit';
                }else{
                    $sale_promotion = new SalePromotion();
                    $sale_promotion->company_id =  Auth::user()->company_id;
                    $sale_promotion->is_active = true;
                    $sale_promotion->user_creator_id =  Auth::user()->id;
                }

                $discount_type = 'percent';
                $discount_percent = 0;
                $discount_price = 0;
                $discount_limit = 0;
                if( isset($request->discount_type) && $request->discount_type=='percent' ){
                    $discount_percent =  @setParamEmptyIsNull($request->discount_percent, 0);
                    $discount_limit =  @setParamEmptyIsNull($request->discount_limit, 0);
                }else{
                    $discount_price = @setParamEmptyIsNull($request->discount_price, 0);
                    $discount_type = 'price';
                }

                $start_date = null;
                $end_date = null;
                if( isset($request->start_date) )
                    $start_date = DateTime::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
                if( isset($request->end_date) )
                    $end_date = DateTime::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');

                $sale_promotion->code =  $request->code;
                $sale_promotion->name_th =  $request->name_th;
                $sale_promotion->name_en =  @setParamEmptyIsNull($request->name_en);
                $sale_promotion->discount_type =  $discount_type;
                $sale_promotion->discount_percent = $discount_percent;
                $sale_promotion->discount_price =  $discount_price;
                $sale_promotion->discount_limit =  $discount_limit;
                $sale_promotion->description =  @setParamEmptyIsNull($request->description);
                $sale_promotion->start_date =  $start_date;
                $sale_promotion->end_date =  $end_date;
                $sale_promotion->save();

                if( !empty($sale_promotion->id) ){

                    $sale_promotion_item_id_deletes = SalePromotionItem::where('sale_promotion_id', $sale_promotion->id)
                        ->pluck('id')
                        ->toArray();

                    foreach( $request->selected_products as $index => $product_id){

                        $sale_promotion_item = SalePromotionItem::where('sale_promotion_id', $sale_promotion->id)
                            ->where('product_id', $product_id)
                            ->first();

                        if ( !empty($sale_promotion_item) ) {
                            if( isset($sale_promotion_item_id_deletes) ){
                                if (($key = array_search($sale_promotion_item->id, $sale_promotion_item_id_deletes)) !== false) {
                                    unset($sale_promotion_item_id_deletes[$key]);
                                }
                            }
                        }else{
                            $sale_promotion_item = new SalePromotionItem();
                            $sale_promotion_item->sale_promotion_id =  $sale_promotion->id;
                            $sale_promotion_item->product_id =  $product_id;
                        }

                        $sale_promotion_item->condition_key =  $request->product_conditions[$index];
                        $sale_promotion_item->amount =  $request->product_amounts[$index];
                        $sale_promotion_item->save();

                    }

                    if( isset($sale_promotion_item_id_deletes) && count($sale_promotion_item_id_deletes) > 0){
                        SalePromotionItem::whereIn('id', $sale_promotion_item_id_deletes)->delete();
                    }

                    $status = true;
                    if( $process == 'edit'){
                        $message = 'แก้ไขข้อมูลเรียบร้อย';
                    }else{
                        $message = 'เพิ่มข้อมูลเรียบร้อย';
                    }

                    return response()->json(['status' => $status, 'msg' => $message, 'redirect' => route('salepromo.index')]);
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

        $sale_promotion = SalePromotion::find($id);
        if ( !empty( $sale_promotion) ) {
            $sale_promotion->is_active = !$sale_promotion->is_active;
            $sale_promotion->save();

            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}

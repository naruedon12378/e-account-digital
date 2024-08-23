<?php

namespace App\Http\Controllers\Admin\Warehouses;

use App\Http\Controllers\Controller;
use App\Http\Requests\warehouse\InventoryLotRequest;
use App\Models\Inventory;
use App\Models\InventoryLot;
use App\Models\InventoryLotItem;
use App\Models\InventoryLotAdjustment;
use App\Models\InventoryLotAdjustmentItem;
use App\Models\InventoryStock;
use App\Models\Product;
use App\Models\Warehouse;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class InventoryLotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $builder = InventoryLot::myCompany()->whereHas('warehouse', function($q){
                $q->where('company_id', Auth::user()->company_id);
            });
            if( !empty($request->warehouse_id) ){
                $builder->where('warehouse_id', $request->warehouse_id);
            }
            $data = $builder->with('warehouse.branch','inventory_lot_items')->get();

            return DataTables::make($data)
            ->addIndexColumn()
            ->addColumn('date', function ($data) {
                return DateTime::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d/m/Y');
            })
            ->addColumn('import_date', function ($data) {
                return DateTime::createFromFormat('Y-m-d', $data->import_date)->format('d/m/Y');
            })
            ->addColumn('btn', function ($data) {
                $btn = $data->btn_approve . ' ' . $data->btn_adjust_stock;
                return $btn;
            })
            ->addColumn('warehouse_name', function ($data) {
                if(!empty($data->warehouse))
                    return $data->warehouse->name_th;
                return null;
            })
            ->addColumn('branch_name', function ($data) {
                if(!empty($data->warehouse->branch))
                    return $data->warehouse->branch->name;
                return null;
            })
            ->editColumn('product_amount', function ($data) {
                $amount = 0;
                if( !empty($data->inventory_lot_items) )
                    $amount = count($data->inventory_lot_items);
                return number_format( $amount, 2);
            })
            ->editColumn('adjustment_count', function ($data) {
                $amount = 0;
                if( !empty($data->inventory_lot_adjustments) )
                    $amount = count($data->inventory_lot_adjustments);
                return number_format( $amount);
            })
            ->addColumn('status', function ($data) {
                if ($data['status'] === 'pending') {
                    $status = '<span class="badge badge-warning">รออนุมัติ</span>';
                } elseif ($data['status'] === 'approve') {
                    $status = '<span class="badge badge-success">อนุมัติ</span>';
                } else {
                    $status = '<span class="badge badge-danger">ยกเลิก</span>';
                }
                return $status;
            })
            ->rawColumns([ 'warehouse_name','product_name', 'btn' , 'status'])
            ->make(true);
        }
        $products = Product::myCompany()->get();
        $warehouses = Warehouse::myCompany()->where('is_active', 1)->get();
        $warehouse_id = @setParamEmptyIsNull($request->whid);
        return view('admin.warehouse.inventory_lot.index',compact('products','warehouses', 'warehouse_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){

        $inventory_lot = new InventoryLot();
        if( isset($request->whid) && $request->whid > 0){
            $inventory_lot->warehouse_id = $request->whid;
        }

        $warehouse_options = getWarehouseOptions();
        $product_options = getProductOptions();

        return view('admin.warehouse.inventory_lot.create', compact('inventory_lot', 'warehouse_options', 'product_options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventoryLotRequest $request)
    {
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

                $inventory_lot = new InventoryLot();
                $inventory_lot->company_id =  Auth::user()->company_id;
                $inventory_lot->user_creator_id =  Auth::user()->id;
                $inventory_lot->warehouse_id =  $request->warehouse_id;
                $inventory_lot->lot_number =  $request->lot_number;
                $inventory_lot->description =  @setParamEmptyIsNull($request->description);

                if( isset($request->import_date) )
                    $inventory_lot->import_date = DateTime::createFromFormat('d/m/Y', $request->import_date)->format('Y-m-d');
                if( isset($request->expiry_date) )
                    $inventory_lot->expiry_date = DateTime::createFromFormat('d/m/Y', $request->expiry_date)->format('Y-m-d');

                if( $inventory_lot->save()  ){

                    foreach( $request->selected_products as $index => $product_id){

                        $inventory = Inventory::where('company_id', $inventory_lot->company_id)
                            ->where('warehouse_id', $inventory_lot->warehouse_id)
                            ->where('product_id',$product_id)
                            ->first();
                        if( empty($inventory) ){
                            $inventory = new Inventory();
                            $inventory->company_id =  $inventory_lot->company_id;
                            $inventory->user_creator_id =  $inventory_lot->user_creator_id;
                            $inventory->warehouse_id = $inventory_lot->warehouse_id;
                            $inventory->product_id = $product_id;
                            $inventory->save();
                        }
                        
                        $amount = $request->product_amounts[$index];

                        $inventory_lot_item = new InventoryLotItem();
                        $inventory_lot_item->inventory_id =  $inventory->id;
                        $inventory_lot_item->inventory_lot_id =  $inventory_lot->id;
                        $inventory_lot_item->product_id =  $product_id;
                        $inventory_lot_item->add_amount =  $amount;
                        $inventory_lot_item->remaining_amount =  $amount;
                        $inventory_lot_item->cost_price =  $request->product_cost_prices[$index];
                        $inventory_lot_item->save();

                    }

                    $status = true;
                    $message = 'แก้ไขข้อมูลเรียบร้อย';

                    return response()->json(['status' => $status, 'msg' => $message, 'redirect' => route('inventorylot.index')]);
                    // return response()->json(['status' => $status, 'msg' => $message, 'table_not_reload'=> true]);
                }

            } catch (\Exception $e) {
                $message = $e->getMessage();
                $errors[] = setInputError('all', $message);
            }

        }

        return response()->json(['status' => $status, 'input_errors' =>$errors, 'msg' => $message], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inventory_lot = InventoryLot::myCompany()->where('id', $id)
            ->with('warehouse.branch')
            ->with('inventory_lot_items.product')
            ->with('user_creator')
            ->with('inventory_lot_adjustments',function ($query) {
                $query->whereHas('inventory_lot_adjustment_items')
                    ->with('user_creator','inventory_lot_adjustment_items.product')
                    ->orderBy('created_at','asc');
            })
            ->first();

        $user_editor_name = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $user_creator_name = $inventory_lot->user_creator->firstname . ' ' . $inventory_lot->user_creator->lastname;

        $lang = app()->getLocale();
        if( $lang == 'th' ){
            $inventory_lot->warehouse->name = $inventory_lot->warehouse->name_th;
        }else{
            $inventory_lot->warehouse->name = $inventory_lot->warehouse->name_en;
        }

        foreach($inventory_lot->inventory_lot_items as $inventory_lot_item){

            if( $lang == 'th' ){
                $inventory_lot_item->product->name = $inventory_lot_item->product->name_th;
            }else{
                $inventory_lot_item->product->name = $inventory_lot_item->product->name_en;
            }
        }

        $inventory_lot->editing_round = $inventory_lot->inventory_lot_adjustments->count();

        foreach ($inventory_lot->inventory_lot_adjustments as  $inventory_lot_adjustment){
            $inventory_lot_adjustment->user_editor_name = $inventory_lot_adjustment->user_creator->firstname . ' '. $inventory_lot_adjustment->user_creator->lastname;

            foreach($inventory_lot_adjustment->inventory_lot_adjustment_items as $inventory_lot_adjustment_item){

                if( $lang == 'th' ){
                    $inventory_lot_adjustment_item->product->name = $inventory_lot_adjustment_item->product->name_th;
                }else{
                    $inventory_lot_adjustment_item->product->name = $inventory_lot_adjustment_item->product->name_en;
                }
            }
        }

        return view('admin.warehouse.inventory_lot.view', compact('inventory_lot','user_editor_name','user_creator_name'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventory_lot = InventoryLot::myCompany()->where('id', $id)
            ->with('warehouse.branch')
            ->with('inventory_lot_items.product')
            ->with('user_creator')
            ->first();

        $user_editor_name = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $user_creator_name = $inventory_lot->user_creator->firstname . ' ' . $inventory_lot->user_creator->lastname;

        $lang = app()->getLocale();
        if( $lang == 'th' ){
            $inventory_lot->warehouse->name = $inventory_lot->warehouse->name_th;
        }else{
            $inventory_lot->warehouse->name = $inventory_lot->warehouse->name_en;
        }

        foreach($inventory_lot->inventory_lot_items as $inventory_lot_item){

            if( $lang == 'th' ){
                $inventory_lot_item->product->name = $inventory_lot_item->product->name_th;
            }else{
                $inventory_lot_item->product->name = $inventory_lot_item->product->name_en;
            }
        }

        $inventory_lot->editing_round = InventoryLotAdjustment::where('inventory_lot_id', $inventory_lot->id)->count() + 1;

        return view('admin.warehouse.inventory_lot.edit', compact('inventory_lot','user_editor_name','user_creator_name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InventoryLotRequest $request, string $id)
    {
        $status = false;
        $message = "";
        $errors = [];
        $chk_valid = true;

        $inventory_lot = InventoryLot::myCompany()->where("id", $id)->with('inventory_lot_items')->first();
        if( !empty($inventory_lot) ){

            $update_amounts = [];
            foreach($inventory_lot->inventory_lot_items as $index => $inventory_lot_item){
                $product_add_amount = $request->product_add_amounts[$index];
                $product_minus_amount = $request->product_minus_amounts[$index];

                if( !empty($product_add_amount) || !empty($product_minus_amount) ){
                    if( $product_add_amount>0 && $product_minus_amount>0 ){
                        $chk_valid = false;
                        $message = 'เลือกเปลี่ยนจำนวนได้เพียง 1 ประเภท';
                        $errors[] = setInputError('product_add_amounts.'.$index, $message);
                    }
                    elseif( $product_minus_amount > $inventory_lot_item->remaining_amount){
                        $chk_valid = false;
                        $message = 'จำนวนต้องไม่เกินกว่าจำนวนคงเหลือ';
                        $errors[] = setInputError('product_minus_amounts.'.$index, $message);
                    }

                    $update_amounts[] = [
                        'inventory_lot_item_id' => $inventory_lot_item->id,
                        'product_id' => $inventory_lot_item->product_id,
                        'add_amount' => $product_add_amount,
                        'minus_amount' => $product_minus_amount,
                    ];
                }
            }

            if( count($update_amounts) == 0 ){
                $chk_valid = false;
                $message = 'ไม่มีรายการสินค้าที่แก้ไข';
                $errors[] = setInputError('value_empty', $message);
            }

            if(!$chk_valid){
            }else{

                try{

                    
                    $inventory_lot_adjustment = new InventoryLotAdjustment();
                    $inventory_lot_adjustment->company_id =  $inventory_lot->company_id;
                    $inventory_lot_adjustment->warehouse_id =  $inventory_lot->warehouse_id;
                    $inventory_lot_adjustment->inventory_lot_id =  $inventory_lot->id;
                    $inventory_lot_adjustment->user_creator_id =  Auth::user()->id;
                    $inventory_lot_adjustment->remark = $request->remark;
                    $inventory_lot_adjustment->status = 'pending';

                    // if( isset($request->import_date) )
                    //     $inventory_lot->import_date = DateTime::createFromFormat('d/m/Y', $request->import_date)->format('Y-m-d');
                    // if( isset($request->expiry_date) )
                    //     $inventory_lot->expiry_date = DateTime::createFromFormat('d/m/Y', $request->expiry_date)->format('Y-m-d');

                    if( $inventory_lot_adjustment->save()  ){

                        // InventoryLotAdjustment::myCompany()->where('inventory_lot_id',$inventory_lot->id)->where('id','!=',$inventory_lot_adjustment->id)->update([
                        //     'status' => 'cancel',
                        // ]);

                        foreach( $update_amounts as $index => $update_amount){

                            $inventory_lot_adjustment_item = new InventoryLotAdjustmentItem();
                            $inventory_lot_adjustment_item->inventory_lot_adjustment_id =  $inventory_lot_adjustment->id;
                            $inventory_lot_adjustment_item->inventory_lot_item_id =  $update_amount['inventory_lot_item_id'];
                            $inventory_lot_adjustment_item->product_id =  $update_amount['product_id'];
                            $inventory_lot_adjustment_item->add_amount = $update_amount['add_amount'];
                            $inventory_lot_adjustment_item->minus_amount = $update_amount['minus_amount'];
                            $inventory_lot_adjustment_item->save();
                        }

                        $status = true;
                        $message = 'ปรับแก้ข้อมูลเรียบร้อย';

                        return response()->json(['status' => $status, 'msg' => $message, 'table_not_reload'=> true, 'redirect' => route('inventorylot.index')]);
                    }

                } catch (\Exception $e) {
                    $message = $e->getMessage();
                    $errors[] = setInputError('all', $message);
                }
            }
        }
        

        return response()->json(['status' => $status, 'input_errors' =>$errors, 'msg' => $message], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $lot_id)
    {
        $status = false;
        $message = "";
        $errors = [];

        try {
            
            $inventory_lot = InventoryLot::myCompany()->where("id", $lot_id)
                ->where("status", 'pending')
                ->first();

            if( !empty($inventory_lot) ){

                InventoryLotAdjustment::where("inventory_lot_id", $inventory_lot->id)
                    ->where("status", 'pending')->update(['status' => 'cancel']);

                $inventory_lot->status = 'cancel';
                $inventory_lot->save();
                $message = 'ทำการยกเลิกรายการเรียบร้อย';
                $status = true;
                return response()->json(['status' => $status, 'message' => $message]);

            }else{
                $message = 'ไม่พบรายการที่ต้องการแก้ไข';
                $errors[] = setInputError('not_found', $message);
            }

        }catch (\Exception $e) {
            $message = $e->getMessage();
            $errors[] = setInputError('all', $message);
        }

        return response()->json(['status' => $status, 'errors' =>$errors, 'message' => $message], 400);
    }

    public function showApprove(string $id)
    {
        
    }

    public function approveAdjustment(int $lot_id, int $adjustment_id){

        $status = false;
        $message = "";
        $errors = [];

        try {
            
            $inventory_lot_adjustment = InventoryLotAdjustment::where("id", $adjustment_id)
                ->where("status", 'pending')
                ->whereHas('inventory_lot', function ($query) use ($lot_id) {
                    $query->where('id', $lot_id)->myCompany();
                })
                ->with('inventory_lot_adjustment_items')
                ->first();

            if( !empty($inventory_lot_adjustment) ){

                $data_updates = [];
                foreach( $inventory_lot_adjustment->inventory_lot_adjustment_items as $inventory_lot_adjustment_item){

                    $amount = 0;
                    if ( $inventory_lot_adjustment_item->add_amount > 0 ){
                        $amount = $inventory_lot_adjustment_item->add_amount;
                    }
                    elseif($inventory_lot_adjustment_item->minus_amount > 0){
                        $amount = -$inventory_lot_adjustment_item->minus_amount;
                    }

                    if( $amount!==0 ){
                        $inventory_lot_item = InventoryLotItem::where('id', $inventory_lot_adjustment_item->inventory_lot_item_id)->first();
                        if( !empty($inventory_lot_item) && ($inventory_lot_item->remaining_amount += $amount) >= 0 ){
                            $data_updates[] = [
                                'lot_item_id' => $inventory_lot_item->id,
                                'amount' => $amount,
                            ];
                        }
                    }
                }

                if( count($data_updates) > 0){

                    foreach( $data_updates as $data_update ){
                        $inventory_lot_item = InventoryLotItem::where('id', $data_update['lot_item_id'])->first();
                        $inventory_lot_item->adjust_amount += $data_update['amount'];
                        $inventory_lot_item->remaining_amount += $data_update['amount'];
                        $inventory_lot_item->save();
                    }

                    $inventory_lot_adjustment->status = 'approve';
                    $inventory_lot_adjustment->save();
                    $status = true;
                    $message = 'ทำการอนุม้ติรายการเรียบร้อย';

                    return response()->json(['status' => $status, 'message' => $message]);
                }else{
                    $message = 'บางรายการ ไม่สามาลบจำนวนออกเกินจำนวนที่มีได้';
                }
                
            }else{
                $message = 'ไม่พบรายการที่ต้องการแก้ไข';
                $errors[] = setInputError('not_found', $message);
            }
        }catch (\Exception $e) {
            $message = $e->getMessage();
            $errors[] = setInputError('all', $message);
        }

        return response()->json(['status' => $status, 'errors' =>$errors, 'message' => $message], 400);
    }

    public function cancelAdjustment(int $lot_id, int $adjustment_id){

        $status = false;
        $message = "";
        $errors = [];

        try {

            $inventory_lot_adjustment = InventoryLotAdjustment::where("id", $adjustment_id)
                ->where("status", 'pending')
                ->whereHas('inventory_lot', function ($query) use ($lot_id) {
                    $query->where('id', $lot_id)->myCompany();
                })
                ->first();

            if( !empty($inventory_lot_adjustment) ){

                $inventory_lot_adjustment->status = 'cancel';
                $inventory_lot_adjustment->save();

                $status = true;
                $message = 'ทำการยกเลิกรายการแก้ไขแล้ว';
                return response()->json(['status' => $status, 'message' => $message]);
            }else{
                $message = 'ไม่พบรายการที่ต้องการแก้ไข';
                $errors[] = setInputError('not_found', $message);
            }

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $errors[] = setInputError('all', $message);
        }

        return response()->json(['status' => $status, 'errors' =>$errors, 'message' => $message], 400);
    }

    public function approveLot(int $lot_id){

        $status = false;
        $message = "";
        $errors = [];

        try {
            
            $inventory_lot = InventoryLot::myCompany()->where("id", $lot_id)
                ->where("status", 'pending')
                ->with('inventory_lot_items')
                ->first();

            if( !empty($inventory_lot) ){

                // add product data to stock
                foreach( $inventory_lot->inventory_lot_items as $inventory_lot_item ){
                    
                    //add inventory stock
                    $inventory_stock = new InventoryStock();
                    // $inventory_stock->company_id = $inventory_lot->company_id;
                    $inventory_stock->inventory_id = $inventory_lot_item->inventory_id;
                    $inventory_stock->order_id = $inventory_lot->id;
                    $inventory_stock->order_item_id = $inventory_lot_item->id;
                    $inventory_stock->transaction = 'lot';
                    $inventory_stock->lot_number = $inventory_lot->lot_number;
                    $inventory_stock->add_amount = $inventory_lot_item->add_amount;
                    // $inventory_stock->used_amount = 0;
                    $inventory_stock->remaining_amount = $inventory_lot_item->add_amount;
                    $inventory_stock->cost_price = $inventory_lot_item->cost_price;
                    $inventory_stock->user_creator_id = Auth::user()->id;
                    $inventory_stock->remark = null;
                    if($inventory_stock->save()){
                        //update inventory product
                        $inventory = Inventory::where('id', $inventory_lot_item->inventory_id)->first();
                        $inventory->amount += $inventory_lot_item->add_amount;
                        $inventory->save();
                    }
                }

                //cancel all edit request
                InventoryLotAdjustment::where("inventory_lot_id", $inventory_lot->id)
                    ->where("status", 'pending')->update(['status' => 'cancel']);

                $inventory_lot->status = 'approve';
                $inventory_lot->user_approver_id = Auth::user()->id;
                $inventory_lot->save();
                $status = true;
                $message = 'ทำการอนุม้ติรายการเรียบร้อย';

                return response()->json(['status' => $status, 'message' => $message]);
                
            }else{
                $message = 'ไม่พบรายการที่ต้องการแก้ไข';
                $errors[] = setInputError('not_found', $message);
            }
        }catch (\Exception $e) {
            $message = $e->getMessage();
            $errors[] = setInputError('all', $message);
        }

        return response()->json(['status' => $status, 'errors' =>$errors, 'message' => $message], 400);
    }
    
}

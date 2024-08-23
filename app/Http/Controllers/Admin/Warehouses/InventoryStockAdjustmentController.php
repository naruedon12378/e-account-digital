<?php

namespace App\Http\Controllers\Admin\Warehouses;
use App\Http\Controllers\Controller;
use App\Http\Requests\warehouse\InventoryStockAdjustmentRequest;
use App\Models\Inventory;
use App\Models\InventoryStock;
use App\Models\InventoryStockAdjustment;
use App\Models\InventoryStockAdjustmentItem;
use App\Models\Product;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use DateTime;

class InventoryStockAdjustmentController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $builder = InventoryStockAdjustment::myCompany();
            if( !empty($request->warehouse_id) ){
                $builder->where('warehouse_id', $request->warehouse_id);
            }
            $datas = $builder->with('warehouse.branch','inventory_stock','inventory_stock_adjustment_item')->get();

            $inventoryStockHistoryController = new InventoryStockHistoryController();
            foreach( $datas as $data ){
                $data->inventory_stock = $inventoryStockHistoryController->_setTransaction($data->inventory_stock);
            }

            return DataTables::make($datas)
            ->addIndexColumn()
            ->addColumn('date', function ($data) {
                return DateTime::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d/m/Y');
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
            ->addColumn('transaction_name', function ($data) {
                return $data->inventory_stock->transaction_data->name;
            })
            ->addColumn('document_code', function ($data) {
                return $data->inventory_stock->transaction_data->code;
            })
            ->editColumn('remaining_amount', function ($data) {
                return number_format( $data->inventory_stock->remaining_amount ,2);
            })
            ->editColumn('adjust_amount', function ($data) {
                // return number_format( $data->adjust_amount ,2);
                $adjust_amount = '';
                if( $data->inventory_stock_adjustment_item->add_amount > 0 ){
                    $adjust_amount = '<span class="text-success">+'.number_format($data->inventory_stock_adjustment_item->add_amount,2).'</span>';
                }
                elseif( $data->inventory_stock_adjustment_item->minus_amount > 0 ){
                    $adjust_amount = '<span class="text-danger">-'.number_format($data->inventory_stock_adjustment_item->minus_amount,2).'</span>';
                }
                return $adjust_amount;
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
            ->rawColumns([ 'warehouse_name','product_name','transaction_name', 'document_code', 'adjust_amount', 'btn' , 'status'])
            ->make(true);
        }
        $inventories = Inventory::myCompany()->where('status', 'active')->get();
        $warehouses = Warehouse::myCompany()->where('is_active', 1)->get();
        $warehouse_id = @setParamEmptyIsNull($request->whid);
        return view('admin.warehouse.inventory_stock_adjustment.index',compact('inventories','warehouses', 'warehouse_id'));
    }

    public function create(Request $request)
    {
        $lang = app()->getLocale();
        $warehouse_name = null;
        $branch_name = null;
        $user_creator_name = '';
        $user_approver_name = '';
        $user_editor_name = Auth::user()->firstname.' '.Auth::user()->lastname;
        $product_name = null;

        $inventory_stock = InventoryStock::where('id', $request->stockId)
            ->with('inventory.product', 'inventory.warehouse.branch', 'order')
            ->with(InventoryStock::$relationship_item_products)
            ->with(InventoryStock::$relationship_users)
            ->first();

        if( !empty($inventory_stock) ){
            $inventoryStockHistoryController = new InventoryStockHistoryController();
            $inventory_stock = $inventoryStockHistoryController->_setTransaction($inventory_stock);

            $inventory_stock->date = Carbon::parse($inventory_stock->date)->format('d/m/Y');

            if( $inventory_stock->inventory->warehouse ){
                $warehouse_name = $lang == 'th' ? $inventory_stock->inventory->warehouse->name_th : $inventory_stock->inventory->warehouse->name_en;
                $branch_name = $inventory_stock->inventory->warehouse->branch->name;
            }

            if( $inventory_stock->transaction_data->user_creator){
                $user_creator_name = $inventory_stock->transaction_data->user_creator->firstname.' '.$inventory_stock->transaction_data->user_creator->lastname;
            }

            if( $inventory_stock->transaction_data->user_approver){
                $user_approver_name = $inventory_stock->transaction_data->user_approver->firstname.' '.$inventory_stock->transaction_data->user_approver->lastname;
            }

            $product_name = $lang == 'th' ? $inventory_stock->inventory->product->name_th : $inventory_stock->inventory->product->name_en;
        }

        return view('admin.warehouse.inventory_stock_adjustment.create', compact('inventory_stock','warehouse_name','branch_name','user_creator_name','user_approver_name','user_editor_name','product_name'));
    }

    public function store(InventoryStockAdjustmentRequest $request)
    {

        $status = false;
        $message = "";
        $errors = [];
        $chk_valid = true;

        try{

            $inventory_stock = InventoryStock::myCompany()
                ->where('id', $request->stock_id)
                ->with('inventory.product', 'inventory.warehouse.branch', 'order')
                ->first();

            if( !empty($inventory_stock) ) {

                $inventory_stock_adjustment = new InventoryStockAdjustment();
                $inventory_stock_adjustment->company_id =  $inventory_stock->inventory->company_id;
                $inventory_stock_adjustment->warehouse_id =  $inventory_stock->inventory->warehouse_id;
                $inventory_stock_adjustment->inventory_stock_id =  $inventory_stock->id;
                $inventory_stock_adjustment->user_creator_id =  Auth::user()->id;
                $inventory_stock_adjustment->user_approver_id =  null;
                $inventory_stock_adjustment->created_by =  Auth::user()->fistname.' '.Auth::user()->lastname;
                
                $inventory_stock_adjustment->remark = $request->remark;
                $inventory_stock_adjustment->status = 'pending';

                if( $inventory_stock_adjustment->save() ){

                    $inventory_stock_adjustment_item = new InventoryStockAdjustmentItem();
                    $inventory_stock_adjustment_item->inventory_stock_adjustment_id = $inventory_stock_adjustment->id;
                    $inventory_stock_adjustment_item->inventory_id = $inventory_stock->inventory_id;
                    $inventory_stock_adjustment_item->product_id = $inventory_stock->inventory->product_id;
                    if( $request->adjust_amount < 0 ){
                        $inventory_stock_adjustment_item->minus_amount = abs($request->adjust_amount);
                    }else{
                        $inventory_stock_adjustment_item->add_amount = $request->adjust_amount;
                    }
                    $inventory_stock_adjustment_item->remark = $request->remark;

                    if( $inventory_stock_adjustment_item->save() ){

                        $status = true;
                        $message = 'ปรับแก้ข้อมูลเรียบร้อย';
        
                        return response()->json(['status' => $status, 'msg' => $message, 'table_not_reload'=> true, 'redirect' => route('inventory.show',['inventory' => 1])]);
                        // return response()->json(['status' => $status, 'msg' => $message, 'table_not_reload'=> true]);

                    }
                }
            }
            
        }catch(\Exception $e){

            $message = $e->getMessage();
            $errors[] = setInputError('all', $message);

        }

        return response()->json(['status' => $status, 'input_errors' =>$errors, 'message' => $message], 400);
    }

    public function show(Request $request, $id)
    {
        $lang = app()->getLocale();
        $warehouse_name = null;
        $branch_name = null;
        $user_creator_name = '';
        $user_approver_name = Auth::user()->firstname.' '.Auth::user()->lastname;
        $product_name = null;
        $inventory_stock = null;
        $adjust_amount = '';
        $remark = '';

        $inventory_stock_adjustment = InventoryStockAdjustment::where('id', $id)
            ->with('inventory_stock', function($q){
                $q->with('inventory.product', 'inventory.warehouse.branch', 'order')
                ->with(InventoryStock::$relationship_item_products)
                ->with(InventoryStock::$relationship_users);
            })
            ->with('user_creator', 'user_approver', 'inventory_stock_adjustment_item')
            ->first();

        if( !empty($inventory_stock_adjustment) ){

            $inventory_stock_adjustment->date = Carbon::parse($inventory_stock_adjustment->created_at)->format('d/m/Y');

            $inventory_stock_adjustment->adjust_amount = '0.00';
            if( $inventory_stock_adjustment->inventory_stock_adjustment_item->add_amount > 0 ){
                $inventory_stock_adjustment->adjust_amount = '<span class="text-success">+'.number_format($inventory_stock_adjustment->inventory_stock_adjustment_item->add_amount,2).'</span>';
            }
            elseif( $inventory_stock_adjustment->inventory_stock_adjustment_item->minus_amount > 0 ){
                $inventory_stock_adjustment->adjust_amount = '<span class="text-danger">-'.number_format($inventory_stock_adjustment->inventory_stock_adjustment_item->minus_amount,2).'</span>';
            }

            $inventoryStockHistoryController = new InventoryStockHistoryController();
            $inventory_stock = $inventoryStockHistoryController->_setTransaction($inventory_stock_adjustment->inventory_stock);

            if( $inventory_stock_adjustment->status == 'approve' ){
                $user_approver_name = $inventory_stock_adjustment->user_approver->firstname . ' ' . $inventory_stock_adjustment->user_approver->lastname;
            }
            $user_creator_name = $inventory_stock_adjustment->user_creator->firstname . ' ' . $inventory_stock_adjustment->user_creator->lastname;

            $inventory_stock->date = Carbon::parse($inventory_stock->date)->format('d/m/Y');

            if( $inventory_stock->inventory->warehouse ){
                $warehouse_name = $lang == 'th' ? $inventory_stock->inventory->warehouse->name_th : $inventory_stock->inventory->warehouse->name_en;
                $branch_name = $inventory_stock->inventory->warehouse->branch->name;
            }

            if( $inventory_stock->transaction_data->user_creator){
                $user_creator_name = $inventory_stock->transaction_data->user_creator->firstname.' '.$inventory_stock->transaction_data->user_creator->lastname;
            }

            if( $inventory_stock->transaction_data->user_approver){
                $user_approver_name = $inventory_stock->transaction_data->user_approver->firstname.' '.$inventory_stock->transaction_data->user_approver->lastname;
            }

            $product_name = $lang == 'th' ? $inventory_stock->inventory->product->name_th : $inventory_stock->inventory->product->name_en;
        }

        return view('admin.warehouse.inventory_stock_adjustment.view', compact('inventory_stock_adjustment','warehouse_name','branch_name','user_creator_name','user_approver_name','product_name'));
    }

    public function edit($id)
    {
        // $inventorystockadjustment = InventoryStockAdjustment::where('id', $id)->first();
        // return response()->json(['inventory_stock_adjustment' => $inventorystockadjustment]);
    }
    public function update(Request $request)
    {
        // $status = false;
        // $msg = 'ผิดพลาด';
        // $inentorystockadjustment = InventoryStockAdjustment::where('id', $request->id)->first();
        // $inentorystockadjustment->product_stock_id = $request->product_stock_id;
        // $inentorystockadjustment->amount = $request->amount;
        // $inentorystockadjustment->note = $request->remark;
        // $inentorystockadjustment->user_approver_id = Auth::user()->id;
        // $inentorystockadjustment->updated_by = Auth::user()->id;
        // if ($inentorystockadjustment->save()) {
        //     $status = true;
        //     $msg = 'บันทึกข้อมูลสําเร็จ';
        // }
        // return response()->json([
        //     'status' => $status,
        //     'msg' => $msg,
        // ]);
    }

    public function destroy($id)
    {
        $status = false;
        $message = "";
        $errors = [];

        try {
            
            $inventory_stock_adjustment = InventoryStockAdjustment::where('id', $id)
                ->where("status", 'pending')
                ->first();

            if( !empty($inventory_stock_adjustment) ){

                $inventory_stock_adjustment->status = 'cancel';
                $inventory_stock_adjustment->save();
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
    public function inventoryimport(Request $request)
    {
    }
    public function inventoryexport(Request $request)
    {
    }
    public function sort(Request $request)
    {
    }
    public function toggleActive(Request $request)
    {
    }

    public function approve(int $id){

        $status = false;
        $message = "";
        $errors = [];

        try {
            
            $inventory_stock_adjustment = InventoryStockAdjustment::myCompany()->where("id", $id)
                ->with('inventory_stock.inventory')
                ->where("status", 'pending')
                ->with('inventory_stock_adjustment_items')
                ->first();

            if( !empty($inventory_stock_adjustment) ){

                $adjust_amount = 0;
                // add product data to stock
                foreach( $inventory_stock_adjustment->inventory_stock_adjustment_items as $inventory_stock_adjustment_item ){
                    if( $inventory_stock_adjustment_item->add_amount > 0 ){
                        $adjust_amount += $inventory_stock_adjustment_item->add_amount;
                    }
                    elseif( $inventory_stock_adjustment_item->minus_amount > 0 ){
                        $adjust_amount += -$inventory_stock_adjustment_item->minus_amount;
                    }
                }

                //update inventory stock
                $inventory_stock_adjustment->inventory_stock->adjust_amount += $adjust_amount;
                $inventory_stock_adjustment->inventory_stock->remaining_amount += $adjust_amount;
                $inventory_stock_adjustment->inventory_stock->save();

                //update inventory product
                $inventory_stock_adjustment->inventory_stock->inventory->amount += $adjust_amount;
                $inventory_stock_adjustment->inventory_stock->inventory->save();

                $inventory_stock_adjustment->status = 'approve';
                $inventory_stock_adjustment->user_approver_id = Auth::user()->id;
                $inventory_stock_adjustment->save();
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


<?php

namespace App\Http\Controllers\Admin\Warehouses;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryStock;
use App\Models\InventoryStockAdjustment;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class InventoryStockHistoryController extends Controller
{
    public function index(Request $request)
    {

        $get_tabkey = !empty($request->tabkey)?$request->tabkey:'all';

        if ($request->ajax()) {

            $builder = InventoryStock::with('inventory.product', 'inventory.warehouse', 'order', 'user')
                ->with(InventoryStock::$relationship_item_products)
                ->with(InventoryStock::$relationship_users);

            if( $get_tabkey != 'all' ){
                $builder->where('transaction', $get_tabkey);
            }

            if( !empty($request->warehouse_id) ){
                $builder->WhereHas('inventory', function($q) use ($request){
                    $q->where('warehouse_id', $request->warehouse_id);
                })->get();
            }

            if( !empty($request->search->value) ){

                $search = $request->search->value;
                $builder->where(function($q) use ($search){
                    $q->orWhere('code', $search)
                    ->orWhere('name_th', $search)
                    ->orWhere('name_en', $search)
                    ->orWhere('price', $search)
                    ->orWhere('detail.serial_no', $search)
                    ->orWhere('detail.path_no', $search);

                });
            }
            $inventory_stocks = $builder->get();

            $lang = app()->getLocale();
            $data_tables = collect();
            foreach( $inventory_stocks as $inventory_stock){
                $inventory_stock = $this->_setTransaction($inventory_stock);
                $data_tables->push((object)[
                    'date' => Carbon::parse($inventory_stock->date)->format('d/m/Y'),
                    'document_code' => $inventory_stock->transaction_data->code,
                    'transaction' => $inventory_stock->transaction,
                    'transaction_name' => $inventory_stock->transaction_data->name,
                    'product_code' => $inventory_stock->inventory->product->code,
                    'product_name' => $lang == 'th' ? $inventory_stock->inventory->product->name_th : $inventory_stock->inventory->product->name_en,
                    'add_amount' => $inventory_stock->add_amount,
                    'used_amount' => $inventory_stock->used_amount,
                    'adjust_amount' => $inventory_stock->adjust_amount,
                    'type' => $inventory_stock->type,
                    'warehouse_name' => $lang == 'th' ? $inventory_stock->inventory->warehouse->name_th : $inventory_stock->inventory->warehouse->name_en,
                ]);
            }

            return DataTables::make($data_tables)
                ->addIndexColumn()
                ->addColumn('adjustment_amount', function ($data) {
                    $adjustment_amount = '0';
                    if( $data->type == 'add' ){
                        $adjustment_amount = '<span class="text-success">+'.number_format($data->add_amount,2).'</span>';
                    }
                    elseif( $data->type == 'used' ){
                        $adjustment_amount = '<span class="text-success">+'.number_format($data->used_amount,2).'</span>';
                    }
                    else{
                        if( $data->adjust_amount > 0 ){
                            $adjustment_amount = '<span class="text-success">+'.number_format($data->adjust_amount,2).'</span>';
                        }
                        elseif( $data->adjust_amount < 0 ){
                            $adjustment_amount = '<span class="text-success">+'.number_format($data->adjust_amount,2).'</span>';
                        }
                    }
                    return $adjustment_amount;
                })
                ->addColumn('action', function ($data) {
                    // $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all inventory_stock_history', 'edit inventory_stock_history']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`' . url('/warehouse/inventorystock/edit') . '/' . $data['id'] . '`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    // $btnDel = (Auth::user()->hasAnyPermission(['*', 'all inventory_stock_history', 'delete inventory_stock_history']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`' . url('/warehouse/inventorystock/destroy') . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');
                    // return $btnEdit . ' ' . $btnDel;
                    return null;
                })
                ->rawColumns(['action', 'adjustment_amount'])
                ->make(true);
        }

        $warehouses = Warehouse::myCompany()->where('is_active', 1)->get();
        $warehouse_id = @setParamEmptyIsNull($request->whid);

        $builder = InventoryStock::query();
        if( !empty($request->whid) ){
            $builder->WhereHas('inventory', function($q) use ($request){
                $q->where('warehouse_id', $request->whid);
            })->get();
        }
        $builder->get();

        $tabArr = [
            ['label' => 'All', 'value' => 'all', 'count' => $this->_getItemCount($builder, 'all'), 'class' => 'active' , 'color' => 'primary'],
        ];
        foreach(InventoryStock::$relationships as $transaction_name){
            $tabArr[] = ['label' => __('inventory.'.$transaction_name), 'value' => $transaction_name, 'count' => $this->_getItemCount($builder, $transaction_name),'color' => 'secondary'];
        }
        $tabs = statusTabs($tabArr, $get_tabkey);

        return view('admin.warehouse.inventory_stock_history.index', compact('tabs','warehouses', 'warehouse_id'));
    }

    private function _getItemCount($builder, $transaction){
        $count = 0;
        if( empty($transaction) || $transaction == 'all'){
            $count = $builder->count();
        }else{
            $count = $builder->where('transaction', $transaction)->count();
        }
        return $count;

    }
    public function _setTransaction($inventory_stock){
        
        // $transaction_data = null;
        switch($inventory_stock->transaction){
            case 'lot':  $transaction_data = $inventory_stock->lot;
                $transaction_data->items = $inventory_stock->lot->items; 
                $transaction_data->code = $inventory_stock->lot->lot_number;
                $transaction_data->name = __('inventory.lot');
                $inventory_stock->transaction_data = $transaction_data;
                break;
            case 'quotation':  $transaction_data = $inventory_stock->quotation;
                $transaction_data->items = $inventory_stock->quotation->items; 
                $transaction_data->code = $inventory_stock->quotation->quotation_number;
                $transaction_data->name = __('inventory.quotation');
                $inventory_stock->transaction_data = $transaction_data;
                break;
            case 'beginning_balance':  $transaction_data = $inventory_stock->beginning_balance;
                $transaction_data->items = $inventory_stock->beginning_balance->items; 
                $transaction_data->name = __('inventory.beginning_balance');
                $inventory_stock->transaction_data = $transaction_data;
                break;
            case 'issue_requisition':  $transaction_data = $inventory_stock->issue_requisition;
                $transaction_data->items = $inventory_stock->issue_requisition->items; 
                $transaction_data->name = __('inventory.issue_requisition');
                $inventory_stock->transaction_data = $transaction_data;
                break;
            case 'reture_issue_stock':  $transaction_data = $inventory_stock->reture_issue_stock;
                $transaction_data->items = $inventory_stock->reture_issue_stock->items; 
                $transaction_data->name = __('inventory.reture_issue_stock');
                $inventory_stock->transaction_data = $transaction_data;
                break;
            case 'receipt_planning':  $transaction_data = $inventory_stock->receipt_planning;
                $transaction_data->items = $inventory_stock->receipt_planning->items; 
                $transaction_data->name = __('inventory.receipt_planning');
                $inventory_stock->transaction_data = $transaction_data;
                break;
            case 'receive_finish_stock':  $transaction_data = $inventory_stock->receive_finish_stock;
                $transaction_data->items = $inventory_stock->receive_finish_stock->items; 
                $transaction_data->name = __('inventory.receive_finish_stock');
                $inventory_stock->transaction_data = $transaction_data;
                break;
            case 'transfer_requistion':  $transaction_data = $inventory_stock->transfer_requistion;
                $transaction_data->items = $inventory_stock->transfer_requistion->items; 
                $transaction_data->name = __('inventory.transfer_requistion');
                $inventory_stock->transaction_data = $transaction_data;
                break;
        }

        return $inventory_stock;
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        // $status = false;
        // $msg = 'ผิดพลาด';
        // $inentorystockadjustment = new InventoryStockAdjustment();
        // $inentorystockadjustment->product_stock_id = $request->inventory_stock_id;
        // $inentorystockadjustment->amount = $request->amount;
        // $inentorystockadjustment->note = $request->remark;
        // $inentorystockadjustment->user_creator_id = Auth::user()->id;
        // $inentorystockadjustment->user_approver_id = Auth::user()->id;
        // $inentorystockadjustment->created_by = Auth::user()->id;
        // if ($inentorystockadjustment->save()) {
        //     $status = true;
        //     $msg = 'บันทึกข้อมูลสําเร็จ';
        // }
        // return response()->json([
        //     'status' => $status,
        //     'msg' => $msg,
        // ]);
    }
    public function show(Request $request)
    {
    }

    public function edit($id)
    {
        // $inventorystockadjustment = InventoryStockAdjustment::where('id', $id)->first();
        // return response()->json(['inventorystockadjustment' => $inventorystockadjustment]);
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
        // $status = false;
        // $msg = 'ไม่สามารถลบข้อมูลได้';
        // $role = InventoryStockAdjustment::findOrFail($id);
        // if ($role) {
        //     $role->delete();
        //     $status = true;
        //     $msg = 'ลบข้อมูลเรียบร้อย';
        // }
        // return response()->json(['status' => $status, 'msg' => $msg]);
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

}


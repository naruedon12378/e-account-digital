<?php
namespace App\Http\Controllers\Admin\Warehouses;
use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use App\Models\Inventory;
use App\Models\InventoryStock;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class InventoryController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $builder = Inventory::whereHas('warehouse', function($q){
                $q->where('company_id', Auth::user()->company_id);
            });
            if( !empty($request->warehouse_id) ){
                $builder->where('warehouse_id', $request->warehouse_id);
            }
            $datas = $builder->with('warehouse', 'product')->get();

            return DataTables::make($datas)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = $data->btn_view.' '.$data->btn_edit;

                return $btn;
            })
            ->addColumn('warehouse_name', function ($data) {
                if(!empty($data->warehouse))
                    return $data->warehouse->name_th;
                return null;
            })
            ->addColumn('product_name', function ($data) {
                if(!empty($data->product))
                    return $data->product->name_th;
                return null;
            })
            ->editColumn('amount', function ($data) {
                return number_format($data->amount, 2);
            })
            ->addColumn('status', function ($data) {
                if ($data['status'] === 'onhold') {
                    $status = '<span class="badge badge-warning">รออนุมัติ</span>';
                } elseif ($data['status'] === 'active') {
                    $status = '<span class="badge badge-success">เผยแพร่</span>';
                } else {
                    $status = '<span class="badge badge-danger">ไม่เผยแพร่</span>';
                }
                return $status;
            })
            ->rawColumns([ 'warehouse_name','product_name', 'action' , 'status'])
            ->make(true);
        }
        $products = Product::myCompany()->get();
        $warehouses = Warehouse::myCompany()->where('is_active', 1)->get();
        $warehouse_id = @setParamEmptyIsNull($request->whid);
        return view('admin.warehouse.inventory.index',compact('products','warehouses', 'warehouse_id'));
    }

    public function create()
    {
    }

    public function store(InventoryRequest $request)
    {
        return $this->_storeOrUpdate($request, null);
    }

    public function show(Request $request, $inventoty_id)
    {

        $lang = app()->getLocale();
        $builder = InventoryStock::where('inventory_id',$inventoty_id)
                ->with('inventory.product', 'inventory.warehouse', 'order')
                ->with(InventoryStock::$relationship_item_products)
                ->with(InventoryStock::$relationship_users);

        // if( !empty($request->search->value) ){
        //     $search = $request->search->value;
        //     $builder->where(function($q) use ($search){
        //         $q->orWhere('code', $search)
        //         ->orWhere('name_th', $search)
        //         ->orWhere('name_en', $search)
        //         ->orWhere('price', $search)
        //         ->orWhere('detail.serial_no', $search)
        //         ->orWhere('detail.path_no', $search);
        //     });
        // }
        $inventory_stocks = $builder->get();

        $inventoryStockHistoryController = new InventoryStockHistoryController();

        if ($request->ajax()) {

            $data_tables = collect();
            foreach( $inventory_stocks as $inventory_stock){
                $inventory_stock = $inventoryStockHistoryController->_setTransaction($inventory_stock);
                $creator_name = '';
                if($inventory_stock->transaction_data->user_creator){
                    $creator_name = $inventory_stock->transaction_data->user_creator->firstname.' '.$inventory_stock->transaction_data->user_creator->lastname;
                }
                $approver_name = '';
                if($inventory_stock->transaction_data->user_approver){
                    $approver_name = $inventory_stock->transaction_data->user_approver->firstname.' '.$inventory_stock->transaction_data->user_approver->lastname;
                }

                $data_tables->push((object)[
                    'date' => Carbon::parse($inventory_stock->date)->format('d/m/Y'),
                    'document_code' => $inventory_stock->transaction_data->code,
                    // 'transaction' => $inventory_stock->transaction,
                    'transaction_name' => $inventory_stock->transaction_data->name,
                    'add_amount' => number_format($inventory_stock->add_amount,2),
                    'used_amount' => number_format($inventory_stock->used_amount,2),
                    'adjust_amount' => number_format($inventory_stock->adjust_amount,2),
                    'remaining_amount' => number_format($inventory_stock->remaining_amount,2),
                    'type' => $inventory_stock->type,
                    'warehouse_name' => $lang == 'th' ? $inventory_stock->inventory->warehouse->name_th : $inventory_stock->inventory->warehouse->name_en,
                    'creator_name' => $creator_name,
                    'approver_name' => $approver_name,
                    'btn_adjust_stock' => $inventory_stock->btn_adjust_stock,
                ]);
            }

            return DataTables::make($data_tables)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = $data->btn_adjust_stock;
    
                    return $btn;
                })
                ->rawColumns(['action', 'adjustment_amount'])
                ->make(true);
        }

        $inventory = Inventory::whereHas('warehouse', function($q){
                $q->where('company_id', Auth::user()->company_id);
            })
            ->where('id', $inventoty_id)
            ->with('warehouse.branch', 'inventory_stock', 'product')
            ->first();

        $total_add_amount = 0;
        $total_remove_amount = 0;
        // $total_remaining_amount = 0;
        foreach( $inventory_stocks as $inventory_stock){
            $total_add_amount += $inventory_stock->add_amount;
            $total_remove_amount += $inventory_stock->used_amount+$inventory_stock->adjust_amount;
            // $total_remaining_amount += $inventory_stock->remaining_amount;
        }

        if( $lang == 'th' ){
            $inventory->product->name = $inventory->product->name_th;
            $inventory->warehouse->name = $inventory->warehouse->name_th;
        }else{
            $inventory->product->name = $inventory->product->name_en;
            $inventory->warehouse->name = $inventory->warehouse->name_en;
        }

        return view('admin.warehouse.inventory.view',compact('inventory','total_add_amount','total_remove_amount'));
    }

    public function edit($id)
    {
        $inventory = Inventory::whereHas('warehouse', function($q){
            $q->where('company_id', Auth::user()->company_id);
        })->where('id', $id)->first();
        return response()->json($inventory);
    }

    public function update(InventoryRequest $request, $id)
    {
        return $this->_storeOrUpdate($request, $id);
    }

    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $package_manage = Inventory::whereHas('warehouse', function($q){
            $q->where('company_id', Auth::user()->company_id);
        })->whereId($id)->first();
        if ($package_manage->delete()) {
            $status = true;
            $msg = 'เสร็จสิ้น';
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function _storeOrUpdate($request, $id){

        $status = false;
        $message = 'บันทึกข้อมูลผิดพลาด';
        $process = 'create';

        try{

            if( !empty($id) ){

                $inventory = Inventory::whereHas('warehouse', function($q){
                        $q->where('company_id', Auth::user()->company_id);
                    })
                    ->where('id', $id)
                    ->first();

                $process = 'edit';
            }else{
                $inventory = new Inventory();
                $inventory->user_creator_id =  Auth::user()->id;
            }

            if( !empty($inventory) ){

                if ($request->status === 'onhold') {
                    $status = 'onhold';
                } elseif ($request->status === 'active') {
                    $status = 'active';
                } else {
                    $status = 'inactive';
                }

                $inventory->warehouse_id = $request->warehouse_id;
                $inventory->product_id = $request->product_id;
                $inventory->limit_min_amount = $request->limit_min_amount;
                $inventory->limit_max_amount = $request->limit_max_amount;
                $inventory->limit_amount_notification = filter_var($request->limit_amount_notification, FILTER_VALIDATE_BOOLEAN);
                $inventory->is_negative_amount = filter_var($request->is_negative_amount, FILTER_VALIDATE_BOOLEAN);
                $inventory->location = $request->location;
                $inventory->description = $request->description;
                $inventory->status = $status;
                $inventory->created_by = Auth::user()->id;

                if ($inventory->save()) {
                    $status = true;
                    if( $process == 'edit'){
                        $message = 'แก้ไขข้อมูลเรียบร้อย';
                    }else{
                        $message = 'เพิ่มข้อมูลเรียบร้อย';
                    }

                    return response()->json(['status' => $status, 'msg' => $message, 'redirect' => route('inventory.index')]);
                }
            }else{
                $message = 'ไม่พบข้อมูล';
                $errors[] = setInputError('not_found', $message);
            }

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $errors[] = setInputError('all', $message);
        }

        return response()->json(['status' => $status, 'input_errors' =>$errors, 'msg' => $message], 400);
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

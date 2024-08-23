<?php
namespace App\Http\Controllers\Admin\Warehouses;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryStock;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
class InventoryStockController  extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = InventoryStock::with('inventory', 'order', 'user')->get();
            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all warehouse', 'edit warehouse']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`' . url('/warehouse/inventorystock/edit') . '/' . $data['id'] . '`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all inventorystock', 'delete inventorystock']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`' . url('/warehouse/inventorystock/destroy') . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');
                    return $btnEdit . ' ' . $btnDel;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $inventories = Inventory::with('warehouse')->get();
        $inventoryOptions = $inventories->mapWithKeys(function ($inventory) {
            $id = $inventory->id;
            $value = $inventory->warehouse->name;
            return [$id => $value];
        });
        $orders = PurchaseOrder::get();
        return view('admin.warehouse.inventorystock.index', compact('inventoryOptions', 'orders'));
    }
    public function created()
    {
        $head_columns = [
            ['name' => 'inventory_stock.inventory', 'width' => '100px'],
            ['name' => 'inventory_stock.product', 'width' => '100px'],
            ['name' => 'inventory_stock.transaction', 'width' => '50px'],
            ['name' => 'inventory_stock.lot_number', 'width' => '50px'],
            ['name' => 'inventory_stock.add_amount', 'width' => '50px'],
            ['name' => 'inventory_stock.used_amount', 'width' => '50px'],
            ['name' => 'inventory_stock.remaining_amount', 'width' => '50px'],
            ['name' => 'inventory_stock.total', 'width' => '50px'],
            ['name' => 'inventory_stock.actions', 'width' => '50px'],
        ];

        $inventories = Inventory::get();
        $orders = PurchaseOrder::get();
        $inentorystocks = new InventoryStock();
        // return view('admin.warehouse.inventorystock.create',compact('inventories', 'orders','inentorystocks','head_columns'));
    }
    public function store(Request $request)
    {
        // $status = false;
        // $msg = 'ผิดพลาด';
        // $inentorystocks = new InventoryStock();
        // $inentorystocks->inventory_id = $request->inventory_id;
        // $inentorystocks->order_id = $request->order_id;
        // $inentorystocks->transaction = $request->transaction;
        // $inentorystocks->lot_number = $request->lot_number;
        // $inentorystocks->add_amount = $request->add_amount;
        // $inentorystocks->used_amount = $request->used_amount;
        // $inentorystocks->remaining_amount = $request->remaining_amount;
        // $inentorystocks->coust_price = $request->coust_price;
        // $inentorystocks->remark = $request->remark;
        // $inentorystocks->user_creator_id = Auth::user()->id;
        // $inentorystocks->created_by = Auth::user()->id;
        // $inentorystocks->save();
        // $status = true;
        // $msg = 'บันทึกข้อมูลเรียบร้อยแล้ว';
        // return response()->json(['status' => $status, 'msg' => $msg]);
    }
    public function edit( string $id)
    {
        // $inventorystock = InventoryStock::where('id', $id)->first();
        // return response()->json(['inventorystock' => $inventorystock]);
    }
    public function update(Request $request)
    {
        // $status = false;
        // $msg = 'บันทึกข้อมูลผิดพลาด';
        // $inentorystocks = InventoryStock::whereId($request->id)->first();
        // if($inentorystocks){
        //     $inentorystocks->inventory_id = $request->inventory_id;
        //     $inentorystocks->order_id = $request->order_id;
        //     $inentorystocks->transaction = $request->transaction;
        //     $inentorystocks->lot_number = $request->lot_number;
        //     $inentorystocks->add_amount = $request->add_amount;
        //     $inentorystocks->used_amount = $request->used_amount;
        //     $inentorystocks->remaining_amount = $request->remaining_amount;
        //     $inentorystocks->coust_price = $request->coust_price;
        //     $inentorystocks->remark = $request->remark;
        //     $inentorystocks->user_creator_id = Auth::user()->id;
        //     $inentorystocks->created_by = Auth::user()->id;
        //     if ($inentorystocks->save()) {
        //         $status = true;
        //         $msg = 'บันทึกข้อมูลเรียบร้อย';
        //     }
        //     return response()->json(['status' => $status, 'msg' => $msg]);
        // }else{
        //     return response()->json(['status' => $status, 'msg' => 'ไม่พบข้อมูล']);
        // }
    }
    public function destroy(string $id)
    {
        // $status = false;
        // $msg = 'ไม่สามารถลบข้อมูลได้';
        // $role = InventoryStock::findOrFail($id);
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


}

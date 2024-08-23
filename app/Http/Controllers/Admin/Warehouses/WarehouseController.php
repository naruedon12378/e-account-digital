<?php
namespace App\Http\Controllers\Admin\Warehouses;
use App\Http\Controllers\Controller;
use App\Http\Requests\warehouse\WarehouseRequest;
use App\Models\Branch;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Warehouse::myCompany()
                ->with('company:id,name_en')
                ->with('branch')
                ->get();

            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all warehouse', 'edit warehouse']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`' . url('/warehouse/warehouse/edit') . '/' . $data['id'] . '`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all warehouse', 'delete warehouse']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`' . url('/warehouse/warehouse') . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');
                    $btn = $btnEdit . ' ' . $btnDel;
                    return $btn;
                })
                ->addColumn('publish', function ($data) {
                    if ($data['is_active']) {
                        $publish = '<label class="switch"> <input type="checkbox" class="custom-control-input"  value="0" id="' . $data['id'] . '" onchange="publish(`' . url('warehouse/warehouse/publish') . '/' . $data['id'] . '`)"> <span class="slider round" style="background-color: green;border-radius: 25px;size: 20px"></span> </label>';
                    } else {
                        $publish = '<label class="switch"> <input type="checkbox" checked class="custom-control-input"  value="1" id="' . $data['id'] . '" onchange="publish(`' . url('warehouse/warehouse/publish') . '/' . $data['id'] . '`)"> <span class="slider rounded-4" style="background-color: red;border-radius: 25px;size: 20px"></span> </label>';
                    }
                    if (Auth::user()->hasRole(['user'])) {
                        $publish = ($data['status'] ? '<span class="badge badge-success">เผยแพร่</span>' : '<span class="badge badge-danger">ไม่เผยแพร่</span>');
                    }
                    return $publish;
                })
                ->addColumn('company_name', function ($data) {
                    return $data->company->name_en;
                })
                ->addColumn('branch_name', function ($data) {
                    return $data->branch->name;
                })
                ->addColumn('isActive', function ($data) {
                    return $data->active_style;
                })
                ->rawColumns(['company_name', 'publish', 'action'])
                ->make(true);
        }
        $warehouses = Warehouse::myCompany()->where('is_active', 1)->get();
        $branches = Branch::myCompany()->where('publish', 1)->get();
        return view('admin.warehouse.warehouse.index', compact('warehouses', 'branches'));
    }
    public function create()
    {
    }

    public function store(WarehouseRequest $request)
    {
        return $this->_storeOrUpdate($request, null);
    }
    public function show(Request $request)
    {
    }

    public function edit(string $id)
    {
        $warehouse = Warehouse::myCompany()->with('company')->find($id);
        return response()->json(['warehouse' => $warehouse]);
    }

    public function update(WarehouseRequest $request, $id)
    {
        return $this->_storeOrUpdate($request, $id);
    }

    public function destroy($id)
    {
        $status = false;
        $msg = 'ผิดพลาด';
        $product_type = Warehouse::myCompany()->whereId($id)->first();
        if (!empty($product_type)) {
            if ($product_type->delete()) {
                $status = true;
                $msg = 'เสร็จสิ้น';
            }
        } else {
            $msg .= 'ไม่พบข้อมูล';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
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

    public function publish($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $product_type = Warehouse::find($id);
        if (!empty($product_type)) {
            $product_type->is_active = $product_type->is_active ? 0 : 1;
            $product_type->updated_by = Auth::user()->firstname . ' ' . Auth::user()->lastname;
            $product_type->save();

            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }

    public function _storeOrUpdate($request, $id)
    {
        $data = $request->except('_token');

        $status = false;
        $msg = "";
        if (!empty($id)) {
            $warehouse = Warehouse::myCompany()->find($id);
        } else {
            $warehouse = new Warehouse();
            $warehouse->company_id = Auth::user()->company_id;
            $warehouse->user_creator_id = Auth::user()->id;
        }

        if (!empty($warehouse)) {

            $warehouse->branch_id = @setParamEmptyIsNull($request->branch_id);
            $warehouse->code = @setParamEmptyIsNull($request->code);
            $warehouse->name_th = $request->name_th;
            $warehouse->name_en = @setParamEmptyIsNull($request->name_en);
            $warehouse->is_active = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);
            if ($warehouse->save()) {

                $status = true;
                if (!empty($id)) {
                    $msg = "Updated successfully";
                }else{
                    $msg = "Created successfully";
                }
            }
        } else {
            $msg = "Data not found!";
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }


}

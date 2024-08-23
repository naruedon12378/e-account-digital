<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitPostRequest;
use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type ?? 'product';
        $units = Unit::myCompany()->where('is_active', true)->get();

        $tabArr = [
            ['label' => 'Product', 'value' => 'product', 'count' => $units->where('type', 'product')->count(), 'color' => 'success'],
            ['label' => 'Service', 'value' => 'service', 'count' => $units->where('type', 'service')->count(), 'color' => 'secondary'],
        ];
        $tabs = statusTabs($tabArr, $type);

        if ($request->ajax()) {
            $data = $units->where('type', $type);
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
        return view('admin.unit.index', compact('tabs'));
    }

    public function store(UnitPostRequest $request)
    {
        return $this->_storeOrUpdate($request, null);
    }

    public function edit($id)
    {
        $unit = Unit::find($id);
        return $unit;
    }

    public function update(UnitPostRequest $request, $id){
        return $this->_storeOrUpdate($request, $id);
    }

    private function _storeOrUpdate($request, $id){

        $data = $request->except('_token');
        $id = $request->id;
        $msg = "";

        if ( !empty($id) ) {
            Unit::find($id)->update($data);
            $status = true;
            $msg = "Updated successfully";
        } else {
            $data['company_id'] = Auth::user()->company_id;
            Unit::create($data);
            $status = false;
            $msg = "Created successfully";
        }

        // Session::flash('success', $msg);
        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function destroy($id)
    {
        $status = false;
        $msg = 'ผิดพลาด';
        $unit = Unit::whereId($id)->first();
        if ($unit->delete()) {
            $status = true;
            $msg = 'เสร็จสิ้น';
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function toggleActive($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $unit = Unit::find($id);
        if ($unit) {
            $unit->is_active = !$unit->is_active;
            $unit->save();

            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Permission::all();
            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('btn',function ($data){
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all permission', 'edit permission']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`'.url('permission/edit') . '/' . $data['id'].'`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all permission', 'delete permission']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`'. url('permission/destroy') . '/' . $data['id'].'`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    $btn = $btnEdit . ' ' . $btnDel;

                    return $btn;
                })
                ->rawColumns(['btn'])
                ->make(true);
        }

        $permissions = Permission::all();
        return view('admin.permission.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->description = $request->description;
        $permission->guard_name = 'web';
        $permission->group_th = $request->group_th;
        $permission->group_en = $request->group_en;

        $permission->created_at = Carbon::now();
        if($permission->save()){
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function edit($id)
    {
        $permission = Permission::whereId($id)->first();

        return response()->json(['permission' => $permission]);
    }

    public function update(Request $request)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $permission = Permission::whereId($request->id)->first();
        $permission->name = $request->name;
        $permission->description = $request->description;
        $permission->group_th = $request->group_th;
        $permission->group_en = $request->group_en;

        $permission->updated_at = Carbon::now();

        if($permission->save()){
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

       return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function destroy($id)
    {
        $status = false;
        $msg = 'ไม่สามารถลบข้อมูลได้';

        $permission = Permission::whereId($id)->first();

        if ($permission->delete()) {
            $status = true;
            $msg = 'ลบข้อมูลเรียบร้อย';
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }
}
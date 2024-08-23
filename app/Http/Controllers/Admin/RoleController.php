<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Role::all();

            if(!Auth::user()->hasRole('developer')) {
                $data = Role::where('name','!=','developer')->get();
            }

            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('btn',function ($data){

                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all role', 'edit role']) ? '<a class="btn btn-sm btn-warning" href="'.route('role.edit',['role' => $data['id']]).'"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all role', 'delete role']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`' . url('role') . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    if(in_array($data['name'],['developer', 'superadmin', 'admin', 'user'])){
                        $btnDel = '<button class="btn btn-sm btn-danger" disabled><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>';
                    }

                    $btn = $btnEdit . ' ' . $btnDel;

                    return $btn;
                })
                ->rawColumns(['btn'])
                ->make(true);
        }

        $permissions = Permission::all();

        if(!Auth::user()->hasRole('developer')) {
            $permissions = Permission::where('name','!=','*')->get();
        }

        // foreach ($permissions->groupBy('group') as $key => $group_permission) {
        //     dd($group_permission);
        // }

        return view('admin.role.index', compact('permissions'));
    }

    public function create() {
        $permissions = Permission::all();

        $permissions = Permission::all()->groupBy('group_th');

        if (App::isLocale('en')) {
            $permissions = Permission::all()->groupBy('group_en');
        }

        if(!Auth::user()->hasRole('developer')) {
            $permissions = Permission::where('name','!=','*')->get()->groupBy('group_th');
        }

        return view('admin.role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->guard_name = 'web';
        $role->created_at = Carbon::now();
        if($role->save()){

            $role->syncPermissions($request->permissions);

            toast('บันทึกข้อมูล','success');
            return redirect()->route('role.index');
        }

        Alert::error('ผิดพลาด');
        return redirect()->back();
    }

    public function edit($id)
    {
        $role = Role::whereId($id)->first();
        $permissions = Permission::all()->groupBy('group_th');

        if (App::isLocale('en')) {
            $permissions = Permission::all()->groupBy('group_en');
        }

        if(!Auth::user()->hasRole('developer')) {
            $permissions = Permission::where('name','!=','*')->get()->groupBy('group_th');
        }

        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::whereId($id)->first();
        $role->name = $request->name;
        $role->description = $request->description;

        $role->updated_at = Carbon::now();

        if($role->save()){

            $role->syncPermissions($request->permissions);

            toast('บันทึกข้อมูล','success');
            return redirect()->route('role.index');
        }

        Alert::error('ผิดพลาด');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $status = false;
        $msg = 'ไม่สามารถลบข้อมูลได้';

        $role = Role::whereId($id)->first();
        $role->revokePermissionTo($role->getPermissionNames()->toarray());

        if ($role->delete()) {
            $status = true;
            $msg = 'ลบข้อมูลเรียบร้อย';
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }
}
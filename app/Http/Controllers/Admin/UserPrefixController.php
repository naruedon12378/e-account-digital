<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

use App\Models\UserPrefix;

class UserPrefixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = UserPrefix::all();
            return DataTables::make($data)
                ->addIndexColumn()

                ->addColumn('btn',function ($data){
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all prefix', 'edit prefix']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`'.url('prefix/edit') . '/' . $data['id'].'`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all prefix', 'delete prefix']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`'. url('prefix/destroy') . '/' . $data['id'].'`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    $btn = $btnEdit . ' ' . $btnDel;

                    return $btn;
                })
                ->addColumn('publish',function ($data){
                    if($data['status']){
                        $publish = '<label class="switch"> <input type="checkbox" checked value="0" id="' . $data['id'] . '" onchange="publish(`'. url('prefix/publish') . '/' . $data['id'].'`)"> <span class="slider round"></span> </label>';
                    }else{
                        $publish = '<label class="switch"> <input type="checkbox" value="1" id="'.$data['id'].'" onchange="publish(`'. url('prefix/publish') . '/' . $data['id'].'`)"> <span class="slider round"></span> </label>';
                    }
                    if(Auth::user()->hasRole('user')) {
                        $publish = ($data['status'] ? '<span class="badge badge-success">เผยแพร่</span>' : '<span class="badge badge-danger">ไม่เผยแพร่</span>');
                    }
                    return $publish;
                })
                ->rawColumns(['btn', 'publish'])
                ->make(true);
        }
        return view('admin.prefix.index');
    }

    public function store(Request $request)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $prefix = new UserPrefix();
        $prefix->name_th = $request->name_th;
        $prefix->name_en = $request->name_en;

        if ($prefix->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function edit(string $id)
    {
        $prefix = UserPrefix::where('id',$id)->first();
        return response()->json(['prefix' => $prefix]);
    }

    public function update(Request $request)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $prefix = UserPrefix::whereId($request->id)->first();
        $prefix->name_th = $request->name_th;
        $prefix->name_en = $request->name_en;
        $prefix->updated_at = Carbon::now();

        if ($prefix->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $prefix = UserPrefix::whereId($id)->first();
        if($prefix->delete()){
            $status = true;
            $msg = 'เสร็จสิ้น';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function publish(string $id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $prefix = UserPrefix::whereId($id)->first();
        if($prefix->status == 1) {
            $prefix->status = 0;
        }else{
            $prefix->status = 1;
        }

        if($prefix->save()){
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}
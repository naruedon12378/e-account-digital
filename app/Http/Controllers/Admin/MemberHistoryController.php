<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

use App\Models\User;

class MemberHistoryController extends Controller
{
    public function index(Request $request) {
        if($request->ajax()){
            $data = User::Where('status',0)
            ->WhereHas('roles', function($q){
                $q->whereIn('name', ['admin','user']);
            })->get();

            // ถ้าไม่ใช้ Developer หรือ Superadmin จะเห็นได้แค่บริษัทตัวเอง
            if(!Auth::user()->hasAnyRole(['developer','admin'])) {
                $data = User::Where('status',0)->where('company_id', Auth::user()->company_id)
                        ->WhereHas('roles', function($q){
                            $q->whereIn('name', ['admin','user']);
                        })->get();
            }

            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('fullname', function($data){
                    $fullname = $data['firstname'] . ' ' . $data['lastname'];
                    return $fullname;
                })
                ->addColumn('img',function($data){
                    if($data->getFirstMediaUrl('user')){
                        $img = '<img src="'.asset($data->getFirstMediaUrl('user')).'" style="width: auto; height: 40px;">';
                    }else{
                        $img = '<img src="'.asset('images/no-image.jpg').'" style="width: auto; height: 40px;">';
                    }
                    return $img;
                })
                ->addColumn('phone', function ($data){
                    $phone = "<a href='tel:".$data['phone']."'>".$data['phone']."</a>";
                    return $phone;
                })
                ->addColumn('btn', function ($data) {
                    $btnRecovery = (Auth::user()->hasAnyPermission(['*', 'all member_history', 'edit member_history']) ? '<a class="btn btn-sm btn-success" onclick="recoveryData(`' . url('member_history/recovery') . '/' . $data['id'] . '`)"><i class="fas fa-undo-alt"></i> กู้ข้อมูล</a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all member_history', 'delete member_history']) ? '<button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(`' . url('member_history/destroy') . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i> ลบข้อมูล</button>' : '');

                    $btn = $btnRecovery . ' ' . $btnDel;

                    return $btn;
                })
                ->addColumn('role', function($data){
                    $role = $data->roles->pluck('description')[0];
                    return $role;
                })
                ->addColumn('created_at', function($data){
                    $created_at = Carbon::parse($data['created_at'])->format('d/m/Y');

                    return $created_at;
                })

                ->addColumn('updated_at', function($data){
                    $updated_at = Carbon::parse($data['updated_at'])->format('d/m/Y');

                    return $updated_at;
                })
                ->rawColumns(['btn', 'status', 'role', 'img', 'fullname', 'phone', 'created_at', 'updated_at'])
                ->make(true);
        }

        return view('admin.member_history.index');

    }

    public function recovery($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $user = User::whereId($id)->first();
        if($user->status == 1) {
            $user->status = 0;
        }else{
            $user->status = 1;
        }

        if($user->save()){
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }

    public function destroy($id)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $user = User::whereId($id)->first();
        if($user->delete()){
            $status = true;
            $msg = 'เสร็จสิ้น';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }
}
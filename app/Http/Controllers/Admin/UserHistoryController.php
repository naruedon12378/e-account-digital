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
use App\Models\UserPrefix;
use App\Models\Company;
use App\Models\Site;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserHistoryController extends Controller
{
    public function index(Request $request) {
        if($request->ajax()){
            $data = User::WhereHas('roles', function($q){
                $q->where('name', '!=' , 'user');
            })->where('status',0)->get();

            if(Auth::user()->hasRole('superadmin')) {
                $data = User::WhereHas('roles', function($q){
                    $q->whereNotIn('name',['developer', 'user']);
                })->where('status',0)->get();
            }else if(Auth::user()->hasRole('admin')) {
                $data = User::WhereHas('roles', function($q){
                    $q->whereNotIn('name',['developer', 'superadmin', 'user']);
                })->where('status',0)->get();
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
                ->addColumn('btn', function ($data) {
                    $btnRecovery = (Auth::user()->hasAnyPermission(['*', 'all user_history', 'edit user_history']) ? '<a class="btn btn-sm btn-success" onclick="recoveryData(`' . url('user_history/recovery') . '/' . $data['id'] . '`)"><i class="fas fa-undo-alt"></i> กู้ข้อมูล</a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all user_history', 'delete user_history']) ? '<button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(`' . url('user_history/destroy') . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i> ลบข้อมูล</button>' : '');

                    $btn = $btnRecovery . ' ' . $btnDel;

                    return $btn;
                })
                ->addColumn('role', function($data){
                    $role = $data->roles->pluck('description')[0];
                    return $role;
                })
                ->rawColumns(['btn','status','role','img','fullname'])
                ->make(true);
        }

        return view('admin.user_history.index');

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
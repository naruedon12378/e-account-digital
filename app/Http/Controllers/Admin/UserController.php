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
use App\Models\UserAddress;
use App\Models\UserPrefix;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::WhereHas('roles', function ($q) {
                $q->whereNotIn('name', ['user']);
            })->where('status', 1)->get();

            if (Auth::user()->hasRole('superadmin')) {
                $data = User::WhereHas('roles', function ($q) {
                    $q->whereNotIn('name', ['developer', 'user']);
                })->where('status', 1)->get();
            } else if (Auth::user()->hasRole('admin')) {
                $data = User::WhereHas('roles', function ($q) {
                    $q->whereNotIn('name', ['developer', 'superadmin', 'user']);
                })->where('status', 1)->get();
            }
            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('fullname', function ($data) {
                    $fullname = $data['firstname'] . ' ' . $data['lastname'];
                    return $fullname;
                })
                ->addColumn('img', function ($data) {
                    if ($data->getFirstMediaUrl('user')) {
                        $img = '<img src="' . asset($data->getFirstMediaUrl('user')) . '" style="width: auto; height: 40px;">';
                    } else {
                        $img = '<img src="' . asset('images/no-image.jpg') . '" style="width: auto; height: 40px;">';
                    }
                    return $img;
                })
                ->addColumn('btn', function ($data) {
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all user', 'edit user']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`' . url('user/edit') . '/' . $data['id'] . '`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i> แก้ไข</a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all user', 'delete user']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`' . url('user/destroy') . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    $btn = $btnEdit;

                    return $btn;
                })
                ->addColumn('role', function ($data) {
                    $role = $data->roles->pluck('description')[0];
                    return $role;
                })
                // ->addColumn('status',function ($data){
                //     if($data['status']){
                //         $status = '<label class="switch"> <input type="checkbox" checked value="0" id="' . $data['id'] . '" onchange="publish(`'. url('user/publish') . '/' . $data['id'].'`)"> <span class="slider round"></span> </label>';
                //     }else{
                //         $status = '<label class="switch"> <input type="checkbox" value="1" id="'.$data['id'].'" onchange="publish(`'. url('user/publish') . '/' . $data['id'].'`)"> <span class="slider round"></span> </label>';
                //     }

                //     if(Auth::user()->id == $data['id']){
                //         $status = '';
                //     }

                //     return $status;
                // })
                ->rawColumns(['btn', 'status', 'role', 'img', 'fullname'])
                ->make(true);
        }

        $user = Auth::user();

        if ($user->hasRole('developer')) {
            $roles = Role::all();
        } else if ($user->hasRole('superadmin')) {
            $roles = Role::whereNotIn('name', ['developer'])->orderBy('id', 'asc')->get();
        } else if ($user->hasRole('admin')) {
            $roles = Role::whereNotIn('name', ['developer', 'superadmin'])->orderBy('id', 'asc')->get();
        } else {
            $roles = Role::whereNotIn('name', ['developer', 'superadmin', 'admin'])->orderBy('id', 'asc')->get();
        }

        return view('admin.user.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $request->validate([
            'email' => 'unique:users',
            // 'username' => 'unique:users'
        ], [
            'email.unique' => 'มีผู้ใช้งานอีเมลนี้แล้ว',
            // 'username.unique' => 'มีชื่อผู้ใช้งานนี้แล้ว'
        ]);

        //pattern
        $config = [
            'table' => 'users',
            'field' => 'user_code',
            'length' => 10,
            'prefix' => 'EM' . date('Y') . date('m'),
            'reset_on_prefix_change' => true,
        ];
        // now use it

        $user_code = IdGenerator::generate($config);

        $user = new User();
        $user->user_code = $user_code;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        // $user->line_id = $request->line_id;
        $user->email = $request->email;
        // $user->username = $request->username;
        $user->password = bcrypt($request->password);

        //add brand and branch
        if ($user->save()) {
            // add Role
            $user->assignRole($request->role);

            if ($request->file('img')) {
                $getImage = $request->img;

                $path = storage_path('app/public');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $img = Image::make($getImage->getRealPath());
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public') . '/' . $getImage->getClientOriginalName());

                $user->addMedia(storage_path('app/public') . '/' . $getImage->getClientOriginalName())->toMediaCollection('user');
            }

            // $address = new UserAddress();
            // $address->user_id = $user->id;
            // $address->save();

            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::whereId($id)->with('roles')->first();
        $image = $user->getFirstMediaUrl('user');

        return response()->json(['user' => $user, 'image' => $image]);
    }

    public function update(Request $request)
    {
        dd($request->all());
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $request->validate([
            'email' => 'unique:users,email,' . $request->id,
            // 'username' => 'unique:users,username,' . $request->id
        ], [
            'email.unique' => 'มีผู้ใช้งานอีเมลนี้แล้ว',
            // 'username.unique' => 'มีชื่อผู้ใช้งานนี้แล้ว'
        ]);

        $user = User::whereId($request->id)->first();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        // $user->line_id = $request->line_id;
        $user->email = $request->email;
        // $user->username = $request->username;

        if ($user->password) {
            $user->password = bcrypt($request->password);
        }

        //add brand and branch
        if ($user->save()) {
            //update role
            $user->syncRoles($request->role);

            if ($request->file('img')) {
                $medias = $user->getMedia('user');
                if (count($medias) > 0) {
                    foreach ($medias as $media) {
                        $media->delete();
                    }
                }

                $getImage = $request->img;
                $path = storage_path('app/public');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $img = Image::make($getImage->getRealPath());
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public') . '/' . $getImage->getClientOriginalName());

                $user->addMedia(storage_path('app/public') . '/' . $getImage->getClientOriginalName())->toMediaCollection('user');
            }

            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function destroy($id)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $user = User::whereId($id)->first();
        if ($user->delete()) {
            $status = true;
            $msg = 'เสร็จสิ้น';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function publish($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $user = User::whereId($id)->first();
        if ($user->status == 1) {
            $user->status = 0;
        } else {
            $user->status = 1;
        }

        if ($user->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }

    public function profile(User $user)
    {
        $user_role = Auth::user();
        $prefixes = UserPrefix::where('status', 1)->get();

        return view('admin.user.profile', compact('user', 'prefixes'));
    }

    public function update_profile(Request $request, $id)
    {
        $request->validate([
            'email' => 'unique:users,email,' . $id,
            // 'username' => 'unique:users,username,' . $id
        ], [
            'email.unique' => 'มีผู้ใช้งานอีเมลนี้แล้ว',
            // 'username.unique' => 'มีชื่อผู้ใช้งานนี้แล้ว'
        ]);

        $user = User::whereId($id)->first();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        // $user->line_id = $request->line_id;
        $user->email = $request->email;
        // $user->username = $request->username;

        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->updated_at = Carbon::now();

        if ($user->save()) {


            if ($request->file('img')) {
                $medias = $user->getMedia('user');
                if (count($medias) > 0) {
                    foreach ($medias as $media) {
                        $media->delete();
                    }
                }

                $getImage = $request->img;
                $path = storage_path('app/public');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $img = Image::make($getImage->getRealPath());
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public') . '/' . $getImage->getClientOriginalName());

                $user->addMedia(storage_path('app/public') . '/' . $getImage->getClientOriginalName())->toMediaCollection('user');
            }

            Alert::success('บันทึกข้อมูล');
            return redirect()->route('user.profile', ['user' => $user->slug]);
        }

        Alert::error('ผิดพลาด');
        return redirect()->back();
    }
}
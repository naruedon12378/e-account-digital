<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::Where('status','1')
                        ->WhereHas('roles', function($q){
                            $q->whereIn('name', ['admin','user']);
                        })->get();

            // ถ้าไม่ใช้ Developer หรือ Superadmin จะเห็นได้แค่บริษัทตัวเอง
            if(!Auth::user()->hasAnyRole(['developer','admin'])) {
                $data = User::Where('status','1')->where('company_id', Auth::user()->company_id)
                        ->WhereHas('roles', function($q){
                            $q->whereIn('name', ['admin','user']);
                        })->get();
            }

            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('role', function ($data) {
                    $role = $data->roles->pluck('description')->ToArray();
                    return $role;
                })
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
                ->addColumn('phone', function ($data){
                    $phone = "<a href='tel:".$data['phone']."'>".$data['phone']."</a>";
                    return $phone;
                })
                ->addColumn('btn', function ($data) {
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all member', 'edit member']) && Auth::user()->id != $data['id'] ? '<a class="btn btn-sm btn-warning" href="'.route('member.edit', ['member' => $data['slug']]).'"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i> แก้ไข</a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all member', 'delete member']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`' . url('user/destroy') . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    $btn = $btnEdit;

                    return $btn;
                })

                ->addColumn('created_at', function($data){
                    $created_at = Carbon::parse($data['created_at'])->format('d/m/Y');

                    return $created_at;
                })
                ->rawColumns(['btn', 'img', 'fullname', 'phone', 'created_at', 'role'])
                ->make(true);
        }

        return view('admin.member.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $abilities = [
            'all',
            'view',
            'create',
            'edit',
            'delete'
        ];

        // Permission ที่จะไม่เอาไปใส่ในหน้าจัดการ Member
        $not_group_permissions = [
            'prefix',
            'article',
            'package_manage',
            'feature_title',
            'feature',
            'bank',
            'user',
            'user_history',
            'permission',
            'role'
        ];

        $other_permissions = ['*', 'website_setting'];

        $permissions_name = [];

        foreach ($not_group_permissions as $key => $group_perm) {
            foreach ($abilities as $akey => $ability) {
                array_push($permissions_name, $ability . ' ' . $group_perm);
            }
        }

        $permissions = Permission::whereNotIn('name', $permissions_name)->whereNotIn('name', $other_permissions)->get()->groupBy('group_th');

        if (App::isLocale('en')) {
            $permissions = Permission::whereNotIn('name', $permissions_name)->whereNotIn('name', $other_permissions)->get()->groupBy('group_en');
        }

        return view('admin.member.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'unique:users',
        ], [
            'email.unique' => 'มีผู้ใช้งานอีเมลนี้แล้ว',
        ]);

        $config = [
            'table' => 'users',
            'field' => 'user_code',
            'length' => 10,
            'prefix' => 'EM' . date('Y') . date('m'),
            'reset_on_prefix_change' => true,
        ];

        $user_code = IdGenerator::generate($config);

        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->user_code = $user_code;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        if(Auth::user()->company_id) {
            $user->company_id = Auth::user()->company_id;
        }

        $user->updated_at = Carbon::now();

        if ($user->save()) {
            $user->assignRole('user');
            $user->givePermissionTo($request->permissions);

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

            Alert::success('บันทึกข้อมูล');
            return redirect()->route('member.index');
        }

        Alert::error('ผิดพลาด', 'ไม่สามารถบันทึกข้อมูลได้');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $member)
    {
        $abilities = [
            'all',
            'view',
            'create',
            'edit',
            'delete'
        ];

        // Permission ที่จะไม่เอาไปใส่ในหน้าจัดการ Member
        $not_group_permissions = [
            'prefix',
            'article',
            'package_manage',
            'feature_title',
            'feature',
            'bank',
            'user',
            'user_history',
            'permission',
            'role'
        ];

        $other_permissions = ['*', 'website_setting'];

        $permissions_name = [];

        foreach ($not_group_permissions as $key => $group_perm) {
            foreach ($abilities as $akey => $ability) {
                array_push($permissions_name, $ability . ' ' . $group_perm);
            }
        }

        $permissions = Permission::whereNotIn('name', $permissions_name)->whereNotIn('name', $other_permissions)->get()->groupBy('group_th');

        if (App::isLocale('en')) {
            $permissions = Permission::whereNotIn('name', $permissions_name)->whereNotIn('name', $other_permissions)->get()->groupBy('group_en');
        }

        return view('admin.member.edit', compact('member', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::whereId($id)->first();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }

        $user->updated_at = Carbon::now();

        if ($user->save()) {

            $user->syncPermissions($request->permissions);

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
            return redirect()->route('member.index');
        }

        Alert::error('ผิดพลาด', 'ไม่สามารถบันทึกข้อมูลได้');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
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
}
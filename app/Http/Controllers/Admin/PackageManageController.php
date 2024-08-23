<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

use App\Models\Package;
use App\Models\FeatureTitle;
use App\Models\FeatureList;

class PackageManageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Package::all();
            return DataTables::make($data)
                ->addIndexColumn()

                ->addColumn('btn',function ($data){
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all package_manage', 'edit package_manage']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`'.url('package_manage/edit') . '/' . $data['id'].'`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all package_manage', 'delete package_manage']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`'. url('package_manage/destroy') . '/' . $data['id'].'`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    $btn = $btnEdit . ' ' . $btnDel;

                    return $btn;
                })
                ->addColumn('sorting', function ($data) {
                    $sorting = '<input name="sort" type="number" class="form-control " value="' . $data['sort'] . '" id="' . $data['id'] . '" onkeyup="sort(this,`' . url('package_manage/sort') . '/' . $data['id'] . '`)"/>';
                    return $sorting;
                })
                ->addColumn('publish', function ($data) {
                    if ($data['publish']) {
                        $publish = '<label class="switch"> <input type="checkbox" checked value="0" id="' . $data['id'] . '" onchange="publish(`' . url('package_manage/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                    } else {
                        $publish = '<label class="switch"> <input type="checkbox" value="1" id="' . $data['id'] . '" onchange="publish(`' . url('package_manage/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                    }
                    if (Auth::user()->hasRole('user')) {
                        $publish = ($data['status'] ? '<span class="badge badge-success">เผยแพร่</span>' : '<span class="badge badge-danger">ไม่เผยแพร่</span>');
                    }
                    return $publish;
                })
                ->rawColumns(['btn', 'publish', 'sorting'])
                ->make(true);
        }

        $feature_titles = FeatureTitle::where('publish', 1)->orderBy('sort', 'asc')->get();
        $feature_lists = FeatureList::where('publish', 1)->orderBy('sort', 'asc')->get();

        return view('admin.package_manage.index', compact('feature_titles', 'feature_lists'));
    }

    public function store(Request $request)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $package_manage = new Package();
        $package_manage->name_th = $request->name_th;
        $package_manage->name_en = $request->name_en;
        $package_manage->description_th = $request->description_th;
        $package_manage->description_en = $request->description_en;
        $package_manage->price = $request->price;
        $package_manage->discount = $request->discount;
        $package_manage->user_limit = $request->user_limit;
        $package_manage->storage_limit = $request->storage_limit;

        if ($package_manage->save()) {
            $package_manage->features()->attach(explode(",", $request->feature_lists));

            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function edit(string $id)
    {
        $package_manage = Package::where('id', $id)->first();
        $package_features = $package_manage->features->pluck('id')->ToArray();
        return response()->json(['package_manage' => $package_manage, 'package_features' => $package_features]);
    }

    public function update(Request $request)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $package_manage = Package::whereId($request->id)->first();
        $package_manage->name_th = $request->name_th;
        $package_manage->name_en = $request->name_en;
        $package_manage->description_th = $request->description_th;
        $package_manage->description_en = $request->description_en;
        $package_manage->price = $request->price;
        $package_manage->discount = $request->discount;
        $package_manage->user_limit = $request->user_limit;
        $package_manage->storage_limit = $request->storage_limit;
        $package_manage->updated_at = Carbon::now();

        if ($package_manage->save()) {
            $package_manage->features()->sync(explode(",", $request->feature_lists));

            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $package_manage = Package::whereId($id)->first();
        if ($package_manage->delete()) {
            $status = true;
            $msg = 'เสร็จสิ้น';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function publish(string $id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $package_manage = Package::whereId($id)->first();
        if ($package_manage->publish == 1) {
            $package_manage->publish = 0;
        } else {
            $package_manage->publish = 1;
        }

        if ($package_manage->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }

    public function sort($id, Request $request)
    {
        $status = false;
        $message = 'ไม่สามารถบันทึกข้อมูลได้';

        $package_manage = Package::whereId($id)->first();
        $package_manage->sort = $request->data;
        $package_manage->updated_at = Carbon::now();

        if ($package_manage->save()) {
            $status = true;
            $message = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }
}

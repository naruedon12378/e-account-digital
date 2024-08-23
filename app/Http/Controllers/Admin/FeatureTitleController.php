<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

use App\Models\FeatureTitle;

class FeatureTitleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FeatureTitle::all();
            return DataTables::make($data)
                ->addIndexColumn()

                ->addColumn('btn',function ($data){
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all feature_title', 'edit feature_title']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`'.url('feature_title/edit') . '/' . $data['id'].'`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all feature_title', 'delete feature_title']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`'. url('feature_title/destroy') . '/' . $data['id'].'`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    $btn = $btnEdit . ' ' . $btnDel;

                    return $btn;
                })
                ->addColumn('sorting', function ($data) {
                    $sorting = '<input name="sort" type="number" class="form-control " value="' . $data['sort'] . '" id="' . $data['id'] . '" onkeyup="sort(this,`' . url('feature_title/sort') . '/' . $data['id'] . '`)"/>';
                    return $sorting;
                })
                ->addColumn('publish', function ($data) {
                    if ($data['publish']) {
                        $publish = '<label class="switch"> <input type="checkbox" checked value="0" id="' . $data['id'] . '" onchange="publish(`' . url('feature_title/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                    } else {
                        $publish = '<label class="switch"> <input type="checkbox" value="1" id="' . $data['id'] . '" onchange="publish(`' . url('feature_title/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                    }
                    if (Auth::user()->hasRole('user')) {
                        $publish = ($data['status'] ? '<span class="badge badge-success">เผยแพร่</span>' : '<span class="badge badge-danger">ไม่เผยแพร่</span>');
                    }
                    return $publish;
                })
                ->rawColumns(['btn', 'publish', 'sorting'])
                ->make(true);
        }
        return view('admin.feature_title.index');
    }

    public function store(Request $request)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $feature_title = new FeatureTitle();
        $feature_title->name_th = $request->name_th;
        $feature_title->name_en = $request->name_en;

        if ($feature_title->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function edit(string $id)
    {
        $feature_title = FeatureTitle::where('id', $id)->first();
        return response()->json(['feature_title' => $feature_title]);
    }

    public function update(Request $request)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $feature_title = FeatureTitle::whereId($request->id)->first();
        $feature_title->name_th = $request->name_th;
        $feature_title->name_en = $request->name_en;
        $feature_title->updated_at = Carbon::now();

        if ($feature_title->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $feature_title = FeatureTitle::whereId($id)->first();
        if ($feature_title->delete()) {
            $status = true;
            $msg = 'เสร็จสิ้น';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function publish(string $id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $feature_title = FeatureTitle::whereId($id)->first();
        if ($feature_title->publish == 1) {
            $feature_title->publish = 0;
        } else {
            $feature_title->publish = 1;
        }

        if ($feature_title->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }

    public function sort($id, Request $request)
    {
        $status = false;
        $message = 'ไม่สามารถบันทึกข้อมูลได้';

        $feature_title = FeatureTitle::whereId($id)->first();
        $feature_title->sort = $request->data;
        $feature_title->updated_at = Carbon::now();
        if ($feature_title->save()) {
            $status = true;
            $message = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }
}

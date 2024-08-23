<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use RealRashid\FeatureTitlet;
use Illuminate\Support\Facades\Auth;

use App\Models\FeatureTitle;
use App\Models\FeatureList;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FeatureList::all();
            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('title', function ($data) {
                    $title = $data->feature_title->name_th;
                    return $title;
                })
                ->addColumn('btn',function ($data){
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all feature', 'edit feature']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`'.url('feature/edit') . '/' . $data['id'].'`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all feature', 'delete feature']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`'. url('feature/destroy') . '/' . $data['id'].'`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    $btn = $btnEdit . ' ' . $btnDel;

                    return $btn;
                })
                ->addColumn('sorting', function ($data) {
                    $sorting = '<input name="sort" type="number" class="form-control " value="' . $data['sort'] . '" id="' . $data['id'] . '" onkeyup="sort(this,`' . url('feature/sort') . '/' . $data['id'] . '`)"/>';
                    return $sorting;
                })
                ->addColumn('publish', function ($data) {
                    if ($data['publish']) {
                        $publish = '<label class="switch"> <input type="checkbox" checked value="0" id="' . $data['id'] . '" onchange="publish(`' . url('feature/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                    } else {
                        $publish = '<label class="switch"> <input type="checkbox" value="1" id="' . $data['id'] . '" onchange="publish(`' . url('feature/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                    }
                    if (Auth::user()->hasRole('user')) {
                        $publish = ($data['status'] ? '<span class="badge badge-success">เผยแพร่</span>' : '<span class="badge badge-danger">ไม่เผยแพร่</span>');
                    }
                    return $publish;
                })
                ->rawColumns(['btn', 'publish', 'title', 'sorting'])
                ->make(true);
        }

        $feature_titles = FeatureTitle::where('publish', 1)->get();

        return view('admin.feature.index', compact('feature_titles'));
    }

    public function store(Request $request)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $feature = new FeatureList();
        $feature->name_th = $request->name_th;
        $feature->name_en = $request->name_en;
        $feature->feature_title_id = $request->feature_title;

        if ($feature->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function edit(string $id)
    {
        $feature = FeatureList::where('id', $id)->first();
        return response()->json(['feature' => $feature]);
    }

    public function update(Request $request)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $feature = FeatureList::whereId($request->id)->first();
        $feature->name_th = $request->name_th;
        $feature->name_en = $request->name_en;
        $feature->feature_title_id = $request->feature_title;
        $feature->updated_at = Carbon::now();

        if ($feature->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $feature = FeatureList::whereId($id)->first();
        if ($feature->delete()) {
            $status = true;
            $msg = 'เสร็จสิ้น';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function publish(string $id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $feature = FeatureList::whereId($id)->first();
        if ($feature->publish == 1) {
            $feature->publish = 0;
        } else {
            $feature->publish = 1;
        }

        if ($feature->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }

    public function sort($id, Request $request)
    {
        $status = false;
        $message = 'ไม่สามารถบันทึกข้อมูลได้';

        $feature = FeatureList::whereId($id)->first();
        $feature->sort = $request->data;
        $feature->updated_at = Carbon::now();
        if ($feature->save()) {
            $status = true;
            $message = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }
}

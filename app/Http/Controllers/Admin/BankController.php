<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Image;

use App\Models\Bank;

class BankController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Bank::all();
            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('img',function($data){
                    if($data->getFirstMediaUrl('bank')){
                        $img = '<img src="'.asset($data->getFirstMediaUrl('bank')).'" style="width: auto; height: 40px;">';
                    }else{
                        $img = '<img src="'.asset('images/no-image.jpg').'" style="width: auto; height: 40px;">';
                    }
                    return $img;
                })
                ->addColumn('btn',function ($data){
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all bank', 'edit bank']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`'.url('bank/edit') . '/' . $data['id'].'`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all bank', 'delete bank']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`'. url('bank/destroy') . '/' . $data['id'].'`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    $btn = $btnEdit . ' ' . $btnDel;

                    return $btn;
                })
                ->addColumn('publish',function ($data){
                    if($data['publish']){
                        $publish = '<label class="switch"> <input type="checkbox" checked value="0" id="' . $data['id'] . '" onchange="publish(`'. url('bank/publish') . '/' . $data['id'].'`)"> <span class="slider round"></span> </label>';
                    }else{
                        $publish = '<label class="switch"> <input type="checkbox" value="1" id="'.$data['id'].'" onchange="publish(`'. url('bank/publish') . '/' . $data['id'].'`)"> <span class="slider round"></span> </label>';
                    }
                    if(Auth::user()->hasRole('user')) {
                        $publish = ($data['publish'] ? '<span class="badge badge-success">เผยแพร่</span>' : '<span class="badge badge-danger">ไม่เผยแพร่</span>');
                    }
                    return $publish;
                })
                ->rawColumns(['btn', 'publish', 'img'])
                ->make(true);
        }
        return view('admin.bank.index');
    }

    public function store(Request $request)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $bank = new Bank();
        $bank->name_th = $request->name_th;
        $bank->name_en = $request->name_en;

        if ($bank->save()) {

            if($request->file('img')){
                $getImage = $request->img;

                $path = storage_path('app/public');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $img = Image::make($getImage->getRealPath());
                $img->resize(300, 300, function ($constraint){
                    $constraint->aspectRatio();
                })->save(storage_path('app/public').'/'.$getImage->getClientOriginalName());

                $bank->addMedia(storage_path('app/public').'/'.$getImage->getClientOriginalName())->toMediaCollection('bank');
            }
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function edit(string $id)
    {
        $bank = Bank::where('id',$id)->first();
        $image = $bank->getFirstMediaUrl('bank');

        return response()->json(['bank' => $bank, 'image' => $image]);
    }

    public function update(Request $request)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $bank = Bank::whereId($request->id)->first();
        $bank->name_th = $request->name_th;
        $bank->name_en = $request->name_en;
        $bank->updated_at = Carbon::now();

        if ($bank->save()) {

            if($request->file('img')){
                $medias = $bank->getMedia('bank');
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
                $img->resize(300, 300, function ($constraint){
                    $constraint->aspectRatio();
                })->save(storage_path('app/public').'/'.$getImage->getClientOriginalName());

                $bank->addMedia(storage_path('app/public').'/'.$getImage->getClientOriginalName())->toMediaCollection('bank');
            }

            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $bank = Bank::whereId($id)->first();
        if($bank->delete()){
            $status = true;
            $msg = 'เสร็จสิ้น';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function publish(string $id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $bank = Bank::whereId($id)->first();
        if($bank->publish == 1) {
            $bank->publish = 0;
        }else{
            $bank->publish = 1;
        }

        if($bank->save()){
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }

    public function sort($id, Request $request)
    {
        $status = false;
        $message = 'ไม่สามารถบันทึกข้อมูลได้';

        $bank = Bank::whereId($id)->first();
        $bank->sort = $request->data;
        $bank->updated_at = Carbon::now();

        if($bank->save()){
            $status = true;
            $message = 'บันทึกข้อมูลเรียบร้อย';
        }

        return response()->json(['status' => $status, 'message' => $message]);
    }
}

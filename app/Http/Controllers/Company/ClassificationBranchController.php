<?php

namespace App\Http\Controllers\Company;

use App\Helpers\UniversalHelper;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SettingClassificationBranch;
use App\Models\SettingDocType;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ClassificationBranchController extends Controller
{
    private $Helper;
    public function __construct()
    {
        $this->Helper = new UniversalHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = false;
        $msg = 'บันทึกผิดพลาด';
        $data = new SettingClassificationBranch();
        $data->classification_branch_code = $request->classification_branch_code;
        $data->name = $request->name;
        $data->description = $request->description;
        $data->classification_group_id = $request->group_id;
        $data->description = $request->description;

        if ($data->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = SettingClassificationBranch::whereId($id)->first();
        return response()->json(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $inputData = $request->all();
        unset($inputData['_token']);
        DB::beginTransaction();
        try {
            $status = false;
            $msg = 'บันทึกผิดพลาด';
            $update = SettingClassificationBranch::findOrFail($inputData['id'])->update($inputData);
            if ($update) {
                DB::commit();
                $status = true;
                $msg = 'บันทึกข้อมูลสำเร็จ';
            }

            return response()->json(['status' => $status, 'msg' => $msg]);
        } catch (\Exception $ex) {
            $result['status'] = "failed";
            $result['message'] = $ex;
            dd($ex);
            DB::rollBack();
            Alert::error('ผิดพลาด');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $data_select = SettingClassificationBranch::whereId($id)->first();
        if ($data_select->publish == 1) {
            $data_select->publish = 0;
        } else {
            $data_select->publish = 1;
        }

        if ($data_select->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }

    public function publish($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $data_select = SettingClassificationBranch::whereId($id)->first();
        if ($data_select->publish == 1) {
            $data_select->publish = 0;
        } else {
            $data_select->publish = 1;
        }

        if ($data_select->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}

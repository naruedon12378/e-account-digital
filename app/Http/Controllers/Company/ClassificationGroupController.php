<?php

namespace App\Http\Controllers\Company;

use App\Helpers\UniversalHelper;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SettingClassificationGroup;
use App\Models\SettingDocType;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ClassificationGroupController extends Controller
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
        // $company_id = Company::where('user_id', Auth::user()->id)->pluck('id')->first();
        $company_id = Auth::user()->company_id;
        if (isset($company_id)) {
            if ($request->ajax()) {
                $data = SettingClassificationGroup::where('company_id', $company_id)->where('record_status', 1)->withCount('settingClassificationBranches')->get();
                return DataTables::make($data)
                    ->addColumn('classification_code', function ($data) {
                        $classification_code = $data['classification_code'];
                        return $classification_code;
                    })
                    ->addColumn('name', function ($data) {
                        $name = $data['name'];
                        return $name;
                    })
                    ->addColumn('items', function ($data) {
                        $items = $data['setting_classification_branches_count'];
                        return $items;
                    })
                    ->addColumn('show_area', function ($data) {
                        $show_area = "-";
                        $revenue = $data['publish_income'];
                        $expense = $data['publish_expense'];
                        if ($revenue == 1 && $expense == 1) {
                            $show_area = __('doc_setting.all');
                        } else if ($revenue == 1) {
                            $show_area = __('doc_setting.income');
                        } else if ($expense == 1) {
                            $show_area = __('doc_setting.expense');
                        }
                        return $show_area;
                    })
                    ->addColumn('publish', function ($data) {
                        if ($data['publish']) {
                            $publish = '<label class="switch"> <input type="checkbox" checked value="0" id="' . $data['id'] . '" onchange="publish(`' . url('doc_setting/setting-classification-group/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                        } else {
                            $publish = '<label class="switch"> <input type="checkbox" value="1" id="' . $data['id'] . '" onchange="publish(`' . url('doc_setting/setting-classification-group/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                        }

                        return $publish;
                    })
                    ->addColumn('btn', function ($data) {
                        $btnEdit = (Auth::user()->hasAnyPermission(['*', 'doc_setting']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`' . url('doc_setting/setting-classification-group/edit') . '/' . $data['id'] . '`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                        $btnView = (Auth::user()->hasAnyPermission(['*', 'doc_setting']) ? '<a class="btn btn-sm btn-primary ml-1" onclick="viewData(`' . url('doc_setting/setting-classification-group/edit') . '/' . $data['id'] . '`)"><i class="fa fa-eye" data-toggle="tooltip" title="เพิ่มเติม"></i></a>' : '');
                        $btnDel = (Auth::user()->hasAnyPermission(['*', 'doc_setting']) ? '<button class="btn btn-sm btn-danger ml-1" onclick="confirmDelete(`' . url('doc_setting/setting-classification-group/destroy') . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');
                        $btn = $btnEdit . $btnView . $btnDel;
                        return $btn;
                    })
                    ->rawColumns(['btn', 'publish', 'classification_code', 'name', 'items', 'show_area'])
                    ->make(true);
            }

            return view('company.doc_setting.classification_group.index', compact('company_id'));
        } else {
            Alert::error('ไม่พบบริษัทของท่าน');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'classification_code' => [
                'required',
                Rule::unique('setting_classification_groups')->where(function ($query) use ($request) {
                    return $query->where('company_id', $request->company_id);
                }),
            ],
            'name' => [
                'required',
                Rule::unique('setting_classification_groups')->where(function ($query) use ($request) {
                    return $query->where('company_id', $request->company_id);
                }),
            ],
        ]);

        if ($validator->fails()) {
            $status = false;
            $msg = 'ข้อมูลซ้ำ';
        } else {
            $data = new SettingClassificationGroup();
            $data->classification_code = $request->classification_code;
            $data->name = $request->name;
            $data->description = $request->description;
            $data->publish_income = $request->publish_income;
            $data->publish_expense = $request->publish_expense;
            $data->company_id = $request->company_id;

            if ($data->save()) {
                $status = true;
                $msg = 'บันทึกข้อมูลสำเร็จ';
            }
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
        $data = SettingClassificationGroup::whereId($id)->with([
            'settingClassificationBranches' => function ($type) {
                return $type->where('publish', 1);
            }
        ])->first();
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
            $validator = Validator::make($request->all(), [
                'classification_code' => [
                    'required',
                    Rule::unique('setting_classification_groups')->where(function ($query) use ($request) {
                        return $query->where('company_id', $request->company_id)->where('id', '!=', $request->id);
                    }),
                ],
                'name' => [
                    'required',
                    Rule::unique('setting_classification_groups')->where(function ($query) use ($request) {
                        return $query->where('company_id', $request->company_id)->where('id', '!=', $request->id);
                    }),
                ],
            ]);

            if ($validator->fails()) {
                $status = false;
                $msg = 'ข้อมูลซ้ำ';
            } else {
                $update = SettingClassificationGroup::findOrFail($inputData['id'])->update($inputData);
                if ($update) {
                    DB::commit();
                    $status = true;
                    $msg = 'บันทึกข้อมูลสำเร็จ';
                }
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

        $data_select = SettingClassificationGroup::whereId($id)->first();
        if ($data_select->record_status == 1) {
            $data_select->record_status = 0;
        } else {
            $data_select->record_status = 1;
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

        $data_select = SettingClassificationGroup::whereId($id)->first();
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

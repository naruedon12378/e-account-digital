<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\Http\Controllers\Controller;
use App\Models\AccountCode;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

use App\Models\PayrollFinancialRecord;
use App\Models\Company;

class PayrollFinancialRecordController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PayrollFinancialRecord::where([['company_id', Auth::user()->company_id], ['record_status', 1]])->with('account')->get();
            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('btn', function ($data) {
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'payroll_financial_record', 'edit payroll_financial_record']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`' . url('payroll_financial_record/edit') . '/' . $data['id'] . '`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'payroll_financial_record', 'delete payroll_financial_record']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`' . url('payroll_financial_record/destroy') . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    $btn = $btnEdit . ' ' . $btnDel;

                    return $btn;
                })
                ->addColumn('account_code', function ($data) {
                    $locale = app()->getLocale();
                    $name = 'name_' . $locale;
                    $account_code = isset($data->account) ? $data->account->account_code . ' - ' . $data->account->$name : "-";
                    return $account_code;
                })
                ->addColumn('account_type', function ($data) {
                    // $account_type = ($data['type_account'] == PayrollFinancialRecord::REVENUE ? __('payroll_financial_record.revenue') : __('payroll_financial_record.deduct'));
                    $account_type = $data['type_account'];
                    return $account_type;
                })
                ->addColumn('type', function ($data) {
                    $type = ($data['type'] == PayrollFinancialRecord::REGULAR ? __('payroll_financial_record.regular') : __('payroll_financial_record.irregular'));
                    return $type;
                })
                ->addColumn('account_ref', function ($data) {
                    $lang = app()->getLocale();
                    $account_ref = isset($data['account']) ? ($lang == 'th' ? $data['account']->name_th : $data['account']->name_en) : '';
                    return $account_ref;
                })
                ->addColumn('annual_revenue', function ($data) {
                    $annual_revenue = ($data['annual_revenue'] == PayrollFinancialRecord::ANNUAL_REVENUE_INCLUDE ? __('payroll_financial_record.include_in_this_item') : __('payroll_financial_record.exclude_this_item'));
                    return $annual_revenue;
                })
                ->addColumn('publish', function ($data) {
                    if ($data['publish']) {
                        $publish = '<label class="switch"> <input type="checkbox" checked value="0" id="' . $data['id'] . '" onchange="publish(`' . url('payroll_financial_record/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                    } else {
                        $publish = '<label class="switch"> <input type="checkbox" value="1" id="' . $data['id'] . '" onchange="publish(`' . url('payroll_financial_record/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                    }
                    if (Auth::user()->hasRole('user')) {
                        $publish = ($data['status'] ? '<span class="badge badge-success">เผยแพร่</span>' : '<span class="badge badge-danger">ไม่เผยแพร่</span>');
                    }
                    return $publish;
                })
                ->rawColumns(['btn', 'publish', 'account', 'account_type', 'type', 'account_ref', 'annual_revenue'])
                ->make(true);
        }

        $account_types = AccountCode::where('company_id', Auth::user()->company_id)->select('id', 'account_code', 'name_th', 'name_en')->where('is_active', 1)->get();
        return view('admin.payroll_financial_record.index', compact('account_types'));
    }

    public function store(Request $request)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $payroll_financial_record = new PayrollFinancialRecord();
        $payroll_financial_record->name_th = $request->name_th;
        $payroll_financial_record->name_en = $request->name_en;
        $payroll_financial_record->type_form = $request->type_form == 'advance' ? 2 : 1;
        $payroll_financial_record->type_account = $request->account_type;
        $payroll_financial_record->type = $request->type;
        $payroll_financial_record->company_id = (Auth::user()->company_id ? Auth::user()->company_id : null);
        if ($request->type_form == "advance") {
            $payroll_financial_record->account_id = $request->account_id;
            $payroll_financial_record->annual_revenue = $request->annual_revenue;
            $payroll_financial_record->ssc_base_salary = $request->ssc_base_salary;
        }

        if ($payroll_financial_record->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function edit(string $id)
    {
        $payroll_financial_record = PayrollFinancialRecord::where('id', $id)->first();
        return response()->json(['payroll_financial_record' => $payroll_financial_record]);
    }

    public function update(Request $request)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $payroll_financial_record = PayrollFinancialRecord::findOrFail($request->id);
        $payroll_financial_record->name_th = $request->name_th;
        $payroll_financial_record->name_en = $request->name_en;
        $payroll_financial_record->type_form = $request->type_form == 'advance' ? 2 : 1;
        $payroll_financial_record->type_account = $request->account_type;
        $payroll_financial_record->type = $request->type;
        $payroll_financial_record->company_id = (Auth::user()->company_id ? Auth::user()->company_id : null);
        if ($request->type_form == "advance") {
            $payroll_financial_record->account_id = $request->account_id;
            $payroll_financial_record->annual_revenue = $request->annual_revenue;
            $payroll_financial_record->ssc_base_salary = $request->ssc_base_salary;
        }
        $payroll_financial_record->updated_at = Carbon::now();

        if ($payroll_financial_record->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $payroll_financial_record = PayrollFinancialRecord::whereId($id)->first();
        if ($payroll_financial_record) {
            $payroll_financial_record->record_status = 0;
            if ($payroll_financial_record->save()) {
                $status = true;
                $msg = 'เสร็จสิ้น';
            }
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function publish(string $id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $payroll_financial_record = PayrollFinancialRecord::whereId($id)->first();
        if ($payroll_financial_record->publish == 1) {
            $payroll_financial_record->publish = 0;
        } else {
            $payroll_financial_record->publish = 1;
        }

        if ($payroll_financial_record->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}

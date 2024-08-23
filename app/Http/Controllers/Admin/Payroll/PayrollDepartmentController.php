<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

use App\Models\PayrollDepartment;
use App\Models\Company;

class PayrollDepartmentController extends Controller
{
    private $company_id;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->company_id = Auth::user()->company_id;
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PayrollDepartment::where([['company_id', Auth::user()->company_id], ['record_status', 1]])->get();
            return DataTables::make($data)
                ->addIndexColumn()

                ->addColumn('btn', function ($data) {
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all payroll_department', 'edit payroll_department']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`' . url('payroll_department/edit') . '/' . $data['id'] . '`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all payroll_department', 'delete payroll_department']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`' . url('payroll_department/destroy') . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    $btn = $btnEdit . ' ' . $btnDel;

                    return $btn;
                })
                ->addColumn('account', function ($data) {
                    $account = '';
                    return $account;
                })
                ->addColumn('publish', function ($data) {
                    if ($data['publish']) {
                        $publish = '<label class="switch"> <input type="checkbox" checked value="0" id="' . $data['id'] . '" onchange="publish(`' . url('payroll_department/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                    } else {
                        $publish = '<label class="switch"> <input type="checkbox" value="1" id="' . $data['id'] . '" onchange="publish(`' . url('payroll_department/publish') . '/' . $data['id'] . '`)"> <span class="slider round"></span> </label>';
                    }
                    if (Auth::user()->hasRole('user')) {
                        $publish = ($data['status'] ? '<span class="badge badge-success">เผยแพร่</span>' : '<span class="badge badge-danger">ไม่เผยแพร่</span>');
                    }
                    return $publish;
                })
                ->rawColumns(['btn', 'publish', 'account'])
                ->make(true);
        }
        return view('admin.payroll_department.index');
    }

    public function store(Request $request)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $payroll_department = new PayrollDepartment();
        $payroll_department->name_th = $request->name_th;
        $payroll_department->name_en = $request->name_en;
        $payroll_department->account_id = $request->account;
        $payroll_department->company_id = Auth::user()->company_id ?? null;

        if ($payroll_department->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function edit(string $id)
    {
        $payroll_department = PayrollDepartment::where('id', $id)->first();
        if ($this->company_id == $payroll_department->company_id) {
            return response()->json(['payroll_department' => $payroll_department]);
        } else {
            return abort(403, 'Forbidden');
        }
    }

    public function update(Request $request)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $payroll_department = PayrollDepartment::whereId($request->id)->first();
        $payroll_department->name_th = $request->name_th;
        $payroll_department->name_en = $request->name_en;
        $payroll_department->account_id = $request->account;
        $payroll_department->updated_at = Carbon::now();

        if ($payroll_department->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function destroy(string $id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $payroll_department = PayrollDepartment::whereId($id)->first();
        $payroll_department->record_status = 0;
        $payroll_department->publish = 0;

        if ($payroll_department->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }

    public function publish(string $id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $payroll_department = PayrollDepartment::whereId($id)->first();
        if ($payroll_department->publish == 1) {
            $payroll_department->publish = 0;
        } else {
            $payroll_department->publish = 1;
        }

        if ($payroll_department->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}

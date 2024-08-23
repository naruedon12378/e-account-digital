<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\Helpers\UniversalHelper;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Company;
use App\Models\PayrollEmployee;
use App\Models\PayrollFinancialRecord;
use App\Models\PayrollSalary;
use App\Models\PayrollSalaryDetail;
use App\Models\PayrollSalaryMoreDetail;
use App\Models\PayrollSalarySummary;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PayrollSalarySummaryController extends Controller
{
    private $company_id;
    private $Helper;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->company_id = Auth::user()->company_id;
            return $next($request);
        });
        $this->Helper = new UniversalHelper();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company_id = Auth::user()->company_id;
        if (isset($company_id)) {
            if ($request->ajax()) {
                $data = PayrollSalarySummary::where('company_id', $company_id)->with('payrollSalarySummaryDetails')->get();
                return DataTables::make($data)
                    ->make(true);
            }
            return view('admin.payroll_salary_summary.index');
        } else {
            Alert::error('ไม่พบบริษัทของท่าน');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $company_id = Auth::user()->company_id;
        $employees = PayrollEmployee::where('company_id', $company_id)->get();
        $employees->each(function ($employee) {
            $combinedNames = $employee->getName();
            $employee->name_th = $combinedNames['name_th'];
            $employee->name_en = $combinedNames['name_en'];
        });

        $financial_records = PayrollFinancialRecord::where([['company_id', $company_id], ['record_status', 1], ['publish', 1]])->select('name_th', 'name_en', 'id', 'type_account')->orderBy('type_account')->get();

        $company_setting = Company::find($company_id);

        return view('admin.payroll_salary.create', compact('employees', 'company_setting', 'financial_records'));
    }

    function convertToDouble($numberString)
    {
        if ($numberString != null) {
            $cleanString = str_replace(',', '', $numberString);
            $number = floatval($cleanString);
            return $number;
        } else {
            return 0;
        }
    }

    function generateCode()
    {
        $date = Carbon::now()->format('Ymd');
        $count = PayrollSalarySummary::where('company_id', Auth::user()->company_id)->whereDate('created_at', Carbon::today())->count() + 1;
        $countFormatted = str_pad($count, 4, '0', STR_PAD_LEFT);
        $code = "SPAY-" . $date . $countFormatted;
        return $code;
    }

    public function store(Request $request)
    {
        $inputData = $request->all();
        $from_date = DateTime::createFromFormat('d/m/Y', $inputData['from_date'])->format('Y-m-d');
        $to_date = DateTime::createFromFormat('d/m/Y', $inputData['to_date'])->format('Y-m-d');

        $getPayrun = PayrollSalary::with('payrollSalaryDetails.payrollSalaryMoreDetails.payrollFinancialRecord')
            ->where([
                ['company_id', Auth::user()->company_id],
                ['status', 3],
            ])->whereBetween('due_date', [$from_date, $to_date])->get();

        $payrun_count = count($getPayrun);
        $total = 0;
        $sum_revenue_item = 0;
        $sum_deduct_item = 0;
        $employee_social_security = 0;
        $sum_holding_tax = 0;
        $company_social_security = 0;
        $payable_social_security = 0;
        $payable_holding_tax = 0;
        $net_amount = 0;

        foreach ($getPayrun as $payrun) {
            dd($payrun);
        }

        $payroll_salary_data = [
            'code' => $this->generateCode(),
            'issue_date' => date('Y-m-d'),
            'from_date' => $from_date,
            'to_date' => $to_date,
            // 'total' => $this->convertToDouble($inputData['total_salary_text']),
            // 'sum_revenue_item' => $this->convertToDouble($inputData['total_revenue_text']),
            // 'sum_deduct_item' => $this->convertToDouble($inputData['total_deduct_text']),
            // 'sum_holding_tax' => $this->convertToDouble($inputData['total_withholding_tax_text']),
            // 'employee_social_security' => $this->convertToDouble($inputData['total_social_security_text']),
            // 'company_social_security' => $this->convertToDouble($inputData['company_social_security']),
            // 'payable_social_security' => $this->convertToDouble($inputData['total_social_security_payable']),
            // 'payable_holding_tax' => $this->convertToDouble($inputData['total_withholding_tax_payable']),
            // 'net_amount' => $this->convertToDouble($inputData['amount_pay']),
            // 'company_id' => Auth::user()->company_id,
            // 'emp_count' => count($inputData['employee']),
        ];

        // ถ้ากดลงบัญชี จะไปลงที่ค้างจ่าย

        $employees = [];
        for ($i = 0; $i < count($inputData['employee']); $i++) {
            $employees[$i]['employee_id'] = $inputData['employee'][$i];
            $employees[$i]['salary'] = $inputData['salary'][$i];
            $employees[$i]['salary'] = $inputData['salary'][$i];
            $employees[$i]['withholding_tax'] = $inputData['withholding_tax'][$i];
            $employees[$i]['social_security'] = $inputData['social_security'][$i];
            $employees[$i]['total_revenue'] = $inputData['total_revenue'][$i];
            $employees[$i]['total_deduct'] = $inputData['total_deduct'][$i];
            $employees[$i]['net_salary'] = $inputData['net_salary'][$i];
            if (isset($inputData['frecord'])) {
                foreach ($inputData['frecord'] as $key => $addition_row) {
                    $employees[$i]['frecord'][$key] = [
                        'payroll_salary_financial_record_id' => $addition_row,
                        'value' => $this->convertToDouble($inputData['frecord_' . $key][$i]),
                    ];
                }
            }
        }

        DB::beginTransaction();
        try {
            $main_insert = PayrollSalary::create($payroll_salary_data);
            if ($main_insert) {
                foreach ($employees as $employee) {
                    $employee['payroll_salary_id'] = $main_insert->id;
                    $detail_insert = PayrollSalaryDetail::create($employee);
                    if ($detail_insert) {
                        if (isset($employee['frecord'])) {
                            foreach ($employee['frecord'] as $frecord) {
                                $frecord['payroll_salary_detail_id'] = $detail_insert->id;
                                $last_insert = PayrollSalaryMoreDetail::create($frecord);
                            }
                        }
                    }
                }

                // add log
                $this->Helper->addActivityLog('payroll_salaries', 'id', $main_insert->id, 'สร้างรายการ');

                DB::commit();
                toast('บันทึกข้อมูล', 'success');
            }
            return redirect()->route('payroll_salary.index');
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payroll_salary = PayrollSalary::with('company', 'payrollSalaryDetails.payrollSalaryMoreDetails.payrollFinancialRecord', 'payrollSalaryDetails.employee')->find($id);
        // dd($payroll_salary);
        $tabs = ['detail' => 'Detail', 'payment' => 'Payment', 'history' => 'History'];
        $getLog = ActivityLog::where([
            ['table_name', 'payroll_salaries'],
            ['primary_key_value', $id],
        ])->orderBy('created_at', 'DESC')->get();
        $histories = [];
        foreach ($getLog as $log) {
            $audit_logs = [
                'user' => $log['created_by'],
                'date' => date('d/m/Y', strtotime($log['created_at'])),
                'time' => date('H:i น.', strtotime($log['created_at'])),
                'desc' => $log['activity'],
            ];
            array_push($histories, $audit_logs);
        }
        if ($payroll_salary->company_id == $this->company_id) {
            $getFinancialRecordID = $payroll_salary->payrollSalaryDetails[0]->payrollSalaryMoreDetails->pluck('payroll_salary_financial_record_id')->toArray();
            $getFinancialRecordForThisRow = PayrollFinancialRecord::where([['company_id', $this->company_id]])->whereIn('id', $getFinancialRecordID);
            if (!empty($getFinancialRecordID)) {
                $arrayFinancialID =  implode(',', $getFinancialRecordID);
                $getFinancialRecordForThisRow->orderByRaw("FIELD(id, $arrayFinancialID)");
            }
            $getFinancialRecordForThisRow = $getFinancialRecordForThisRow->get();
            $financial_records = $getFinancialRecordForThisRow;
            $this->Helper->addActivityLog('payroll_salaries', 'id', $id, 'ดูรายการ');

            return view('admin.payroll_salary.show', compact('payroll_salary', 'tabs', 'histories', 'financial_records'));
        } else {
            return abort(403, 'Forbidden');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payroll_salary = PayrollSalary::with('payrollSalaryDetails.payrollSalaryMoreDetails.payrollFinancialRecord')->find($id);
        if ($payroll_salary->company_id == $this->company_id) {
            $company_id = Auth::user()->company_id;
            $employees = PayrollEmployee::where('company_id', $company_id)->get();
            $employees->each(function ($employee) {
                $combinedNames = $employee->getName();
                $employee->name_th = $combinedNames['name_th'];
                $employee->name_en = $combinedNames['name_en'];
            });
            $financial_records = PayrollFinancialRecord::where([['company_id', $company_id], ['record_status', 1], ['publish', 1]])->select('name_th', 'name_en', 'id', 'type_account')->orderBy('type_account')->get();
            $company_setting = Company::find($company_id);

            return view('admin.payroll_salary.edit', compact('id', 'payroll_salary', 'company_id', 'employees', 'financial_records', 'company_setting'));
        } else {
            return abort(403, 'Forbidden');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputData = $request->all();
        switch ($inputData['action']) {
            case 0:
                $status = 0;
                break;
            case 3:
                $status = 1;
                break;
            case 1:
            case 2:
                $status = 2;
                break;
            default:
                $status = -1;
                break;
        }

        if ($status != -1) {
            $payroll_salary_data = [
                'code' => $this->generateCode(),
                'issue_date' => DateTime::createFromFormat('d/m/Y', $inputData['issue_date'])->format('Y-m-d'),
                'due_date' => DateTime::createFromFormat('d/m/Y', $inputData['due_date'])->format('Y-m-d'),
                'from_date' => DateTime::createFromFormat('d/m/Y', $inputData['from_date'])->format('Y-m-d'),
                'to_date' => DateTime::createFromFormat('d/m/Y', $inputData['to_date'])->format('Y-m-d'),
                'total' => $this->convertToDouble($inputData['total_salary_text']),
                'sum_revenue_item' => $this->convertToDouble($inputData['total_revenue_text']),
                'sum_deduct_item' => $this->convertToDouble($inputData['total_deduct_text']),
                'sum_holding_tax' => $this->convertToDouble($inputData['total_withholding_tax_text']),
                'employee_social_security' => $this->convertToDouble($inputData['total_social_security_text']),
                'company_social_security' => $this->convertToDouble($inputData['company_social_security']),
                'payable_social_security' => $this->convertToDouble($inputData['total_social_security_payable']),
                'payable_holding_tax' => $this->convertToDouble($inputData['total_withholding_tax_payable']),
                'net_amount' => $this->convertToDouble($inputData['amount_pay']),
                'emp_count' => count($inputData['employee']),
                'company_id' => Auth::user()->company_id,
                'status' => $status
            ];

            // ถ้ากดลงบัญชี จะไปลงที่ค้างจ่าย

            $employees = [];
            for ($i = 0; $i < count($inputData['employee']); $i++) {
                $employees[$i]['employee_id'] = $inputData['employee'][$i];
                $employees[$i]['salary'] = $inputData['salary'][$i];
                $employees[$i]['salary'] = $inputData['salary'][$i];
                $employees[$i]['withholding_tax'] = $inputData['withholding_tax'][$i];
                $employees[$i]['social_security'] = $inputData['social_security'][$i];
                $employees[$i]['total_revenue'] = $inputData['total_revenue'][$i];
                $employees[$i]['total_deduct'] = $inputData['total_deduct'][$i];
                $employees[$i]['net_salary'] = $inputData['net_salary'][$i];
                if (isset($inputData['frecord'])) {
                    foreach ($inputData['frecord'] as $key => $addition_row) {
                        $employees[$i]['frecord'][$key] = [
                            'payroll_salary_financial_record_id' => $addition_row,
                            'value' => $this->convertToDouble($inputData['frecord_' . $key][$i]),
                        ];
                    }
                }
            }

            DB::beginTransaction();
            try {
                $getTarget = PayrollSalary::find($inputData['id']);
                $main_insert = $getTarget->update($payroll_salary_data);
                if ($main_insert) {
                    $get1stChild = PayrollSalaryDetail::where('payroll_salary_id', $inputData['id'])->get();
                    foreach ($get1stChild as $child) {
                        $get2ndChild = PayrollSalaryMoreDetail::where('payroll_salary_detail_id', $child['id'])->get();
                        foreach ($get2ndChild as $lastChild) {
                            $lastChild->forceDelete();
                        }
                        $child->forceDelete();
                    }
                    // เหลือลบลูก
                    foreach ($employees as $employee) {
                        $employee['payroll_salary_id'] = $getTarget->id;
                        $detail_insert = PayrollSalaryDetail::create($employee);
                        if ($detail_insert) {
                            if (isset($employee['frecord'])) {
                                foreach ($employee['frecord'] as $frecord) {
                                    $frecord['payroll_salary_detail_id'] = $detail_insert->id;
                                    $last_insert = PayrollSalaryMoreDetail::create($frecord);
                                }
                            }
                        }
                    }

                    $this->Helper->addActivityLog('payroll_salaries', 'id', $inputData['id'], 'อัพเดทรายการ');


                    DB::commit();
                    toast('บันทึกข้อมูล', 'success');
                }
                return redirect()->route('payroll_salary.index');
            } catch (\Exception $ex) {
                $result['status'] = "failed";
                $result['message'] = $ex;
                dd($ex);
                DB::rollBack();
                Alert::error('ผิดพลาด');
                return redirect()->back();
            }
        } else {
            Alert::error('เกิดข้อผิดพลาด กรุณาทำรายการใหม่');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ไม่สามารถลบข้อมูลได้';

        $role = PayrollSalary::findOrFail($id);
        $role->status = 4;
        if ($role->save()) {
            $status = true;
            $msg = 'ลบข้อมูลเรียบร้อย';
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }
}

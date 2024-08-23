<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\Helpers\UniversalHelper;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Company;
use App\Models\ExpenseRecord;
use App\Models\ExpenseRecordItem;
use App\Models\PayrollEmployee;
use App\Models\PayrollFinancialRecord;
use App\Models\PayrollSalary;
use App\Models\PayrollSalaryDetail;
use App\Models\PayrollSalaryMoreDetail;
use App\Services\NumberingService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

use function PHPUnit\Framework\isEmpty;

class PayrollSalaryController extends Controller
{
    private $company_id;
    private $Helper;
    private $numberingService;

    public function __construct(NumberingService $numberingService)
    {
        $this->middleware(function ($request, $next) {
            $this->company_id = Auth::user()->company_id;
            return $next($request);
        });
        $this->Helper = new UniversalHelper();
        $this->numberingService = $numberingService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company_id = Auth::user()->company_id;
        if (isset($company_id)) {
            if ($request->ajax()) {
                $data = PayrollSalary::where('company_id', $company_id)->with('payrollSalaryDetails')->get();
                return DataTables::make($data)
                    ->addColumn('btn', function ($data) {
                        $btnView = ('<a class="btn btn-sm btn-info" href="' . route('payroll_salary.show', ['payroll_salary' => $data['id']]) . '"><i class="fas fa-eye" data-toggle="tooltip" title="รายละเอียด"></i></a>');
                        $btnEdit = ('<a class="btn btn-sm btn-warning ml-1" href="' . route('payroll_salary.edit', ['payroll_salary' => $data['id']]) . '"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>');
                        $btnDel = ('<a class="btn btn-sm btn-danger ml-1" onclick="confirmDelete(`' . route('payroll_salary.destroy', ['payroll_salary' => $data['id']]) . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></a>');
                        if (in_array($data['status'], [2, 3, 4])) {
                            // ถ้า อนุมัติแล้ว , จ่ายแล้ว , void แล้ว จะไม่แสดงปุ่มแก้ไขและลบ
                            $btn = $btnView;
                        } else {
                            $btn = $btnView . $btnEdit . $btnDel;
                        }

                        return $btn;
                    })
                    ->rawColumns(['btn'])
                    ->make(true);
            }
            return view('admin.payroll_salary.index');
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
        $count = PayrollSalary::where('company_id', $this->company_id)->whereDate('created_at', Carbon::today())->count() + 1;
        $countFormatted = str_pad($count, 4, '0', STR_PAD_LEFT);
        $code = "PAY-" . $date . $countFormatted;
        return $code;
    }

    public function store(Request $request)
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
                // รอลงบัญชี
                break;
            default:
                $status = -1;
                break;
        }

        $pvd_text = isset($inputData['total_pvd_text']) ? $this->convertToDouble($inputData['total_pvd_text']) : 0;

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
                'pvd' => $pvd_text,
                'payable_holding_tax' => $this->convertToDouble($inputData['total_withholding_tax_payable']),
                'net_amount' => $this->convertToDouble($inputData['amount_pay']),
                'company_id' => Auth::user()->company_id,
                'emp_count' => count($inputData['employee']),
                'status' => $status
            ];

            $employees = [];
            for ($i = 0; $i < count($inputData['employee']); $i++) {
                $employees[$i]['employee_id'] = $inputData['employee'][$i];
                $employees[$i]['salary'] = $inputData['salary'][$i];
                $employees[$i]['salary'] = $inputData['salary'][$i];
                $employees[$i]['withholding_tax'] = $inputData['withholding_tax'][$i];
                $employees[$i]['social_security'] = $inputData['social_security'][$i];
                $employees[$i]['pvd'] = isset($inputData['pvd'][$i]) ? $inputData['pvd'][$i] : 0;
                $employees[$i]['total_revenue'] = $inputData['total_revenue'][$i];
                $employees[$i]['total_deduct'] = $inputData['total_deduct'][$i];
                $employees[$i]['net_salary'] = $inputData['net_salary'][$i];
                if (isset($inputData['frecord'])) {
                    foreach ($inputData['frecord'] as $key => $addition_row) {
                        $filtered_records = PayrollFinancialRecord::leftJoin('account_codes', function ($join) {
                            $join->on('payroll_financial_records.account_id', '=', 'account_codes.id')
                                ->whereNotNull('payroll_financial_records.account_id');
                        })
                            ->where('payroll_financial_records.id', $addition_row)
                            ->select(
                                'payroll_financial_records.id',
                                'annual_revenue',
                                'ssc_base_salary',
                                'account_id',
                                DB::raw('IF(payroll_financial_records.account_id IS NOT NULL, account_codes.account_code, NULL) as account_code'),
                                DB::raw('IF(payroll_financial_records.account_id IS NOT NULL, account_codes.name_th, NULL) as name')
                            )
                            ->first();
                        $employees[$i]['frecord'][$key] = [
                            'payroll_salary_financial_record_id' => $addition_row,
                            'value' => $this->convertToDouble($inputData['frecord_' . $key][$i]),
                            'annual_revenue' => $filtered_records['annual_revenue'],
                            'ssc_base_salary' => $filtered_records['ssc_base_salary'],
                            'account_code' => $filtered_records['account_code'],
                            'name' => $filtered_records['name'],
                        ];
                    }
                }
            }

            DB::beginTransaction();
            try {
                $main_insert = PayrollSalary::create($payroll_salary_data);
                $base_sal = $payroll_salary_data['total'];
                $record_not_include_salary_arr = [];
                if ($main_insert) {
                    foreach ($employees as $employee) {
                        $employee['payroll_salary_id'] = $main_insert->id;
                        $detail_insert = PayrollSalaryDetail::create($employee);
                        if ($detail_insert) {
                            if (isset($employee['frecord'])) {
                                foreach ($employee['frecord'] as $frecord) {
                                    $frecord['payroll_salary_detail_id'] = $detail_insert->id;
                                    $last_insert = PayrollSalaryMoreDetail::create($frecord);
                                    if ($frecord['account_code'] == null) {
                                        $base_sal += $frecord['value'];
                                    } else {
                                        // $record_not_include_salary_arr[$frecord['account_code']]
                                        array_push($record_not_include_salary_arr, $frecord);
                                    }
                                }
                            }
                        }
                    }
                    $record_not_include_salary = [];
                    if (!empty($record_not_include_salary_arr)) {
                        foreach ($record_not_include_salary_arr as $record) {
                            $account_code = $record['account_code'];
                            if (!isset($record_not_include_salary[$account_code])) {
                                $record_not_include_salary[$account_code] = $record;
                            } else {
                                $record_not_include_salary[$account_code]['value'] += $record['value'];
                            }
                        }
                    }

                    if ($status == 2) {
                        // อนุมัติลงบัญชี
                        $exp_main = [
                            'reference' => $payroll_salary_data['code'],
                            'doc_number' => $this->numberingService->getRefNumber('EXP'),
                            'transaction_type' => 'EXP',
                            'seller_id' => 1, //ต้อง get seller_id จาก tbl_company แทนค่า 1 รอพี่ไนท์ทำ
                            'issue_date' => $payroll_salary_data['issue_date'],
                            'due_date' => $payroll_salary_data['due_date'],
                            'total_std_amt' => 0,
                            'total_vat_amt' => 0,
                            'total_wht_amt' => 0,
                            'grand_total' => $payroll_salary_data['net_amount'],
                            'company_id' => $payroll_salary_data['company_id'],
                            'status_code' => 'outstanding',
                            'progress' => 'exp',
                        ];

                        $expense_main_insert = ExpenseRecord::create($exp_main);
                        if ($expense_main_insert) {
                            $exp_detail_data = [
                                '0' => [
                                    'expense_record_id' => $expense_main_insert->id,
                                    'line_item_no' => 1,
                                    'code' => 1,
                                    'name' => 'เงินเดือน ค่าจ้าง',
                                    'account_code' => 530101,
                                    'price' => $base_sal,
                                ],
                                '1' => [
                                    'expense_record_id' => $expense_main_insert->id,
                                    'line_item_no' => 2,
                                    'code' => 2,
                                    'name' => 'ภ.ง.ด. 1 ค้างจ่าย',
                                    'account_code' => 215201,
                                    'price' => $this->convertToDouble($inputData['total_withholding_tax_payable']),
                                ],
                                '2' => [
                                    'expense_record_id' => $expense_main_insert->id,
                                    'line_item_no' => 3,
                                    'code' => 3,
                                    'name' => 'ประกันสังคมค้างจ่าย',
                                    'account_code' => 215501,
                                    'price' => $this->convertToDouble($inputData['total_social_security_payable']),

                                ],
                                '3' => [
                                    'expense_record_id' => $expense_main_insert->id,
                                    'line_item_no' => 4,
                                    'code' => 4,
                                    'name' => 'เงินสมทบประกันสังคม และกองทุนทดแทน',
                                    'account_code' => 215201,
                                    'price' => $this->convertToDouble($inputData['total_social_security_text']),
                                ],
                                '4' => [
                                    'expense_record_id' => $expense_main_insert->id,
                                    'line_item_no' => 5,
                                    'code' => 5,
                                    'name' => 'กองทุนสำรองเลี้ยงชีพค้างจ่าย',
                                    'account_code' => 212302,
                                    'price' => $pvd_text * 2,
                                ],
                                '5' => [
                                    'expense_record_id' => $expense_main_insert->id,
                                    'line_item_no' => 6,
                                    'code' => 6,
                                    'name' => 'เงินสมทบกองทุนสำรองเลี้ยงชีพ',
                                    'account_code' => 530105,
                                    'price' => $pvd_text,
                                ],
                            ];
                            $counter = 0;
                            if (!empty($record_not_include_salary)) {
                                foreach ($record_not_include_salary as $key => $not_include) {
                                    $counter++;
                                    $r_data = [
                                        'expense_record_id' => $expense_main_insert->id,
                                        'line_item_no' => $counter + 6,
                                        'code' => $counter + 6,
                                        'name' => $not_include['name'],
                                        'account_code' => $not_include['account_code'],
                                        'price' => $not_include['value'],
                                    ];
                                    array_push($exp_detail_data, $r_data);
                                }
                            }


                            foreach ($exp_detail_data as $exp_detail_insert) {
                                ExpenseRecordItem::create($exp_detail_insert);
                            }
                        }
                    }

                    // add log
                    $this->Helper->addActivityLog('payroll_salaries', 'id', $main_insert->id, 'log.create');

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
            $text =  $log['activity'];
            $audit_logs = [
                'user' => $log['created_by'],
                'date' => date('d/m/Y', strtotime($log['created_at'])),
                'time' => date('H:i น.', strtotime($log['created_at'])),
                'desc' => __($log['activity']),
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
            $this->Helper->addActivityLog('payroll_salaries', 'id', $id, 'log.view');

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
        $payroll_salary = PayrollSalary::with('payrollSalaryDetails.payrollSalaryMoreDetails.payrollFinancialRecord', 'payrollSalaryDetails.employee')->find($id);
        if ($payroll_salary->company_id == $this->company_id) {
            $company_id = Auth::user()->company_id;
            $employees = PayrollEmployee::where('company_id', $company_id)->get();
            $employees->each(function ($employee) {
                $combinedNames = $employee->getName();
                $employee->name_th = $combinedNames['name_th'];
                $employee->name_en = $combinedNames['name_en'];
            });
            $getFinancialRecordID = $payroll_salary->payrollSalaryDetails[0]->payrollSalaryMoreDetails->pluck('payroll_salary_financial_record_id')->toArray();
            $getFinancialRecordForThisRow = PayrollFinancialRecord::where([['company_id', $this->company_id]])->whereIn('id', $getFinancialRecordID);
            if (!empty($getFinancialRecordID)) {
                $arrayFinancialID =  implode(',', $getFinancialRecordID);
                $getFinancialRecordForThisRow->orderByRaw("FIELD(id, $arrayFinancialID)");
            }
            $getFinancialRecordForThisRow = $getFinancialRecordForThisRow->get();
            $financial_records = $getFinancialRecordForThisRow;
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
                // ลงตาราง expense
                break;
            default:
                $status = -1;
                break;
        }

        $pvd_text = isset($inputData['total_pvd_text']) ? $this->convertToDouble($inputData['total_pvd_text']) : 0;

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
                'pvd' => $pvd_text,
                'payable_holding_tax' => $this->convertToDouble($inputData['total_withholding_tax_payable']),
                'net_amount' => $this->convertToDouble($inputData['amount_pay']),
                'company_id' => Auth::user()->company_id,
                'emp_count' => count($inputData['employee']),
                'status' => $status
            ];

            $employees = [];
            for ($i = 0; $i < count($inputData['employee']); $i++) {
                $employees[$i]['employee_id'] = $inputData['employee'][$i];
                $employees[$i]['salary'] = $inputData['salary'][$i];
                $employees[$i]['salary'] = $inputData['salary'][$i];
                $employees[$i]['withholding_tax'] = $inputData['withholding_tax'][$i];
                $employees[$i]['social_security'] = $inputData['social_security'][$i];
                $employees[$i]['pvd'] = isset($inputData['pvd'][$i]) ? $inputData['pvd'][$i] : 0;
                $employees[$i]['total_revenue'] = $inputData['total_revenue'][$i];
                $employees[$i]['total_deduct'] = $inputData['total_deduct'][$i];
                $employees[$i]['net_salary'] = $inputData['net_salary'][$i];
                if (isset($inputData['frecord'])) {
                    foreach ($inputData['frecord'] as $key => $addition_row) {
                        $filtered_records = PayrollFinancialRecord::leftJoin('account_codes', function ($join) {
                            $join->on('payroll_financial_records.account_id', '=', 'account_codes.id')
                                ->whereNotNull('payroll_financial_records.account_id');
                        })
                            ->where('payroll_financial_records.id', $addition_row)
                            ->select(
                                'payroll_financial_records.id',
                                'annual_revenue',
                                'ssc_base_salary',
                                'account_id',
                                DB::raw('IF(payroll_financial_records.account_id IS NOT NULL, account_codes.account_code, NULL) as account_code'),
                                DB::raw('IF(payroll_financial_records.account_id IS NOT NULL, account_codes.name_th, NULL) as name')
                            )
                            ->first();
                        $employees[$i]['frecord'][$key] = [
                            'payroll_salary_financial_record_id' => $addition_row,
                            'value' => $this->convertToDouble($inputData['frecord_' . $key][$i]),
                            'annual_revenue' => $filtered_records['annual_revenue'],
                            'ssc_base_salary' => $filtered_records['ssc_base_salary'],
                            'account_code' => $filtered_records['account_code'],
                            'name' => $filtered_records['name'],
                        ];
                    }
                }
            }

            DB::beginTransaction();
            try {
                $getTarget = PayrollSalary::find($inputData['id']);
                $main_insert = $getTarget->update($payroll_salary_data);
                $base_sal = $payroll_salary_data['total'];
                $record_not_include_salary_arr = [];
                if ($main_insert) {
                    $get1stChild = PayrollSalaryDetail::where('payroll_salary_id', $inputData['id'])->get();
                    foreach ($get1stChild as $child) {
                        $get2ndChild = PayrollSalaryMoreDetail::where('payroll_salary_detail_id', $child['id'])->get();
                        foreach ($get2ndChild as $lastChild) {
                            $lastChild->forceDelete();
                        }
                        $child->forceDelete();
                    }

                    foreach ($employees as $employee) {
                        $employee['payroll_salary_id'] = $inputData['id'];
                        $detail_insert = PayrollSalaryDetail::create($employee);
                        if ($detail_insert) {
                            if (isset($employee['frecord'])) {
                                foreach ($employee['frecord'] as $frecord) {
                                    $frecord['payroll_salary_detail_id'] = $detail_insert->id;
                                    $last_insert = PayrollSalaryMoreDetail::create($frecord);
                                    if ($frecord['account_code'] == null) {
                                        $base_sal += $frecord['value'];
                                    } else {
                                        // $record_not_include_salary_arr[$frecord['account_code']]
                                        array_push($record_not_include_salary_arr, $frecord);
                                    }
                                }
                            }
                        }
                    }
                    $record_not_include_salary = [];
                    if (!empty($record_not_include_salary_arr)) {
                        foreach ($record_not_include_salary_arr as $record) {
                            $account_code = $record['account_code'];
                            if (!isset($record_not_include_salary[$account_code])) {
                                $record_not_include_salary[$account_code] = $record;
                            } else {
                                $record_not_include_salary[$account_code]['value'] += $record['value'];
                            }
                        }
                    }

                    if ($status == 2) {
                        // อนุมัติลงบัญชี
                        $exp_main = [
                            'reference' => $payroll_salary_data['code'],
                            'doc_number' => $this->numberingService->getRefNumber('EXP'),
                            'transaction_type' => 'EXP',
                            'seller_id' => 1, //ต้อง get seller_id จาก tbl_company แทนค่า 1 รอพี่ไนท์ทำ
                            'issue_date' => $payroll_salary_data['issue_date'],
                            'due_date' => $payroll_salary_data['due_date'],
                            'total_std_amt' => 0,
                            'total_vat_amt' => 0,
                            'total_wht_amt' => 0,
                            'grand_total' => $payroll_salary_data['net_amount'],
                            'company_id' => $payroll_salary_data['company_id'],
                            'status_code' => 'outstanding',
                            'progress' => 'exp',
                        ];

                        $expense_main_insert = ExpenseRecord::create($exp_main);
                        if ($expense_main_insert) {
                            $exp_detail_data = [
                                '0' => [
                                    'expense_record_id' => $expense_main_insert->id,
                                    'line_item_no' => 1,
                                    'code' => 1,
                                    'name' => 'เงินเดือน ค่าจ้าง',
                                    'account_code' => 530101,
                                    'price' => $base_sal,
                                ],
                                '1' => [
                                    'expense_record_id' => $expense_main_insert->id,
                                    'line_item_no' => 2,
                                    'code' => 2,
                                    'name' => 'ภ.ง.ด. 1 ค้างจ่าย',
                                    'account_code' => 215201,
                                    'price' => $this->convertToDouble($inputData['total_withholding_tax_payable']),
                                ],
                                '2' => [
                                    'expense_record_id' => $expense_main_insert->id,
                                    'line_item_no' => 3,
                                    'code' => 3,
                                    'name' => 'ประกันสังคมค้างจ่าย',
                                    'account_code' => 215501,
                                    'price' => $this->convertToDouble($inputData['total_social_security_payable']),

                                ],
                                '3' => [
                                    'expense_record_id' => $expense_main_insert->id,
                                    'line_item_no' => 4,
                                    'code' => 4,
                                    'name' => 'เงินสมทบประกันสังคม และกองทุนทดแทน',
                                    'account_code' => 215201,
                                    'price' => $this->convertToDouble($inputData['total_social_security_text']),
                                ],
                                '4' => [
                                    'expense_record_id' => $expense_main_insert->id,
                                    'line_item_no' => 5,
                                    'code' => 5,
                                    'name' => 'กองทุนสำรองเลี้ยงชีพค้างจ่าย',
                                    'account_code' => 212302,
                                    'price' => $pvd_text * 2,
                                ],
                                '5' => [
                                    'expense_record_id' => $expense_main_insert->id,
                                    'line_item_no' => 6,
                                    'code' => 6,
                                    'name' => 'เงินสมทบกองทุนสำรองเลี้ยงชีพ',
                                    'account_code' => 530105,
                                    'price' => $pvd_text,
                                ],
                            ];
                            $counter = 0;
                            if (!empty($record_not_include_salary)) {
                                foreach ($record_not_include_salary as $key => $not_include) {
                                    $counter++;
                                    $r_data = [
                                        'expense_record_id' => $expense_main_insert->id,
                                        'line_item_no' => $counter + 6,
                                        'code' => $counter + 6,
                                        'name' => $not_include['name'],
                                        'account_code' => $not_include['account_code'],
                                        'price' => $not_include['value'],
                                    ];
                                    array_push($exp_detail_data, $r_data);
                                }
                            }
                            foreach ($exp_detail_data as $exp_detail_insert) {
                                ExpenseRecordItem::create($exp_detail_insert);
                            }
                        }
                    }

                    $this->Helper->addActivityLog('payroll_salaries', 'id', $inputData['id'], 'log.edit');

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
            $this->Helper->addActivityLog('payroll_salaries', 'id', $id, 'log.delete');
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }
}

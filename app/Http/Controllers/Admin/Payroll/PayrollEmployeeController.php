<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Facades\Auth;

use App\Models\PayrollEmployee;
use App\Models\UserPrefix;
use App\Models\Bank;
use App\Models\ChartOfAccount;
use App\Models\PayrollDepartment;
use DateTime;
use Illuminate\Support\Facades\DB;

class PayrollEmployeeController extends Controller
{
    private $company_id;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->company_id = Auth::user()->company_id;
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $company_id = Auth::user()->company_id;
        if (isset($company_id)) {
            if ($request->ajax()) {
                $data = PayrollEmployee::where('company_id', $company_id)->where('record_status', 1)
                    ->with('prefix', 'department')->get();
                return DataTables::make($data)
                    ->addColumn('name', function ($data) {
                        $lang = app()->getLocale();
                        $prefix = $lang == 'th' ? $data['prefix']->name_th : $data['prefix']->name_en;
                        $first_name = $lang == 'th' ? $data['first_name_th'] : $data['first_name_en'];
                        $mid_name = $lang == 'th' ? $data['mid_name_th'] : $data['mid_name_en'];
                        $last_name = $lang == 'th' ? $data['last_name_th'] : $data['last_name_en'];
                        $name = $prefix . " " . $first_name . " " . $mid_name . " " . $last_name;
                        return $name;
                    })
                    ->addColumn('department_text', function ($data) {
                        $department_text = "";
                        if (isset($data['department'])) {
                            $lang = app()->getLocale();
                            $department_text = $lang == 'th' ? $data['department']->name_th : $data['department']->name_en;
                        }
                        return $department_text;
                    })
                    ->addColumn('btn', function ($data) {
                        $btnEdit = ('<a class="btn btn-sm btn-warning" href="' . route('payroll_employee.edit', ['payroll_employee' => $data['id']]) . '"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>');
                        $btnView = ('<a class="btn btn-sm btn-primary ml-1" href="' . route('payroll_employee.show', ['payroll_employee' => $data['id']]) . '"><i class="fa fa-eye" data-toggle="tooltip" title="เพิ่มเติม"></i></a>');
                        $btnDel = ('<a class="btn btn-sm btn-danger ml-1" onclick="confirmDelete(`' . route('payroll_employee.destroy', ['payroll_employee' => $data['id']]) . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></a>');
                        $btn = $btnEdit . $btnView . $btnDel;
                        return $btn;
                    })
                    ->rawColumns(['btn'])
                    ->make(true);
            }
            return view('admin.payroll_employee.index', compact('company_id'));
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
        $prefixes = UserPrefix::where('status', 1)->get();
        $banks = Bank::where('publish', 1)->get();
        $departments = PayrollDepartment::where([['publish', 1], ['company_id', Auth::user()->company_id]])->get();
        $account_types = ChartOfAccount::where('company_id', Auth::user()->company_id)->get();

        return view('admin.payroll_employee.form', compact('prefixes', 'banks', 'departments', 'account_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputData = $request->all();
        $inputData['start_date'] = DateTime::createFromFormat('d/m/Y', $inputData['start_date'])->format('Y-m-d');
        $inputData['company_id'] = Auth::user()->company_id;
        DB::beginTransaction();
        try {
            $insert = PayrollEmployee::create($inputData);
            if ($insert) {
                if ($request->file('img')) {
                    $medias = $insert->getMedia('employee_profile');
                    if (count($medias) > 0) {
                        foreach ($medias as $media) {
                            $media->delete();
                        }
                    }

                    $getImage = $request->file('img');
                    $dateTime = Carbon::now();
                    $formattedDateTime = $dateTime->format('YmdHis');
                    $newFileName = $formattedDateTime . '_' . $request->file('img')->getClientOriginalName();

                    $insert->addMedia($getImage)
                        ->usingFileName($newFileName)
                        ->toMediaCollection('employee_profile');
                }

                if ($request->file('img_citizen')) {
                    $medias = $insert->getMedia('employee_ctz');
                    if (count($medias) > 0) {
                        foreach ($medias as $media) {
                            $media->delete();
                        }
                    }

                    $getImage = $request->file('img_citizen');
                    $dateTime = Carbon::now();
                    $formattedDateTime = $dateTime->format('YmdHis');
                    $newFileName = $formattedDateTime . '_' . $request->file('img_citizen')->getClientOriginalName();

                    $insert->addMedia($getImage)
                        ->usingFileName($newFileName)
                        ->toMediaCollection('employee_ctz');
                }
                DB::commit();
                toast('บันทึกข้อมูล', 'success');
            }
            return redirect()->route('payroll_employee.index');
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
        $payroll_employee = PayrollEmployee::find($id);
        if ($payroll_employee->company_id == $this->company_id) {
            $prefixes = UserPrefix::where('status', 1)->get();
            $banks = Bank::where('publish', 1)->get();
            $departments = PayrollDepartment::where([['publish', 1], ['company_id', Auth::user()->company_id]])->get();
            $account_types = ChartOfAccount::where('company_id', Auth::user()->company_id)->get();
        } else {
            return abort(403, 'Forbidden');
        }
        return view('admin.payroll_employee.show_form', compact('prefixes', 'banks', 'departments', 'account_types', 'payroll_employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payroll_employee = PayrollEmployee::find($id);
        if ($payroll_employee->company_id == $this->company_id) {
            $prefixes = UserPrefix::where('status', 1)->get();
            $banks = Bank::where('publish', 1)->get();
            $departments = PayrollDepartment::where([['publish', 1], ['company_id', Auth::user()->company_id]])->get();
            $account_types = ChartOfAccount::where('company_id', Auth::user()->company_id)->get();
            return view('admin.payroll_employee.edit_form', compact('prefixes', 'banks', 'departments', 'account_types', 'payroll_employee'));
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
        $inputData['start_date'] = DateTime::createFromFormat('d/m/Y', $inputData['start_date'])->format('Y-m-d');
        $inputData['company_id'] = Auth::user()->company_id;
        $inputData['scc_chkbox'] = isset($inputData['scc_chkbox']) ? 1 : 0;
        $inputData['tax_holding_chkbox'] = isset($inputData['tax_holding_chkbox']) ? 1 : 0;
        DB::beginTransaction();
        try {
            $update = PayrollEmployee::findOrFail($inputData['id']);
            $update->update($inputData);
            if ($update) {
                if ($request->file('img')) {
                    $medias = $update->getMedia('employee_profile');
                    if (count($medias) > 0) {
                        foreach ($medias as $media) {
                            $media->delete();
                        }
                    }

                    $getImage = $request->file('img');
                    $dateTime = Carbon::now();
                    $formattedDateTime = $dateTime->format('YmdHis');
                    $newFileName = $formattedDateTime . '_' . $request->file('img')->getClientOriginalName();

                    $update->addMedia($getImage)
                        ->usingFileName($newFileName)
                        ->toMediaCollection('employee_profile');
                }

                if ($request->file('img_citizen')) {
                    $medias = $update->getMedia('employee_ctz');
                    if (count($medias) > 0) {
                        foreach ($medias as $media) {
                            $media->delete();
                        }
                    }

                    $getImage = $request->file('img_citizen');
                    $dateTime = Carbon::now();
                    $formattedDateTime = $dateTime->format('YmdHis');
                    $newFileName = $formattedDateTime . '_' . $request->file('img_citizen')->getClientOriginalName();

                    $update->addMedia($getImage)
                        ->usingFileName($newFileName)
                        ->toMediaCollection('employee_ctz');
                }
                DB::commit();
                toast('บันทึกข้อมูล', 'success');
            }
            return redirect()->route('payroll_employee.index');
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
     */
    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ไม่สามารถลบข้อมูลได้';

        $role = PayrollEmployee::findOrFail($id);
        $role->record_status = 0;
        if ($role->save()) {
            $status = true;
            $msg = 'ลบข้อมูลเรียบร้อย';
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }
}

<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\CategoryBusiness;
use App\Models\Company;
use App\Models\TypeBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PayrollSettingController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        if (isset($company_id)) {
            $data = Company::with('company_address')
                ->where('id', $company_id)
                ->first();
            $logo = "https://placehold.co/500x500";
            if ($data->hasMedia('company_logo')) {
                $logo = $data->getFirstMedia('company_logo')->getUrl();
            }
            $stamp = "https://placehold.co/500x500";
            if ($data->hasMedia('company_stamp')) {
                $stamp = $data->getFirstMedia('company_stamp')->getUrl();
            }
            $type_businesses = TypeBusiness::where('publish', 1)->get();
            $category_businesses = CategoryBusiness::where('publish', 1)->get();
            $banks = BankAccount::where('company_id', $company_id)->with('bank')->select('id', 'account_name', 'account_number', 'bank_id')->get();
            return view('admin.payroll_setting.index', compact('data', 'type_businesses', 'category_businesses', 'logo', 'stamp', 'company_id', 'banks'));
        } else {
            Alert::error('ไม่พบบริษัทของท่าน');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $inputData = $request->all();
        DB::beginTransaction();
        try {
            $update = Company::where([
                ['id', $inputData['id']]
            ])->first();
            $update->social_security_status = $inputData['social_security_status'];
            $update->pvd_status = $inputData['pvd_status'];
            $update->pvd_rate = $inputData['pvd_rate'];
            $update->social_security_id = $inputData['social_security_id'];
            $update->social_security_branch_type = $inputData['social_security_branch_type'];
            $update->social_security_branch_id = $inputData['social_security_branch_id'];
            $update->employers_social_security_rate = $inputData['employers_social_security_rate'];
            $update->employers_maximum_amount = $inputData['employers_maximum_amount'];
            $update->employees_social_security_rate = $inputData['employees_social_security_rate'];
            $update->employees_maximum_amount = $inputData['employees_maximum_amount'];
            if (isset($inputData['paid_salary_account_id'])) {
                $update->paid_salary_account_id = $inputData['paid_salary_account_id'];
            }
            $update->save();

            DB::commit();
            toast('บันทึกข้อมูล', 'success');
            return redirect()->route('payroll_setting.index');
        } catch (\Exception $ex) {
            $result['status'] = "failed";
            $result['message'] = $ex;
            dd($ex);
            DB::rollBack();
            Alert::error('ผิดพลาด');
            return redirect()->back();
        }
    }
}

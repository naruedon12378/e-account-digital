<?php

namespace App\Http\Controllers\Import;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use App\Models\PayrollEmployee;
use App\Models\UserPrefix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

use function App\Repositories\Impl\getBrand;

class PayrollEmployeeImportController extends Controller
{
    private $modelsRepo;
    public function __construct()
    {
    }

    public function importPayrollEmployee(Request $request)
    {
        DB::beginTransaction();
        try {
            $path = 'excel_temp';
            $file_name_old = date('YmdHis') . "_ITEM_" . '.' . $request->file('file')->getClientOriginalExtension();
            $save_path = $request->file('file')->move(public_path($path), $file_name_old);
            $file_name = $path . "/" . $file_name_old;

            $rows = Excel::toArray(false, $file_name);
            foreach ($rows[0] as $key => $row) {
                if ($key > 0) {
                    $r_prefix = $row[0] == null ? '' : $row[0];
                    $r_first_name_th = $row[1] == null ? '' : $row[1];
                    $r_last_name_th = $row[2] == null ? '' : $row[2];
                    $r_first_name_en = $row[3] == null ? '' : $row[3];
                    $r_last_name_en = $row[4] == null ? '' : $row[4];
                    $r_phone = $row[5] == null ? '' : $row[5];
                    $r_citizen_id = $row[6] == null ? '' : $row[6];
                    $r_contract_type = $row[7] == null ? '' : $row[7];
                    $r_salary = $row[8] == null ? '' : $row[8];
                    $r_urgent_name = $row[9] == null ? '' : $row[9];
                    $r_urgent_phone = $row[10] == null ? '' : $row[10];
                    $r_address = $row[11] == null ? '' : $row[11];
                    $r_sub_district = $row[12] == null ? '' : $row[12];
                    $r_district = $row[13] == null ? '' : $row[13];
                    $r_province = $row[14] == null ? '' : $row[14];
                    $r_zipcode = $row[15] == null ? '' : $row[15];

                    $getPrefix = UserPrefix::where('name_th', 'like', $r_prefix)->pluck('id')->first();
                    $getContractType = 1;
                    if ($r_contract_type == "รายวัน") {
                        $getContractType = 2;
                    }

                    $data = [
                        "prefix_id" => $getPrefix,
                        "first_name_th" => $r_first_name_th,
                        "last_name_th" => $r_last_name_th,
                        "first_name_en" => $r_first_name_en,
                        "last_name_en" => $r_last_name_en,
                        "phone" => $r_phone,
                        "citizen_no" => $r_citizen_id,
                        "contract_type" => $getContractType,
                        "salary" => $r_salary,
                        "urgent_name" => $r_urgent_name,
                        "urgent_phone" => $r_urgent_phone,
                        "address" => $r_address,
                        "sub_district" => $r_sub_district,
                        "district" => $r_district,
                        "province" => $r_province,
                        "zipcode" => $r_zipcode,
                        "company_id" => Auth::user()->company_id,
                    ];

                    if (isset($getItem)) {
                    } else {
                        PayrollEmployee::create($data);
                    }
                }
            }
            DB::commit();
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        } catch (\Exception $e) {
            DB::rollback();
            $status = false;
            $msg = 'บันทึกข้อมูลผิดพลาด';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}

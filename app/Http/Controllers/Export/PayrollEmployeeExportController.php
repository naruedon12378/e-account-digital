<?php

namespace App\Http\Controllers\Export;

use App\Exports\PayrollEmployeeExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PayrollEmployeeExportController extends Controller
{
    public function __construct()
    {
    }

    function export(Request $request)
    {
        $param = $request->all();
        $date = "_ALL";
        $filename = "PAYROLL_EMPLOYEE_EXPORT";
        return Excel::download(new PayrollEmployeeExport($param), $filename . $date . '.xlsx');
    }
}

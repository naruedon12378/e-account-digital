<?php

namespace App\Http\Controllers\Export;

use App\Exports\EmployeeExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeExportController extends Controller
{
    public function __construct()
    {
    }

    function export(Request $request)
    {
        $param = $request->all();
        $date = "_ALL";
        $filename = "PAYROLL_SALARY_EMPLOYEE_IMPORT";
        return Excel::download(new EmployeeExport($param), $filename . $date . '.xlsx');
    }
}

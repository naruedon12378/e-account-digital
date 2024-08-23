<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ExcelReading;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReadXlsxController extends Controller
{
    public function read(Request $request)
    {
        $path = 'excel_temp';
        $file_name_old = date('YmdHis') . "_TEMP_" . '.' . $request->file('file')->getClientOriginalExtension();
        $save_path = $request->file('file')->move(public_path($path), $file_name_old);
        $file_name = $path . "/" . $file_name_old;

        $rows = Excel::toArray(new ExcelReading, $file_name);
        $data = [];
        foreach ($rows[0] as $key => $row) {
            if ($key > 0) {
                $rowData = [];
                foreach ($row as $column) {
                    $rowData[] = $column == null ? '' : $column;
                }
                $data[] = $rowData;
            }
        }
        return response()->json($data);
    }
}

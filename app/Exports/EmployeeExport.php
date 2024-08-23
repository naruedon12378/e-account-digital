<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\PayrollEmployee;
use App\Models\PayrollFinancialRecord;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EmployeeExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    use Exportable;

    protected $request;
    protected $company_id;

    public function __construct($request)
    {
        $this->request = $request;
        $this->company_id = Auth::user()->company_id;
    }

    function getLocale()
    {
        $locale = app()->getLocale();
        $name = 'name_' . $locale;
        return $name;
    }

    function getFrecord()
    {
        $financial_records = PayrollFinancialRecord::where([['company_id', $this->company_id], ['record_status', 1], ['publish', 1]])->select('name_th', 'name_en', 'id', 'type_account')->orderBy('type_account')->get();
        return $financial_records;
    }

    function getPVDStatus()
    {
        $company_pvd_status = Company::where('id', $this->company_id)->pluck('pvd_status')->first();
        return $company_pvd_status;
    }
    public function collection()
    {
        $param = $this->request;
        $company_id = $this->company_id;
        $name = $this->getLocale();
        $fname = "first_" . $name;
        $lname = "last_" . $name;
        $data = [];
        $mainQuery = PayrollEmployee::where(function ($q) use ($param, $company_id) {
            $q->where('company_id', $company_id);
            $q->where('record_status', 1);
        })->with('prefix')
            ->select(
                "id",
                "prefix_id",
                "first_name_th",
                "last_name_th",
                "first_name_en",
                "last_name_en",
                "salary",
            )
            ->get();

        $frecords = $this->getFrecord();
        foreach ($mainQuery as $index => $row) {
            $data[$index] = [
                "0" => $row->id,
                "1" => (isset($row->prefix) ? $row->prefix->$name : '') . " " . $row->$fname . " " . $row->$lname,
                "2" => number_format((float)$row->salary, 2, '.', ''),
            ];
            foreach ($frecords as $key => $value) {
                array_push($data[$index], number_format((float)0, 2, '.', ''));
            }
            if ($this->getPVDStatus() == 1) {
                array_push($data[$index], number_format((float)0, 2, '.', ''), number_format((float)0, 2, '.', ''), number_format((float)0, 2, '.', ''));
            } else {
                array_push($data[$index], number_format((float)0, 2, '.', ''), number_format((float)0, 2, '.', ''));
            }
        }
        return collect($data);
    }

    public function headings(): array
    {
        $name = $this->getLocale();
        $frecords = $this->getFrecord();
        $array = "";
        $data = [
            "รหัสอ้างอิง (ห้ามเปลี่ยนแปลง)",
            "ชื่อ",
            "เงินเดือน",
        ];
        foreach ($frecords as $key => $value) {
            array_push($data, $value->name_th);
        }

        if ($this->getPVDStatus() == 1) {
            array_push($data, "กองทุนสำรองเลี้ยงชีพ", "ภาษีหัก ณ ที่จ่าย", "ประกันสังคม");
        } else {
            array_push($data, "ภาษีหัก ณ ที่จ่าย", "ประกันสังคม");
        }

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $numberOfColumns = count($this->headings());
                $lastColumnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($numberOfColumns);
                $range = 'A1:' . $lastColumnLetter . '1';
                $event->sheet->getStyle($range)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('A0A0A0');
                $event->sheet->getStyle($range)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }
}

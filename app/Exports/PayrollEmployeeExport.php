<?php

namespace App\Exports;

use App\Models\PayrollEmployee;
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

class PayrollEmployeeExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    use Exportable;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $param = $this->request;
        $data = [];
        $mainQuery = PayrollEmployee::where(function ($q) use ($param) {
            $q->where('company_id', Auth::user()->company_id);
            if (isset($param['search'])) {
                $q->where('first_name_th', 'LIKE', '%' . $param['search'] . '%');
                $q->orWhere('first_name_en', 'LIKE', '%' . $param['search'] . '%');
                $q->orWhere('last_name_th', 'LIKE', '%' . $param['search'] . '%');
                $q->orWhere('last_name_en', 'LIKE', '%' . $param['search'] . '%');
            }
        })->with('prefix')
            ->select(
                "prefix_id",
                "first_name_th",
                "last_name_th",
                "first_name_en",
                "last_name_en",
                "phone",
                "citizen_no",
                "contract_type",
                "salary",
                "urgent_name",
                "urgent_phone",
                "address",
                "sub_district",
                "district",
                "province",
                "zipcode",
            )
            ->get();

        foreach ($mainQuery as $row) {
            $contract_type = 'รายเดือน';
            if ($row['contract_type'] == 2) {
                $contract_type = "รายวัน";
            }

            // ฟังก์ชันสำหรับแปลง Citizen No เป็นรูปแบบที่ต้องการ
            $formatCitizenNo = function ($citizenNo) {
                return Str::substr($citizenNo, 0, 1) . '-' .
                    Str::substr($citizenNo, 1, 4) . '-' .
                    Str::substr($citizenNo, 5, 5) . '-' .
                    Str::substr($citizenNo, 10, 2) . '-' .
                    Str::substr($citizenNo, 12, 1);
            };

            $formatSalary = function ($salary) {
                return number_format($salary, 2, '.', '');
            };

            $data[] = [
                isset($row->prefix) ? $row->prefix->name_th : '',
                $row->first_name_th,
                $row->last_name_th,
                $row->first_name_en,
                $row->last_name_en,
                $row->phone,
                $formatCitizenNo($row->citizen_no),
                $contract_type,
                $formatSalary($row->salary),
                $row->urgent_name,
                $row->urgent_phone,
                $row->address,
                $row->sub_district,
                $row->district,
                $row->province,
                $row->zipcode,
            ];
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            "คำนำหน้า",
            "ชื่อ (TH)",
            "นามสกุล (TH)",
            "ชื่อ (EN)",
            "นามสกุล (EN)",
            "เบอร์โทรศัพท์",
            "เลขบัตรประชาชน",
            "ประเภทสัญญา",
            "จำนวนเงินจ้าง",
            "ชื่อผู้ติดต่อ (กรณีฉุกเฉิน)",
            "เบอร์ผู้ติดต่อ (กรณีฉุกเฉิน)",
            "ที่อยู่",
            "อำเภอ/เขต",
            "ตำบล/แขวง",
            "จังหวัด",
            "รหัสไปรษณีย์"
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:P1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('A0A0A0');

                $event->sheet->getStyle('A1:P1')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => '0.00',
        ];
    }
}

<?php

namespace App\Exports;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;

class ProductExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
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
        $mainQuery = Product::where(function ($q) use ($param) {
            // $q->where('name_en', $param['name_en']);
            // if (isset ($param['search'])) {
            //     $q->where('name_th', 'LIKE', '%' . $param['search'] . '%');
            // }
        })->with('prefix')
            ->select(
                "id",
                "name_en",
            )
            ->get();

        foreach ($mainQuery as $row) {

            $data[] = [
                $row->name_en,
                $row->name_th
            ];
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            "คำนำหน้า",
            "ชื่อ (TH)"
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
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

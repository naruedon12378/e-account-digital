<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AssetExport implements FromView,
WithEvents,
WithCalculatedFormulas,
ShouldAutoSize,
WithColumnWidths,
WithColumnFormatting
{
    use RegistersEventListeners;
    public static $total;
    public function __construct($data)
    {
     $this->data = $data;
      static::$total =  count($this->data) + 3;

    }

    public function columnFormats(): array
    {
        return [

        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18.29, 'B' => 26.43, 'C' => 23.86,
            'D' => 22.86, 'E' => 22.86, 'F' => 16.71,
            'G' => 14.71, 'H' => 15.71, 'I' => 15.71,
            'J' => 15.71, 'K' => 8, 'L' => 8, 'M' => 8,
            'N' => 8, 'O' => 8, 'P' => 8, 'Q' => 8,
            'R' => 8, 'S' => 8, 'T' => 8, 'U' => 8,
            'V' => 8, 'W' => 8, 'X' => 8, 'Y' => 8,
            'Z' => 8, 'AA' => 11, 'AB' => 11, 'AC' => 14,
            'AD' => 14, 'AE' => 14, 'AF' => 14, 'AG' => 14,
            'AH' => 14, 'AI' => 14, 'AJ' => 14, 'AK' => 14,
            'AL' => 14, 'AM' => 14, 'AN' => 14, 'AO' => 14,
            'AP' => 14, 'AQ' => 14, 'AR' => 14, 'AS' => 14,
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
        $sheet->getStyle(0)->getFont()->setSize(16);
        // $sheet->getRowDimension(9)->setRowHeight(24);

        $AllWrapText = [
            'A2:AS2',
        //    'A17', 'A18','A19','A20','A21','A22','A24', 'A25','A28', 'B9', 'B10', 'B11','B21','B23','B22','B26','B27','A32','E17:G29'
        ];
        foreach ($AllWrapText as $col) {
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
        }

        $allFontBold = array(
            'font' => [
                'bold' => true,
            ]
        );

        $allBorder = array(
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        );

        $BorderLeftNone = array(
            'borders' => [

                'left' => [
                    'borderStyle' => Border::BORDER_NONE,
                ],

            ],
        );

        $allBorderBottom = array(
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_NONE,
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_NONE,
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_NONE,
                ],
            ],
        );

        $allBorderDotted = array(
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_DOTTED,
                ],
            ],
        );

        $allCenterTop = array(
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        );
        $allCenterBottom = array(
            'alignment' => [
                'vertical' => Alignment::VERTICAL_BOTTOM,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        );
        $allTopLeft = array(
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
                'horizontal' => Alignment::HORIZONTAL_LEFT
            ],
        );

        $allCenter = array(
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        );

        $allRight = array(
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
            ],
        );

        $allCenterLeft = array(
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_LEFT
            ],
        );

        $bold = [
            'A1:J1'
        ];
        foreach ($bold as $col) {
            $sheet->getStyle($col)->applyFromArray($allFontBold);
        }

        $textCenter = [
            'A1:AS2',
        ];
        foreach ($textCenter as $col) {
            $sheet->getStyle($col)->applyFromArray($allCenter);
        }

        $sheet->getPageSetup()->setScale(85);
         $borderAll = [
            //  'A16:G18','E19:G29','A21:D21','A25:D25','A28:D29'
         ];

         $borderBottomAll = [
            // 'A19:D19','A20:D20','A22:D22','A23:D23','A24:D24','A26:D26','A27:D27'
         ];
         foreach ($borderBottomAll as $col) {
             $sheet->getStyle($col)->applyFromArray($allBorderBottom);
         }


         foreach ($borderAll as $col) {
             $sheet->getStyle($col)->applyFromArray($allBorder);
         }

         /*สร้าง border ตามจำนวนข้อมูลที่ดึงมา*/
         for ($i = 1; $i <= static::$total; $i++) {
            $sheet->getStyle('B' . $i)->applyFromArray($allBorder);
            $sheet->getStyle('A' . $i)->applyFromArray($allBorder);
            $sheet->getStyle('B' . $i)->applyFromArray($allBorder);
            $sheet->getStyle('C' . $i)->applyFromArray($allBorder);
            $sheet->getStyle('D' . $i)->applyFromArray($allBorder);
            $sheet->getStyle('E' . $i)->applyFromArray($allBorder);
            $sheet->getStyle('F' . $i)->applyFromArray($allBorder);
            $sheet->getStyle('G' . $i)->applyFromArray($allBorder);
            $sheet->getStyle('H' . $i)->applyFromArray($allBorder);
            $sheet->getStyle('I' . $i)->applyFromArray($allBorder);
            $sheet->getStyle('J' . $i)->applyFromArray($allBorder);


        }

         /*เครื่องหมายการตรวจสอบ*/
        //  $sheet->getStyle('B36:B41')->applyFromArray($allCenterTop);

     }

     public function view(): View
     {
         return view('admin.asset.report.export')
             ->with('data', $this->data);

     }
}

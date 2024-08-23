<?php

namespace App\Helpers;

use Maatwebsite\Excel\Concerns\ToArray;

class ExcelReading implements ToArray
{
    public function array(array $array)
    {
        return $array;
    }
}

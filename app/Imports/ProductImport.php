<?php
namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        $name = $row['name'];
        $code = $row['code'];
        return new Product([
            'name' => $name,
            'code' => $code
        ]);
    }

    public function rules(): array
    {
        return [

        ];
    }
}

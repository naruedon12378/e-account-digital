<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'item_class' => 'basic',
                'type' => 'product',
                'code' => '00001',
                'name_en' => 'product 1',
                'name_th' => 'product 1',
                'unit_id' => 5,
                'sale_price' => 2000,
                'purchase_price' => 2000,
                'company_id' => 1,
                'created_by' => 'S',
            ],
            [
                'id' => 2,
                'item_class' => 'basic',
                'type' => 'product',
                'code' => '00002',
                'name_en' => 'product 2',
                'name_th' => 'product 2',
                'unit_id' => 2,
                'sale_price' => 1500,
                'purchase_price' => 1500,
                'company_id' => 1,
                'created_by' => 'S',
            ]

        ];
        foreach ($data as $value) {
            Product::create($value);
        }
    }
}

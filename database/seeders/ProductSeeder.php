<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $env = env('APP_ENV');

        if( $env == 'local') {
            Schema::disableForeignKeyConstraints();
            ProductCategory::truncate();
            Product::truncate();
            Schema::enableForeignKeyConstraints();
        }

        if(ProductCategory::query()->count() < 1) {

            $datas = [
                [ 'กลุ่มสินค้า1', 'Product Catetgory 1', 'Aa'],
                [ 'กลุ่มสินค้า2', 'Product Catetgory 2', 'Bb'],
                [ 'กลุ่มสินค้า3', 'Product Catetgory 3', 'Cc'],
                [ 'กลุ่มสินค้า4', 'Product Catetgory 4', 'Dd'],
                [ 'กลุ่มสินค้า5', 'Product Catetgory 4', 'Ee'],
                [ 'กลุ่มสินค้า6', 'Product Catetgory 4', 'Ff'],
                [ 'กลุ่มสินค้า7', 'Product Catetgory 4', 'Gg'],
                [ 'กลุ่มสินค้า8', 'Product Catetgory 4', 'Hh'],
            ];

            foreach ( $datas as $data) {
                $query = new ProductCategory();
                $query->company_id = 1;
                $query->product_type_id = 1;
                $query->name_th = $data[0];
                $query->name_en = $data[1];
                $query->code = $data[2];
                $query->save();
            };
        }

        if(Product::query()->count() < 1) {

            $datas = [
                [
                    'item_class' => 'basic',
                    'type' => 'product',
                    'code' => 'Aa-01',
                    'name_en' => 'product 1',
                    'name_th' => 'product 1',
                    'unit_id' => 1,
                    'sale_price' => 1000,
                    'purchase_price' => 500,
                    'company_id' => 1,
                    'product_category_id' => 1,
                    'unit_id' => 1,
                ],
                [
                    'item_class' => 'basic',
                    'type' => 'product',
                    'code' => 'Bb-02',
                    'name_en' => 'product 2',
                    'name_th' => 'product 2',
                    'unit_id' => 2,
                    'sale_price' => 2000,
                    'purchase_price' => 1000,
                    'company_id' => 1,
                    'product_category_id' => 2,
                    'unit_id' => 2,
                ],
                [
                    'item_class' => 'basic',
                    'type' => 'product',
                    'code' => 'Cc-01',
                    'name_en' => 'product 3',
                    'name_th' => 'product 3',
                    'unit_id' => 3,
                    'sale_price' => 3000,
                    'purchase_price' => 1500,
                    'company_id' => 1,
                    'product_category_id' => 3,
                    'unit_id' => 3,
                ],
                [
                    'item_class' => 'basic',
                    'type' => 'product',
                    'code' => 'Dd-01',
                    'name_en' => 'product 4',
                    'name_th' => 'product 4',
                    'unit_id' => 4,
                    'sale_price' => 4000,
                    'purchase_price' => 2000,
                    'company_id' => 1,
                    'product_category_id' => 4,
                    'unit_id' => 4,
                ]
            ];

            foreach ( $datas as $data) {
                $query = new Product();
                $query->company_id = $data['company_id'];
                $query->code = $data['code'];
                $query->name_th = $data['name_th'];
                $query->name_en = $data['name_en'];
                $query->sale_price = $data['sale_price'];
                $query->purchase_price = $data['purchase_price'];
                $query->product_category_id = $data['product_category_id'];
                $query->unit_id = $data['unit_id'];
                $query->save();
            };
        }


    }
}

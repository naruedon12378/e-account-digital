<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $env = env('APP_ENV');

        if( $env == 'local') {
            // ProductType::truncate();
        }

        if(ProductType::query()->count() < 1) {

            $datas = [
                [ 'สินค้าสำเร็จรูป', 'Finished product'],
                [ 'วัตถุดิบ', 'Raw material'],
                [ 'สินค้ากึ่งสำเร็จรูป', 'Semi-finished product'],
                [ 'สินค้าประกอบ', 'Assembly product'],
                [ 'สินค้าบริการ', 'Service product'],
            ];

            foreach ( $datas as $data) {
                $query = new ProductType();
                $query->company_id = 1;
                $query->name_th = $data[0];
                $query->name_en = $data[1];
                $query->save();
            };
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            WarehouseSeeder::class,
            ProductSeeder::class,
        ]);

        $env = env('APP_ENV');

        if( $env == 'local') {
            Schema::disableForeignKeyConstraints();
            Inventory::truncate();
            Schema::enableForeignKeyConstraints();
        }

        if(Inventory::query()->count() < 1) {

            $datas = [
                [ 1, 1],
                [ 1, 2],
                [ 1, 3],
                [ 2, 2],
                [ 2, 3],
                [ 2, 4],
            ];

            foreach ( $datas as $data) {
                $query = new Inventory();
                $query->company_id = 1;
                $query->warehouse_id = $data[0];
                $query->product_id = $data[1];

                $query->limit_min_amount = 0;
                $query->limit_max_amount = 0;
                $query->limit_amount_notification = true;
                $query->is_negative_amount = true;
                $query->description = null;
                $query->status = 'active';
                $query->user_creator_id = 1;

                $query->save();
            };
        }
    }
}

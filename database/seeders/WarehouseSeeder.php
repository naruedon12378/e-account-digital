<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $env = env('APP_ENV');

        if( $env == 'local') {
            Schema::disableForeignKeyConstraints();
            Warehouse::truncate();
            Schema::enableForeignKeyConstraints();
        }

        if(Warehouse::query()->count() < 1) {
            $datas = [
                [ 1, '001', 'คลัง1', 'inventory1'],
                [ 2, '002', 'คลัง2', 'inventory2'],
                [ 3, '003', 'คลัง3', 'inventory3'],
            ];

            foreach ( $datas as $data) {
                $query = new Warehouse();
                $query->company_id = 1;
                $query->branch_id = $data[0];
                $query->code = $data[1];
                $query->name_th = $data[2];
                $query->name_en = $data[3];
                $query->user_creator_id = 1;
                $query->save();
            };
        }


    }
}

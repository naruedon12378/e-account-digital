<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            // SqlThailandProvinceSeeder::class,
            MasterSeeder::class,
            UserSeeder::class,
            ChartOfAccountSeeder::class,
            TransactionSeeder::class,
            BranchSeeder::class,
            ProductTypeSeeder::class,
         ]);
    }
}

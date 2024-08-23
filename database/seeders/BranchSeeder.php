<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $primaries = [
            [
                "code" => "001",
                "name" => "Head Office",
                "description" => "Head Office Of Bangkok",
                "address" => "Thailand",
                "telephone" => "0123456789",
                "fax" => "0123456789",
                "email" => "qkqKg@example.com",
                "website" => "thailand.com",
                "created_by" => "s",
                "updated_by" => null,
                "publish" => 1,
                "company_id" => 1,
                "user_creator_id" => 1,
                "user_checker_id" => null,
                "user_approver_id" => null,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "code" => "002",
                "name" => "Branch",
                "description" => "Branch Of Bangkok",
                "address" => "Thailand",
                "telephone" => "0123456789",
                "fax" => "0123456789",
                "email" => "qkqKg@example.com",
                "website" => "thailand.com",
                "created_by" => "s",
                "updated_by" => null,
                "publish" => 1,
                "company_id" => 1,
                "user_creator_id" => 1,
                "user_checker_id" => null,
                "user_approver_id" => null,
            ],
            [
                "code" => "003",
                "name" => "Branch",
                "description" => "Branch Of Bangkok",
                "address" => "Thailand",
                "telephone" => "0123456789",
                "fax" => "0123456789",
                "email" => "qkqKg@example.com",
                "website" => "thailand.com",
                "created_by" => "s",
                "updated_by" => null,
                "publish" => 1,
                "company_id" => 1,
                "user_creator_id" => 1,
                "user_checker_id" => null,
                "user_approver_id" => null,
            ]
        ];
        foreach ($primaries as $primary) {
            Branch::create($primary);
        }
    }
}

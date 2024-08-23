<?php

namespace Database\Seeders;

use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $env = env('APP_ENV');

        if( $env == 'local') {
            Unit::truncate();
        }

        if(Unit::query()->count() < 1) {
            $units = [
                [
                    "id" => 1,
                    "code" => "box",
                    "type" => "product",
                    "name_en" => "box",
                    "name_th" => "กล่อง",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 2,
                    "code" => "piece",
                    "type" => "product",
                    "name_en" => "piece",
                    "name_th" => "ชิ้น",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 3,
                    "code" => "stick",
                    "type" => "product",
                    "name_en" => "stick",
                    "name_th" => "แท่ง",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 4,
                    "code" => "box2",
                    "type" => "product",
                    "name_en" => "box",
                    "name_th" => "ลัง",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 5,
                    "code" => "machine",
                    "type" => "product",
                    "name_en" => "machine",
                    "name_th" => "เครื่อง",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 6,
                    "code" => "ea",
                    "type" => "product",
                    "name_en" => "ea",
                    "name_th" => "อัน",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 7,
                    "code" => "dozen",
                    "type" => "product",
                    "name_en" => "dozen",
                    "name_th" => "โหล",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 8,
                    "code" => "pack",
                    "type" => "product",
                    "name_en" => "pack",
                    "name_th" => "แพ็ค",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 9,
                    "code" => "reel",
                    "type" => "product",
                    "name_en" => "reel",
                    "name_th" => "ม้วน",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 10,
                    "code" => "case",
                    "type" => "product",
                    "name_en" => "case",
                    "name_th" => "ตลับ",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 11,
                    "code" => "inkwell",
                    "type" => "product",
                    "name_en" => "inkwell",
                    "name_th" => "ขวด",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 12,
                    "code" => "line",
                    "type" => "product",
                    "name_en" => "line",
                    "name_th" => "เส้น",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 13,
                    "code" => "set",
                    "type" => "product",
                    "name_en" => "set",
                    "name_th" => "ชุด",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 14,
                    "code" => "times",
                    "type" => "service",
                    "name_en" => "times",
                    "name_th" => "ครั้ง",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 15,
                    "code" => "course",
                    "type" => "service",
                    "name_en" => "course",
                    "name_th" => "คอร์ส",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 16,
                    "code" => "person",
                    "type" => "service",
                    "name_en" => "person",
                    "name_th" => "คน",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 17,
                    "code" => "man-day",
                    "type" => "service",
                    "name_en" => "man-day",
                    "name_th" => "คน-วัน",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 18,
                    "code" => "man-month",
                    "type" => "service",
                    "name_en" => "man-month",
                    "name_th" => "คน-เดือน",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 19,
                    "code" => "year",
                    "type" => "service",
                    "name_en" => "year",
                    "name_th" => "ปี",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 20,
                    "code" => "month",
                    "type" => "service",
                    "name_en" => "month",
                    "name_th" => "เดือน",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 21,
                    "code" => "week",
                    "type" => "service",
                    "name_en" => "week",
                    "name_th" => "สัปดาห์",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 22,
                    "code" => "day",
                    "type" => "service",
                    "name_en" => "day",
                    "name_th" => "วัน",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 23,
                    "code" => "hour",
                    "type" => "service",
                    "name_en" => "hour",
                    "name_th" => "ชั่วโมง",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 24,
                    "code" => "minute",
                    "type" => "service",
                    "name_en" => "minute",
                    "name_th" => "นาที",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ],
                [
                    "id" => 25,
                    "code" => "round",
                    "type" => "service",
                    "name_en" => "round",
                    "name_th" => "รอบ",
                    "is_active" => 1,
                    "created_by" => "s",
                    "updated_by" => null,
                ]
            ];

            if (count($units) > 0) {
                foreach ($units as $unit) {
                    $unit['company_id'] = 1;
                    $unit['created_at'] = Carbon::now();
                    $unit['updated_at'] = Carbon::now();
                    Unit::create($unit);
                }
            }
        }
    }
}

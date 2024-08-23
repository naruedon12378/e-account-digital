<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_group_id',
        'asset_number',
        'reference',
        'name_th',
        'name_en',
        'serial_number',
        'location',
        'description',
        'purchase_date',
        'depreciation_date',
        'purchase_amount',
        'depreciation_amount',
        'accrum_depreciation_amount',
        'booked_value',
        'time_in_used',
        'category_id',
        'sub_category_id',
        'asset_acc_code',
        'depreciation_acc_code',
        'accrum_depreciation_acc_code',
        'depreciation_period',
        'salvage_amt',
        'depreciation_policy',
        'image',
        'is_active',
        'company_id',
        'created_by',
        'updated_by',
    ];
}

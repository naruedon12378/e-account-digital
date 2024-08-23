<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_code',
        'category_id',
        'sub_category_id',
        'curr_code',
        'name_th',
        'name_en',
        'unit_id',
        'barcode',
        'description',
        'asset_acc_code',
        'depreciation_acc_code',
        'accrum_depreciation_acc_code',
        'depreciation_period',
        'salvage_amt',
        'depreciation_policy',
        'is_active',
        'company_id',
        'created_by',
        'updated_by',
    ];
}

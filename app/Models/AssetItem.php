<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_id',
        'line_item_no',
        'depreciation_date',
        'depreciation_amount',
        'par_day_dep_amt',
        'period',
        'number_of_days',
        'balance_amt',
        'journal_number',
        'journal_date',
        'description',
        'created_by',
        'updated_by',
    ];
}

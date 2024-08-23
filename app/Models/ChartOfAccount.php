<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;
    protected $table = 'chart_of_accounts';
    protected $fillable = [
        'account_code',
        'name_th',
        'name_en',
        'description',
        'sortText',
        'publish',
        'company_id',
    ];
}

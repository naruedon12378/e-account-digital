<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxIncomeType extends Model
{
    use HasFactory;
    protected $table = 'tax_income_types';
    protected $fillable = [
        'name_th',
        'name_en',
        'percent_calculate',
        'deduct_expense_limit',
        'sort',
        'publish',
    ];
}

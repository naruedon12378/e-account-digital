<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainChartOfAccount extends Model
{
    use HasFactory;
    protected $table = 'main_chart_of_accounts';
    protected $fillable = [
        'name_th',
        'name_en',
        'code',
        'sort',
        'publish',
    ];



}

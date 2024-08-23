<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RunningNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_id',
        'month01',
        'month02',
        'month03',
        'month04',
        'month05',
        'month06',
        'month07',
        'month08',
        'month09',
        'month10',
        'month11',
        'month12',
        'year',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $table = 'series';
    protected $fillable = [
        'transaction_type',
        'prefix',
        'symbol',
        'year',
        'month',
        'date',
        'digit',
        'company_id',
    ];
}

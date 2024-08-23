<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TransactionEnum;

class TransactionType extends Model
{
    protected $fillable = [
        'trx_type'
    ];

    protected $casts = [
        'trx_type' => TransactionEnum::class,
    ];
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'purchase_id',
        'purchase_date',
        'qty',
        'price',
        "created_by",
        "updated_by",
        "created_at",
        "updated_at",
    ];
}

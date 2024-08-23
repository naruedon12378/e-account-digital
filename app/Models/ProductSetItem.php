<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductSetItem extends Model
{
    use HasFactory;
    protected $table = 'product_set_items';
    protected $fillable = [
        'product_set_id',
        'product_id',
        'amount',
        'created_by',
        'updated_by',
    ];

    public function product_set()
    {
        return $this->belongsTo(ProductSet::class, 'product_set_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}

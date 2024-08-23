<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountStockItem extends Model
{
    use HasFactory;

    protected $table = 'count_stock_items';

    protected $fillable = [
        'count_stock_id',
        'product_id',
        'product_name',
        'branch_id',
        'location',
        'stock_amount',
        'count_amount',
        'is_check',
        'created_by',
        'updated_by',
    ];

    public function countStock()
    {
        return $this->belongsTo(CountStock::class, 'count_stock_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function branch(){}
}

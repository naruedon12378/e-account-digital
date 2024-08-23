<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnFinishStockItem extends Model
{
    use HasFactory;

    protected $table = 'return_finish_stock_items';

    protected $fillable = [
        'return_finish_stock_id',
        'product_id',
        'inventory_stock_id',
        'location',
        'amount',
        'remark',
        'created_by',
        'updated_by',
    ];

    public function return_finish_stock()
    {
        return $this->belongsTo(ReturnFinishStock::class, 'return_finish_stock_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function inventory_stock()
    {
        return $this->belongsTo(InventoryStock::class, 'inventory_stock_id');
    }
}

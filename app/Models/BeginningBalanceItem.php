<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeginningBalanceItem extends Model
{
    use HasFactory;
    protected $table = 'beginning_balance_items';
    protected $fillable = [
        'beginning_balance_id',
        'product_id',
        'inventory_stock_id',
        'line_item_no',
        'code',
        'name',
        'account_code',
        'location',
        'amount',
        'discount',
        'qty',
        'vat_rate',
        'vat_amt',
        'wht_rate',
        'wht_amt',
        'total_price',
        'price',
        'remark',
        'created_by',
        'updated_by',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function inventory_stock()
    {
        return $this->belongsTo(InventoryStock::class, 'inventory_stock_id');
    }

    public function beginning_balance()
    {
        return $this->belongsTo(BeginningBalance::class, 'beginning_balance_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferStockItem extends Model
{
    use HasFactory;
    protected $table = 'transfer_stock_items';
    protected $guarded = [ 'id' ];
    protected $fillable = ['transfer_stock_id', 'product_id', 'product_name', 'branch_id', 'location', 'stock_amount', 'count_amount', 'is_check', 'created_by', 'updated_by'];
    public function transfer_stock()
    {
        return $this->belongsTo(TransferStock::class, 'transfer_stock_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function inventory_stock()
    {
        return $this->belongsTo(InventoryStock::class, 'inventory_stock_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}

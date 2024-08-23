<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLotAdjustmentItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_lot_adjustment_items';

    public function inventory_adjustment()
    {
        return $this->belongsTo(InventoryLot::class,'inventory_log_adjustment_id');
    }

    public function inventory_lot_item()
    {
        return $this->belongsTo(InventoryLot::class,'inventory_lot_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

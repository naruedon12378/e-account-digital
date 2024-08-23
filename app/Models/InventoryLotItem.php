<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLotItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_lot_items';

    public function inventory_lot()
    {
        return $this->belongsTo(InventoryLot::class,'inventory_lot_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

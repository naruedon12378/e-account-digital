<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferRequistionItem extends Model
{
    use HasFactory;
    protected $table = 'transfer_requistion_items';
    protected $guarded = [ 'id' ];
    protected $fillable = [ 'transfer_requistion_id', 'product_id', 'inventory_stock_id', 'location', 'amount', 'remark', 'created_by', 'updated_by' ];

    public function transfer_requistion()
    {
        return $this->belongsTo(TransferRequistion::class, 'transfer_requistion_id');
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

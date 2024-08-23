<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueReturnStockItem extends Model
{
    use HasFactory;
    protected $table = 'issue_return_stock_items';
    protected $fillable = [
        'issue_return_stock_id',
        'product_id',
        'inventory_stock_id',
        'location',
        'amount',
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

    public function issue_requisition()
    {
        return $this->belongsTo(IssueRequisition::class, 'issue_requisition_id');
    }
}

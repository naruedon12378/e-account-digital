<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueRequisitionItem extends Model
{

    use HasFactory;
    protected $table = 'issue_requisition_items';

    protected $fillable = [
        'issue_requisition_id',
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
        return $this->belongsTo(Product::class);
    }
    public function issueRequisition()
    {
        return $this->belongsTo(IssueRequisition::class, 'issue_requisition_id');
    }
    public function inventory_stock()
    {
        return $this->belongsTo(InventoryStock::class, 'inventory_stock_id');
    }

}

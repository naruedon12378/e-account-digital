<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptPlanningItem extends Model
{
    use HasFactory;
    protected $table = 'receipt_planning_items';
    protected $guarded = ['id'];
    protected $with = ['product', 'inventory_stock'];
    protected $fillable = [
        'receipt_planning_id',
        'product_id',
        'inventory_stock_id',
        'location',
        'amount',
        'remark',
        'created_by',
        'updated_by',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function inventory_stock(){
        return $this->belongsTo(InventoryStock::class, 'inventory_stock_id');
    }
    public function receipt_planning(){
        return $this->belongsTo(ReceiptPlanning::class, 'receipt_planning_id');
    }

    public function user_creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function user_approver()
    {
        return $this->belongsTo(User::class, 'user_approver_id');
    }
}


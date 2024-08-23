<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InventoryStockAdjustment extends Model
{
    use HasFactory;
    protected $table = 'inventory_stock_adjustments';

    protected $fillable = [
        'company_id',
        'warehouse_id',
        'inventory_stock_id',
        'amount',
        'remark',
        'user_creator_id',
        'user_approver_id',
        'created_by',
        'updated_by',
        'status',
    ];

    public function scopeMyCompany($query)
    {
        return $query->where('company_id', Auth::user()->company_id);
    }

    public function getBtnApproveAttribute()
    {
        $btnApprove = '';
        if( Auth::user()->hasAnyPermission(['*', 'all inventory_stock_adjustment', 'edit inventory_stock_adjustment']) ){
            if( $this->status == 'pending'){
                $btnApprove = '<a class="btn btn-warning btn-sm js-approve" data-id="'.$this->id.'" href=" '.url('warehouse/inventorystockadjustment/'.$this->id).'"><i class="fas fa-file-circle-check" data-toggle="tooltip" title="จัดการอนุมัติ"></i> จัดการอนุมัติ</a>';
            }else{
                $btnApprove = '<a class="btn btn-outline-primary btn-sm" href=" '.url('warehouse/inventorystockadjustment/'.$this->id).'" ><i class="fas fa-eye" data-toggle="tooltip" title="ดูประวัติ"></i> ดูประวัติ</a>';
            }
        }

        return $btnApprove;
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function inventory_stock()
    {
        return $this->belongsTo(InventoryStock::class, 'inventory_stock_id');
    }
    public function user_creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function user_approver()
    {
        return $this->belongsTo(User::class, 'user_approver_id');
    }

    public function inventory_stock_adjustment_item()
    {
        return $this->hasOne(InventoryStockAdjustmentItem::class, 'inventory_stock_adjustment_id');
    }

    public function inventory_stock_adjustment_items()
    {
        return $this->hasMany(InventoryStockAdjustmentItem::class, 'inventory_stock_adjustment_id');
    }

    public function items()
    {
        return $this->hasMany(InventoryStockAdjustmentItem::class, 'inventory_stock_adjustment_id');
    }
}

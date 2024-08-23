<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InventoryLot extends Model
{
    use HasFactory;
    protected $table = 'inventory_lots';

    protected $fillable = [
        // 'warehouse_id',
        // 'product_id',
        // 'amount',
        // 'is_negative_amount',
        // 'limit_min_amount',
        // 'limit_max_amount',
        // 'limit_amount_notification',
        // 'is_negative_amount',
        // 'location',
        // 'description',
        // 'status',
    ];

    protected $casts = [
        // 'is_negative_amount' => 'boolean',
        // 'limit_amount_notification' => 'boolean',
    ];

    public function scopeMyCompany($query)
    {
        return $query->where('company_id', Auth::user()->company_id);
    }

    public function getBtnApproveAttribute()
    {
        $btnApprove = '';
        if( Auth::user()->hasAnyPermission(['*', 'all inventory_lot', 'edit inventory_lot']) ){
            if( $this->status == 'pending'){
                $btnApprove = '<a class="btn btn-warning btn-sm js-approve" data-id="'.$this->id.'" href=" '.url('warehouse/inventorylot/'.$this->id).'"><i class="fas fa-file-circle-check" data-toggle="tooltip" title="จัดการอนุมัติ"></i> จัดการอนุมัติ</a>';
            }else{
                $btnApprove = '<a class="btn btn-outline-primary btn-sm" href=" '.url('warehouse/inventorylot/'.$this->id).'" ><i class="fas fa-eye" data-toggle="tooltip" title="ดูประวัติ"></i> ดูประวัติ</a>';
            }
        }

        return $btnApprove;
    }
    
    public function getBtnAdjustStockAttribute()
    {
        $btnAdjustStock = '';
        if( Auth::user()->hasAnyPermission(['*', 'all inventory_lot', 'edit inventory_lot']) ){
            if( $this->status == 'pending'){
                $btnAdjustStock = '<a class="btn btn-outline-primary btn-sm js-adjust" data-id="'.$this->id.'" href=" '.url('warehouse/inventorylot/'.$this->id.'/edit').'"><i class="fas fa-box-open " data-toggle="tooltip" title="จัดการสต็อก"></i> ปรับแก้สต็อก</a>';
            }else{
                // $btnAdjustStock = '<a class="btn btn-outline-secondary btn-sm disabled" ><i class="fas fa-box-open" data-toggle="tooltip" title="จัดการสต็อก"></i> ปรับสต็อก</a>';
            }
        }

        return $btnAdjustStock;
    }

    public function getBtnEditAttribute()
    {
        // $btnEdit = view('vendor.adminlte.components.form.table-edit',[
        //                 'permissions' => ['*', 'all inventory_lot', 'edit inventory_lot'],
        //                 'url' => null,
        //                 'id' => $this->id,
        //             ]);
        $btnEdit = '';
        if( Auth::user()->hasAnyPermission(['*', 'all inventory_lot', 'edit inventory_lot']) ){
            $btnEdit = '<a href="javascript:;" class="btn btn-outline-primary btn-sm js-edit" data-id="'.$this->id.'"><i class="fas fa-edit"></i> แก้ไข</a>';
        }

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {

        $btnDelete = '';
        if( $this->status == 'pending'){
            $btnDelete = view('vendor.adminlte.components.form.table-delete',[
                            'permissions' => ['*', 'all inventory_adjustment', 'delete inventory_adjustment'],
                            'url' => 'warehouse/inventorylot/'.$this->id,
                        ]);
        }else{
            // $btnDelete = '<button class="btn btn-outline-secondary btn-sm disabled" ><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i>ลบ</button>';
        }

        return $btnDelete;
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function inventory_lot_items()
    {
        return $this->hasMany(InventoryLotItem::class, 'inventory_lot_id');
    }

    public function items()
    {
        return $this->hasMany(InventoryLotItem::class, 'inventory_lot_id');
    }

    public function user_creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function user_approver()
    {
        return $this->belongsTo(User::class, 'user_approver_id');
    }

    public function inventory_lot_adjustment()
    {
        return $this->hasOne(InventoryLotAdjustment::class, 'inventory_lot_id');
    }

    public function inventory_lot_adjustments()
    {
        return $this->hasMany(InventoryLotAdjustment::class, 'inventory_lot_id');
    }
}

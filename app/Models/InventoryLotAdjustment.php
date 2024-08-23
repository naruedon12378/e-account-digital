<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InventoryLotAdjustment extends Model
{
    use HasFactory;
    protected $table = 'inventory_lot_adjustments';

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
    
    public function getBtnAdjustStockAttribute()
    {
        $btnAdjustStock = '';
        if( Auth::user()->hasAnyPermission(['*', 'all inventory_lot', 'edit inventory_lot']) ){
            if( $this->status == 'pending'){
                $btnAdjustStock = '<a class="btn btn-outline-primary btn-sm js-adjust" data-id="'.$this->id.'" href=" '.url('warehouse/inventoryadjustment/'.$this->id.'/edit').'"><i class="fas fa-box-open " data-toggle="tooltip" title="จัดการสต็อก"></i> ปรับแก้สต็อก</a>';
            }else{
                $btnAdjustStock = '<a class="btn btn-outline-secondary btn-sm disabled" ><i class="fas fa-box-open" data-toggle="tooltip" title="จัดการสต็อก"></i> ปรับสต็อก</a>';
            }
        }

        return $btnAdjustStock;
    }

    public function getBtnConfirmAttribute()
    {
        $btnAdjustStock = '';
        if( Auth::user()->hasAnyPermission(['*', 'all inventory_lot', 'edit inventory_lot']) ){
            if( $this->status == 'pending'){
                $btnAdjustStock = '<a class="btn btn-outline-success btn-sm js-adjust" data-id="'.$this->id.'" href=" '.url('warehouse/inventorylot/'.$this->id.'/view').'"><i class="fas fa-box-open " data-toggle="tooltip" title="ยืนยันรายการ"></i> ยืนยันรายการ</a>';
            }else{
                $btnAdjustStock = '<a class="btn btn-outline-secondary btn-sm disabled" ><i class="fas fa-box-open" data-toggle="tooltip" title="ยืนยันรายการ"></i> ยืนยันรายการ</a>';
            }
        }

        return $btnAdjustStock;
    }

    public function getBtnEditAttribute()
    {
        $btnEdit = view('vendor.adminlte.components.form.table-edit',[
                        'permissions' => ['*', 'all inventory_lot', 'edit inventory_lot'],
                        'url' => null,
                        'id' => $this->id,
                    ]);
        if( Auth::user()->hasAnyPermission(['*', 'all inventory_lot', 'edit inventory_lot']) ){
            $btnEdit = '<a href="javascript:;" class="btn btn-outline-primary btn-sm js-edit" data-id="'.$this->id.'"><i class="fas fa-edit"></i> แก้ไข</a>';
        }

        return $btnEdit;
    }

    public function getBtnDeleteAttribute()
    {
        if( $this->status == 'pending'){
            $btnDelete = view('vendor.adminlte.components.form.table-delete',[
                            'permissions' => ['*', 'all inventory_lot', 'delete inventory_lot'],
                            'url' => 'warehouse/inventorylot/'.$this->id,
                        ]);
        }else{
            $btnDelete = '<button class="btn btn-outline-secondary btn-sm disabled" ><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i> ปรับสต็อก</button>';
        }

        return $btnDelete;
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function user_creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function user_approver()
    {
        return $this->belongsTo(User::class, 'user_approver_id');
    }

    public function inventory_lot()
    {
        return $this->belongsTo(InventoryLot::class, 'inventory_lot_id');
    }

    public function inventory_lot_adjustment_items()
    {
        return $this->hasMany(InventoryLotAdjustmentItem::class, 'inventory_lot_adjustment_id');
    }

    public function items()
    {
        return $this->hasMany(InventoryLotAdjustmentItem::class, 'inventory_lot_adjustment_id');
    }
}
